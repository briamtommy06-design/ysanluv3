<?php
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";

class AjaxVentas{

    public $activarVenta;
    public $activarId;

    public function ajaxActivarVenta(){
        $tabla = "ventas";
        $item1 = "estado";
        $valor1 = $this->activarVenta;
        $item2 = "codigo";
        $valor2 = $this->activarId;
        $respuesta = ModeloVentas::mdlActualizarVenta($tabla,$item1,$valor1,$item2,$valor2);
        return $respuesta;

    }

}


if(isset($_POST["estadoVenta"])){

    $activarVentas = new AjaxVentas();
    $activarVentas -> activarVenta = $_POST["estadoVenta"];
    $activarVentas -> activarId = $_POST["idVenta"];
    $activarVentas -> ajaxActivarVenta();
}