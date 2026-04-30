<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "ysanluv3";

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_errno) {
    echo "Error de conexión (" . $mysqli->connect_errno . "): " . $mysqli->connect_error;
} else {
    echo "Conexión OK";
}
