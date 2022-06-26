<?php

require_once('src/Model/User.php');
require_once('src/Model/Response.php');

class LoginController {

	public function login(): string {
		try {
			$user = User::whereC(
				new Comparation(
					new Condition('user', Input::get('user')),
					'AND',
					new Comparation(new Condition('password', Input::get('password')))
				)
			)[0];
			Auth::login($user);
			$message = $user === null ? 'Credenciales invalidas' : 'Usuario validado';
			return json_encode(new Response(200, $message, $user));
		} catch (Exception $ex) {
			return json_encode(new Response(500, $ex->getMessage(), $ex));
		}
	}

	public function logout(): string {
		try {
			if (!Auth::check()) throw new Exception('No ha iniciado sesión');
			$user = Auth::name();
			Auth::logout();
			return json_encode(new Response(200, 'El usuario ' . $user . ' cerro la sesión', $user));
		} catch (Exception $ex) {
			return json_encode(new Response(500, $ex->getMessage(), $ex->getMessage()));
		}
	}
}
