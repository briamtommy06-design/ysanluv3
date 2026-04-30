<?php

// require_once '../modelos/conexion.php';
require_once __DIR__ . "/../modelos/conexion.php";


class TablaProductos {

    public function mostrarTablaProductos() {

        $db = Conexion::conectar();

        // UNA sola consulta con JOIN para traer:
        // producto + categoría + categoría padre
        $sql = "
            SELECT 
                p.id,
                p.codigo,
                p.descripcion,
                p.imagen,
                p.stock,
                p.precio_compra,
                p.precio_venta,
                p.fecha,
                m.marca          AS marca,
                c.categoria      AS categoria,
                cp.categoria     AS categoria_padre
            FROM productos p
            LEFT JOIN marcas m
                ON p.id_marca = m.id
            LEFT JOIN categorias c 
                ON p.id_categoria = c.id
            LEFT JOIN categorias cp 
                ON c.id_padre = cp.id
            ORDER BY p.id DESC
            ";


        $stmt = $db->prepare($sql);
        $stmt->execute();

        $data = [];
        $index = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $index++;

            $idProducto   = (int)$row["id"];
            $codigo       = $row["codigo"];
            $descripcion  = $row["descripcion"];
            $stock        = (int)$row["stock"];
            $precioCompra = $row["precio_compra"];
            $precioVenta  = $row["precio_venta"];
            $fecha        = $row["fecha"];

            // ---------- IMAGEN ----------
            $rutaImg = $row["imagen"];
            if ($rutaImg == "" || $rutaImg === null) {
                $rutaImg = "vistas/img/productos/default/anonymous.png";
            }

            $imagenHtml = "<img src='".$rutaImg."' class='img-thumbnail imgTablaProducto' width='40' data-imagen-grande='".$rutaImg."'>";

            // ---------- CATEGORÍA Y PADRE ----------
            $nombreCategoria      = $row["categoria"]       ?? "";
            $nombreCategoriaPadre = $row["categoria_padre"] ?? "SIN PADRE";

            // ---------- BOTONES ----------
            $botonesHtml =
            "<div class='btn-group'>".
                "<button class='btn btn-success btnIngresoStock'
                idProducto='".$row["id"]."'
                codigo='".$codigo."'
                descripcion='".htmlspecialchars($descripcion, ENT_QUOTES, "UTF-8")."'
                stock='".$stock."'>
                <i class='fa fa-plus'></i>
                </button>".
                "<button class='btn btn-danger btnSalidaStock'
                idProducto='".$row["id"]."'
                codigo='".$codigo."'
                descripcion='".htmlspecialchars($descripcion, ENT_QUOTES, "UTF-8")."'
                stock='".$stock."'>
                <i class='fa fa-minus'></i>
                </button>".

                // ✅ NUEVO BOTÓN KARDEX
                "<button class='btn btn-info btnKardexStock'
                idProducto='".$row["id"]."'
                codigo='".$codigo."'
                descripcion='".htmlspecialchars($descripcion, ENT_QUOTES, "UTF-8")."'>
                <i class='fa fa-list'></i>
                </button>".

                "<button class='btn btn-warning btnEditarProducto' idProducto='".$idProducto."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-pencil'></i></button>".
                "<button class='btn btn-danger btnEliminarProducto' idProducto='".$idProducto."' codigo='".$codigo."' imagen='".$rutaImg."'><i class='fa fa-times'></i></button>".
            "</div>";


            // ---------- FILA PARA DATATABLE (11 columnas) ----------
            $nombreMarca = $row["marca"] ?? "";

            $fila = [
            (string)$index,                    // 0
            $imagenHtml,                       // 1
            $codigo,                           // 2
            strtoupper($descripcion),          // 3
            strtoupper($nombreMarca),          // 4  <-- NUEVO
            strtoupper($nombreCategoria),      // 5
            strtoupper($nombreCategoriaPadre), // 6
            $stock,                            // 7
            $precioCompra,                     // 8
            $precioVenta,                      // 9
            $fecha,                            // 10
            $botonesHtml                       // 11
            ];


            $data[] = $fila;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(["data" => $data], JSON_UNESCAPED_UNICODE);
    }
}

/* ACTIVAR TABLA DE PRODUCTOS */
$activarProductos = new TablaProductos();
$activarProductos->mostrarTablaProductos();
