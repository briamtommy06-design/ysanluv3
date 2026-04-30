<?php
require_once "conexion.php";

class ModeloMovimientosStock {

  static public function mdlRegistrarMovimiento($d){

    $db = Conexion::conectar();

    try {

      $db->beginTransaction();

      // 1) bloquear y leer stock actual
      $stmt = $db->prepare("SELECT stock FROM productos WHERE id = :id FOR UPDATE");
      $stmt->bindParam(":id", $d["id_producto"], PDO::PARAM_INT);
      $stmt->execute();

      $stockAnterior = $stmt->fetchColumn();
      if ($stockAnterior === false) {
        throw new Exception("No existe el producto");
      }
      $stockAnterior = (int)$stockAnterior;

      $cant = (int)$d["cantidad_unidades"];
      if ($cant <= 0) throw new Exception("Cantidad inválida");

      // 2) calcular nuevo stock
      if ($d["tipo"] === "INGRESO") {
        $stockNuevo = $stockAnterior + $cant;
      } else if ($d["tipo"] === "SALIDA") {
        $stockNuevo = $stockAnterior - $cant;
        if ($stockNuevo < 0) throw new Exception("Stock insuficiente");
      } else {
        throw new Exception("Tipo no implementado aún");
      }

      // 3) actualizar producto
      $up = $db->prepare("UPDATE productos SET stock = :stock WHERE id = :id");
      $up->bindParam(":stock", $stockNuevo, PDO::PARAM_INT);
      $up->bindParam(":id", $d["id_producto"], PDO::PARAM_INT);
      $up->execute();

      // 4) preparar costos/docenas
      $docenas = round($cant / 12, 2);
      $costoDocena = isset($d["costo_docena"]) ? $d["costo_docena"] : null;
      $costoUnit = null;
      if ($costoDocena !== null && $costoDocena !== "") {
        $costoDocena = (float)$costoDocena;
        $costoUnit = $costoDocena / 12;
      }

      // 5) insertar movimiento
      $ins = $db->prepare("
        INSERT INTO movimientos_stock
          (id_producto, id_usuario, id_venta, tipo, motivo, cajas, unidades_por_caja,
           cantidad_unidades, cantidad_docenas, stock_anterior, stock_nuevo,
           costo_unitario, costo_docena, moneda, precio_unitario, observacion)
        VALUES
          (:id_producto, :id_usuario, :id_venta, :tipo, :motivo, :cajas, :unidades_por_caja,
           :cantidad_unidades, :cantidad_docenas, :stock_anterior, :stock_nuevo,
           :costo_unitario, :costo_docena, :moneda, NULL, :observacion)
      ");

      $ins->bindValue(":id_producto", (int)$d["id_producto"], PDO::PARAM_INT);
      $ins->bindValue(":id_usuario", $d["id_usuario"] !== null ? (int)$d["id_usuario"] : null, PDO::PARAM_INT);
      $idVenta = isset($d["id_venta"]) && $d["id_venta"] !== "" ? (int)$d["id_venta"] : null;
      $ins->bindValue(":id_venta", $idVenta, $idVenta === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
      $ins->bindValue(":tipo", $d["tipo"], PDO::PARAM_STR);
      $ins->bindValue(":motivo", $d["motivo"], PDO::PARAM_STR);

      // nullables:
      $cajas = $d["cajas"] ?? null;
      $upc   = $d["unidades_por_caja"] ?? null;

      $ins->bindValue(":cajas", ($cajas === null ? null : (int)$cajas), ($cajas === null ? PDO::PARAM_NULL : PDO::PARAM_INT));
      $ins->bindValue(":unidades_por_caja", ($upc === null ? null : (int)$upc), ($upc === null ? PDO::PARAM_NULL : PDO::PARAM_INT));

      $ins->bindValue(":cantidad_unidades", $cant, PDO::PARAM_INT);
      $ins->bindValue(":cantidad_docenas", $docenas);

      $ins->bindValue(":stock_anterior", $stockAnterior, PDO::PARAM_INT);
      $ins->bindValue(":stock_nuevo", $stockNuevo, PDO::PARAM_INT);

      $ins->bindValue(":costo_unitario", $costoUnit);
      $ins->bindValue(":costo_docena", $costoDocena);
      $ins->bindValue(":moneda", $d["moneda"] ?? null);
      $ins->bindValue(":observacion", $d["observacion"] ?? null);

      $ins->execute();

      $db->commit();

      return [
        "ok" => true,
        "idProducto" => (int)$d["id_producto"],
        "stock_anterior" => $stockAnterior,
        "stock_nuevo" => $stockNuevo
      ];

    } catch (Exception $e) {
      if ($db->inTransaction()) $db->rollBack();
      return ["ok" => false, "mensaje" => $e->getMessage()];
    }
  }

}
