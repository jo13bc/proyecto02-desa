<?php

require_once('src/Model/Meeting.php');
require_once('src/Model/TimeBox.php');

class MeetingController extends ControllerAPI {

	protected function new(array $array) {
		$timeBox = new TimeBox(json_encode($array['start']), $array['end']);
		$meeting = Meeting::new($array);
		return [$meeting, $timeBox];
	}

	public function insert(array $body): string {
		$json = '';
		foreach($body as $key => $value){
			$json .= $key;
		}
		$object = json_decode($json);
		return $this->base(
			'Insertado con éxito',
			function ($array) {
				$timeBox = TimeBox::create($array[1]);
				if($timeBox == null){
					throw new Exception('Ocurrió un problema al crear el tiempo de la reunión');
				}
				$meeting = Meeting::create($array[0]->setTimeBoxId($timeBox->getId()));
				if($meeting == null){
					throw new Exception('Ocurrió un problema al crear la reunión');
				}
				return [$meeting, $timeBox->setId(null)];
			},
			$object
		);
	}

	public function update(array $body, int $id): string {
		$json = '';
		foreach($body as $key => $value){
			$json .= $key;
		}
		$object = json_decode($json);
		return $this->base(
			'Actualizado con éxito',
			function ($array) use ($id) {
				$meeting = Meeting::find($array[0]->setId($id));
				if($meeting == null){
					throw new Exception('Ocurrió un problema al buscar la reunión para actualizarla');
				}
				$timeBox = TimeBox::update($array[1]->setId($meeting->getTimeBoxId()));
				if($timeBox == null){
					throw new Exception('Ocurrió un problema al actualizar el tiempo de la reunión');
				}
				$meeting = Meeting::update($array[0]->setId($id)->setTimeBoxId($timeBox->getId()));
				if($meeting == null){
					throw new Exception('Ocurrió un problema al actualizar la reunión');
				}
				return [$meeting->setTimeBoxId(null), $timeBox->setId(null)];
			},
			$object
		);
	}

	public function delete(int $id): string {
		return $this->base(
			'Eliminado con éxito',
			function ($array) use ($id) {
				$meeting = Meeting::find($array[0]->setId($id));
				if($meeting == null){
					throw new Exception('Ocurrió un problema al buscar la reunión para eliminarla');
				}
				$timeBox = TimeBox::destroy($array[1]->setId($meeting->getTimeBoxId()));
				if($timeBox == null){
					throw new Exception('Ocurrió un problema al eliminar el tiempo de la reunión');
				}
				$meeting = Meeting::destroy($meeting);
				return [$meeting->setTimeBoxId(null), $timeBox->setId(null)];
			}
		);
	}

	public function find(int $id): string {
		return $this->base(
			'Encontrado con éxito',
			function ($array) use ($id) {
				$meeting = Meeting::find($array[0]->setId($id));
				if($meeting == null){
					throw new Exception('Ocurrió un problema al buscar la reunión');
				}
				$timeBox = TimeBox::find($array[1]->setId($meeting->getTimeBoxId()));
				if($timeBox == null){
					throw new Exception('Ocurrió un problema al buscar el tiempo para la reunión');
				}
				return [$meeting->setTimeBoxId(null), $timeBox->setId(null)];
			}
		);
	}

	public function all(): string {
		return $this->base(
			'Consultado con éxito',
			function ($array) {
				return array_map(
					function ($model) {
						$timeBox = TimeBox::find((new TimeBox())->setId($model->getTimeBoxId()));
						return [$model->setTimeBoxId(null), $timeBox];
					},
					Meeting::all()
				);
			}
		);
	}

	public function forUser(int $id): string {
		return $this->base(
			'Consultado con éxito',
			function ($array) use ($id) {
				return array_map(
					function ($model) {
						$timeBox = TimeBox::find((new TimeBox())->setId($model->getTimeBoxId()));
						return [$model->setTimeBoxId(null), $timeBox];
					},
					Meeting::where(new Condition('professional_id', $id))
				);
			}
		);
	}
}
