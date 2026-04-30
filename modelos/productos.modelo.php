<?php

require_once "conexion.php";
class ModeloProductos{
   
     static public function  mdlMostrarProductos($tabla,$item,$valor){

        if($item !=null){
            $stmt = Conexion::conectar()-> prepare("SELECT *FROM $tabla where $item=:$item");
            $stmt -> bindParam(":".$item,$valor,PDO::PARAM_STR);
            $stmt -> execute();
            return $stmt -> fetch();
        }else{
            $stmt = Conexion::conectar()-> prepare("SELECT *FROM $tabla");
            $stmt -> execute();
            return $stmt -> fetchAll();

        }

        $stmt->close();
    }

    static public function mdlIngresarProducto($tabla,$datos){

        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(id_categoria,id_marca,codigo,descripcion,imagen,stock,precio_compra,
        precio_venta,bultos,cantidad_bulto,observacion,stock_inicial) VALUES(:id_categoria,:id_marca,:codigo,:descripcion,:imagen,:stock,:precio_compra,:precio_venta,:bultos,:cantidad_bulto,:observacion,:stock_inicial)");

        $stmt->bindParam(":id_categoria",$datos['id_categoria'],PDO::PARAM_INT);
        $stmt->bindParam(":id_marca",$datos['id_marca'],PDO::PARAM_INT);
        $stmt->bindParam(":codigo",$datos['codigo'],PDO::PARAM_STR);
        $stmt->bindParam(":descripcion",$datos['descripcion'],PDO::PARAM_STR);
        $stmt->bindParam(":imagen",$datos['imagen'],PDO::PARAM_STR);
        $stmt->bindParam(":stock",$datos['stock'],PDO::PARAM_STR);
        // $stmt->bindParam(":stock_inicial",$datos['stock'],PDO::PARAM_STR);
        $stmt->bindParam(":stock_inicial",$datos['stock_inicial'],PDO::PARAM_INT);
        $stmt->bindParam(":precio_compra",$datos['precio_compra'],PDO::PARAM_STR);
        $stmt->bindParam(":precio_venta",$datos['precio_venta'],PDO::PARAM_STR);
        $stmt->bindParam(":bultos",$datos['bultos'],PDO::PARAM_INT);
        $stmt->bindParam(":cantidad_bulto",$datos['cantidad_bulto'],PDO::PARAM_INT);
        $stmt->bindParam(":observacion",$datos['observacion'],PDO::PARAM_STR);
    

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();

    }
      /* =========================================
        Editar producto
    ======================================== */
    static public function mdlEditarProducto($tabla,$datos){
        $stmt=Conexion::conectar()->prepare("UPDATE $tabla SET id_categoria = :id_categoria,id_marca=:id_marca,codigo=:codigo,descripcion=:descripcion,imagen=:imagen,stock=:stock,precio_compra=:precio_compra,precio_venta=:precio_venta,observacion=:observacion,fecha_updated=:fecha_updated,cantidad_bulto =:cantidad_bulto,bultos=:bultos,stock_inicial=:stock_inicial WHERE codigo=:codigo"); 
        $stmt->bindParam(":id_categoria",$datos['id_categoria'],PDO::PARAM_INT);
        $stmt->bindParam(":id_marca",$datos['id_marca'],PDO::PARAM_INT);
        $stmt->bindParam(":codigo",$datos['codigo'],PDO::PARAM_STR);
        $stmt->bindParam(":descripcion",$datos['descripcion'],PDO::PARAM_STR);
        $stmt->bindParam(":imagen",$datos['imagen'],PDO::PARAM_STR);
        $stmt->bindParam(":stock",$datos['stock'],PDO::PARAM_STR);
        $stmt->bindParam(":precio_compra",$datos['precio_compra'],PDO::PARAM_STR);
        $stmt->bindParam(":precio_venta",$datos['precio_venta'],PDO::PARAM_STR);
        $stmt->bindParam(":cantidad_bulto",$datos['cantidad_bulto'],PDO::PARAM_INT);
        $stmt->bindParam(":stock_inicial",$datos['stock_inicial'],PDO::PARAM_INT);
        $stmt->bindParam(":bultos",$datos['bultos'],PDO::PARAM_INT);
        $stmt->bindParam(":observacion",$datos['observacion'],PDO::PARAM_STR);
        $stmt->bindParam(":fecha_updated",$datos['fecha_updated'],PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();
  
    }
 
     /* =========================================
        Eliminar producto
    ======================================== */
    static public function mdlEliminarProducto($tabla,$datos){

        $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt->bindParam(":id",$datos,PDO::PARAM_INT);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }
        $stmt->close();

    }

    /*======================================
        Actualizar producto
    =====================================*/
    static public function mdlActualizarProducto($tabla,$item1,$valor1,$valor2){
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