<?php
class Response {
    public int $statusCode;
    public array $data;
    public function __construct(int $statusCode, array $data) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }    
}

class Usuario {
    public $usuario;
    public $senha;
    public $nome;
    public $nascimento ;
    public $email;
    public $telefone; 
    public $whatsapp; 
    public $cidade; 
    public $estado;
    public function __construct($usuario, $senha, $nome, $nascimento, $email, $telefone, $whatsapp, $cidade, $estado) {
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->nascimento = $nascimento ;
        $this->email = $email;
        $this->telefone = $telefone; 
        $this->whatsapp = $whatsapp; 
        $this->cidade = $cidade; 
        $this->estado = $estado;
    }
}

class Ouvidoria {
    public $idUsuario;
    public $descricao;
    public $tipoServico;
    public $anexos;
    public function __construct($idUsuario, $descricao, $tipoServico, $anexos) {
        $this->idUsuario = $idUsuario;
        $this->descricao = $descricao;
        $this->tipoServico = $tipoServico;
        $this->anexos = $anexos;
    }
}
    