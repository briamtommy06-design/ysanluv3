<?php
    require_once '../controladores/productos.controlador.php';
    require_once '../modelos/productos.modelo.php';
    class AjaxProductos{
        /* ==================================
        Generar codigo a partir de ID categoria 
        =========================================*/
        public $idCategoria;
        public function ajaxCrearCodigoProducto(){
            $item="id_categoria";
            $valor=$this->idCategoria;
            $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor);
        
            echo json_encode($respuesta);
        }
        /* ==================================
        Editar producto
        =========================================*/
    
        public $idProducto;
        public $traerProductos;
        public $nombreProducto;

        public function ajaxEditarProducto(){

            if($this->traerProductos=="ok"){
                $item=null;
                $valor=null;
                $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor);
            
                echo json_encode($respuesta); 
            }else if($this->nombreProducto!=""){

                $item="descripcion";
                $valor=$this->nombreProducto;
                $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor);
        
                echo json_encode($respuesta);
            }else{

                $item="id";
                $valor=$this->idProducto;
                $respuesta=ControladorProductos::ctrMostrarProductos($item,$valor);
        
                echo json_encode($respuesta);
            }
            
        }

        
        public $codigoProducto;
        public $idProductoActual; // opcional, para el caso de edición

        public function ajaxValidarCodigoProducto(){

            $item  = "codigo";
            $valor = $this->codigoProducto;

            $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

            // Si estoy editando y el código pertenece al mismo producto, NO es repetido
            if (!empty($this->idProductoActual) &&
                $respuesta &&
                $respuesta["id"] == $this->idProductoActual) {

                echo json_encode(["repetido" => false]);
                return;
            }

            // Si hay algún producto con ese código y no es el mismo → repetido
            if ($respuesta) {
                echo json_encode(["repetido" => true]);
            } else {
                echo json_encode(["repetido" => false]);
            }
        }

    }

     /* ==================================
        Generar codigo a partir de ID categoria 
    =========================================*/
   /* if(isset($_POST['idCategoria'])){
        $codigoProducto=new AjaxProductos();
        $codigoProducto->idCategoria=$_POST['idCategoria'];
        $codigoProducto->ajaxCrearCodigoProducto();
    } */

      /* ==================================
        Editar producto
    =========================================*/
    if(isset($_POST['idProducto'])){
        $editarProducto=new AjaxProductos();
        $editarProducto->idProducto=$_POST['idProducto'];
        $editarProducto->ajaxEditarProducto();
    } 
    /* ==================================
        traer productos
    =========================================*/
    if(isset($_POST['traerProductos'])){
        $traerProductos=new AjaxProductos();
        $traerProductos->traerProductos=$_POST['traerProductos'];
        $traerProductos->ajaxEditarProducto();
    } 
    /* ==================================
        traer productos
    =========================================*/
    if(isset($_POST['nombreProducto'])){
        $traerProductos=new AjaxProductos();
        $traerProductos->nombreProducto=$_POST['nombreProducto'];
        $traerProductos->ajaxEditarProducto();
    } 

    /* ==================================
   Validar código de producto (en vivo)
    =========================================*/
    if (isset($_POST["codigoValidar"])) {

        $validar = new AjaxProductos();
        $validar->codigoProducto = $_POST["codigoValidar"];

        // Para el caso de edición, puede venir el id actual
        if (isset($_POST["idProductoActual"])) {
            $validar->idProductoActual = $_POST["idProductoActual"];
        }

        $validar->ajaxValidarCodigoProducto();
    }
