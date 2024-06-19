<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");

if(!isset($_SERVER["PATH_INFO"]) || $_SERVER["PATH_INFO"] == ""){
    // redirecionar para views caso o servidor seja um so
    echo "<script> window.location = \"./views/\" ;</script>";
    //readfile("./views/index.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {    
    session_start();
    require_once("./models/anexo.php");
    require_once("./models/ouvidoria.php");
    require_once("./models/response.php");
    require_once("./models/user.php");

    require_once("./repositories/repo.php");
    require_once("./repositories/anexoRepo.php");
    require_once("./repositories/loginRepo.php");
    require_once("./repositories/ouvidoriaRepo.php");
    require_once("./repositories/userRepo.php");
    
    require_once("./controllers/authController.php");
    require_once("./controllers/userController.php");
    require_once("./controllers/ouvidoriaController.php");
    require_once("./controllers/anexoController.php");

    $controllers = [
        "/login" => "loginController",
        "/signin" => "signinController",
        "/email" => "emailController",
        "/user" => "userController",
        "/ouvidoria" => "ouvidoriaController",
        "/ouvidoria/anexos" => "ouvidoriaAnexosController"
    ];
    $response = $controllers[$_SERVER["PATH_INFO"]]();
    
    http_response_code($response->statusCode);
    header('Content-Type: application/json');    
    echo json_encode($response->data);
} catch (Throwable $th) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo "";
    //echo json_encode(["error" => $th->__toString()]);
}