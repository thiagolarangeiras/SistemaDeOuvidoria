<?php
// geito inseguro
//     $db = connectToDatabase();
//     $db->beginTransaction();
//     $sql = "SELECT senha FROM usuarios au WHERE au.email = $email;";
//     $result = $db->query($sql)->fetchAll();
//     $db->commit();
//     return $result["senha"];

function loginRepoGetPasswordByEmail(string $email): array {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT id_usuario, senha FROM usuarios au WHERE au.email = ?;");
    $prepare->execute([$email]);
    $result = $prepare->fetch();
    $db->commit();
    return $result;
}
function loginRepoGetPasswordByUsuario(string $usuario): array {
    $db = connectToDatabase();
    $db->beginTransaction();
    $prepare = $db->prepare("SELECT id_usuario, senha FROM usuarios au WHERE au.usuario = ?;");
    $prepare->execute([$usuario]);
    $result = $prepare->fetch();
    $db->commit();
    return $result;
}

function loginController(): Response {
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

        
        if($senhaBanco == null || $senhaBanco < 1)
            $token = null;
        else if(!password_verify($senha, $senhaBanco["senha"]))
            $token = null;
        else {
            //session_regenerate_id(true);
            $_SESSION["userId"] = $senhaBanco["id_usuario"];
            $token = "token-example";
        }
    }

    if($token == null)
        return new Response(400, ["error" => "Senha ou Usuario incorretos!"]);
    return new Response(200, ["token" => $token]);
}

function signinController(): Response { 
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return new Response(400,["error"=> "Metodo não permitido"]);    
    return userControllerPost();
}