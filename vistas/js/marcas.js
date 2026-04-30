/*====Editar Categoria====*/

$(".tablas").on("click", ".btnEditarMarca", function(){

    var idMarca = $(this).attr("idMarca");
    var datos = new FormData();
    datos.append("idMarca",idMarca);
    $.ajax({
        url:"ajax/marcas.ajax.php",
        method : "POST",
        data : datos,
        cache : false,
        contentType : false,
        processData: false,
        dataType : "json",
        success : function(respuesta){
            
            $("#editarMarca").val(respuesta["marca"]);
            $("#idMarca").val(respuesta["id"]);
            
                    
           
        }
    });


})

/*====Eliminar Categoria====*/
$(".btnEliminarMarca").click(function(){

    var idMarca = $(this).attr("idMarca");
    swal({
        title: '¿Está seguro de borrar la Marca?',
        text : "¡Si no lo esta puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar Marca'
    }).then((result)=>{

       if(result.value){
            window.location = "index.php?ruta=marcas&idMarca="+idMarca;       }
    })


})

