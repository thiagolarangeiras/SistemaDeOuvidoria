<?php
class ReturnOuvidoriaInsert{
    public int $idOuvidoria;
    public array $idsAnexos;
}

function ouvidoriaRepoSelect(int $idUsuario = 0){
    $db = connectToDatabase();
    $db->beginTransaction();
    $sql = "SELECT * FROM ouvidoria au JOIN usuarios us ON (au.id_usuario = us.id_usuario)";
    if($idUsuario > 0){
        $sql += "WHERE au.id_usuario = $idUsuario";
    }

    $resultArray = $db->query($sql);
    $db->commit();
    return $resultArray;
    //$db->rollBack();
}

function ouvidoriaRepoInsert(Ouvidoria $ouvidoriaInsertDto): ReturnOuvidoriaInsert{
    $result = new ReturnOuvidoriaInsert();
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare("INSERT INTO ouvidoria VALUES (?, ?, ?, ?)");
    $prepare->execute([
        0, // id_ouvidoria
        $ouvidoriaInsertDto->idUsuario,
        $ouvidoriaInsertDto->descricao,
        $ouvidoriaInsertDto->tipoServico
    ]);
    $result->idOuvidoria = $db->lastInsertId();
    $db->commit();
    
    if(count($ouvidoriaInsertDto->anexos) < 1)
        return $result;

    $db->beginTransaction();
    $prepare = $db->prepare("INSERT INTO anexos VALUES (?, ?, ?)");
    foreach ($ouvidoriaInsertDto->anexos as $anexo) {
        $prepare->execute(array(
            0, // id_anexos
            $result->idOuvidoria,
            $anexo
        ));
        array_push($result->idsAnexos, $db->lastInsertId());
    }
    $db->commit();
    return $result;
}

function ouvidoriaService(){

}

function ouvidoriaController(){

}