<?php
require_once "conexion.php";

class ModeloEmisor{

    static public function mdlIngresarEmisor($tabla,$datos){

        $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(tipodoc,ruc,razon_social,nombre_comercial,direccion,ubigeo,departamento,provincia,distrito,pais,usuario_secundario,clave_usuario_secundario,certificado_digital) VALUES (:tipodoc,:ruc,:razon_social,:nombre_comercial,:direccion,:ubigeo,:departamento,:provincia,:distrito,:pais,:usuario_secundario,:clave_usuario_secundario,:certificado_digital)"); 
        $stmt->bindParam(":tipo",$datos["tipodoc"],PDO::PARAM_STR);
        $stmt->bindParam(":ruc",$datos["ruc"],PDO::PARAM_STR);
        $stmt->bindParam(":razon_social",$datos["razon_social"],PDO::PARAM_STR);
        $stmt->bindParam(":nombre_comercial",$datos["nombre_comercial"],PDO::PARAM_STR);

        $stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
        $stmt->bindParam(":ubigeo",$datos["ubigeo"],PDO::PARAM_STR);
        $stmt->bindParam(":departamento",$datos["departamento"],PDO::PARAM_STR);
        $stmt->bindParam(":provincia",$datos["provincia"],PDO::PARAM_STR);

        $stmt->bindParam(":distrito",$datos["distrito"],PDO::PARAM_STR);
        $stmt->bindParam(":pais",$datos["pais"],PDO::PARAM_STR);
        $stmt->bindParam(":usuario_secundario",$datos["usuario_secundario"],PDO::PARAM_STR);
        $stmt->bindParam(":clave_usuario_secundario",$datos["clave_usuario_secundario"],PDO::PARAM_STR);

        $stmt->bindParam(":certificado_digital",$datos["certificado_digital"],PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            return "error";
        }


    }


}