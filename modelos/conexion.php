<?php

class Conexion {
    static public function conectar() {

        $host   = '127.0.0.1';   // IGUAL que en test_pdo
        $port   = 3306;          // IGUAL que en test_pdo
        $dbname = 'ysanlunew';    // IGUAL que en test_pdo
        $user   = 'root';        // IGUAL que en test_pdo
        $pass   = '';            // IGUAL que en test_pdo

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8";

        try {
            $link = new PDO($dsn, $user, $pass);
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;

        } catch (PDOException $e) {
            die("Error de conexión PDO: " . $e->getMessage());
        }
    }
}
