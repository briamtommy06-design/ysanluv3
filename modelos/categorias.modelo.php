<?php
require_once "conexion.php";
class ModeloCategorias{

    /* Crear Categoria */
    /* Crear Categoria */
    public static function mdlIngresarCategoria($tabla, $datos){

        $sql = "INSERT INTO $tabla (categoria, id_padre) VALUES (:categoria, :id_padre)";
        $stmt = Conexion::conectar()->prepare($sql);

        $stmt->bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);

        if($datos["id_padre"] === "" || $datos["id_padre"] === null){
            $stmt->bindValue(":id_padre", null, PDO::PARAM_NULL);
        }else{
            $stmt->bindValue(":id_padre", $datos["id_padre"], PDO::PARAM_INT);
        }

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }

        $stmt->close();
    }

    /* MOSTRAR Categoria */
    static function mdlMostrarCategorias($tabla, $item, $valor){

        if($item != null){

            $stmt = Conexion::conectar()
                ->prepare("SELECT * FROM $tabla WHERE $item = :$item");
            $stmt->bindParam(':'.$item, $valor, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();

        }else{

            // c = categoría hija, cp = categoría padre
            $stmt = Conexion::conectar()->prepare("
                SELECT c.*,
                    cp.categoria AS categoria_padre
                FROM $tabla c
                LEFT JOIN $tabla cp ON cp.id = c.id_padre
                ORDER BY c.id ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll();
        }

        $stmt->close();
    }


/* EDITAR Categoria */
public static function mdlEditarCategoria($tabla,$datos){

    $sql = "UPDATE $tabla 
            SET categoria = :categoria,
                id_padre  = :id_padre
            WHERE id = :id";

    $stmt = Conexion::conectar()->prepare($sql);

    $stmt -> bindParam(":categoria",$datos["categoria"],PDO::PARAM_STR);
    $stmt -> bindParam(":id",$datos["id"],PDO::PARAM_INT);

    if($datos["id_padre"] === "" || $datos["id_padre"] === null){
        $stmt->bindValue(":id_padre", null, PDO::PARAM_NULL);
    }else{
        $stmt->bindValue(":id_padre", $datos["id_padre"], PDO::PARAM_INT);
    }

    if($stmt->execute()){
        return "ok";
    }else{
        return "error";
    }
    $stmt->close();
}



        /*Borrar categoria*/

        public static function mdlBorrarCategoria($tabla,$datos){
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