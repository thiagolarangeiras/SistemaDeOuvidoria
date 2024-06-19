<?php
class Usuario {
    public string $usuario;
    public string $senha;
    public string $nome;
    public string $nascimento;
    public string $email;
    public string $telefone; 
    public string $whatsapp; 
    public string $cidade; 
    public string $estado;
    public bool $validado;
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
        $novoUsuario->validado = false;
        return $novoUsuario;
    }
}