<?php

class User extends Model {

	public static string $TABLE = 'user';

	public static function INSTANCE(): Model {
		return new User();
	}


	private ?string $user;
	private ?string $password;
	private ?string $name;

	/**
	 * @param $id int
	 * @param $user string 
	 * @param $password string 
	 * @param $name string
	 */
	function __construct(string $user = null, string $password = null, string $name = null, int $id = null) {
		$this->id = $id;
		$this->user = $user;
		$this->password = $password;
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	function getUser(): ?string {
		return $this->user;
	}

	/**
	 * @param string $user 
	 * @return User
	 */
	function setUser(?string $user): self {
		$this->user = $user;
		return $this;
	}

	/**
	 * @return string
	 */
	function getPassword(): ?string {
		return $this->password;
	}

	/**
	 * @param string $password 
	 * @return User
	 */
	function setPassword(?string $password): self {
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	function getName(): ?string {
		return $this->name;
	}

	/**
	 * @param string $name 
	 * @return User
	 */
	function setName(string $name): self {
		$this->name = $name;
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

	public static function all(): array {
		return DB::table(self::INSTANCE())->select();
	}

	public static function where(Condition $condition): array {

		return DB::table(self::INSTANCE())->where($condition)->select();
	}

	public static function whereC(Comparation $comparation) {
		$statement = DB::table(self::INSTANCE());
		while ($comparation != null) {
			$statement->where($comparation->getCondition1(), $comparation->getComparator());
			$comparation = $comparation->getCondition2();
		}
		return $statement->select();
	}

	public function jsonSerialize() {
		return get_object_vars($this);
	}

	public static function new($array): Model {
		return new User(
			$array['user'],
			$array['password'],
			$array['name'],
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
}
