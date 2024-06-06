<?php

function mapOuvidoriaResult(array $ouvidoria): OuvidoriaResult {
    $result = new OuvidoriaResult(); 
    $result->idOuvidoria = $ouvidoria["id_ouvidoria"];
    $result->idUsuario = $ouvidoria["id_usuario"];
    $result->descricao = $ouvidoria["descricao"];
    $result->tipoServico = $ouvidoria["tipo_servico"];
    $result->nomeUsuario = $ouvidoria["usuario_nome"];
    return $result;
}

function mapOuvidoriaAnexoResult(array $anexo): OuvidoriaAnexoResult {
    $result = new OuvidoriaAnexoResult(); 
    $result->idAnexo = $anexo["id_anexo"];
    $result->nome = $anexo["nome"];
    return $result;
}

class OuvidoriaAnexoResult {
    public int $idAnexo;
    public string $nome;
}

class OuvidoriaResult {
    public int $idOuvidoria;
    public int $idUsuario;
    public string $descricao;
    public string $tipoServico;
    public string $nomeUsuario;
    public array $anexos;
}