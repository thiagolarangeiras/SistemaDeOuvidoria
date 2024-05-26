<?php
require_once("./models.php");
require_once("./repo.php");

function userRepoSelect(int $idUsuario = 0, string $email = "", string $usuario = ""){
    $db = connectToDatabase();
    $db->beginTransaction();

    $sql = "SELECT * FROM usuarios au;";
    if($idUsuario > 0){
        $sql += "WHERE au.id_usuario = $idUsuario";
    } else if($email != ""){
        $sql += "WHERE au.email = $idUsuario";
    } else if($usuario != ""){
        $sql += "WHERE au.usuario = $idUsuario";
    }

    $resultArray = $db->query($sql)->fetchAll();
    $db->commit();
    return $resultArray;
    //$db->rollBack();
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
    //$db->rollBack();
    $id = $db->lastInsertId();
    $db->commit();
    return $id;
}

//Controllers
function userControllerGet(){ }
function userControllerPost(): Response {
try {
    $input = json_decode(file_get_contents('php://input'), TRUE);
    $usuario = new Usuario(
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
    $id = userRepoInsert($usuario);
    $response = new Response(201, ["id" => $id]);
    return $response;

} catch (Throwable $th) {
    throw $th;
}
}
function userControllerPut(){ }
function userControllerDelete(){ }
function userController(): Response{    
    $methods = [
        "GET" => "userControllerGet",
        "POST" => "userControllerPost",
        "PUT" => "userControllerPut",
        "DELETE" => "userControllerDelete",
    ];
    return $methods[$_SERVER["REQUEST_METHOD"]](); 
}