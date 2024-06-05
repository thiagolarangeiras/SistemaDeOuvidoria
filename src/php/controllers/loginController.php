<?php
require_once("./models.php");
require_once("./repo.php");

// geito inseguro
//     $db = connectToDatabase();
//     $db->beginTransaction();
//     $sql = "SELECT senha FROM usuarios au WHERE au.email = $email;";
//     $result = $db->query($sql)->fetchAll();
//     $db->commit();
//     return $result["senha"];

function loginRepoGetPasswordByEmail(string $email): string {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT senha FROM usuarios au WHERE au.email = ?;");
    $prepare->execute([$email]);
    $result = $prepare->fetch();
    $db->commit();
    return $result["senha"];
}
function loginRepoGetPasswordByUsuario(string $usuario): string {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT senha FROM usuarios au WHERE au.usuario = ?");
    $prepare->execute([$usuario]);
    $result = $prepare->fetch();
    $db->commit();
    var_dump($result);
    return $result["senha"];
}

function loginController(): Response{ 
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return new Response(400,["error"=> "Metodo não permitido"]);

    //pagar os dados
    {
        $input = json_decode(file_get_contents('php://input'), TRUE); 
        $usuario = $input["usuario"]; 
        $senha = $input["senha"];
    }
    
    //validacao
    {
        if(filter_var($usuario, FILTER_VALIDATE_EMAIL))
            $senhaBanco = loginRepoGetPasswordByEmail($usuario);
        else 
            $senhaBanco = loginRepoGetPasswordByUsuario($usuario);

        if(!is_string($senhaBanco))
            $token = null;

        if(!password_verify($senha, $senhaBanco))
            $token = null;
        
        $token = "token-example";
    }

    if($token == null)
        return new Response(400, ["error" => "Senha ou Usuario incorretos!"]);
    return new Response(200, ["token" => $token]);
}
