<?php
function ouvidoriaRepoSelectAll(int $page = 0, int $count = 50): array{
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare(
        "SELECT ou.*, us.nome AS usuario_nome FROM ouvidorias ou 
        INNER JOIN usuarios us ON (ou.id_usuario = us.id_usuario)
        WHERE ou.id_usuario = :idUsario
        LIMIT :limit OFFSET :offset"
    );

    $offset = $page * $count;
    $prepare->bindParam(':limit', $count, PDO::PARAM_INT);
    $prepare->bindParam(':offset', $offset, PDO::PARAM_INT);
    $prepare->bindParam(':idUsario', $_SESSION['userId'], PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}

function ouvidoriaRepoSelectOne(int $idOuvidoria): array{
    $db = connectToDatabase();
    $db->beginTransaction();

    $prepare = $db->prepare(
        "SELECT ou.*, 
            an.id_anexo, 
            an.nome AS anexo_nome
        FROM ouvidorias ou 
        LEFT JOIN anexos an ON (an.id_ouvidoria = ou.id_ouvidoria) 
        WHERE ou.id_ouvidoria = :id AND ou.id_usuario = :idUsario"
    );
    
    $prepare->bindParam(':id', $idOuvidoria, PDO::PARAM_INT);
    $prepare->bindParam(':idUsario', $_SESSION['userId'], PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}


function ouvidoriaRepoInsert(Ouvidoria $ouvidoria): int{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("INSERT INTO ouvidorias VALUES (?, ?, ?, ?)");
    $prepare->execute([
        0, // id_ouvidoria
        $ouvidoria->idUsuario,
        $ouvidoria->descricao,
        $ouvidoria->tipoServico
    ]);
    $id = $db->lastInsertId();
    $db->commit();
    return $id;
}