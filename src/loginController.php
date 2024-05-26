<?php
require_once("./models.php");
require_once("./repo.php");

function loginRepoGetPasswordByEmail(string $email): string {
    $db = connectToDatabase();
    $db->beginTransaction();
    $sql = "SELECT senha FROM usuarios au WHERE au.email = $email;";
    $result = $db->query($sql)->fetchColumn();
    $db->commit();
    return $result["senha"];
}
function loginRepoGetPasswordByUsuario(string $usuario): string {
    $db = connectToDatabase();
    $db->beginTransaction();
    $sql = "SELECT senha FROM usuarios au WHERE au.usuario = $usuario;";
    $result = $db->query($sql)->fetchColumn();
    $db->commit();
    return $result["senha"];
}

function loginService(string $usuarioOuEmail, string $senha): string { 
    if(filter_var($usuarioOuEmail, FILTER_VALIDATE_EMAIL))
        $senhaBanco = loginRepoGetPasswordByEmail($usuarioOuEmail);
    else 
        $senhaBanco = loginRepoGetPasswordByUsuario($usuarioOuEmail);

    if(!is_string($senhaBanco))
        return null;

    if(!password_verify($senha, $senhaBanco))
        return null;
    
    return "token-example";
}

function loginController(): Response{
try {
    $input = json_decode(file_get_contents('php://input')); 
    //fazer sanatizar essa data
    $usuario = $input["usuario"]; 
    $senha = $input["senha"];
    $token = loginService($usuario, $senha);
    if($token == null)
        return new Response(400, ["error" => "Senha ou Usuario incorretos!"]);
    return new Response(200, ["token" => $token]);
} catch (\Throwable $th) {
    throw $th;
}
}
