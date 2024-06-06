<?php
class Response {
    public int $statusCode;
    public array|object $data;
    public function __construct(int $statusCode, array|object $data) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }    
}

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

class Ouvidoria {
    public int $idOuvidoria;
    public int $idUsuario;
    public string $descricao;
    public string $tipoServico;
    public array $anexos;
    public Usuario|null $usuario;

    public static function mapToOuvidoriaRetornoOne(array $ouvidoria): Ouvidoria {
        $usuario = new Usuario();
        $usuario->nome = $ouvidoria[0]["usuario_nome"];
        
        $anexos = [];
        if ($ouvidoria[0]["id_anexo"] != null)
        foreach($ouvidoria as $key => $value) {
            array_push($anexos, new Anexo(
                $value["id_anexo"],
                $value["id_ouvidoria"],
                $value["anexo_nome"],
            ));    
        }
        
        return new Ouvidoria(
            $ouvidoria[0]["id_ouvidoria"],
            $ouvidoria[0]["id_usuario"],
            $ouvidoria[0]["descricao"],
            $ouvidoria[0]["tipo_servico"],
            $anexos,
            $usuario
        );
    }

    public static function mapToOuvidoriaRetornoAll(array $ouvidoria): Ouvidoria {
        $usuario = new Usuario();
        $usuario->nome = $ouvidoria["usuario_nome"];
        return new Ouvidoria(
            $ouvidoria["id_ouvidoria"],
            $ouvidoria["id_usuario"],
            $ouvidoria["descricao"],
            $ouvidoria["tipo_servico"],
            [],
            $usuario
        );
    }


    public function __construct($idOuvidoria, $idUsuario, $descricao, $tipoServico, $anexos, $usuario) {
        $this->idOuvidoria = $idOuvidoria;
        $this->idUsuario = $idUsuario;
        $this->descricao = $descricao;
        $this->tipoServico = $tipoServico;
        $this->anexos = $anexos;
        $this->usuario = $usuario;
    }
}

class Anexo {
    public int $idAnexo;
    public int $idOuvidoria;
    public string $nome;
    public function __construct(int $idAnexo, int $idOuvidoria, string $nome) {
        $this->idAnexo = $idAnexo;
        $this->idOuvidoria = $idOuvidoria;
        $this->nome = $nome;
    }
}
    