<?php

require_once "conexion.php";

class DashboardModelo{

    static public function mdlGetDatosDashboard(){

        $stmt = Conexion::conectar()->prepare('call prc_get_dashboard()');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
        $stmt->close();
       
    }



        static public function mdlEstadoVentas(){


            
            $stmt = Conexion::conectar()->prepare('call prc_estado_ventas()');

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
   
            $stmt->close();
        }

        static public function mdlTopClientes(){
            
            $stmt = Conexion::conectar()->prepare('call prc_top_clientes()');

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
   
            $stmt->close();
        }




}