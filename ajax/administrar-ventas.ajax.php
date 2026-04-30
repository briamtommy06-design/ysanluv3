<?php
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';


class TablaAdministrarVentas{

    public function mostrarTablaAdministrarVentas(){
      $item=null;
      $valor=null;

      $ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
    
 
      if(count($ventas) == 0){

  			echo '{"data": []}';

		  	return;
  		}


      $datosJson='{
        "data": [';
        for($i=0;$i<count($ventas);$i++){

          
            $idCli = $ventas[$i]["id_cliente"];

            if (!isset($cacheClientes[$idCli])) {
              $cacheClientes[$idCli] = ControladorClientes::ctrMostrarClientes("id", $idCli);
            }

            $respuestaCliente = $cacheClientes[$idCli];

            if($ventas[$i]["estado"]!=0){
              $estado="<button class='btn btn-success btn-xs btnEstadoVenta' idVenta='".$ventas[$i]["codigo"]."' estadoVenta='0'>Entregado</button>";
            }else{
              $estado="<button class='btn btn-danger btn-xs btnEstadoVenta' idVenta='".$ventas[$i]["codigo"]."' estadoVenta='1'>No entregado</button>";
            }

            /*=======================================
              Traemos las acciones
            =======================================*/
         $acciones="<div class='btn-group'><button class='btn btn-info btnImprimirFactura' codigoVenta='".$ventas[$i]["codigo"]."'><i class='fa fa-print'></i></button><button class='btn btn-success btnImprimirTicket' codigoVenta='".$ventas[$i]["codigo"]."'><i class='fa fa-ticket'></i></button><button class='btn btn-warning btnEditarVenta' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarVenta' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
          $datosJson.= '[
            "'.($i+1).'",
            "'.$ventas[$i]["codigo"].'",
            "'.$respuestaCliente["nombre"].'",
            "'.$ventas[$i]["metodo_pago"].'",
            "'.$estado.'",
            "'.$ventas[$i]["total"].'",
            "'.$ventas[$i]["fecha"].'",
            "'.$acciones.'"
          ],';
        }

        $datosJson=substr($datosJson,0,-1);
        $datosJson.='] 
        }';

        
        echo $datosJson;
      

        
    }
}

/* ACTIVAR TABLA DE PRODUCTOS */
$activarProductos=new TablaAdministrarVentas();
$activarProductos->mostrarTablaAdministrarVentas(); 