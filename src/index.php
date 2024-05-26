<?php
// router.php
// get pass: username password receives: log-hash-jwt
// post pass: user-data receives: ok-check-your-mail

//var_dump($_REQUEST); // print any variable to echo html
//phpinfo(); // show all info 
require_once("./models.php");
require_once("./repo.php");
require_once("./userController.php");

password_hash("123456", PASSWORD_BCRYPT);

$controllers = [
    "/login" => "loginController",
    "/user" => "userController",
    "/ouvidoria" => "ouvidoriaController"
];

try {
    $response = $controllers[$_SERVER["REQUEST_URI"]]();
    http_response_code($response->statusCode);
    header('Content-Type: application/json');    
    echo json_encode($response->data);
} catch (Throwable $th) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(["error" => "untreated error"]);
}
