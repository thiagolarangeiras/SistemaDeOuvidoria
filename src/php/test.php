<?php
session_start();

$_SESSION["userId"] = 1;
$_SESSION["date"] = "";

date_default_timezone_set("America/Sao_Paulo");

$awd = date("Y/m/d H:i:s");
var_dump($awd);
echo gettype($awd);

if (isset($_SESSION['user_id'])) {
    echo 'Usuário está autenticado';
} else {
    echo 'Usuário não está autenticado';
}

session_destroy();