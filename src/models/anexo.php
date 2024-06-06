<?php
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
    