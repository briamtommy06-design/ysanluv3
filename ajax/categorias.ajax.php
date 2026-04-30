<?php
require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class AjaxCategorias{

    public $idCategoria;

    /* Obtener datos de una categoría para el modal */
    public function ajaxObtenerCategoria(){
        $item = "id";
        $valor  = $this->idCategoria;
        $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);
        echo json_encode($respuesta);
    }

    /* Actualizar categoría desde AJAX */
    public function ajaxActualizarCategoria(){

        $tabla = "categorias";

        $datos = array(
            "categoria" => $_POST["editarCategoria"],
            "id"        => $_POST["idCategoria"],
            "id_padre"  => $_POST["editarPadreCategoria"] !== "" ? $_POST["editarPadreCategoria"] : null
        );

        // OJO: llamamos DIRECTO al MODELO para que NO imprima scripts ni HTML
        $respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

        // Solo devolvemos JSON
        echo json_encode(array("resultado" => $respuesta));
    }
}

/* router de las peticiones AJAX */

// 1) Obtener datos de una categoría (para cargar el modal)
if(isset($_POST["idCategoria"]) && !isset($_POST["accion"])){

    $editar = new AjaxCategorias();
    $editar->idCategoria = $_POST["idCategoria"];
    $editar->ajaxObtenerCategoria();
    exit;
}

// 2) Actualizar categoría
if(isset($_POST["accion"]) && $_POST["accion"] === "actualizarCategoria"){

    $ajax = new AjaxCategorias();
    $ajax->ajaxActualizarCategoria();
    exit;
}
