<?php
require_once "conexion.php";
class ModeloClientes{
    static public function mdlIngresarCliente($tabla,$datos)
    {   
        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,telefono,direccion,ciudad) VALUES (:nombre,:telefono,:direccion,:ciudad)"); 
        $stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
        $stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
        $stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
        
    }

    static public function mdlMostrarClientes($item,$tabla,$valor){
        if($item!=null){
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");
            $stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch();
        }else{
            $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla");
            $stmt->execute();
            
            return $stmt->fetchAll();
        
        }
        $stmt->close();

    }



     /* ==========================
        Editar clientes        
    =============================*/
    static public function mdlEditarCliente($tabla,$datos){

        
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET nombre=:nombre,
        telefono=:telefono,direccion=:direccion,ciudad=:ciudad WHERE id=:id");
        $stmt->bindParam(":id",$datos["id"],PDO::PARAM_INT);
        $stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
        $stmt->bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
        $stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
        $stmt->bindParam(":ciudad",$datos["ciudad"],PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
    }
     /* ========================================
        Eliminar cliente
      ======================================== */
      static public function mdlEliminarCliente($tabla,$datos){
        
        $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt->bindParam(":id",$datos,PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
    }

    /*======================================
        Actualizar cliente
    =====================================*/
    static public function mdlActualizarCliente($tabla,$item1,$valor1,$valor2){
        $stmt=Conexion ::conectar()->prepare("UPDATE $tabla SET $item1=:$item1 WHERE id=:id");

        $stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
        $stmt->bindParam(":id",$valor2,PDO::PARAM_STR);
        
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
    }

}