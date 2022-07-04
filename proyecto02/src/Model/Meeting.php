<?php

class Meeting extends Model {

	public static string $TABLE = 'meeting';

	public static function INSTANCE(): Meeting {
		return new Meeting();
	}

	private ?int $professional_id;
	private ?string $date;
	private ?string $description;
	private ?int $time_box_id;
	private ?int $user_id;

	/**
	 * @param $TABLE mixed 
	 * @param $professional_id int 
	 * @param $date string 
	 * @param $description string 
	 * @param $time_box_id int 
	 * @param $user_id int 
	 */
	function __construct(int $professional_id = null, string $date = null, string $description = null, int $time_box_id = null, int $user_id = null, int $id = null) {
		$this->id = $id;
		$this->professional_id = $professional_id;
		$this->date = $date;
		$this->description = $description;
		$this->time_box_id = $time_box_id;
		$this->user_id = $user_id;
	}

	/**
	 * @return int
	 */
	function getProfessionalId(): ?int {
		return $this->professional_id;
	}

	/**
	 * @param int $professional_id 
	 * @return Meeting
	 */
	function setProfessionalId(?int $professional_id): self {
		$this->professional_id = $professional_id;
		return $this;
	}

	/**
	 * @return string
	 */
	function getDate(): ?string {
		return $this->date;
	}

	/**
	 * @param string $date 
	 * @return Meeting
	 */
	function setDate(string $date): self {
		$this->date = $date;
		return $this;
	}

	/**
	 * @return string
	 */
	function getDescription(): ?string {
		return $this->description;
	}

	/**
	 * @param string $description 
	 * @return Meeting
	 */
	function setDescription(string $description): self {
		$this->description = $description;
		return $this;
	}

	/**
	 * @return int
	 */
	function getTimeBoxId(): ?int {
		return $this->time_box_id;
	}

	/**
	 * @param int $time_box_id 
	 * @return Meeting
	 */
	function setTimeBoxId(?int $time_box_id): self {
		$this->time_box_id = $time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getUserId(): ?int {
		return $this->user_id;
	}

	/**
	 * @param int $user_id 
	 * @return Meeting
	 */
	function setUserId(?int $user_id): self {
		$this->user_id = $user_id;
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

	public static function new($array): Meeting {
		return new Meeting(
			(int) $array['professional_id'],
			$array['date'],
			$array['description'],
			(int) $array['time_box_id'],
			(int) $array['user_id'],
			(int) $array['id']
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

	public function jsonSerialize() {
		return get_object_vars($this);
	}
}
