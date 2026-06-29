<?php

class ControladorVentas{

    static public function ctrMostrarVentas($item,$valor){
        $tabla  = "ventas";
        $respuesta = ModeloVentas::mdlMostrarVentas($tabla,$item,$valor);
        return $respuesta;
    }

    static public function ctrObtenerSiguienteCodigoVenta(){
        return ModeloVentas::mdlObtenerSiguienteCodigoVenta();
    }

    static public function ctrCrearVenta(){
        
        if(isset($_POST["nuevaVenta"])){

            /* ACTUALIZAR LAS COMPRAS DEL CLIENTE Y REDUCIR EL STOCK Y AUMENTAR LAS VENTAS DE LOS PRODUCTOS*/

            $listaProductos = json_decode($_POST["listaProductos"],true);

            $totalProductosComprados = array();
            /* var_dump($listaProductos);*/

            foreach($listaProductos as $key => $value){

                array_push($totalProductosComprados,$value["cantidad"]);

                $tablaProductos = "productos";

                $item = "id";

                $valor = $value["id"];
                $traerProducto = ModeloProductos::mdlMostrarProductos($tablaProductos, $item, $valor);

				$item1a = "ventas";
				$valor1a = $value["cantidad"] + $traerProducto["ventas"];

			    $nuevasVentas = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1a, $valor1a, $valor);

				// $item1b = "stock";
				// $valor1b = $value["stock"];

				// $nuevoStock = ModeloProductos::mdlActualizarProducto($tablaProductos, $item1b, $valor1b, $valor);

            }

            $tablaClientes = "clientes";

            $item = "id";
            $valor = $_POST["seleccionarCliente"];

            $traerCliente = ModeloClientes::mdlMostrarClientes($item,$tablaClientes,$valor);
			
			$nombreCliente = $traerCliente ? $traerCliente["nombre"] : "Sin cliente";

			// (Opcional) también forzamos que la observación de la venta incluya cliente:
			$obsForm = trim($_POST["observacionVenta"] ?? "");
			$obsVenta = ($obsForm !== "" ? $obsForm." | " : "") . "Cliente: ".$nombreCliente;


            // var_dump($traerCliente["compras"]);

            $item1a = "compras";
            $valor1a = array_sum($totalProductosComprados) + $traerCliente["compras"];

            $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes,$item1a,$valor1a,$valor);

            $item1b = "ultima_compra";
            date_default_timezone_set('America/Bogota');
            $fecha  = date('Y-m-d');
            $hora = date('H:i:s');
            $valor1b = $fecha.' '.$hora;
            $comprasCliente = ModeloClientes::mdlActualizarCliente($tablaClientes,$item1b,$valor1b,$valor);

            
           
           
            /* GUARDAR LA COMPRA */

            $tabla = "ventas";
            $codigoVenta = ModeloVentas::mdlObtenerSiguienteCodigoVenta();

            while (ModeloVentas::mdlMostrarVentas("ventas", "codigo", $codigoVenta)) {
                $codigoVenta++;
            }

            $datos = array("id_vendedor"=> $_POST["idVendedor"],
                            "id_cliente"=> $_POST["seleccionarCliente"],
                            "codigo" => $codigoVenta,
                            "productos" => $_POST["listaProductos"],
							 "tipo_cambio" => $_POST["listaTipoCambio"],
							 "total_soles" => $_POST["listaTotalSoles"],                        
                            "total" => $_POST["totalVenta"],
                            "metodo_pago" => $_POST["listaMetodoPago"],
							"fecha" => $valor1b,
							"estado" => "1",
							"observacion" => $obsVenta

						 );

            $respuesta = ModeloVentas::mdlIngresarVenta($tabla,$datos);
			if ($respuesta == "ok") {

				require_once "movimientos_stock.controlador.php";

				// Obtener ID real de la venta recién creada
				$venta = ModeloVentas::mdlMostrarVentas("ventas", "codigo", $codigoVenta);
				$idVenta = (int)$venta["id"];

				$listaProductos = json_decode($_POST["listaProductos"], true);
				$idUsuario = (int)$_POST["idVendedor"];
				$moneda = (stripos($_POST["listaMetodoPago"], "dolar") !== false || stripos($_POST["listaMetodoPago"], "usd") !== false) ? "USD" : "PEN";

				foreach($listaProductos as $p){

					$idProducto = (int)$p["id"];
					$cantidad = (int)$p["cantidad"];
					$stockNuevo = (int)$p["stock"];

					// Obtener stock anterior
					$tablaProductos = "productos";
					$producto = ModeloProductos::mdlMostrarProductos($tablaProductos, "id", $idProducto);
					$stockAnterior = $stockNuevo + $cantidad;

					$datosMov = [
						"id_producto" => $idProducto,
						"id_usuario" => $idUsuario,
						"id_venta" => $idVenta,
						"tipo" => "SALIDA",
						"motivo" => "VENTA",
						"cajas" => null,
						"unidades_por_caja" => null,
						"cantidad_unidades" => $cantidad,
						"cantidad_docenas" => round($cantidad / 12, 2),
						"stock_anterior" => $stockAnterior,
						"stock_nuevo" => $stockNuevo,
						"costo_unitario" => null,
						"costo_docena" => null,
						"moneda" => $moneda,
						"precio_unitario" => null,
						"observacion" => "Venta #".$codigoVenta." - Cliente: ".$nombreCliente
					];

					ControladorMovimientosStock::ctrRegistrarMovimiento($datosMov);
				}
				echo '<script>
					
					localStorage.removeItem("rango");
					swal({
						type:"success",
						title:"¡La venta ha sido guardada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
					}).then((result) => {
						console.log("Mensaje de éxito mostrado");
						if (result.value) {
							swal({
								title: "¿Deseas generar un ticket o una Nota pedido?",
								icon: "question",
								showCancelButton: true,
								confirmButtonColor: "#3085d6",
								cancelButtonColor: "#d33",
								confirmButtonText: "Generar Ticket",
								cancelButtonText: "Generar Nota Pedido",
							}).then((result) => {
								if (result.value) {
									
									// Lógica para generar el ticket
									window.open("extensiones/tcpdf/pdf/ticket.php?codigo='.$codigoVenta.'", "_blank");
									window.location = "ventas";

			

								} else {
								
									// Lógica para generar la nota de pedido
						
									
									window.open("extensiones/tcpdf/pdf/prueba.php?codigo='.$codigoVenta.'", "_blank");
									window.location = "ventas";
								}
							
							});
						}
					});
				</script>';
			}
			
			
			
			


        }



    }

	/*=============================================
	EDITAR VENTA
	=============================================*/

	static public function ctrEditarVenta(){

	if(isset($_POST["editarVenta"])){

		$tabla = "ventas";
		$item = "codigo";
		$valor = $_POST["editarVenta"];

		$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
		if(!$traerVenta){
		echo '<script>
			swal({ type:"error", title:"Venta no encontrada", showConfirmButton:true, confirmButtonText:"Cerrar" })
		</script>';
		return;
		}

		// Productos (JSON)
		$listaProductos = ($_POST["listaProductos"] == "") ? $traerVenta["productos"] : $_POST["listaProductos"];
		$cambioProducto = ($_POST["listaProductos"] != "");

		// Parsear arrays
		$productosAntes = json_decode($traerVenta["productos"], true);
		if(!is_array($productosAntes)) $productosAntes = [];

		$productosAhora = json_decode($listaProductos, true);
		if(!is_array($productosAhora)) $productosAhora = [];

		// Helpers: mapa id => cantidad total
		$mapOld = [];
		foreach($productosAntes as $p){
		$id = (int)$p["id"];
		$mapOld[$id] = ($mapOld[$id] ?? 0) + (int)$p["cantidad"];
		}

		$mapNew = [];
		foreach($productosAhora as $p){
		$id = (int)$p["id"];
		$mapNew[$id] = ($mapNew[$id] ?? 0) + (int)$p["cantidad"];
		}

		// Calcular deltas
		$deltas = []; // id_producto => delta (nuevo - anterior)
		$ids = array_unique(array_merge(array_keys($mapOld), array_keys($mapNew)));

		foreach($ids as $idProd){
		$oldQty = (int)($mapOld[$idProd] ?? 0);
		$newQty = (int)($mapNew[$idProd] ?? 0);
		$delta = $newQty - $oldQty;
		if($delta !== 0) $deltas[$idProd] = $delta;
		}

		// Validar stock SOLO cuando delta > 0 (porque se descontará más)
		if($cambioProducto){
			$cliMov = ModeloClientes::mdlMostrarClientes("id", "clientes", (int)$_POST["seleccionarCliente"]);
			$nombreCliente = $cliMov ? $cliMov["nombre"] : "Sin cliente";

		foreach($deltas as $idProd => $delta){
			if($delta > 0){
			$prod = ModeloProductos::mdlMostrarProductos("productos", "id", $idProd);
			if(!$prod || (int)$prod["stock"] < $delta){
				$nombre = $prod ? $prod["descripcion"] : ("ID ".$idProd);
				echo '<script>
				swal({
					type:"error",
					title:"Stock insuficiente",
					text:"No hay stock suficiente para aumentar la venta de '.$nombre.'. Faltan '.$delta.' unidades.",
					showConfirmButton:true,
					confirmButtonText:"Cerrar"
				})
				</script>';
				return;
			}
			}
		}
		}

		// Guardar venta
		$datos = array(
		"id_vendedor"   => $_POST["idVendedor"],
		"id_cliente"    => $_POST["seleccionarCliente"],
		"codigo"        => $_POST["editarVenta"],
		"productos"     => $listaProductos,
		"tipo_cambio"   => $_POST["listaTipoCambio"],
		"total_soles"   => $_POST["listaTotalSoles"],
		"total"         => $_POST["totalVenta"],
		"metodo_pago"   => $_POST["listaMetodoPago"],
		"observacion"   => $_POST["observacionVenta"]
		);

		$respuesta = ModeloVentas::mdlEditarVenta($tabla, $datos);

		if($respuesta == "ok"){

		// Si cambiaron productos, aplicar deltas con movimientos_stock + actualizar "ventas" del producto
		if($cambioProducto && !empty($deltas)){

			require_once "movimientos_stock.controlador.php";

			$idVenta = (int)$traerVenta["id"];
			$idUsuario = (int)$_POST["idVendedor"];
			$moneda = (stripos($_POST["listaMetodoPago"], "dolar") !== false || stripos($_POST["listaMetodoPago"], "usd") !== false) ? "USD" : "PEN";

			foreach($deltas as $idProd => $delta){

			if($delta > 0){
				// SALIDA (se vendió más)
				$mov = [
				"id_producto" => (int)$idProd,
				"id_usuario" => $idUsuario,
				"id_venta" => $idVenta,
				"tipo" => "SALIDA",
				"motivo" => "VENTA",
				"cajas" => null,
				"unidades_por_caja" => null,
				"cantidad_unidades" => (int)$delta,
				"moneda" => $moneda,
				"observacion" => "Edición venta #".$_POST["editarVenta"]." (delta +".$delta.") - Cliente: ".$nombreCliente

				];

				$r = ControladorMovimientosStock::ctrRegistrarMovimiento($mov);
				if(!$r["ok"]){
				echo '<script>
					swal({ type:"error", title:"Error stock", text:"'.$r["mensaje"].'", showConfirmButton:true, confirmButtonText:"Cerrar" })
				</script>';
				return;
				}

				// actualizar contador "ventas" del producto
				$prod = ModeloProductos::mdlMostrarProductos("productos", "id", (int)$idProd);
				if($prod){
				$nuevoVentas = (int)$prod["ventas"] + (int)$delta;
				ModeloProductos::mdlActualizarProducto("productos", "ventas", $nuevoVentas, (int)$idProd);
				}

			} else {
				// INGRESO (se devolvió / redujo en la venta)
				$abs = abs((int)$delta);

				$mov = [
				"id_producto" => (int)$idProd,
				"id_usuario" => $idUsuario,
				"id_venta" => $idVenta,
				"tipo" => "INGRESO",
				"motivo" => "AJUSTE",
				"cajas" => null,
				"unidades_por_caja" => null,
				"cantidad_unidades" => (int)$abs,
				"moneda" => $moneda,
				"observacion" => "Edición venta #".$_POST["editarVenta"]." (delta -".$abs.") - Cliente: ".$nombreCliente

				];

				$r = ControladorMovimientosStock::ctrRegistrarMovimiento($mov);
				if(!$r["ok"]){
				echo '<script>
					swal({ type:"error", title:"Error stock", text:"'.$r["mensaje"].'", showConfirmButton:true, confirmButtonText:"Cerrar" })
				</script>';
				return;
				}

				// actualizar contador "ventas" del producto
				$prod = ModeloProductos::mdlMostrarProductos("productos", "id", (int)$idProd);
				if($prod){
				$nuevoVentas = (int)$prod["ventas"] - (int)$abs;
				if($nuevoVentas < 0) $nuevoVentas = 0;
				ModeloProductos::mdlActualizarProducto("productos", "ventas", $nuevoVentas, (int)$idProd);
				}
			}
			}
		}

		// Actualizar compras del cliente (considerando si cambió el cliente)
		$totalOld = array_sum(array_values($mapOld));
		$totalNew = array_sum(array_values($mapNew));

		$idClienteOld = (int)$traerVenta["id_cliente"];
		$idClienteNew = (int)$_POST["seleccionarCliente"];

		if($idClienteOld === $idClienteNew){

			$cli = ModeloClientes::mdlMostrarClientes("id", "clientes", $idClienteNew);
			if($cli){
			$deltaTotal = $totalNew - $totalOld;
			$nuevoCompras = (int)$cli["compras"] + (int)$deltaTotal;
			if($nuevoCompras < 0) $nuevoCompras = 0;
			ModeloClientes::mdlActualizarCliente("clientes", "compras", $nuevoCompras, $idClienteNew);

			// ultima_compra
			date_default_timezone_set('America/Lima');
			$valorUlt = date('Y-m-d H:i:s');
			ModeloClientes::mdlActualizarCliente("clientes", "ultima_compra", $valorUlt, $idClienteNew);
			}

		} else {

			// Restar al cliente anterior
			$cliOld = ModeloClientes::mdlMostrarClientes("id", "clientes", $idClienteOld);
			if($cliOld){
			$nuevoComprasOld = (int)$cliOld["compras"] - (int)$totalOld;
			if($nuevoComprasOld < 0) $nuevoComprasOld = 0;
			ModeloClientes::mdlActualizarCliente("clientes", "compras", $nuevoComprasOld, $idClienteOld);
			}

			// Sumar al cliente nuevo
			$cliNew = ModeloClientes::mdlMostrarClientes("id", "clientes", $idClienteNew);
			if($cliNew){
			$nuevoComprasNew = (int)$cliNew["compras"] + (int)$totalNew;
			ModeloClientes::mdlActualizarCliente("clientes", "compras", $nuevoComprasNew, $idClienteNew);

			date_default_timezone_set('America/Lima');
			$valorUlt = date('Y-m-d H:i:s');
			ModeloClientes::mdlActualizarCliente("clientes", "ultima_compra", $valorUlt, $idClienteNew);
			}
		}

		echo'<script>
			localStorage.removeItem("rango");
			swal({
			type: "success",
			title: "La venta ha sido editada correctamente",
			showConfirmButton: true,
			confirmButtonText: "Cerrar"
			}).then((result) => {
			if (result.value) window.location = "ventas";
			})
		</script>';

		}

	}

	}
	/*=============================================
	ELIMINAR VENTA
	=============================================*/

	static public function ctrEliminarVenta(){

	if(isset($_GET["idVenta"])){

		$tabla = "ventas";
		$item = "id";
		$valor = $_GET["idVenta"];

		$traerVenta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);
		if(!$traerVenta){
		echo '<script>
			swal({ type:"error", title:"Venta no encontrada", showConfirmButton:true, confirmButtonText:"Cerrar" })
		</script>';
		return;
		}

		/*=============================================
		ACTUALIZAR FECHA ÚLTIMA COMPRA
		=============================================*/

		$tablaClientes = "clientes";

		$traerVentas = ModeloVentas::mdlMostrarVentas($tabla, null, null);

		$guardarFechas = [];
		foreach ($traerVentas as $v) {
		if($v["id_cliente"] == $traerVenta["id_cliente"]){
			$guardarFechas[] = $v["fecha"];
		}
		}

		$valorIdCliente = (int)$traerVenta["id_cliente"];

		if(count($guardarFechas) > 1){

		// si la venta borrada era la última, poner la anterior
		$ultima = $guardarFechas[count($guardarFechas)-1];
		$penultima = $guardarFechas[count($guardarFechas)-2];

		$nuevoUlt = ($traerVenta["fecha"] >= $ultima) ? $penultima : $ultima;
		ModeloClientes::mdlActualizarCliente($tablaClientes, "ultima_compra", $nuevoUlt, $valorIdCliente);

		} else {

		ModeloClientes::mdlActualizarCliente($tablaClientes, "ultima_compra", "0000-00-00 00:00:00", $valorIdCliente);

		}

		/*=============================================
		DEVOLVER STOCK CON movimientos_stock
		y BAJAR contador ventas del producto
		=============================================*/

		$productos = json_decode($traerVenta["productos"], true);
		if(!is_array($productos)) $productos = [];

		$totalProductosComprados = [];

		require_once "movimientos_stock.controlador.php";

		$idUsuario = isset($_SESSION["id"]) ? (int)$_SESSION["id"] : (int)$traerVenta["id_vendedor"];
		$moneda = (stripos($traerVenta["metodo_pago"], "dolar") !== false || stripos($traerVenta["metodo_pago"], "usd") !== false) ? "USD" : "PEN";
		$cliMov = ModeloClientes::mdlMostrarClientes("id", "clientes", (int)$traerVenta["id_cliente"]);
		$nombreCliente = $cliMov ? $cliMov["nombre"] : "Sin cliente";

		foreach ($productos as $p) {

		$cant = (int)$p["cantidad"];
		$idProd = (int)$p["id"];

		$totalProductosComprados[] = $cant;

		// 1) bajar contador ventas del producto
		$prod = ModeloProductos::mdlMostrarProductos("productos", "id", $idProd);
		if($prod){
			$nuevoVentas = (int)$prod["ventas"] - $cant;
			if($nuevoVentas < 0) $nuevoVentas = 0;
			ModeloProductos::mdlActualizarProducto("productos", "ventas", $nuevoVentas, $idProd);
		}

		// 2) devolver stock en base a movimientos_stock (NO actualizar stock manual aquí)
		$datosMov = [
			"id_producto" => $idProd,
			"id_usuario" => $idUsuario,
			"id_venta" => (int)$traerVenta["id"],
			"tipo" => "INGRESO",
			"motivo" => "AJUSTE",
			"cajas" => null,
			"unidades_por_caja" => null,
			"cantidad_unidades" => $cant,
			"moneda" => $moneda,
			"observacion" => "Anulación venta #".$traerVenta["codigo"]." - Cliente: ".$nombreCliente

		];

		$r = ControladorMovimientosStock::ctrRegistrarMovimiento($datosMov);
		if(!$r["ok"]){
			echo '<script>
			swal({ type:"error", title:"Error al devolver stock", text:"'.$r["mensaje"].'", showConfirmButton:true, confirmButtonText:"Cerrar" })
			</script>';
			return;
		}

		}

		// 3) actualizar compras del cliente
		$traerCliente = ModeloClientes::mdlMostrarClientes("id", "clientes", $valorIdCliente);
		if($traerCliente){
		$nuevoCompras = (int)$traerCliente["compras"] - (int)array_sum($totalProductosComprados);
		if($nuevoCompras < 0) $nuevoCompras = 0;
		ModeloClientes::mdlActualizarCliente("clientes", "compras", $nuevoCompras, $valorIdCliente);
		}

		/*=============================================
		ELIMINAR VENTA
		=============================================*/

		$respuesta = ModeloVentas::mdlEliminarVenta($tabla, $_GET["idVenta"]);

		if($respuesta == "ok"){

		echo'<script>
			swal({
			type: "success",
			title: "La venta ha sido borrada correctamente",
			showConfirmButton: true,
			confirmButtonText: "Cerrar",
			closeOnConfirm: false
			}).then((result) => {
			if (result.value) window.location = "ventas";
			})
		</script>';

		}

	}

	}



	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasVentas($fechaInicial, $fechaFinal){

		$tabla = "ventas";

		$respuesta = ModeloVentas::mdlRangoFechasVentas($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}

	static public function ctrSumarUtilidad($fechaInicial,$fechaFinal){
		$respuesta = ModeloVentas::mdlSumaUltilidad($fechaInicial,$fechaFinal);
		return $respuesta;
	}


	static public function ctrReporteVenta(){

		$respuesta = ModeloVentas::mdlMostrarReporteVenta();
		return $respuesta;

	}

}