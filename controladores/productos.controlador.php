<?php
class ControladorProductos{

    static public function ctrMostrarProductos($item,$valor){
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarProductos($tabla,$item,$valor);
        return $respuesta;

    }

    static public function ctrCrearProducto(){

        if(isset($_POST['nuevaDescripcion'])){
            if(
            preg_match('/^[0-9]+$/',$_POST['nuevoStock'])&&
            preg_match('/^[0-9.]+$/',$_POST['nuevoPrecioCompra'])&&
            preg_match('/^[0-9.]+$/',$_POST['nuevoPrecioVenta'])){


                /*=============================================
                VALIDAR QUE EL CÓDIGO NO ESTÉ REPETIDO
                =============================================*/
                $tabla       = "productos";
                $itemCodigo  = "codigo";
                $valorCodigo = $_POST["nuevoCodigo"];

                $productoExistente = ModeloProductos::mdlMostrarProductos($tabla, $itemCodigo, $valorCodigo);

                if($productoExistente){

                    echo '<script>
                        swal({
                            type: "error",
                            title: "Código repetido",
                            text: "Ya existe un producto con el código '.$_POST["nuevoCodigo"].'",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then((result)=>{
                            if(result.value){
                                window.location = "productos";
                            }
                        });
                    </script>';

                    return; // 👉 corta aquí, NO sigue creando el producto
                }



                    /*=============================================
            VALIDAR IMAGEN AL CREAR PRODUCTO
            =============================================*/
            $ruta = "vistas/img/productos/default/anonymous.png";

            if(isset($_FILES["nuevaImagen"]["tmp_name"]) && !empty($_FILES["nuevaImagen"]["tmp_name"])){

                list($ancho, $alto) = getimagesize($_FILES["nuevaImagen"]["tmp_name"]);
                $nuevoAncho = 500;
                $nuevoAlto  = 500;

                $directorio = "vistas/img/productos/".$_POST["nuevoCodigo"];

                if(!is_dir($directorio)){
                    mkdir($directorio, 0755, true);
                }

                if($_FILES["nuevaImagen"]["type"] == "image/jpeg"){
                    $aleatorio = mt_rand(100,999);
                    $ruta = $directorio."/".$aleatorio.".jpg";

                    $origen = imagecreatefromjpeg($_FILES["nuevaImagen"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, 
                                    $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagejpeg($destino, $ruta);
                }

                if($_FILES["nuevaImagen"]["type"] == "image/png"){
                    $aleatorio = mt_rand(100,999);
                    $ruta = $directorio."/".$aleatorio.".png";

                    $origen = imagecreatefrompng($_FILES["nuevaImagen"]["tmp_name"]);
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                    imagecopyresized($destino, $origen, 0, 0, 0, 0, 
                                    $nuevoAncho, $nuevoAlto, $ancho, $alto);
                    imagepng($destino, $ruta);
                }
            }

                    $tabla = "productos";
                    $stockInicial = (int)$_POST["nuevoStock"];
                    $datos = array("id_categoria" => $_POST["nuevaCategoria"],
                                    "id_marca" => $_POST["nuevaMarca"],
                                    "codigo" => $_POST["nuevoCodigo"],
                                    "descripcion" => $_POST["nuevaDescripcion"],
                                    "imagen"         => $ruta, // 👈 importante
                                    // "stock" => $_POST["nuevoStock"],
                                    "stock"           => 0,                 // 👈 IMPORTANTE
                                    "stock_inicial"   => $stockInicial,     // 👈 IMPORTANTE
                                    "precio_compra" => $_POST["nuevoPrecioCompra"],
                                    "precio_venta" => $_POST["nuevoPrecioVenta"],
                                    "bultos" => $_POST["nuevoBultosCompra"],
                                    "cantidad_bulto" => $_POST["nuevoCantidadCompra"],
                                    "observacion" => $_POST["nuevoObservacion"],
                                    
                                );
        
      
                    $respuesta=ModeloProductos::mdlIngresarProducto($tabla,$datos);
                    

                

			
                if($respuesta=="ok"){
                    
                    if($stockInicial > 0){

                        // obtener el producto recién creado (por código)
                    $prod = ModeloProductos::mdlMostrarProductos("productos", "codigo", $_POST["nuevoCodigo"]);

                        if($prod){
                        // requiere tener cargado movimientos_stock.modelo.php
                        $mov = ModeloMovimientosStock::mdlRegistrarMovimiento([
                            "id_producto"        => (int)$prod["id"],
                            "id_usuario"         => isset($_SESSION["id"]) ? (int)$_SESSION["id"] : null,
                            "tipo"               => "INGRESO",
                            "motivo"             => "AJUSTE",
                            "cajas"              => (int)$_POST["nuevoBultosCompra"],
                            "unidades_por_caja"  => (int)$_POST["nuevoCantidadCompra"],
                            "cantidad_unidades"  => $stockInicial,
                            "costo_docena"       => null,
                            "moneda"             => null,
                            "observacion"        => "Stock inicial (creación de producto)"
                        ]);
                        }
                    }
                    echo '<script>
                    swal({
                        type:"success",
                        title:"!El producto ha sido guardado correctamente ¡",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="productos";
                        }
                    });

                </script>';
                } 
            }else{
                echo '<script>
                    swal({
                        type:"error",
                        title:"!El producto no puede ir con los campos vacíos o llevar caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="productos";
                        }
                    });

                </script>';
            }
        }


    }

    /*=============================
        Editar productos
    ==============================*/
    static public function ctrEditarProducto(){
        
        
        if(isset($_POST['editarDescripcion'])){
            if(
            preg_match('/^[0-9]+$/',$_POST['editarStock'])&&
            preg_match('/^[0-9.]+$/',$_POST['editarPrecioCompra'])&&
            preg_match('/^[0-9.]+$/',$_POST['editarPrecioVenta'])){


                /*=============================================
                VALIDAR QUE EL NUEVO CÓDIGO NO ESTÉ REPETIDO
                (EXCEPTO EN EL MISMO PRODUCTO)
                =============================================*/
                $tabla       = "productos";
                $itemCodigo  = "codigo";
                $valorCodigo = $_POST["editarCodigo"];

                $productoExistente = ModeloProductos::mdlMostrarProductos($tabla, $itemCodigo, $valorCodigo);

                if($productoExistente && $productoExistente["id"] != $_POST["idProductoEditar"]){

                    echo '<script>
                        swal({
                            type: "error",
                            title: "Código repetido",
                            text: "Ya existe otro producto con el código '.$_POST["editarCodigo"].'",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                        }).then((result)=>{
                            if(result.value){
                                window.location = "productos";
                            }
                        });
                    </script>';

                    return; // 👉 corta aquí, NO sigue editando
                }

            /* ========================================
                PROCESAMIENTO DE IMAGEN EDITADA
            ======================================== */

            $ruta = $_POST["imagenActual"]; // imagen actual por defecto

            // Si subieron una imagen nueva
            if(isset($_FILES["editarImagen"]["tmp_name"]) && !empty($_FILES["editarImagen"]["tmp_name"])){

                list($ancho, $alto) = getimagesize($_FILES["editarImagen"]["tmp_name"]);

                $nuevoAncho = 500;
                $nuevoAlto = 500;

                $directorio = "vistas/img/productos/".$_POST["editarCodigo"];

                // Crear directorio si no existe
                if(!is_dir($directorio)){
                    mkdir($directorio, 0755, true);
                }

                // Borrar imagen anterior solo si existe físicamente
                if(!empty($_POST["imagenActual"]) && 
                $_POST["imagenActual"] != "vistas/img/productos/default/anonymous.png" &&
                file_exists($_POST["imagenActual"])){

                    unlink($_POST["imagenActual"]);
                }

                // Crear nueva imagen
                $aleatorio = mt_rand(100,999);

                if($_FILES["editarImagen"]["type"] == "image/jpeg"){

                    $ruta = $directorio."/".$aleatorio.".jpg";

                    $origen = imagecreatefromjpeg($_FILES["editarImagen"]["tmp_name"]); 
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagecopyresized($destino, $origen, 0, 0, 0, 0, 
                                    $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagejpeg($destino, $ruta);

                } elseif($_FILES["editarImagen"]["type"] == "image/png"){

                    $ruta = $directorio."/".$aleatorio.".png";

                    $origen = imagecreatefrompng($_FILES["editarImagen"]["tmp_name"]); 
                    $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                    imagecopyresized($destino, $origen, 0, 0, 0, 0, 
                                    $nuevoAncho, $nuevoAlto, $ancho, $alto);

                    imagepng($destino, $ruta);
                }
            }


                $tabla="productos";
                
                date_default_timezone_set('America/Lima');

                // Obtener la fecha y hora actual
                $fecha_actual = new DateTime();
                
                // Formatear la fecha y hora actual según el formato deseado
                $fecha_actual_formateada = $fecha_actual->format('Y-m-d H:i:s');
   


                $datos=array("id_categoria"=>$_POST["editarCategoria"],
                "codigo"=>$_POST["editarCodigo"],
                "id_marca"=>$_POST["editarMarca"],
                "descripcion"=>$_POST["editarDescripcion"],
                "imagen"         => $ruta, // 👈 aquí también
                "stock"=>$_POST["editarStock"],
                "precio_compra"=>$_POST["editarPrecioCompra"],
                "precio_venta"=>$_POST["editarPrecioVenta"],
                "bultos" => $_POST["editarBultosCompra"],
                "cantidad_bulto" => $_POST["editarCantidadCompra"],
                "stock_inicial" => $_POST["editarStockInicial"],
                "observacion" => $_POST["editarObservacion"],
                "fecha_updated" => $fecha_actual_formateada

                
                );

                $respuesta=ModeloProductos::mdlEditarProducto($tabla,$datos);
                
                if($respuesta=="ok"){
                    echo '<script>
                    swal({
                        type:"success",
                        title:"!El producto ha sido editado correctamente ¡",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                    
                        }
                    });

                </script>';
                }


            }else{
                echo '<script>
                    swal({
                        type:"error",
                        title:"!El producto no puede ir con los campos vacíos o llevar caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                           
                        }
                    });

                </script>';
            }
        }
    }


    /* ==============================
        Eliminar producto
    ========================== */
    static public function ctrEliminarProducto(){

        if(isset($_GET["idProducto"])){

            $tabla = "productos";
            $idProducto = $_GET["idProducto"];

            // 1) Traer el producto para revisar su campo "ventas"
            $producto = ModeloProductos::mdlMostrarProductos($tabla, "id", $idProducto);

            // Si existe y tiene ventas > 0, BLOQUEAR ELIMINACIÓN
            if($producto && !empty($producto["ventas"]) && $producto["ventas"] > 0){

                echo '<script>
                        swal({
                            type: "error",
                            title: "No se puede eliminar el producto",
                            text: "Este producto ya tiene ventas registradas. Primero debes anular esas ventas si realmente quieres eliminarlo.",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{
                            if(result.value){
                                window.location = "productos";
                            }
                        });
                    </script>';

                return; // 👈 IMPORTANTE: salimos y NO borramos nada
            }

            // 2) Si NO tiene ventas, sí permitimos eliminar

            $datos = $idProducto;

            // Borrar imagen y carpeta (como ya lo hacías)
            if(isset($_GET["imagen"]) 
                && $_GET["imagen"] != "" 
                && $_GET["imagen"] != "vistas/img/productos/default/anonymous.png"){

                // Borrar archivo si existe
                if(file_exists($_GET["imagen"])){
                    unlink($_GET["imagen"]);
                }

                // Borrar carpeta del producto (si está vacía)
                $directorio = "vistas/img/productos/".$_GET["codigo"];
                if(is_dir($directorio)){
                    // Opcional: borrar cualquier archivo dentro
                    foreach(glob($directorio."/*") as $file){
                        if(is_file($file)){
                            unlink($file);
                        }
                    }
                    @rmdir($directorio);
                }
            }

            // 3) Eliminar registro en BD
            $respuesta = ModeloProductos::mdlEliminarProducto($tabla, $datos);

            if($respuesta=="ok"){
                echo '<script>
                        swal({
                            type:"success",
                            title:"¡El producto ha sido borrado correctamente!",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{
                            if(result.value){
                                window.location="productos";
                            }
                        });
                    </script>'; 
            }
        }
    }
    static public function ctrIngresoStock(){

        if(isset($_POST["idProductoStock"])){

            $idProducto = (int)$_POST["idProductoStock"];
            $cajas = !empty($_POST["cajasStock"]) ? (int)$_POST["cajasStock"] : null;
            $unidadesCaja = !empty($_POST["unidadesCajaStock"]) ? (int)$_POST["unidadesCajaStock"] : null;

            // Si compra por caja: unidades = cajas * unidadesCaja
            $cantidadUnidades = 0;
            if($cajas && $unidadesCaja){
            $cantidadUnidades = $cajas * $unidadesCaja;
            } else {
            // fallback: permitir ingresar unidades directas
            $cantidadUnidades = (int)$_POST["cantidadAgregarStock"];
            }

            $costoDocena = !empty($_POST["costoDocena"]) ? (float)$_POST["costoDocena"] : null;
            $moneda = !empty($_POST["monedaStock"]) ? $_POST["monedaStock"] : null;
            $obs = !empty($_POST["obsStock"]) ? $_POST["obsStock"] : null;

            $cantidadDocenas = $cantidadUnidades > 0 ? round($cantidadUnidades/12, 2) : null;
            $costoUnitario = ($costoDocena !== null) ? round($costoDocena/12, 4) : null;

            $datos = [
            "id_producto" => $idProducto,
            "id_usuario" => isset($_SESSION["id"]) ? (int)$_SESSION["id"] : null,
            "id_venta" => null,

            "tipo" => "INGRESO",
            "motivo" => "COMPRA",

            "cajas" => $cajas,
            "unidades_por_caja" => $unidadesCaja,
            "cantidad_unidades" => $cantidadUnidades,
            "cantidad_docenas" => $cantidadDocenas,

            "costo_docena" => $costoDocena,
            "costo_unitario" => $costoUnitario,
            "moneda" => $moneda,

            "observacion" => $obs
            ];

            $respuesta = ModeloMovimientosStock::mdlAplicarMovimiento($datos);

            if($respuesta === "ok"){
            echo '<script>
                swal({type:"success", title:"Ingreso registrado", showConfirmButton:true, confirmButtonText:"Cerrar"})
                .then((r)=>{ if(r.value){ window.location="productos"; }});
            </script>';
            }else{
            echo '<script>
                swal({type:"error", title:"No se pudo registrar", text:"'.$respuesta.'", showConfirmButton:true, confirmButtonText:"Cerrar"})
                .then((r)=>{ if(r.value){ window.location="productos"; }});
            </script>';
            }
        }
    }

    static public function ctrSalidaStock(){

        if(isset($_POST["idProductoDisminuir"])){

            $idProducto = (int)$_POST["idProductoDisminuir"];
            $cant = (int)$_POST["cantidadDisminuirStock"];
            $motivo = !empty($_POST["motivoDisminuirStock"]) ? $_POST["motivoDisminuirStock"] : "OTRO";
            $obs = !empty($_POST["obsDisminuirStock"]) ? $_POST["obsDisminuirStock"] : null;

            $datos = [
            "id_producto" => $idProducto,
            "id_usuario" => isset($_SESSION["id"]) ? (int)$_SESSION["id"] : null,
            "id_venta" => null,

            "tipo" => "SALIDA",
            "motivo" => $motivo,

            "cantidad_unidades" => $cant,
            "cantidad_docenas" => round($cant/12, 2),

            "observacion" => $obs
            ];

            $respuesta = ModeloMovimientosStock::mdlAplicarMovimiento($datos);

            if($respuesta === "ok"){
            echo '<script>
                swal({type:"success", title:"Salida registrada", showConfirmButton:true, confirmButtonText:"Cerrar"})
                .then((r)=>{ if(r.value){ window.location="productos"; }});
            </script>';
            }else{
            echo '<script>
                swal({type:"error", title:"No se pudo registrar", text:"'.$respuesta.'", showConfirmButton:true, confirmButtonText:"Cerrar"})
                .then((r)=>{ if(r.value){ window.location="productos"; }});
            </script>';
            }
        }
    }




}

