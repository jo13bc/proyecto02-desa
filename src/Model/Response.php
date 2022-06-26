<?php

class Response implements JsonSerializable {

	private ?int $code;
	private ?string $message;
	private $result;

	public function jsonSerialize() {
		return get_object_vars($this);
	}
	/**
	 * @param $code ?int 
	 * @param $message ?string 
	 * @param $result mixed 
	 */
	function __construct(?int $code, ?string $message, $result = null) {
	    $this->code = $code;
	    $this->message = $message;
	    $this->result = $result;
	}
	/**
	 * @return ?int
	 */
	function getCode(): ?int {
		return $this->code;
	}
	
	/**
	 * @param ?int $code 
	 * @return Response
	 */
	function setCode(?int $code): self {
		$this->code = $code;
		return $this;
	}
	
	/**
	 * @return ?string
	 */
	function getMessage(): ?string {
		return $this->message;
	}
	
	/**
	 * @param ?string $message 
	 * @return Response
	 */
	function setMessage(?string $message): self {
		$this->message = $message;
		return $this;
	}
	
	/**
	 * @return mixed
	 */
	function getResult() {
		return $this->result;
	}
	
	/**
	 * @param mixed $result 
	 * @return Response
	 */
	function setResult($result): self {
		$this->result = $result;
		return $this;
	}
}
