<?php
require_once "conexion.php";
class ModeloVentas{

    /* Mostrar VENTAS */
    static public function mdlMostrarVentas($tabla,$item,$valor){

        if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}
		
		$stmt->close();



    }

    static public function mdlObtenerSiguienteCodigoVenta(){

        $stmt = Conexion::conectar()->prepare("SELECT MAX(codigo) as ultimo_codigo FROM ventas");
        $stmt->execute();
        $respuesta = $stmt->fetch();

        $ultimoCodigo = isset($respuesta["ultimo_codigo"]) ? (int)$respuesta["ultimo_codigo"] : 0;

        return $ultimoCodigo > 0 ? $ultimoCodigo + 1 : 10001;
    }
	

	static public function mdlMostrarReporteVenta(){

		$stmt = Conexion::conectar()->prepare(" SELECT v.codigo as notapedido,cl.nombre, pr.codigo, p.descripcion, p.cantidad, p.precio_producto, p.importe, v.fecha
        FROM (
            SELECT ventas.id, ventas.id_cliente, 
                   REPLACE(JSON_EXTRACT(JSON_EXTRACT(ventas.productos, CONCAT('$[',n,'].id')), '$'), '\"', '') AS id_producto,
                   REPLACE(JSON_EXTRACT(JSON_EXTRACT(ventas.productos, CONCAT('$[',n,'].descripcion')), '$'), '\"', '') AS descripcion,
                   REPLACE(JSON_EXTRACT(JSON_EXTRACT(ventas.productos, CONCAT('$[',n,'].cantidad')), '$'), '\"', '') AS cantidad,
                   REPLACE(JSON_EXTRACT(JSON_EXTRACT(ventas.productos, CONCAT('$[',n,'].precio')), '$'), '\"', '') AS precio_producto,
                   REPLACE(JSON_EXTRACT(JSON_EXTRACT(ventas.productos, CONCAT('$[',n,'].total')), '$'), '\"', '') AS importe
            FROM ventas
            INNER JOIN (
                SELECT 0 n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12 UNION ALL SELECT 13
            ) numbers
            WHERE n < JSON_LENGTH(ventas.productos)
        ) p
        INNER JOIN ventas v ON p.id = v.id 
        INNER JOIN productos pr ON p.id_producto = pr.id 
        INNER JOIN clientes cl ON p.id_cliente = cl.id");


		$stmt -> execute();

		return $stmt -> fetchAll();



		$stmt->close();


	}


    static public function mdlIngresarVenta($tabla,$datos){

      
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, id_cliente, id_vendedor, productos, tipo_cambio, neto, total, metodo_pago, fecha,estado,observacion) VALUES (:codigo, :id_cliente, :id_vendedor, :productos, :impuesto, :neto, :total, :metodo_pago, :fecha,:estado,:observacion)");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["total_soles"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
		$stmt->close();


    }

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function mdlEditarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  id_cliente = :id_cliente, id_vendedor = :id_vendedor, productos = :productos, tipo_cambio = :impuesto, neto = :neto, total= :total, metodo_pago = :metodo_pago, observacion= :observacion WHERE codigo = :codigo");

		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente", $datos["id_cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor", $datos["id_vendedor"], PDO::PARAM_INT);
		$stmt->bindParam(":productos", $datos["productos"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["tipo_cambio"], PDO::PARAM_STR);
		$stmt->bindParam(":neto", $datos["total_soles"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datos["total"], PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago", $datos["metodo_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
	}

	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function mdlEliminarVenta($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}
		$stmt->close();

	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal){

		if($fechaInicial == null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();	

			$stmt->close();

		}else if($fechaInicial == $fechaFinal){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha like '%$fechaFinal%'");


		//	$stmt -> bindParam(":fecha", $fechaFinal, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt->close();
		}else{

			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual->format("Y-m-d");

			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2->format("Y-m-d");

			if($fechaFinalMasUno == $fechaActualMasUno){

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'");

			}else{


				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinal'");

			}
		
			$stmt -> execute();

			return $stmt -> fetchAll();
			$stmt->close();
		}
	

	}
	/*=============================================
	SUMAR EL TOTAL DE VENTAS
	=============================================*/

	static public function mdlSumaTotalVentas($tabla){	

		$stmt = Conexion::conectar()->prepare("SELECT SUM(total) as total FROM $tabla WHERE estado = 1");
		$stmt -> execute();

		return $stmt -> fetch();
		$stmt->close();
	}

	static public function mdlActualizarVenta($tabla,$item1,$valor1,$item2,$valor2){


		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1= :$item1 where $item2=:$item2");
		$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
		$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		if($stmt -> execute()){
			return "ok";
		}else{
			return "error";
		}
		$stmt->close();


	}


	static public function mdlSumaUltilidad($fecha_ini, $fecha_fin) {
		$stmt = Conexion::conectar()->prepare("CALL GetSumaUtilidad(:fecha_ini, :fecha_fin)");
		$stmt->bindParam(':fecha_ini', $fecha_ini, PDO::PARAM_STR);
		$stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
	
		$stmt->execute();
	
		$resultado = $stmt->fetchAll(PDO::FETCH_OBJ);
	
		$stmt->close();
	
		return $resultado;
	}
	

}