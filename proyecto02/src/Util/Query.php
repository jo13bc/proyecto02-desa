<?php

class Order implements JsonSerializable {
    private string $column;
    private string $order;

    public function __construct(string $column, string $order = 'ASC') {
        $this->column = $column;
        $this->order = $order;
    }

    public function generate(): string {
        return $this->column . ' ' . $this->order;
    }
    /**
     * @return string
     */
    function getColumn(): string {
        return $this->column;
    }

    /**
     * @param string $column 
     * @return Order
     */
    function setColumn(string $column): self {
        $this->column = $column;
        return $this;
    }

    /**
     * @return string
     */
    function getOrder(): string {
        return $this->order;
    }

    /**
     * @param string $order 
     * @return Order
     */
    function setOrder(string $order): self {
        $this->order = $order;
        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    function jsonSerialize() {
        return get_object_vars($this);
    }
}

class Condition implements JsonSerializable {
    private string $param1;
    private string $comparator;
    private $param2;

    public function __construct(string $param1, $param2, string $comparator = '=') {
        $this->param1 = $param1;
        $this->comparator = $comparator;
        $this->param2 = $param2;
    }

    public function generate(): string {
        return $this->param1 . ' ' . $this->comparator . ' ?';
    }

    public function generateValue() {
        return $this->param2;
    }

    /**
     * @return string
     */
    function getParam1(): string {
        return $this->param1;
    }

    /**
     * @param string $param1 
     * @return Condition
     */
    function setParam1(string $param1): self {
        $this->param1 = $param1;
        return $this;
    }

    /**
     * @return string
     */
    function getComparator(): string {
        return $this->comparator;
    }

    /**
     * @param string $comparator 
     * @return Condition
     */
    function setComparator(string $comparator): self {
        $this->comparator = $comparator;
        return $this;
    }


    /**
     * Get the value of param2
     */
    public function getParam2() {
        return $this->param2;
    }

    /**
     * Set the value of param2
     *
     * @return  self
     */
    public function setParam2($param2) {
        $this->param2 = $param2;

        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    function jsonSerialize() {
        return get_object_vars($this);
    }
}

class Set implements JsonSerializable {
    private string $column;
    private $value;

    public function __construct(string $column, $value) {
        $this->column = $column;
        $this->value = $value;
    }

    public function generate(): string {
        return $this->column . ' = ' . '?';
    }

    /**
     * @return string
     */
    function getColumn(): string {
        return $this->column;
    }

    /**
     * @param string $column 
     * @return Set
     */
    function setColumn(string $column): self {
        $this->column = $column;
        return $this;
    }

    /**
     * @return string
     */
    function getValue() {
        return $this->value;
    }

    /**
     * @param string $value 
     * @return Set
     */
    function setValue($value): self {
        $this->value = $value;
        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    function jsonSerialize() {
        return get_object_vars($this);
    }
}

class Comparation implements JsonSerializable {
    private Condition $condition1;
    private string $comparator;
    private ?Comparation $condition2;
    public function __construct(Condition $condition1, string $comparator = 'AND', Comparation $condition2 = null) {
        $this->condition1 = $condition1;
        $this->comparator = $comparator;
        $this->condition2 = $condition2;
    }

    public function generate(): string {
        if ($this->condition2 === null) return $this->condition1->generate();
        return $this->condition1->generate() . ' ' . $this->comparator . ' ' .  $this->condition2->generate();
    }

    public function generateValue(): array {
        if ($this->condition2 === null) return [$this->condition1->generateValue()];
        return array_merge([$this->condition1->generateValue()], $this->condition2->generateValue());
    }

    /**
     * @return Condition
     */
    function getCondition1(): Condition {
        return $this->condition1;
    }

    /**
     * @param Condition $condition1 
     * @return Comparation
     */
    function setCondition1(Condition $condition1): self {
        $this->condition1 = $condition1;
        return $this;
    }

    /**
     * @return string
     */
    function getComparator(): string {
        return $this->comparator;
    }

    /**
     * @param string $comparator 
     * @return Comparation
     */
    function setComparator(string $comparator): self {
        $this->comparator = $comparator;
        return $this;
    }

    /**
     * @return Comparation
     */
    function getCondition2(): ?Comparation {
        return $this->condition2;
    }

    /**
     * @param Comparation $condition2 
     * @return Comparation
     */
    function setCondition2(Comparation $condition2): self {
        $this->condition2 = $condition2;
        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value of any type other than a resource .
     */
    function jsonSerialize() {
        return get_object_vars($this);
    }
}

class DB {

    protected static $db_config;
    protected static $dbh;

    public function __construct() {
        if (empty(self::$db_config)) {
            self::init();
        }
    }

    private static function init() {
        if (empty(self::$db_config)) {
            self::$db_config = parse_ini_file('config.ini');
        }
        self::$dbh = new PDO(self::$db_config['db_driver'] . ":" . self::$db_config['db_name']);
        if (empty(self::$dbh)) {
            throw new Exception('Database not found.');
        }
    }

    private static function connection(Statement $statement, $process) {
        if (empty(self::$db_config)) {
            self::init();
        }
        self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = self::$dbh->prepare($statement->generate());
        if (!$stmt) {
            throw new Exception('Query not found.');
        }
        //echo '<script>alert("' . json_encode($statement->values()) . '")</script>';
        foreach ($statement->values() as $k => $v) {
            $stmt->bindValue($k + 1, $v);
        }
        return $process($stmt, self::$dbh);
    }

    public static function function(Statement $statement) {
        return self::connection($statement, function ($stmt, $dbh) {
            $stmt->execute();
            $data = array();
            while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $result;
            }
            return $data;
        });
    }

    public static function procedure(Statement $query) {
        self::connection($query, function ($stmt, $dbh) {
            $dbh->beginTransaction();
            $stmt->execute();
            $dbh->commit();
        });
    }

    public static function table(Model $model) {
        $qry = new Statement($model);
        return $qry;
    }
}

class Statement {

    private Model $model;
    private bool $distinct;
    private ?string $insert;
    private ?string $update;
    private ?string $delete;
    private ?string $select;
    private ?string $columns;
    private ?array $set;
    private ?Comparation $where;
    private ?Comparation $having;
    private ?array $order;
    private ?array $group;
    private ?int $limit;
    private ?int $skip;

    public function __construct(Model $model) {
        $this->model = $model;
        $this->clear();
    }

    private function clear() {
        $this->insert = null;
        $this->update = null;
        $this->delete = null;
        $this->select = null;
        $this->set = null;
        $this->distinct = false;
        $this->columns = null;
        $this->where = null;
        $this->having = null;
        $this->order = null;
        $this->group = null;
        $this->limit = null;
        $this->skip = null;
    }

    public function set(Set $set) {
        if ($this->set === null) {
            $this->set[] = $set;
        } else {
            $this->set[] = $set;
        }
        return $this;
    }

    public function where(Condition $condition, string $comparator = 'AND'): self {
        if ($this->where === null) {
            $this->where = new Comparation($condition, $comparator);
        } else {
            $actual = $this->where;
            while ($actual->getCondition2() != null) {
                $actual = $actual->getCondition2();
            }
            $actual->setCondition2(new Comparation($condition, $comparator));
        }
        return $this;
    }

    public function distinct(bool $distinct) {
        $this->distinct = $distinct;
        return $this;
    }

    public function orderBy(array $order) {
        if ($this->order === null) {
            $this->order = $order;
        } else {
            $this->order = array_merge($this->order, $order);
        }
        return $this;
    }

    public function groupBy(array $group) {
        if ($this->group === null) {
            $this->group = $group;
        } else {
            $this->group = array_merge($this->group, $group);
        }
        return $this;
    }

    public function having(Comparation $comparation) {
        if ($this->having === null) {
            $this->having = $comparation;
        } else {
            $actual = $this->having;
            while ($actual->getCondition2() != null) {
                $actual = $actual->condition2;
            }
            $actual->setCondition2($comparation);
        }
        return $this;
    }

    public function skip($num) {
        $this->skip = $num;
        return $this;
    }

    public function limit($num) {
        $this->limit = $num;
        return $this;
    }

    public function column($column) {
        $this->columns .= (($this->columns === null) ? '' : ', ') . $column;
        return $this;
    }

    public function first() {
        return $this->limit(1)->select()[0];
    }

    public function find() {
        $condition = new Condition($this->model::$PK, $this->model->getId());
        return $this->limit(1)->where($condition)->select()[0];
    }

    public function last() {
        return $this->limit(1)->orderBy([new Order($this->model::$PK, 'DESC')])->select()[0];
    }

    public function insert() {
        $insert_column = $this->model->fields();
        unset($insert_column[0]);
        $this->insert = "INSERT INTO " . $this->model::$TABLE;
        $this->insert .= " ( " . join(',', array_map(function ($x) {
            return $x;
        }, $insert_column)) . " ) ";
        $this->insert .= " VALUES ( " . join(',', array_map(function ($x) {
            return '?';
        }, $insert_column)) . " ) ";
        foreach ($this->model->toArray() as $k => $v) {
            if ($k !== $this->model::$PK) {
                $this->set(new Set($k, $v));
            }
        }
        DB::procedure($this);
        $this->clear();
        return $this->last();
    }

    public function update() {
        foreach ($this->model->toArray() as $k => $v) {
            if ($k !== $this->model::$PK) {
                $this->set(new Set($k, $v));
            }
        }
        $this->update = "UPDATE " . $this->model::$TABLE;
        $this->update .= ' SET ' . join(',', array_map(function ($x) {
            return $x->generate();
        }, $this->set));
        $this->where(new Condition($this->model::$PK, $this->model->getId()));
        DB::procedure($this);
        $this->clear();
        return $this->find();
    }

    public function delete() {
        $model = $this->find();
        $this->clear();
        $this->delete = "DELETE FROM " . $this->model::$TABLE;
        $this->where(new Condition($this->model::$PK, $this->model->getId()));
        DB::procedure($this);
        $this->clear();
        return $model;
    }

    public function select() {
        $this->select = 'SELECT ' . (($this->distinct) ? 'distinct ' : '');
        foreach ($this->model->fields() as $field) {
            $this->column($field);
        }
        $this->select .= ($this->columns === null) ? '*' : $this->columns;
        $this->select .= " FROM " . $this->model::$TABLE;
        return array_map(
            function ($item) {
                return $this->model::new($item);
            },
            DB::function($this)
        );
    }

    public function values() {
        $where_values = $this->where !== null ? $this->where->generateValue() : [];
        $set_values = [];
        if ($this->set !== null) {
            foreach ($this->set as $value) {
                $set_values[] = $value->getValue();
            }
        }
        return array_merge($set_values, $where_values);
    }

    private function generateInsert(): string {
        return ($this->insert !== null) ? $this->insert : '';
    }

    private function generateUpdate(): string {
        return ($this->update !== null) ? $this->update : '';
    }

    private function generateDelete(): string {
        return ($this->delete !== null) ? $this->delete : '';
    }

    private function generateSelect(): string {
        return ($this->select !== null) ? $this->select : '';
    }

    private function generateWhere(): string {
        return ($this->where === null) ? '' : ' WHERE ' . $this->where->generate();
    }

    private function generateOther(): string {
        $statement = '';
        if ($this->select !== null) {
            if ($this->having !== null) $statement .= " HAVING " . $this->having->generate();
            if ($this->order !== null) $statement .= " ORDER BY " . implode(',', array_map(function ($o) {
                return $o->generate();
            }, $this->order));
            if ($this->limit !== null) $statement .= " LIMIT(" . $this->limit . ')';
            if ($this->skip !== null) $statement .= " OFFSET(" . $this->skip . ')';
        }
        return $statement;
    }

    public function generate(): string {
        $statement = '';
        $statement .= $this->generateInsert();
        $statement .= $this->generateUpdate();
        $statement .= $this->generateDelete();
        $statement .= $this->generateSelect();
        $statement .= $this->generateWhere();
        $statement .= $this->generateOther();
        return $statement;
    }
}
