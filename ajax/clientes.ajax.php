<?php
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

class AjaxClientes{
    /*==========================
        Editar cliente
    ==========================*/
    public $idCliente;
    public function ajaxEditarCliente(){

        $item="id";
        $valor=$this->idCliente;

        $respuesta= ControladorClientes::ctrMostrarClientes($item,$valor);
    
        echo json_encode($respuesta);
    }
}

/*==========================
    Editar cliente
==========================*/
if(isset($_POST['idCliente'])){
    $categoria=new AjaxClientes();
    $categoria -> idCliente=$_POST["idCliente"];
    $categoria -> ajaxEditarCliente();
}