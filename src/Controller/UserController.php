<?php

require_once('src/Model/User.php');
require_once('src/Model/TimeBox.php');
require_once('src/Model/Availability.php');

class UserController extends ControllerAPI {

	private static function newTimeBox(string $day, array $array) {
		return new TimeBox(
			$array['start_' . $day],
			$array['end_' . $day],
			(int) $array['id_' . $day]
		);
	}

	protected function new(array $array) {
		$user = User::new($array);
		$monday = self::newTimeBox('monday', $array);
		$tuesday = self::newTimeBox('tuesday', $array);
		$wednesday = self::newTimeBox('wednesday', $array);
		$thursday = self::newTimeBox('thursday', $array);
		$friday = self::newTimeBox('friday', $array);
		$saturday = self::newTimeBox('saturday', $array);
		$sunday = self::newTimeBox('sunday', $array);
		return [
			$user,
			$monday,
			$tuesday,
			$wednesday,
			$thursday,
			$friday,
			$saturday,
			$sunday
		];
	}

	public function insert(): string {
		return $this->base(
			'Insertado con éxito',
			function ($array) {
				$user = User::create($array[0]);
				if($user == null){
					throw new Exception('Ocurrió un problema al crear el usuario');
				}
				$monday = TimeBox::create($array[1]);
				if($monday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día lunes');
				}
				$tuesday = TimeBox::create($array[2]);
				if($tuesday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día martes');
				}
				$wednesday = TimeBox::create($array[3]);
				if($wednesday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día miércoles');
				}
				$thursday = TimeBox::create($array[4]);
				if($thursday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día jueves');
				}
				$friday = TimeBox::create($array[5]);
				if($friday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día viernes');
				}
				$saturday = TimeBox::create($array[6]);
				if($saturday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día sábado');
				}
				$sunday = TimeBox::create($array[7]);
				if($sunday == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de día domingo');
				}
				$availability = Availability::create(
					new Availability(
						$user->getId(),
						$monday->getId(),
						$tuesday->getId(),
						$wednesday->getId(),
						$thursday->getId(),
						$friday->getId(),
						$saturday->getId(),
						$sunday->getId()
					)
				);
				if($availability == null){
					throw new Exception('Ocurrió un problema al crear la disponibilidad de la semana');
				}
				return [
					$user,
					$monday->setId(null),
					$tuesday->setId(null),
					$wednesday->setId(null),
					$thursday->setId(null),
					$friday->setId(null),
					$saturday->setId(null),
					$sunday->setId(null)
				];
			},
			[
				'user', 'password', 'name',
				'start_monday', 'end_monday',
				'start_tuesday', 'end_tuesday',
				'start_wednday', 'end_wednday',
				'start_thursday', 'end_thursday',
				'start_friday', 'end_friday',
				'start_saturday', 'end_saturday',
				'start_sunday', 'end_sunday'
			]
		);
	}

	public function update(array $object, int $id): string {
		return $this->base(
			'Actualizado con éxito',
			function ($array) use ($id) {
				$user = User::update($array[0]->setId($id));
				if($user == null){
					throw new Exception('Ocurrió un problema al actualizar el usuario');
				}
				$availability = Availability::where(new Condition('user_id', $id))[0];
				if($availability == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de la semana');
				}
				$monday = TimeBox::update($array[1]->setId($availability->getMonday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día lunes');
				}
				$tuesday = TimeBox::update($array[2]->setId($availability->getTuesday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día martes');
				}
				$wednesday = TimeBox::update($array[3]->setId($availability->getWednesday_time_box_id()));
				if($wednesday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día miércoles');
				}
				$thursday = TimeBox::update($array[4]->setId($availability->getThursday_time_box_id()));
				if($thursday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día jueves');
				}
				$friday = TimeBox::update($array[5]->setId($availability->getFriday_time_box_id()));
				if($friday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día viernes');
				}
				$saturday = TimeBox::update($array[6]->setId($availability->getSaturday_time_box_id()));
				if($saturday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día sábado');
				}
				$sunday = TimeBox::update($array[7]->setId($availability->getSunday_time_box_id()));
				if($sunday == null){
					throw new Exception('Ocurrió un problema al actualizar la disponibilidad de día domingo');
				}
				return [
					$user,
					$monday->setId(null),
					$tuesday->setId(null),
					$wednesday->setId(null),
					$thursday->setId(null),
					$friday->setId(null),
					$saturday->setId(null),
					$sunday->setId(null)
				];
			},
			[
				'user', 'password', 'name', 'id',
				'start_monday', 'end_monday',
				'start_tuesday', 'end_tuesday',
				'start_wednesday', 'end_wednesday',
				'start_thursday', 'end_thursday',
				'start_friday', 'end_friday',
				'start_saturday', 'end_saturday',
				'start_sunday', 'end_sunday'
			]
		);
	}

	public function delete(int $id): string {
		return $this->base(
			'Eliminado con éxito',
			function ($array) use ($id) {
				$user = User::destroy($array[0]->setId($id));
				if($user == null){
					throw new Exception('Ocurrió un problema al eliminar el usuario');
				}
				$availability = Availability::where(new Condition('user_id', $id))[0];
				if($availability == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de la semana');
				}
				$monday = TimeBox::destroy($array[1]->setId($availability->getMonday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día lunes');
				}
				$tuesday = TimeBox::destroy($array[2]->setId($availability->getTuesday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día martes');
				}
				$wednesday = TimeBox::destroy($array[3]->setId($availability->getWednesday_time_box_id()));
				if($wednesday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día miércoles');
				}
				$thursday = TimeBox::destroy($array[4]->setId($availability->getThursday_time_box_id()));
				if($thursday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día jueves');
				}
				$friday = TimeBox::destroy($array[5]->setId($availability->getFriday_time_box_id()));
				if($friday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día viernes');
				}
				$saturday = TimeBox::destroy($array[6]->setId($availability->getSaturday_time_box_id()));
				if($saturday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día sábado');
				}
				$sunday = TimeBox::destroy($array[7]->setId($availability->getSunday_time_box_id()));
				if($sunday == null){
					throw new Exception('Ocurrió un problema al eliminar la disponibilidad de día domingo');
				}
				return [
					$user,
					$monday->setId(null),
					$tuesday->setId(null),
					$wednesday->setId(null),
					$thursday->setId(null),
					$friday->setId(null),
					$saturday->setId(null),
					$sunday->setId(null)
				];
			}
		);
	}

	public function find(int $id): string {
		return $this->base(
			'Encontrado con éxito',
			function ($array) use ($id) {
				$user = User::find($array[0]->setId($id));
				if($user == null){
					throw new Exception('Ocurrió un problema al buscar el usuario');
				}
				$availability = Availability::where(new Condition('user_id', $id))[0];
				if($availability == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de la semana');
				}
				$monday = TimeBox::find($array[1]->setId($availability->getMonday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día lunes');
				}
				$tuesday = TimeBox::find($array[2]->setId($availability->getTuesday_time_box_id()));
				if($monday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día martes');
				}
				$wednesday = TimeBox::find($array[3]->setId($availability->getWednesday_time_box_id()));
				if($wednesday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día miércoles');
				}
				$thursday = TimeBox::find($array[4]->setId($availability->getThursday_time_box_id()));
				if($thursday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día jueves');
				}
				$friday = TimeBox::find($array[5]->setId($availability->getFriday_time_box_id()));
				if($friday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día viernes');
				}
				$saturday = TimeBox::find($array[6]->setId($availability->getSaturday_time_box_id()));
				if($saturday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día sábado');
				}
				$sunday = TimeBox::find($array[7]->setId($availability->getSunday_time_box_id()));
				if($sunday == null){
					throw new Exception('Ocurrió un problema al buscar la disponibilidad de día domingo');
				}
				return [
					$user,
					$monday->setId(null),
					$tuesday->setId(null),
					$wednesday->setId(null),
					$thursday->setId(null),
					$friday->setId(null),
					$saturday->setId(null),
					$sunday->setId(null)
				];
			}
		);
	}

	public function all(): string {
		return $this->base(
			'Consultado con éxito',
			function ($array) {
				return User::all();
			}
		);
	}

	public function otherUser(int $id): string {
		return $this->base(
			'Consultado con éxito',
			function ($array) use ($id) {
				return array_map(
					function ($model) {
						return $model->setUser(null)->setPassword(null);
					},
					User::where(new Condition('id', $id, '<>'))
				);
			}
		);
	}
}
