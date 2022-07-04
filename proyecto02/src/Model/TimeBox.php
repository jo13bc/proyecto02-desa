<?php

class TimeBox extends Model {

	public static string $TABLE = 'time_box';

	public static function INSTANCE(): Model {
		return new TimeBox();
	}

	private ?string $start;
	private ?string $end;
	/**
	 * @param $id int 
	 * @param $start string 
	 * @param $end string 
	 */
	function __construct(string $start = null, string $end = null, int $id = null) {
		$this->id = $id;
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return string
	 */
	function getStart(): ?string {
		return $this->start;
	}

	/**
	 * @param string $start 
	 * @return TimeBox
	 */
	function setStart(string $start): self {
		$this->start = $start;
		return $this;
	}

	/**
	 * @return string
	 */
	function getEnd(): ?string {
		return $this->end;
	}

	/**
	 * @param string $end 
	 * @return TimeBox
	 */
	function setEnd(string $end): self {
		$this->end = $end;
		return $this;
	}

	public function fields(): array {
		$result = array();
		foreach ($this as $key => $value) {
			$result[] = $key;
		}
		return $result;
	}

	public function values() {
		$result = array();
		foreach ($this as $key => $value) {
			$result[] = $value;
		}
		return $result;
	}

	public static function new($array): Model {
		return new TimeBox(
			$array['start'],
			$array['end'],
			$array['id']
		);
	}

	public function toArray(string $id = 'id'): array {
		$result = array();
		foreach ($this as $key => $value) {
			if ($key === self::$PK) {
				$key = $id;
			}
			$result[$key] = $value;
		}
		return $result;
	}

	public static function all(): array {
        return DB::table(self::INSTANCE())->select();
    }

	public static function where(Condition $condition): array {
		return DB::table(self::INSTANCE())->where($condition)->select();
	}

	public function jsonSerialize(){
        return get_object_vars($this);
    }
}
