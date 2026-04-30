<?php
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';





class TablaProductosVentas{
  /*=======================================
    Mostrar tabla de productos
  =======================================*/
    public function mostrarTablaProductosVentas(){

      $item=null;
      $valor=null;

      $productos=ControladorProductos::ctrMostrarProductos($item,$valor);




      
      $datosJson='{
        "data": [';
        for($i=0;$i<count($productos);$i++){
            /*=======================================
              Traemos la imagen
            =======================================*/

          /*=======================================
              Stock
            =======================================*/
            if($productos[$i]["stock"]<=10){
              $stock="<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";

            }else if($productos[$i]["stock"]>11&&$productos[$i]["stock"]<=15){

              $stock="<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";
            }else{
              $stock="<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";
            }
          
          
            /*=======================================
              Traemos las acciones
            =======================================*/

          $botones="<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]["id"]."' >Agregar</button></div>";

          $datosJson.= '[
            "'.($i+1).'",
          
            "'.$productos[$i]["codigo"].'",
           "'.$productos[$i]["descripcion"].'",
            "'.$stock.'",
            "'.$botones.'"
          ],';
        }

        $datosJson=substr($datosJson,0,-1);
        $datosJson.='] 
        }';

        
        echo $datosJson;
      

        
    }
}
/*=======================================
    Activar tabla de productos
=======================================*/
$activarProductosVentas=new TablaProductosVentas();
$activarProductosVentas->mostrarTablaProductosVentas();

?>