<?php
function anexoRepoSelectAll(int $idOuvidoria): array{
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare(
        "SELECT id_anexo, nome FROM anexos 
        WHERE id_ouvidoria = :idOuvidoria"
    );

    $prepare->bindParam(':idOuvidoria', $idOuvidoria, PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}

function anexoRepoSelectArquivo(int $idAnexo): string{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT arquivo FROM anexos WHERE id_anexo = ?;");    
    $prepare->execute([$idAnexo]);
    $file = $prepare->fetch(PDO::FETCH_ASSOC);
    $db->commit();
    return $file["arquivo"];
}

function anexoRepoInsert(int $idOuvidoria, string $name, string $anexo): int{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("INSERT INTO anexos VALUES (?, ?, ?, ?)");    
    $prepare->execute([
        0, // id_anexo
        $idOuvidoria,
        $name,
        $anexo
    ]);
    $id = $db->lastInsertId();
    $db->commit();
    return $id;
}


function anexoRepoDelete(int $idAnexo): void{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("DELETE FROM anexos WHERE id_anexo = ?");    
    $prepare->execute([$idAnexo]);
    $db->commit();
}