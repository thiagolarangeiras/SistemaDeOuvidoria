<?php
require_once("./models.php");

function connectToDatabase(): PDO{
    $servername = "localhost:3306";
    $username = "php";
    $password = "php";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=ouvidoria", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(PDOException $e) {
        throw new Exception("erro de database". $e->getMessage());
    }
}