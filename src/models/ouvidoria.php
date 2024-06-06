<?php

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

class OuvidoriaResult {
    public int $idOuvidoria;
    public int $idUsuario;
    public string $descricao;
    public string $tipoServico;
    public string $nomeUsuario;
    public array $anexos;
}

function mapOuvidoriaResult(array $ouvidoria): OuvidoriaResult {
    $result = new OuvidoriaResult(); 
    $result->idOuvidoria = $ouvidoria["id_ouvidoria"];
    $result->idUsuario = $ouvidoria["id_usuario"];
    $result->descricao = $ouvidoria["descricao"];
    $result->tipoServico = $ouvidoria["tipo_servico"];
    $result->nomeUsuario = $ouvidoria["usuario_nome"];
    return $result;
}

class OuvidoriaAnexoResult {
    public int $idAnexo;
    public string $nome;
}

function mapOuvidoriaAnexoResult(array $anexo): OuvidoriaAnexoResult {
    $result = new OuvidoriaAnexoResult(); 
    $result->idAnexo = $anexo["id_anexo"];
    $result->nome = $anexo["nome"];
    return $result;
}