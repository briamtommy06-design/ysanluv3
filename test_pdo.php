<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host   = '127.0.0.1';   // o 'localhost'
$port   = 3306;          // pon aquí el puerto que encontraste
$dbname = 'ysanluv3';
$user   = 'root';
$pass   = '';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión OK";
} catch (PDOException $e) {
    echo "Error de conexión PDO: " . $e->getMessage();
}
