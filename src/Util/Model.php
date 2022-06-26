<?php

abstract class Model implements JsonSerializable {
	public static string $TABLE;
	public static string $PK = 'id';
	protected ?int $id;

	/**
	 * @return int
	 */
	function getId(): ?int {
		return $this->id;
	}

	/**
	 * @param int $id 
	 * @return Model
	 */
	function setId(?int $id): self {
		$this->id = $id;
		return $this;
	}

	public abstract function fields();

	public abstract function values();

	public abstract function jsonSerialize();

	public abstract static function new($array): Model;

	public abstract function toArray(): array;

	public static abstract function INSTANCE(): Model;

	public abstract static function all(): array;

	public abstract static function where(Condition $condition): array;

	public static function find(Model $model) {
		return DB::table($model)->find();
	}

	public static function create(Model $model) {
		return DB::table($model)->insert();
	}

	public static function update(Model $model) {
		return DB::table($model)->update();
	}

	public static function destroy(Model $model) {
		return DB::table($model)->delete();
	}
}
