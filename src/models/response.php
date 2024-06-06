<?php
class Response {
    public int $statusCode;
    public array|object $data;
    public function __construct(int $statusCode, array|object $data) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }    
}