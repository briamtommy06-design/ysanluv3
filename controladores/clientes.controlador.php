<?php
class ControladorClientes{

    static public function ctrCrearCliente(){
        if(isset($_POST["nuevoCliente"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST['nuevoCliente'])&& 
			preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"]) && 
			preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaDireccion"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["nuevaCiudad"])
            ){
                $tabla="clientes";

                $datos=array("nombre"=>$_POST["nuevoCliente"],
                            "telefono"=>$_POST["nuevoTelefono"],
                            "direccion"=>$_POST["nuevaDireccion"],
                            "ciudad"=>$_POST["nuevaCiudad"]);
                $respuesta = ModeloClientes::mdlIngresarCliente($tabla,$datos);
                if($respuesta=="ok"){
                    
                    echo '<script>
                    swal({
                        type:"success",
                        title:"!El cliente ha sido guardado correctamente ¡",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });

                </script>';
                }
       
            }else{
                echo '<script>
                    swal({
                        type:"error",
                        title:"!El Cliente no puede ir con los campos vacíos o llevar caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });

                </script>';
            }
                
        }

    }

    static public function ctrMostrarClientes($item,$valor){
        $tabla = "clientes";
        $respuesta = ModeloClientes::mdlMostrarClientes($item,$tabla,$valor);
        return $respuesta;

    }

    static public function ctrEditarCliente(){
        
        if(isset($_POST["editarCliente"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarCliente"]) && 
			preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"]) && 
			preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarDireccion"])&&
            preg_match('/^[#\.\-a-zA-Z0-9 ]+$/', $_POST["editarCiudad"])
            ){

                $tabla="clientes";
                 $datos=array("id"=>$_POST["idCliente"],
                "nombre"=>$_POST["editarCliente"],
                "telefono"=>$_POST["editarTelefono"],
                "direccion"=>$_POST["editarDireccion"],
                "ciudad"=>$_POST["editarCiudad"]);
           
                $respuesta=ModeloClientes::mdlEditarCliente($tabla,$datos);     
                
                if($respuesta=="ok"){
                    
                    echo '<script>
                    swal({
                        type:"success",
                        title:"!El cliente ha sido cambiado correctamente ¡",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });

                </script>';
                }
            }else{
                echo '<script>
                    swal({
                        type:"error",
                        title:"!El Cliente no puede ir con los campos vacíos o llevar caracteres especiales",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    }).then((result)=>{
                        if(result.value){
                            window.location="clientes";
                        }
                    });

                </script>';
            }

        }

    }
     /* ==============================
        Eliminar cliente
    ========================== */
    static public function ctrEliminarCliente(){
        if(isset($_GET["idCliente"])){
            $tabla="clientes";
            $datos=$_GET["idCliente"];
            
            $respuesta=ModeloClientes::mdlEliminarCliente($tabla,$datos);
           
            if($respuesta=="ok"){
                echo '<script>
                        swal({
                            type:"success",
                            title:"!El cliente ha sido borrado correctamente ¡",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        }).then((result)=>{
                            if(result.value){
                                window.location="clientes";
                            }
                        });
    
                    </script>'; 
            }
        }
    }


}

/**** PRUEBA */