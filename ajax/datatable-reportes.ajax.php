<?php
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';

class TablaReportes{

    public function mostrarTablaReportes(){
    
       $respuesta = ControladorVentas::ctrReporteVenta();

        if(count($respuesta) == 0){

  			echo '{"data": []}';

		  	return;
  		}
        
        $datosJson='{

            "data": [';
            for($i=0;$i<count($respuesta);$i++){

                $datosJson.= '[
                    "'.$respuesta[$i]["notapedido"].'",
                    "'.$respuesta[$i]["nombre"].'",
                    "'.$respuesta[$i]["codigo"].'",
                    "'.$respuesta[$i]["descripcion"].'",
                    "'.$respuesta[$i]["cantidad"].'",
                    "'.$respuesta[$i]["precio_producto"].'",
                    "'.$respuesta[$i]["importe"].'",
                    "'.$respuesta[$i]["fecha"].'"
                  ],';
                }
        
            $datosJson=substr($datosJson,0,-1);
            $datosJson.='] 
            }';


            

        
   

        
        echo $datosJson;
      

    }


}


/* ACTIVAR TABLA DE PRODUCTOS */
$activarReportes=new TablaReportes();
$activarReportes->mostrarTablaReportes();