$(".tablas").on("click", ".btnEditarCategoria", function(){

    var idCategoria = $(this).attr("idCategoria");
    var datos = new FormData();
    datos.append("idCategoria", idCategoria);

    $.ajax({
        url: "ajax/categorias.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            console.log(respuesta); // 👈 revisa en la consola qué viene

            $("#editarCategoria").val(respuesta["categoria"]);
            $("#idCategoria").val(respuesta["id"]);

            // 👇 importante: rellenar el combo del padre
            if (respuesta["id_padre"] === null || respuesta["id_padre"] === "0" || respuesta["id_padre"] === 0) {
                $("#editarPadreCategoria").val(""); // opción "Sin categoría padre"
            } else {
                $("#editarPadreCategoria").val(respuesta["id_padre"]);
            }
        }
    });
});


/*====Eliminar Categoria====*/
$(".btnEliminarCategoria").click(function(){
    var idCategoria = $(this).attr("idCategoria");
    swal({
        title: '¿Está seguro de borrar la categoría?',
        text : "¡Si no lo esta puede cancelar la acción!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Si, borrar categoria'
    }).then((result)=>{

        if(result.value){
            window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;       }
    })


})
$("#formEditarCategoria").on("submit", function(e){
    e.preventDefault();

    var idCategoria = $("#idCategoria").val();
    var nombre      = $("#editarCategoria").val();
    var idPadre     = $("#editarPadreCategoria").val();
    var textoPadre  = $("#editarPadreCategoria option:selected").text();

    if(idPadre === "" || idPadre === null){
        textoPadre = "SIN PADRE";
    }

    var datos = new FormData(this);
    datos.append("accion", "actualizarCategoria");

    $.ajax({
        url: "ajax/categorias.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            if(respuesta["resultado"] === "ok"){

                var $btn  = $('.btnEditarCategoria[idCategoria="'+idCategoria+'"]');
                var $fila = $btn.closest("tr");

                $fila.find("td").eq(1).text(nombre.toUpperCase());
                $fila.find("td").eq(2).text(textoPadre.toUpperCase());

                $("#modalEditarCategoria").modal("hide");

                swal({
                    type: "success",
                    title: "Categoría actualizada",
                    showConfirmButton: false,
                    timer: 1200
                });

            }else{
                swal({
                    type: "error",
                    title: "No se pudo actualizar la categoría",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });
            }
        },
        error: function(xhr, status, error){
            console.error("Error AJAX:", status, error);
            console.log("Respuesta:", xhr.responseText);
            swal({
                type: "error",
                title: "Error en el servidor",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            });
        }
    });
});
$(function(){

    // Inicializamos DataTable (si no lo tienes ya en otro JS general)
    var tabla = $(".tablas").DataTable();

    // Filtro por categoría padre
    $("#filtroCategoriaPadre").on("change", function(){

        var valor = $(this).val(); // texto del option seleccionado

        if(valor === ""){
            // Sin filtro → mostrar todas
            tabla.column(2).search("").draw();  // col 2 = "Categoría padre"
        }else{
            // Filtrar por coincidencia exacta (usamos regex ^texto$)
            tabla.column(2).search("^"+valor+"$", true, false).draw();
        }
    });

});
