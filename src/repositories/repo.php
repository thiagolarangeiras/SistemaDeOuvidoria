<?php
function connectToDatabase(): PDO{
    $servername = getenv("PHP_SERVER_NAME") ?? "host.docker.internal:3306";
    $username = getenv("PHP_USERNAME") ?? "php";
    $password = getenv("PHP_PASSWORD") ?? "php";
    $database = getenv("PHP_DATABASE") ?? "ouvidoria";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        throw new Exception("erro de database". $e->getMessage());
    }
}