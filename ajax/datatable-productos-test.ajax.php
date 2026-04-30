<?php
require_once '../modelos/conexion.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {

    $pdo = Conexion::conectar();

    $stmt = $pdo->query("SELECT id, codigo, descripcion FROM productos ORDER BY id DESC LIMIT 20");

    $data = [];
    $i = 1;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $codigo      = isset($row['codigo']) ? $row['codigo'] : '';
        $descripcion = isset($row['descripcion']) ? $row['descripcion'] : '';

        $data[] = [
            (string)$i++,
            $codigo,
            strtoupper($descripcion)
        ];
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['data' => $data], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {

    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode([
        'data'  => [],
        'error' => 'Error: '.$e->getMessage()
    ]);
}
