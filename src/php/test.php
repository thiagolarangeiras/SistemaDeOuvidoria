<?php
session_start();

var_dump($_SESSION);
echo "<BR>";



var_dump($_SESSION);
echo "<BR>";

//session_destroy();

//$_SESSION['userId'] = '1';

var_dump($_SESSION);
echo "<BR>";

if (isset($_SESSION['userId'])) {
    echo 'Usuário está autenticado';
} else {
    echo 'Usuário não está autenticado';
}

