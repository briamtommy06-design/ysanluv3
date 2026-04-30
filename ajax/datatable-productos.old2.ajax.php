<?php

require_once '../modelos/conexion.php';
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';
require_once '../controladores/categorias.controlador.php';
require_once '../modelos/categorias.modelo.php';
require_once '../controladores/marcas.controlador.php';
require_once '../modelos/marcas.modelo.php';

error_reporting(E_ALL);
ini_set('display_errors', 0); // si quieres ver errores, pon 1 mientras depuras

class TablaProductos {

    public function mostrarTablaProductos() {

        $item  = null;
        $valor = null;

        $productos = ControladorProductos::ctrMostrarProductos($item, $valor);

        $data = [];

        if ($productos) {

            foreach ($productos as $index => $p) {

                // --------- CAMPOS BASE ---------
                $idProducto    = isset($p["id"]) ? (int)$p["id"] : 0;
                $codigo        = isset($p["codigo"]) ? $p["codigo"] : "";
                $descripcion   = isset($p["descripcion"]) ? $p["descripcion"] : "";
                $stock         = isset($p["stock"]) ? (int)$p["stock"] : 0;
                $precioCompra  = isset($p["precio_compra"]) ? (float)$p["precio_compra"] : 0;
                $precioVenta   = isset($p["precio_venta"]) ? (float)$p["precio_venta"] : 0;
                $fecha         = isset($p["fecha"]) ? $p["fecha"] : "";

                // --------- IMAGEN ---------
                $rutaImg = isset($p["imagen"]) ? $p["imagen"] : "";
                if ($rutaImg == "" || $rutaImg === null) {
                    $rutaImg = "vistas/img/productos/default/anonymous.png";
                }

                $imagenHtml = "<img src='".$rutaImg."' class='img-thumbnail imgTablaProducto' width='40' data-imagen-grande='".$rutaImg."'>";

                // --------- CATEGORÍA Y PADRE ---------
                $nombreCategoria      = "";
                $nombreCategoriaPadre = "SIN PADRE";

                $idCat = isset($p["id_categoria"]) ? $p["id_categoria"] : null;

                if ($idCat) {

                    $categoria = ControladorCategorias::ctrMostrarCategorias("id", $idCat);

                    if ($categoria && isset($categoria["categoria"])) {

                        $nombreCategoria = $categoria["categoria"];

                        if (!empty($categoria["id_padre"])) {

                            $catPadre = ControladorCategorias::ctrMostrarCategorias("id", $categoria["id_padre"]);

                            if ($catPadre && isset($catPadre["categoria"])) {
                                $nombreCategoriaPadre = $catPadre["categoria"];
                            }
                        }
                    }
                }

                // --------- BOTONES ---------
                $botonesHtml =
                    "<div class='btn-group'>".
                        "<button class='btn btn-warning btnEditarProducto' idProducto='".$idProducto."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>".
                        "<button class='btn btn-danger btnEliminarProducto' idProducto='".$idProducto."' codigo='".$codigo."' imagen='".$rutaImg."'><i class='fa fa-times'></i></button>".
                    "</div>";

                // --------- 11 COLUMNAS EXACTAS ---------
                $fila = [
                    (string)($index + 1),              // 0: #
                    $imagenHtml,                       // 1: Imagen
                    $codigo,                           // 2: Código
                    strtoupper($descripcion),          // 3: Descripción
                    strtoupper($nombreCategoria),      // 4: Categoría
                    strtoupper($nombreCategoriaPadre), // 5: Categoría padre
                    $stock,                            // 6: Stock
                    $precioCompra,                     // 7: Precio compra
                    $precioVenta,                      // 8: Precio venta
                    $fecha,                            // 9: Agregado
                    $botonesHtml                       // 10: Acciones
                ];

                $data[] = $fila;
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE);
    }
}

$activarProductos = new TablaProductos();
$activarProductos->mostrarTablaProductos();
