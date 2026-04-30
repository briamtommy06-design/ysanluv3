<?php
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once "../modelos/conexion.php";

$idProducto = isset($_GET["idProducto"]) ? (int)$_GET["idProducto"] : 0;

if ($idProducto <= 0) {
  echo json_encode(["data" => []], JSON_UNESCAPED_UNICODE);
  exit;
}

try {

  $db = Conexion::conectar();

  $stmt = $db->prepare("
    SELECT
      ms.id,
      ms.tipo,
      ms.motivo,
      ms.cajas,
      ms.unidades_por_caja,
      ms.cantidad_unidades,
      ms.cantidad_docenas,
      ms.stock_anterior,
      ms.stock_nuevo,
      ms.costo_docena,
      ms.moneda,
      ms.observacion,
      ms.fecha,
      u.nombre as usuario_nombre,
      u.usuario as usuario_user
    FROM movimientos_stock ms
    LEFT JOIN usuarios u ON u.id = ms.id_usuario
    WHERE ms.id_producto = :idProducto
    ORDER BY ms.fecha DESC, ms.id DESC
  ");

  $stmt->bindParam(":idProducto", $idProducto, PDO::PARAM_INT);
  $stmt->execute();

  $data = [];
  $i = 1;

  while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {

    $usuario = $r["usuario_nombre"] ?: ($r["usuario_user"] ?: "—");
    $fecha = $r["fecha"] ? date("Y-m-d H:i", strtotime($r["fecha"])) : "";

    $data[] = [
      (string)$i++,
      $fecha,
      $r["tipo"],
      $r["motivo"],
      $r["cajas"] ?? "",
      $r["unidades_por_caja"] ?? "",
      (string)$r["cantidad_unidades"],
      (string)$r["cantidad_docenas"],
      (string)$r["stock_anterior"],
      (string)$r["stock_nuevo"],
      ($r["costo_docena"] !== null ? number_format((float)$r["costo_docena"], 2, ".", "") : ""),
      $r["moneda"] ?? "",
      $usuario,
      $r["observacion"] ?? ""
    ];
  }

  echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE);
  exit;

} catch (Exception $e) {
  echo json_encode(["data" => [], "error" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
  exit;
}
