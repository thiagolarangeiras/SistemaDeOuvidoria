<?php
// geito inseguro
//     $db = connectToDatabase();
//     $db->beginTransaction();
//     $sql = "SELECT senha FROM usuarios au WHERE au.email = $email;";
//     $result = $db->query($sql)->fetchAll();
//     $db->commit();
//     return $result["senha"];

function loginRepoGetPasswordByEmail(string $email): array|bool {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT id_usuario, senha FROM usuarios au WHERE au.email = ?;");
    $prepare->execute([$email]);
    $result = $prepare->fetch(PDO::FETCH_ASSOC);
    $db->commit();
    return $result;
}
function loginRepoGetPasswordByUsuario(string $usuario): array|bool {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT id_usuario, senha FROM usuarios au WHERE au.usuario = ?;");
    $prepare->execute([$usuario]);
    $result = $prepare->fetch(PDO::FETCH_ASSOC);
    $db->commit();
    return $result;
}