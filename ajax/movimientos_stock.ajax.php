<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once "../modelos/movimientos_stock.modelo.php";
require_once "../controladores/movimientos_stock.controlador.php";

try {

  $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : null; // INGRESO | SALIDA
  if (!$tipo) {
    echo json_encode(["ok" => false, "mensaje" => "Falta tipo de movimiento"]);
    exit;
  }

  // Normalizar según modal
  if ($tipo === "INGRESO") {

    $datos = [
      "id_producto"        => (int)($_POST["idProductoIngreso"] ?? 0),
      "id_usuario"         => isset($_SESSION["id"]) ? (int)$_SESSION["id"] : null,
      "id_venta"           => null,
      "tipo"               => "INGRESO",
      "motivo"             => "COMPRA", // tu enum lo permite :contentReference[oaicite:5]{index=5}
      "cajas"              => ($_POST["cajasIngreso"] !== "" ? (int)$_POST["cajasIngreso"] : null),
      "unidades_por_caja"  => ($_POST["unidadesCajaIngreso"] !== "" ? (int)$_POST["unidadesCajaIngreso"] : null),
      "cantidad_unidades"  => (int)($_POST["cantidadUnidadesIngreso"] ?? 0),
      "costo_docena"       => ($_POST["costoDocenaIngreso"] !== "" ? (float)$_POST["costoDocenaIngreso"] : null),
      "moneda"             => ($_POST["monedaIngreso"] ?? null),
      "observacion"        => ($_POST["obsIngreso"] ?? null),
    ];

  } else if ($tipo === "SALIDA") {

    $datos = [
      "id_producto"        => (int)($_POST["idProductoSalida"] ?? 0),
      "id_usuario"         => isset($_SESSION["id"]) ? (int)$_SESSION["id"] : null,
      "id_venta"           => null,
      "tipo"               => "SALIDA",
      "motivo"             => ($_POST["motivoSalida"] ?? "OTRO"),
      "cajas"              => null,
      "unidades_por_caja"  => null,
      "cantidad_unidades"  => (int)($_POST["cantidadUnidadesSalida"] ?? 0),
      "costo_docena"       => null,
      "moneda"             => null,
      "observacion"        => ($_POST["obsSalida"] ?? null),
    ];

  } else {
    echo json_encode(["ok" => false, "mensaje" => "Tipo inválido"]);
    exit;
  }

  $resp = ControladorMovimientosStock::ctrRegistrarMovimiento($datos);
  echo json_encode($resp, JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
  echo json_encode(["ok" => false, "mensaje" => $e->getMessage()]);
}
