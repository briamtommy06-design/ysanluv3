<?php

require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';

require_once '../controladores/categorias.controlador.php';
require_once '../modelos/categorias.modelo.php';

require_once '../controladores/marcas.controlador.php';
require_once '../modelos/marcas.modelo.php';

// Puedes dejar los errores en 0 cuando ya esté estable
error_reporting(E_ALL);
ini_set('display_errors', 0);

class TablaProductos {

    public function mostrarTablaProductos() {

        $item  = null;
        $valor = null;

        try {

            $productos = ControladorProductos::ctrMostrarProductos($item, $valor);

        } catch (Throwable $e) {

            // Si algo explota (conexión, consulta, etc.), devolvemos JSON válido
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                "data"  => [],
                "error" => "Error al obtener productos: ".$e->getMessage()
            ]);
            return;
        }

        $data = [];

        if ($productos) {

            foreach ($productos as $index => $p) {

                $idProducto = isset($p["id"]) ? $p["id"] : 0;

                /* ================== IMAGEN ================== */

                $rutaImg = isset($p["imagen"]) ? $p["imagen"] : "";

                if ($rutaImg == "" || $rutaImg === null) {
                    $rutaImg = "vistas/img/productos/default/anonymous.png";
                }

                $imagenHtml = "<img src='".$rutaImg."' class='img-thumbnail imgTablaProducto' width='40' data-imagen-grande='".$rutaImg."'>";

                /* ============ CATEGORÍA / CATEGORÍA PADRE ============ */

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

                /* ================== DATOS BÁSICOS ================== */

                $codigo       = isset($p["codigo"]) ? $p["codigo"] : "";
                $descripcion  = isset($p["descripcion"]) ? $p["descripcion"] : "";
                $stock        = isset($p["stock"]) ? $p["stock"] : 0;
                $precioCompra = isset($p["precio_compra"]) ? $p["precio_compra"] : 0;
                $precioVenta  = isset($p["precio_venta"]) ? $p["precio_venta"] : 0;
                $fecha        = isset($p["fecha"]) ? $p["fecha"] : "";

                /* ================== BOTONES ================== */

                $botonesHtml =
                    "<div class='btn-group'>".
                        "<button class='btn btn-warning btnEditarProducto' idProducto='".$idProducto."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>".
                        "<button class='btn btn-danger btnEliminarProducto' idProducto='".$idProducto."' codigo='".$codigo."' imagen='".$rutaImg."'><i class='fa fa-times'></i></button>".
                    "</div>";

                /* ================== FILA PARA DATATABLE ================== */

                $fila = [
                    (string)($index + 1),
                    $imagenHtml,
                    $codigo,
                    strtoupper($descripcion),
                    strtoupper($nombreCategoria),
                    strtoupper($nombreCategoriaPadre),
                    $stock,
                    $precioCompra,
                    $precioVenta,
                    $fecha,
                    $botonesHtml
                ];

                $data[] = $fila;
            }
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["data" => $data]);
    }
}

/* ACTIVAR TABLA DE PRODUCTOS */
$activarProductos = new TablaProductos();
$activarProductos->mostrarTablaProductos();
