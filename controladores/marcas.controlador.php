<?php
class ControladorMarcas{
/*CREAR CATEGORIAS*/
    static public function ctrCrearMarca(){
        if(isset($_POST["nuevaMarca"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevaMarca"])){

                $tabla = "marcas";
                $datos = $_POST["nuevaMarca"];
                $respuesta = ModeloMarcas::mdlIngresarMarca($tabla,$datos);
                if($respuesta=="ok"){

                     echo '<script>
                          swal({
                            type:"success",
                               title:"La marca ha sido guardado correctamente",
                               showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                               closeOnConfirm: false
                            }).then((result)=>{
                                if(result.value){
                                    window.location="marcas";
                                }
                            });
        
                    </script>';

                }



            }else{
                echo '<script> 
                swal({
                    type:"error",
                    title:"La marca no puede ir vacia",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result)=>{
                    if(result.value){
                        window.location="marcas";
                    }
                });
                </script>';

            }
        }
    }

    static public function ctrMostrarMarcas($item,$valor){
        $tabla = "marcas";
        $respuesta = ModeloMarcas::mdlMostrarMarca($tabla,$item,$valor);
        return $respuesta;
    }



    static public function ctrEditarMarca(){

        if(isset($_POST["editarMarca"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarMarca"])){

                $tabla = "marcas";
                $datos = array("marca"=>$_POST["editarMarca"],
                                "id"=>$_POST["idMarca"]) ;
                $respuesta = ModeloMarcas::mdlEditarMarca($tabla,$datos);
                if($respuesta=="ok"){
                     echo '<script>
                          swal({
                            type:"success",
                               title:"La categoria ha sido cambiada correctamente",
                               showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                               closeOnConfirm: false
                            }).then((result)=>{
                                if(result.value){
                                    window.location="marcas";
                                }
                            });
        
                    </script>';

                }else{
                echo '<script> 
                swal({
                    type:"error",
                    title:"La categoría no puede ir vacia o lleva caracteres especiales",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result)=>{
                    if(result.value){
                        window.location="marcas";
                    }
                });
                </script>';}

            }
        }


    }

    static public function ctrBorrarMarca(){

        if(isset($_GET["idMarca"])){

            $tabla = "marcas";
            $datos = $_GET["idMarca"];
            $respuesta = ModeloMarcas::mdlBorrarMarca($tabla,$datos);
            if($respuesta=="ok"){
                echo '<script>
                swal({
                  type:"success",
                     title:"La categoria ha sido borrado correctamente",
                     showConfirmButton: true,
                      confirmButtonText: "Cerrar",
                     closeOnConfirm: false
                  }).then((result)=>{
                      if(result.value){
                          window.location="marcas";
                      }
                  });

          </script>';

            }

        }
    }
    
}