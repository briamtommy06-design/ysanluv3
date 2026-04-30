<?php

class DashboardControlador{

    static public function ctrMostrarEstadoVentas(){
    
        $estadoventa = DashboardModelo::mdlEstadoVentas();
    
        return $estadoventa;
    
    }


    static public function ctrTopClientes(){
    
        $topclientes = DashboardModelo::mdlTopClientes();
    
        return $topclientes;
    
    }

    static public function ctrGetDatosDashboard(){

        $datos = DashboardModelo::mdlGetDatosDashboard();

        return $datos;
    }


}