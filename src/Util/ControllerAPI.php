<?php

require_once('src/Model/Response.php');

abstract class ControllerAPI {

    protected function base(string $message, $function, $body = []): string {
        try {
            $array = array();
            foreach ($body as $key => $value) {
                $array[$key] = $value;
            }
            return json_encode(new Response(200, $message, $function($this->new($array))));
        } catch (Exception $ex) {
            return json_encode(new Response(500, $ex->getMessage()));
        }
    }
    
    protected abstract function new(array $array);
    public abstract function insert(array $object): string;
    public abstract function update(array $object, int $id): string;
    public abstract function delete(int $id): string;
    public abstract function find(int $id): string;
    public abstract function all(): string;
}
?>