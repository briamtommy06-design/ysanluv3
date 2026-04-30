<?php
require_once "conexion.php";
class ModeloMarcas{

    /* Crear Categoria */
    public static function mdlIngresarMarca($tabla,$datos){

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(marca) value(:marca)");
        $stmt -> bindParam(":marca",$datos,PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
    }

    /* MOSTRAR Categoria */
  static function mdlMostrarMarca($tabla,$item,$valor){
        if($item != null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");
            $stmt->bindParam(':'.$item,$valor,PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        }
       else{
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();
       }

       $stmt->close();

    }


        /* EDITAR Categoria */
        public static function mdlEditarMarca($tabla,$datos){

            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET marca= :marca WHERE id= :id");
            $stmt -> bindParam(":marca",$datos["marca"],PDO::PARAM_STR);
            $stmt -> bindParam(":id",$datos["id"],PDO::PARAM_INT);
            if($stmt->execute()){
                return "ok";
            }else{
                return "error";
            }
            $stmt->close();

        }

        /*Borrar categoria*/

        public static function mdlBorrarMarca($tabla,$datos){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla where id=:id");
            $stmt ->bindParam(":id",$datos,PDO::PARAM_INT);
            if($stmt->execute()){
                return "ok";
            }else{
                return "error";
            }
            $stmt->close();
 

        }

}