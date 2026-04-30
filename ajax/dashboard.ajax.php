<?php

require_once "../controladores/dashboard.controlador.php";
require_once "../modelos/dashboard.modelo.php";


class AjaxDashboard{

    // public function getDatosDashboard(){

    //     $datos = DashboardControlador::ctrGetDatosDashboard();

    //     echo json_encode($datos);
    // }

    // public function getVentasMesActual(){
    //     $ventasMesActual = DashboardControlador::ctrGetVentasMesActual();
    //     echo json_encode($ventasMesActual);
    // }
    
    // public function getProductosMasVendidos(){
    
    //     $productosMasVendidos = DashboardControlador::ctrProductosMasVendidos();
    
    //     echo json_encode($productosMasVendidos);
    
    // }
    // public function getProductosPocoStock(){
    
    //     $productosPocoStock = DashboardControlador::ctrProductosPocoStock();
    
    //     echo json_encode($productosPocoStock);
    
    // }

    public function getEstadoVentas(){

        $ventasEstado = DashboardControlador::ctrMostrarEstadoVentas();

        echo json_encode($ventasEstado);

    }

    public function getClienteTop(){

        $clientetop = DashboardControlador::ctrTopClientes();
        echo json_encode($clientetop);

    }
    public function getDatosDashboard(){

        $datos = DashboardControlador::ctrGetDatosDashboard();

        echo json_encode($datos);
    }
    
  
}

if(isset($_POST['accion']) && $_POST['accion'] == 1){ //Ejecutar funcion estado ventas

    $estadoVentas = new AjaxDashboard();
    $estadoVentas -> getEstadoVentas();

}

elseif(isset($_POST['accion']) && $_POST['accion'] == 2){ //Ejecutar funcion estado ventas

    $clienteTop = new AjaxDashboard();
    $clienteTop -> getClienteTop();

}else{
    $datos = new AjaxDashboard();
    $datos -> getDatosDashboard();

}
