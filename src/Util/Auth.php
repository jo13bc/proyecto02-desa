<?php

class Auth {

    public static function name() {
        return Session::get('name');
    }

    public static function id() {
        return Session::get('id');
    }

    public static function check() {
        return (Session::get('id') != NULL);
    }

    public static function login($user, bool $remember = false) {
        Session::put('name', $user->getName());
        Session::put('id', $user->getId());
    }

    public static function loginUsingId($id) {
    }

    public static function logout() {
        Session::forget('name');
        Session::forget('id');
    }

    public static function viaRemember() {
    }

    public static function once($credentials) {
    }

    public static function onceBasic() {
    }
}
?>