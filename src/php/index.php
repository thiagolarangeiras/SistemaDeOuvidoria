<?php
//var_dump($_REQUEST); // print any variable to echo html
//phpinfo(); // show all info 

require_once("./models.php");
require_once("./repo.php");
require_once("./controllers/loginController.php");
require_once("./controllers/userController.php");
require_once("./controllers/ouvidoriaController.php");
require_once("./controllers/anexoController.php");

ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $controllers = [
        "/login" => "loginController",
        "/user" => "userController",
        "/ouvidoria" => "ouvidoriaController",
        "/ouvidoria/anexos" => "ouvidoriaAnexosController"
    ];
    session_start();
    
    $response = $controllers[$_SERVER["PATH_INFO"]]();
    http_response_code($response->statusCode);
    header('Content-Type: multipart/form-data');    
    echo json_encode($response->data);
} catch (Throwable $th) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(["error" => " error"]);
}
