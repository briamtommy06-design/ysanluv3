<?php

class ControladorEmisor{

    static public function ctrCrearEmisor(){

        if(isset($_POST["nuevoEmisor"])){ //nuevo emisor = RUC
            //PREDEFINIDO TIPO DE DOCUMENTO = 6
            if(preg_match('/^[#\.\-a-zA-Z0-9 ]+$/',$_POST['nuevoRuc'])&& //nuevo emisor = RUC
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoRazon_social"]) && 
			preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoNombre_comercial"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoDireccion"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoUbigeo"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoDepartamento"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoProvincia"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoDistrito"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoPais"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoUsuario_secundario"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevoClave_usuario_secundario"])
            ){

                 /*=============================================
				VALIDAR CERTIFICADO
				=============================================*/

			   	$ruta = "vistas/img/productos/default/anonymous.png";
                   

			   	if(isset($_FILES["editarCertificado"]["tmp_name"]) && !empty($_FILES["editarCertificado"]["tmp_name"])){

					
					/*=============================================
					CREAMOS EL DIRECTORIO DONDE VAMOS A GUARDAR LA FOTO DEL USUARIO
					=============================================*/

					$directorio = "vistas/certificado/".$_POST["nuevoRuc"];

					mkdir($directorio, 0755);

					

					if($_FILES["nuevaImagen"]["type"] == "image/png"){

						/*=============================================
						GUARDAMOS LA IMAGEN EN EL DIRECTORIO
						=============================================*/

					

					}

           
				}

                /* PASO 2 */


                $tabla = "emisor";
                $tipodoc = 6;
                $datos=array("tipodoc"=> $tipodoc,
                            "ruc" => $_POST['nuevoRuc'],
                            "razon_social" => $_POST['nuevoRazon_social'],
                            "nombre_comercial" => $_POST["nuevoNombre_comercial"],
                            "direccion" => $_POST["nuevoDireccion"],
                            "ubigeo" => $_POST["nuevoUbigeo"],
                            "departamento" => $_POST["nuevoDepartamento"],
                            "provincia" => $_POST["nuevoProvincia"],
                            "distrito" => $_POST["nuevoDistrito"],
                            "pais" => $_POST["nuevoPais"],
                            "usuario_secundario" => $_POST["nuevoUsuario_secundario"],
                            "clave_usuario_secundario" => $_POST["nuevoClave_usuario_secundario"],
                            "certificado_digital" => $_POST["nuevoCertificado_digital"]
                            );
                
              

            }

        }

    }


}