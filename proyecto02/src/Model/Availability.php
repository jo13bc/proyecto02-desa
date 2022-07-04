<?php

class Availability extends Model {

	public static string $TABLE = 'availability';

	public static function INSTANCE(): Model {
		return new Availability();
	}

	private ?int $user_id;
	private ?int $monday_time_box_id;
	private ?int $tuesday_time_box_id;
	private ?int $wednesday_time_box_id;
	private ?int $thursday_time_box_id;
	private ?int $friday_time_box_id;
	private ?int $saturday_time_box_id;
	private ?int $sunday_time_box_id;

	/**
	 * @param $user_id int 
	 * @param $monday_time_box_id int 
	 * @param $tuesday_time_box_id int 
	 * @param $wednesday_time_box_id int 
	 * @param $thursday_time_box_id int 
	 * @param $friday_time_box_id int 
	 * @param $saturday_time_box_id int 
	 * @param $sunday_time_box_id int 
	 * @param $id int 
	 */
	function __construct(int $user_id = null, int $monday_time_box_id = null, int $tuesday_time_box_id = null, int $wednesday_time_box_id = null, int $thursday_time_box_id = null, int $friday_time_box_id = null, int $saturday_time_box_id = null, int $sunday_time_box_id = null, int $id = null) {
		$this->id = $id;
		$this->user_id = $user_id;
		$this->monday_time_box_id = $monday_time_box_id;
		$this->tuesday_time_box_id = $tuesday_time_box_id;
		$this->wednesday_time_box_id = $wednesday_time_box_id;
		$this->thursday_time_box_id = $thursday_time_box_id;
		$this->friday_time_box_id = $friday_time_box_id;
		$this->saturday_time_box_id = $saturday_time_box_id;
		$this->sunday_time_box_id = $sunday_time_box_id;
	}
	/**
	 * @return int
	 */
	function getUser_id(): ?int {
		return $this->user_id;
	}

	/**
	 * @param int $user_id 
	 * @return Availability
	 */
	function setUser_id(int $user_id): self {
		$this->user_id = $user_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getMonday_time_box_id(): ?int {
		return $this->monday_time_box_id;
	}

	/**
	 * @param int $monday_time_box_id 
	 * @return Availability
	 */
	function setMonday_time_box_id(int $monday_time_box_id): self {
		$this->monday_time_box_id = $monday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getTuesday_time_box_id(): ?int {
		return $this->tuesday_time_box_id;
	}

	/**
	 * @param int $tuesday_time_box_id 
	 * @return Availability
	 */
	function setTuesday_time_box_id(int $tuesday_time_box_id): self {
		$this->tuesday_time_box_id = $tuesday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getWednesday_time_box_id(): ?int {
		return $this->wednesday_time_box_id;
	}

	/**
	 * @param int $wednesday_time_box_id 
	 * @return Availability
	 */
	function setWednesday_time_box_id(int $wednesday_time_box_id): self {
		$this->wednesday_time_box_id = $wednesday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getThursday_time_box_id(): ?int {
		return $this->thursday_time_box_id;
	}

	/**
	 * @param int $thursday_time_box_id 
	 * @return Availability
	 */
	function setThursday_time_box_id(int $thursday_time_box_id): self {
		$this->thursday_time_box_id = $thursday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getFriday_time_box_id(): ?int {
		return $this->friday_time_box_id;
	}

	/**
	 * @param int $friday_time_box_id 
	 * @return Availability
	 */
	function setFriday_time_box_id(int $friday_time_box_id): self {
		$this->friday_time_box_id = $friday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getSaturday_time_box_id(): ?int {
		return $this->saturday_time_box_id;
	}

	/**
	 * @param int $saturday_time_box_id 
	 * @return Availability
	 */
	function setSaturday_time_box_id(int $saturday_time_box_id): self {
		$this->saturday_time_box_id = $saturday_time_box_id;
		return $this;
	}

	/**
	 * @return int
	 */
	function getSunday_time_box_id(): ?int {
		return $this->sunday_time_box_id;
	}

	/**
	 * @param int $sunday_time_box_id 
	 * @return Availability
	 */
	function setSunday_time_box_id(int $sunday_time_box_id): self {
		$this->sunday_time_box_id = $sunday_time_box_id;
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
		return new Availability(
			$array['user_id'],
			$array['monday_time_box_id'],
			$array['tuesday_time_box_id'],
			$array['wednesday_time_box_id'],
			$array['thursday_time_box_id'],
			$array['friday_time_box_id'],
			$array['saturday_time_box_id'],
			$array['sunday_time_box_id'],
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

	public function jsonSerialize() {
		return get_object_vars($this);
	}

	public static function findByUser(int $user_id): array {
		$availability = DB::table(self::INSTANCE())->where(new Condition('user_id', $user_id))->first();
		$timeBox = new TimeBox();
		return [
			'monday' => TimeBox::find($timeBox->setId($availability->getMonday_time_box_id())),
			'tuesday' => TimeBox::find($timeBox->setId($availability->getTuesday_time_box_id())),
			'wednesday' => TimeBox::find($timeBox->setId($availability->getWednesday_time_box_id())),
			'thursday' => TimeBox::find($timeBox->setId($availability->getThursday_time_box_id())),
			'friday' => TimeBox::find($timeBox->setId($availability->getFriday_time_box_id())),
			'saturday' => TimeBox::find($timeBox->setId($availability->getSaturday_time_box_id())),
			'sunday' => TimeBox::find($timeBox->setId($availability->getSunday_time_box_id()))
		];
	}
}
