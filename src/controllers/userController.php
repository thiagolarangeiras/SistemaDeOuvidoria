<?php
function userController(): Response{    
    $methods = [
        "GET" => "userControllerGet",
        "POST" => "userControllerPost",
        "PUT" => "userControllerPut",
        "DELETE" => "userControllerDelete",
    ];
    if(!isset($_SESSION['userId']))
        return new Response(401,[ ]);

    if(isset($methods[$_SERVER["REQUEST_METHOD"]]))
        return $methods[$_SERVER["REQUEST_METHOD"]]();

    return new Response(400,["error"=> "Metodo não permitido"]);
}

function userControllerGet(): Response {
    $idUser = (int) $_REQUEST['id'];
    $page = (int) $_REQUEST['page'];
    $count = (int) $_REQUEST['count'];

    if($idUser != null){
        $oneResult = userRepoSelectOne($idUser);
        $usuario = Usuario::mapToUsuarioRetorno($oneResult[0]);
        return new Response(200, $usuario);
    }

    if($page == null && $count == null)
        $selectResults = userRepoSelectAll();
    else
        $selectResults = userRepoSelectAll($page, $count);

    $users = [];
    foreach($selectResults as $result) {
        array_push($users, Usuario::mapToUsuarioRetorno($result));
    }
    return new Response(200, $users);
}

function userControllerPost(): Response {
    $input = json_decode(file_get_contents('php://input'), TRUE);
    $usuario = Usuario::construct(
        $input["usuario"],
        $input["senha"],
        $input["nome"],
        $input["nascimento"],
        $input["email"],
        $input["telefone"],
        $input["whatsapp"],
        $input["cidade"],
        $input["estado"]
    );

    $fieldErrors = [];
    //usuario
    if(!preg_match("/^\w{10,50}$/", $usuario->usuario)){
        $fieldErrors["usuario"] = "Nome de usuario invalido!";    
    } else if(userRepoCheckUser($usuario->usuario)){
        $fieldErrors["usuario"] = "Nome de usuario já foi utilizado!";
    }

    //senha
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/", $usuario->senha)){
        $fieldErrors["senha"] = "Senha invalido!";
    }
    //nome
    //nascimento
    //email
    if(!filter_var($usuario->email, FILTER_VALIDATE_EMAIL)){
        $fieldErrors["email"] = "email invalido!";    
    } else if(userRepoCheckEmail($usuario->email)){
        $fieldErrors["email"] = "email já foi utilizado!";
    }   
    //telefone
    //whatsapp
    //cidade
    //estado
    if(count($fieldErrors)>0) 
        return new Response(400, ["error" => "Erros ao validar os Campos",  "fields" => $fieldErrors]);


    $usuario->senha = password_hash($usuario->senha, PASSWORD_BCRYPT);
    $id = userRepoInsert($usuario);
    return new Response(201, ["id" => $id]);
}