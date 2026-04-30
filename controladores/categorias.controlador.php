<?php
class ControladorCategorias{
/*CREAR CATEGORIAS*/
    static public function ctrCrearCategoria(){
        if(isset($_POST["nuevaCategoria"])){
            if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nuevaCategoria"])){

                $tabla = "categorias";

                $datos = array(
                    "categoria" => $_POST["nuevaCategoria"],
                    "id_padre"  => isset($_POST["idPadreCategoria"]) ? $_POST["idPadreCategoria"] : null
                );

                $respuesta = ModeloCategorias::mdlIngresarCategoria($tabla, $datos);

                if($respuesta=="ok"){

                     echo '<script>
                          swal({
                            type:"success",
                               title:"La categoria ha sido guardado correctamente",
                               showConfirmButton: true,
                                confirmButtonText: "Cerrar",
                               closeOnConfirm: false
                            }).then((result)=>{
                                if(result.value){
                                    window.location="categorias";
                                }
                            });
        
                    </script>';

                }



            }else{
                echo '<script> 
                swal({
                    type:"error",
                    title:"La categoría no puede ir vacia",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                }).then((result)=>{
                    if(result.value){
                        window.location="categorias";
                    }
                });
                </script>';

            }
        }
    }

    static public function ctrMostrarCategorias($item,$valor){
        $tabla = "categorias";
        $respuesta = ModeloCategorias::mdlMostrarCategorias($tabla,$item,$valor);
        return $respuesta;
    }



static public function ctrEditarCategoria(){

    if(isset($_POST["editarCategoria"])){

        $tabla = "categorias";

        $datos = array(
            "categoria" => $_POST["editarCategoria"],
            "id"        => $_POST["idCategoria"],
            "id_padre"  => isset($_POST["editarPadreCategoria"]) ? $_POST["editarPadreCategoria"] : null
        );

        $respuesta = ModeloCategorias::mdlEditarCategoria($tabla, $datos);

        if($respuesta == "ok"){
            echo'<script>
                swal({
                    type: "success",
                    title: "La categoría ha sido editada correctamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if (result.value) {
                        window.location = "categorias";
                    }
                })
            </script>';
        }
    }
}


    static public function ctrBorrarCategoria(){

        if(isset($_GET["idCategoria"])){

            $tabla = "categorias";
            $datos = $_GET["idCategoria"];
            $respuesta = ModeloCategorias::mdlBorrarCategoria($tabla,$datos);
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
                          window.location="categorias";
                      }
                  });

          </script>';

            }

        }
    }
    
}