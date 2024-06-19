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
        $fieldErrors["senha"] = "Senha invalida!";
    }
    //nome
    //nascimento
    $data = explode("/", $usuario->nascimento);
    if(!checkdate($data[1], $data[0], $data[2])){
        $fieldErrors["nascimento"] = "Data invalida!";
    }

    $nascimento = date_create_from_format("d/m/Y", $usuario->nascimento);
    $usuario->nascimento = date_format($nascimento,"Y-m-d");
    //email
    if(!filter_var($usuario->email, FILTER_VALIDATE_EMAIL)){
        $fieldErrors["email"] = "email invalido!";    
    } else if(userRepoCheckEmail($usuario->email)){
        $fieldErrors["email"] = "email já foi utilizado!";
    }   
    //telefone
    if(strlen($usuario->telefone) != 15)
        $fieldErrors["telefone"] = "Telefone invalido!";
    //whatsapp
    if(strlen($usuario->telefone) != 15)
        $fieldErrors["whatsapp"] = "whatsapp invalido!";
    //cidade
    //estado
    if(count($fieldErrors)>0) 
        return new Response(400, ["error" => "Erros ao validar os Campos",  "fields" => $fieldErrors]);


    $usuario->senha = password_hash($usuario->senha, PASSWORD_BCRYPT);
    $id = userRepoInsert($usuario);
    if($id > 0){
        sendValidationEmail($id);
    }
    return new Response(201, ["id" => $id]);
}

function sendValidationEmail(int $userId, string $userEmail): bool{  
    $tokenPassword = getenv("PHP_EMAIL_TOKEN_PASSWORD") ?? throw new ErrorException();
    $maillerKey = getenv("PHP_MAILLER_KEY") ?? throw new ErrorException();
    $maillerEmail = getenv("PHP_MAILLER_EMAIL") ?? throw new ErrorException();
    
    $tokenPassword = $tokenPassword . $userId;
    $token = password_hash($tokenPassword, PASSWORD_BCRYPT);
    $link = $_SERVER["HTTP_HOST"] . "/emailController?userId=$userId&token=$token";
    
    $data = [
        "from"=> [
            "email"=> $maillerEmail
        ],
        "to"=> [
            [
                "email"=> $userEmail
            ]
        ],
        "subject"=> "Verifique seu email da ouvidoria",
        "text"=> "Use o link a seguir para verificar o seu email.\n$link",
        "html"=> "Use o link a seguir para verificar o seu email.<br/><a href=\"$link\">$link</a>"
    ];
    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer $maillerKey"
    ];

    $ch = curl_init("https://api.mailersend.com/v1/email");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $result = false;
    } else {
        $result = true;
    }
    curl_close($ch);
    return $result;
}