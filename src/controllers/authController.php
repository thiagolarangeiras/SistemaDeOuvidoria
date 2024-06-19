<?php
function loginController(): Response {
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return new Response(405,["error"=> "Metodo não permitido"]);    
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

        
        if($senhaBanco == null || !$senhaBanco)
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

function emailController(): Response{    
    if($_SERVER["REQUEST_METHOD"] != "POST")
        return new Response(405,["error"=> "Metodo não permitido"]);

    $userId = (int) $_REQUEST["userId"];
    $token = $_REQUEST["token"];
    if(isset($userId) && $userId > 0 && isset($token)){
        $tokenPassword = getenv("PHP_EMAIL_TOKEN_PASSWORD") ?? throw new ErrorException();
        $tokenPassword = $tokenPassword . $userId;
        if( 
            password_verify($token, password_hash($tokenPassword, PASSWORD_BCRYPT)) &&
            userRepoValidate($userId)
        ){
            return new Response(200,["message"=> "Email validado"]);   
        }
    }
    return new Response(500,["error"=> "Erro ao validar email"]);
}