<?php
function userRepoSelectAll(int $page = 0, int $count = 50): array{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT * FROM usuarios au LIMIT :limit OFFSET :offset");
   
    $offset = $page * $count;
    $prepare->bindParam(':limit', $count, PDO::PARAM_INT);
    $prepare->bindParam(':offset', $offset, PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();

    return $resultArray;
}

function userRepoSelectOne(int $idUsuario): array{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT * FROM usuarios au WHERE id_usuario = :id");
    $prepare->bindParam(':id', $idUsuario, PDO::PARAM_INT);
    $prepare->execute();
    $resultArray = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $resultArray;
}

function userRepoInsert(Usuario $usuarioInsertDto): int{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("INSERT INTO usuarios VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $prepare->execute([
        0, // id_usuario
        $usuarioInsertDto->usuario,
        $usuarioInsertDto->senha,
        $usuarioInsertDto->nome,
        $usuarioInsertDto->nascimento,
        $usuarioInsertDto->email,
        $usuarioInsertDto->telefone,
        $usuarioInsertDto->whatsapp,
        $usuarioInsertDto->cidade,
        $usuarioInsertDto->estado
    ]);
    $id = $db->lastInsertId();
    $db->commit();
    return $id;
}

function userRepoCheckEmail(string $email): bool{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT 1 FROM usuarios WHERE email = ?;");
    $prepare->execute([$email]);
    $result = $prepare->fetch();
    $db->commit();
    if(is_array($result))
        return true;
    return false;
}

function userRepoCheckUser(string $usuario): bool{
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT 1 FROM usuarios WHERE usuario = ?;");
    $prepare->execute([$usuario]);
    $result = $prepare->fetch();
    $db->commit();
    if(is_array($result))
        return true;
    return false;
}