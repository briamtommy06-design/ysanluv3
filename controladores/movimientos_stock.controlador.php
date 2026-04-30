<?php

class ControladorMovimientosStock {

  static public function ctrRegistrarMovimiento($datos){

    // Validaciones rápidas
    if (empty($datos["id_producto"])) {
      return ["ok" => false, "mensaje" => "Producto inválido"];
    }

    if (empty($datos["tipo"]) || !in_array($datos["tipo"], ["INGRESO","SALIDA","AJUSTE"])) {
      return ["ok" => false, "mensaje" => "Tipo de movimiento inválido"];
    }

    if (!isset($datos["cantidad_unidades"]) || (int)$datos["cantidad_unidades"] <= 0) {
      return ["ok" => false, "mensaje" => "Cantidad inválida"];
    }

    // Motivo (según tu enum) :contentReference[oaicite:6]{index=6}
    $motivosValidos = ["COMPRA","VENTA","DEVOLUCION_CLIENTE","DEVOLUCION_PROVEEDOR","MERMA","AJUSTE","OTRO"];
    if (empty($datos["motivo"]) || !in_array($datos["motivo"], $motivosValidos)) {
      $datos["motivo"] = "OTRO";
    }

    return ModeloMovimientosStock::mdlRegistrarMovimiento($datos);
  }

}
