<?php
class Usuario {
    public $usuario;
    public $senha;
    public $nome;
    public $nascimento;
    public $email;
    public $telefone; 
    public $whatsapp; 
    public $cidade; 
    public $estado;
    public static function mapToUsuarioRetorno(array $usuario): Usuario {
        return Usuario::construct(
            $usuario["usuario"],
            "",
            $usuario["nome"],
            $usuario["nascimento"],
            $usuario["email"],
            $usuario["telefone"],
            $usuario["whatsapp"],
            $usuario["cidade"],
            $usuario["estado"]
        );
    }

    public static function construct($usuario, $senha, $nome, $nascimento, $email, $telefone, $whatsapp, $cidade, $estado): Usuario {
        $novoUsuario = new Usuario();
        $novoUsuario->usuario = $usuario;
        $novoUsuario->senha = $senha;
        $novoUsuario->nome = $nome;
        $novoUsuario->nascimento = $nascimento ;
        $novoUsuario->email = $email;
        $novoUsuario->telefone = $telefone; 
        $novoUsuario->whatsapp = $whatsapp; 
        $novoUsuario->cidade = $cidade; 
        $novoUsuario->estado = $estado;
        return $novoUsuario;
    }
}