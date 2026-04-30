<?php
ini_set('display_errors', 0);   // 👈 agrega esta línea
require_once "../modelos/conexion.php";
require_once "../modelos/productos.modelo.php";

header('Content-Type: application/json; charset=utf-8');

try {

    // Validar que venga el id
    if (empty($_POST["idProductoEditar"])) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "Falta id de producto"
        ]);
        exit;
    }

    $idProducto = (int)$_POST["idProductoEditar"];

    // ========= VALIDAR Y PREPARAR DATOS IGUAL QUE EN ctrEditarProducto =========

    // OJO: aquí simplifico; puedes copiar tu lógica de validación
    if(
        !preg_match('/^[0-9]+$/', $_POST['editarStock']) ||
        !preg_match('/^[0-9.]+$/', $_POST['editarPrecioCompra']) ||
        !preg_match('/^[0-9.]+$/', $_POST['editarPrecioVenta'])
    ){
        echo json_encode([
            "ok" => false,
            "mensaje" => "Datos numéricos inválidos"
        ]);
        exit;
    }

    // Ruta imagen
    // Ruta imagen (URL que se guardará en la BD)
    $ruta = $_POST["imagenActual"];

    if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

        list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

        $nuevoAncho = 500;
        $nuevoAlto  = 500;

        // Rutas: una para la BD (URL) y otra física (en disco)
        $directorioUrl = "vistas/img/productos/".$_POST["editarCodigo"]; // lo que verá el navegador
        $directorioFs  = "../".$directorioUrl;                            // ruta física desde /ajax

        // Crear carpeta física si no existe
        if (!is_dir($directorioFs)) {
            mkdir($directorioFs, 0755, true);
        }

        // Borrar imagen anterior si no es la de default
        if (
            !empty($_POST["imagenActual"]) &&
            $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png" &&
            file_exists("../".$_POST["imagenActual"])
        ) {
            unlink("../".$_POST["imagenActual"]);
        }

        // ===== JPG =====
        if($_FILES["editarImagen"]["type"] == "image/jpeg"){

            $aleatorio = mt_rand(100,999);

            // Ruta que se guarda en la BD
            $ruta = $directorioUrl."/".$aleatorio.".jpg";

            // Ruta física donde se escribe el archivo
            $rutaFs = "../".$ruta;

            $origen  = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            imagecopyresized(
                $destino, $origen,
                0, 0, 0, 0,
                $nuevoAncho, $nuevoAlto,
                $ancho, $alto
            );

            imagejpeg($destino, $rutaFs);
        }

        // ===== PNG =====
        if($_FILES["editarImagen"]["type"] == "image/png"){

            $aleatorio = mt_rand(100,999);

            // Ruta que se guarda en la BD
            $ruta = $directorioUrl."/".$aleatorio.".png";

            // Ruta física
            $rutaFs = "../".$ruta;

            $origen  = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            // Mantener transparencia
            imagealphablending($destino, false);
            imagesavealpha($destino, true);

            imagecopyresized(
                $destino, $origen,
                0, 0, 0, 0,
                $nuevoAncho, $nuevoAlto,
                $ancho, $alto
            );

            imagepng($destino, $rutaFs);
        }
    }


    // Fecha actualización
    date_default_timezone_set('America/Lima');
    $fecha_actual = (new DateTime())->format('Y-m-d H:i:s');

    // Preparar datos para el modelo
    $tabla = "productos";

    $datos = array(
        "id"             => $idProducto, // SI tu modelo actualiza por id
        "id_categoria"   => $_POST["editarCategoria"],
        "codigo"         => $_POST["editarCodigo"],
        "id_marca"       => $_POST["editarMarca"],
        "descripcion"    => $_POST["editarDescripcion"],
        "imagen"         => $ruta,
        "stock"          => $_POST["editarStock"],
        "precio_compra"  => $_POST["editarPrecioCompra"],
        "precio_venta"   => $_POST["editarPrecioVenta"],
        "bultos"         => $_POST["editarBultosCompra"],
        "cantidad_bulto" => $_POST["editarCantidadCompra"],
        "stock_inicial"  => $_POST["editarStockInicial"],
        "observacion"    => $_POST["editarObservacion"],
        "fecha_updated"  => $fecha_actual
    );

    // Aquí debes adaptar a cómo funciona tu mdlEditarProducto
    $respuesta = ModeloProductos::mdlEditarProducto($tabla, $datos);

    if ($respuesta != "ok") {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se pudo actualizar en la BD"
        ]);
        exit;
    }

    // ========= VOLVEMOS A LEER EL PRODUCTO ACTUALIZADO PARA ARMAR LA FILA =========

    $db = Conexion::conectar();

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
    LEFT JOIN marcas m     ON p.id_marca     = m.id
    LEFT JOIN categorias c ON p.id_categoria = c.id
    LEFT JOIN categorias cp ON c.id_padre    = cp.id
    WHERE p.id = :id
    LIMIT 1
    ";


    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $idProducto, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se pudo leer el producto actualizado"
        ]);
        exit;
    }

 
    // Construir la fila EXACTAMENTE como en datatable-productos.ajax.php
    $idProducto   = (int)$row["id"];
    $codigo       = $row["codigo"];
    $descripcion  = $row["descripcion"];
    $stock        = (int)$row["stock"];
    $nombreMarca = $row["marca"] ?? "";
    $precioCompra = $row["precio_compra"];
    $precioVenta  = $row["precio_venta"];
    $fecha        = $row["fecha"];

    $rutaImg = $row["imagen"];
    if ($rutaImg == "" || $rutaImg === null) {
    $rutaImg = "vistas/img/productos/default/anonymous.png";
    }

    $imagenHtml = "<img src='".$rutaImg."' class='img-thumbnail imgTablaProducto' width='40' data-imagen-grande='".$rutaImg."'>";

    $nombreCategoria      = $row["categoria"]       ?? "";
    $nombreCategoriaPadre = $row["categoria_padre"] ?? "SIN PADRE";
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


    // Mantener el # que ya tenía la fila (si lo mandas desde JS), si no, 0
    $indice = isset($_POST["dt_index"]) ? (string)$_POST["dt_index"] : "0";

    $fila = [
    $indice,                         // 0: #
    $imagenHtml,                     // 1: Imagen
    $codigo,                         // 2: Código
    strtoupper($descripcion),        // 3: Descripción
    strtoupper($nombreMarca),          // <-- NUEVO (índice 4)
    strtoupper($nombreCategoria),    // 4: Categoría
    strtoupper($nombreCategoriaPadre),// 5: Categoría padre
    $stock,                          // 6: Stock
    $precioCompra,                   // 7: Precio compra
    $precioVenta,                    // 8: Precio venta
    $fecha,                          // 9: Agregado
    $botonesHtml                     // 10: Acciones
    ];

    echo json_encode(["ok" => true, "row" => $fila], JSON_UNESCAPED_UNICODE);
    exit;


} catch (Exception $e) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error: ".$e->getMessage()
    ]);
}
