/*CARGAR TABLA DINAMICA DE PRODUCTOS*/
// $('.tablaProductos').DataTable({
//     ajax: 'ajax/datatable-productos-test.ajax.php'
// });


// $('.tablaProductos').DataTable({
//     "ajax": "ajax/datatable-productos.ajax.php",
//     "deferRender":true,
//     "retrieve":true,
//     "processing": true,
//     "language": {

// 		"sProcessing":     "Procesando...",
// 		"sLengthMenu":     "Mostrar _MENU_ registros",
// 		"sZeroRecords":    "No se encontraron resultados",
// 		"sEmptyTable":     "Ningún dato disponible en esta tabla",
// 		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
// 		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
// 		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
// 		"sInfoPostFix":    "",
// 		"sSearch":         "Buscar:",
// 		"sUrl":            "",
// 		"sInfoThousands":  ",",
// 		"sLoadingRecords": "Cargando...",
// 		"oPaginate": {
// 		"sFirst":    "Primero",
// 		"sLast":     "Último",
// 		"sNext":     "Siguiente",
// 		"sPrevious": "Anterior"
// 		},
// 		"oAria": {
// 			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
// 			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
// 		}

// 	}
// } );
var tablaProductos;
var filaStockActual = null;

$(function () {

	var filaEditando = null;

tablaProductos = $('.tablaProductos').DataTable({

    ajax: {
        url: "ajax/datatable-productos.ajax.php",
        dataSrc: "data"
    },
    columns: [
    { data: 0,  defaultContent: "" }, // #
    { data: 1,  defaultContent: "" }, // Imagen
    { data: 2,  defaultContent: "" }, // Código
    { data: 3,  defaultContent: "" }, // Descripción
    { data: 4,  defaultContent: "" }, // Marca   <-- NUEVO
    { data: 5,  defaultContent: "" }, // Categoría
    { data: 6,  defaultContent: "" }, // Categoría padre
    { data: 7,  defaultContent: "" }, // Stock
    { data: 8,  defaultContent: "" }, // Precio compra
    { data: 9,  defaultContent: "" }, // Precio venta
    { data: 10, defaultContent: "" }, // Agregado
    { data: 11, defaultContent: "" }  // Acciones
    ],

    columnDefs: [
    { targets: [8], visible: false, searchable: false } // 8 = Precio compra
    ],

    
stateSave: true,
    deferRender: true,
    retrieve: true,
    processing: true,
    language: {
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});
// 🔥 limpiar estado guardado y filtros al entrar al módulo
tablaProductos.state.clear();
tablaProductos.search("").columns().search("").draw();

$("#filtroMarcaProductos").val("");
$("#filtroCategoriaPadreProductos").val("");
$("#filtroCategoriaHijaProductos").val("").prop("disabled", true);

// // Filtro por categoría padre (columna 5)
// $("#filtroCategoriaPadreProductos").on("change", function(){

//     var valor = $(this).val();

//     if(valor === ""){
//         tablaProductos.column(5).search("").draw();
//     }else{
//         // coincidencia exacta
//         tablaProductos.column(5).search("^"+valor+"$", true, false).draw();
//     }
// });
$("#filtroCategoriaPadreProductos").on("change", function(){

    var valor = $(this).val(); // el texto de la categoría padre en el <select>

    if(valor === ""){
        // Quitar filtro
        tablaProductos.column(5).search("").draw();
    }else{
        // Buscar por ese texto (no hace falta regex)
        tablaProductos.column(5).search(valor).draw();
    }
});

$(document).on("click", "#btnLimpiarFiltrosProductos", function(){

  $("#filtroMarcaProductos").val("");
  $("#filtroCategoriaPadreProductos").val("");
  $("#filtroCategoriaHijaProductos").val("").prop("disabled", true);

  $("#filtroCategoriaHijaProductos option").hide();
  $("#filtroCategoriaHijaProductos option:first").show();

  tablaProductos.column(4).search(""); // Marca
  tablaProductos.column(5).search(""); // Categoría hija
  tablaProductos.column(6).search(""); // Categoría padre
  tablaProductos.draw();
});

/* =======================================
capturando categoria para asignar código 
========================================*/
$("#nuevaCategoria").change(function(){
var idCategoria=$(this).val();

var datos=new FormData();
datos.append("idCategoria",idCategoria);

$.ajax({
    url:"ajax/productos.ajax.php",
    method: "POST",
    data:datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

        if(!respuesta){
            var nuevoCodigo=idCategoria+"01";
            $("#nuevoCodigo").val(nuevoCodigo);
        }else{
            var nuevoCodigo=Number(respuesta['codigo'])+1;
            $("#nuevoCodigo").val(nuevoCodigo);
        }
        
    
    }
})
});	
/* =======================================
Agregando precio de venta 
========================================*/
$("#nuevoPrecioCompra, #editarPrecioCompra").change(function(){

if($(".porcentaje").prop("checked")){
    
    var valorPorcentaje=$(".nuevoPorcentaje").val();
    
    var porcentaje=Number($("#nuevoPrecioCompra").val()*(valorPorcentaje/100))+ Number($("#nuevoPrecioCompra").val());
    var editarPorcentaje=Number($("#editarPrecioCompra").val()*(valorPorcentaje/100))+ Number($("#editarPrecioCompra").val());

    $("#nuevoPrecioVenta").val(porcentaje);
    $("#nuevoPrecioVenta").prop("readonly",true);	
    
    $("#editarPrecioVenta").val(editarPorcentaje);
    $("#editarPrecioVenta").prop("readonly",true);	
}



})


// $("#nuevoBultosCompra").change(function(){

// 	var cantidad = Number($("#nuevoCantidadCompra").val());

// 	// var cant = $(this).parent().parent().children(".cantcompra").children(".nuevocantcompra");
// 	// if(cantidad === ""){
// 	// 	// Aquí puedes agregar cualquier acción que necesites en caso de que "cantidad" sea una cadena vacía
// 	// }else{
// 	// 	var stock =  cantidad * $(this).val();
// 	// 	$("#nuevoStock").val(stock);

// 	// }
// 	console.log("la cantidad de productos es :",cantidad)
	
// })

//INGRESAR PRODUCTO (stock = bultos * cantidad por bulto)
//INGRESAR PRODUCTO
var input1 = document.getElementById("nuevoBultosCompra");
var input2 = document.getElementById("nuevoCantidadCompra");
var resultadoInput = document.getElementById("nuevoStock");

function multiplicarInputs() {
  if(!input1 || !input2 || !resultadoInput) return;

  var valorInput1 = parseFloat(input1.value) || 0;
  var valorInput2 = parseFloat(input2.value) || 0;
  resultadoInput.value = valorInput1 * valorInput2;
}

// ✅ solo engancha eventos si existen los inputs
if(input1 && input2){
  input1.addEventListener("input", multiplicarInputs);
  input2.addEventListener("input", multiplicarInputs);
  input1.addEventListener("change", multiplicarInputs);
  input2.addEventListener("change", multiplicarInputs);
}


//EDITAR PRODUCTO

// Obtener los elementos input que contienen los números que se multiplicarán
var input3 = document.getElementById("editarBultosCompra");
var input4 = document.getElementById("editarCantidadCompra");

// Obtener el elemento input donde se mostrará el resultado de la multiplicación
var resultadoInputEditar = document.getElementById("editarStockInicial");

// Agregar un evento change a cada input
input3.addEventListener("change", multiplicarInputsEditar);
input4.addEventListener("change", multiplicarInputsEditar);

// Función que se ejecutará cuando cambie alguno de los inputs
function multiplicarInputsEditar() {
  // Obtener los valores de los inputs y multiplicarlos
  var valorInput1 = input3.value;
  var valorInput2 = input4.value;
  var resultado = valorInput1 * valorInput2;

  // Actualizar el valor del input de resultado con el valor de la multiplicación
  resultadoInputEditar.value = resultado;
}



// var cantidad_bulto = document.getElementById("editarCantidadCompra");
// var nuevoBulto = document.getElementById("nuevoBultosAumento");

// var resultadoStockActual = document.getElementById("editarStock");
// var resultadoStockInicial = document.getElementById("editarStockInicial");
// var resultadoBultos = document.getElementById("editarBultosCompra");

// nuevoBulto.addEventListener("change",modificarInput);

// function modificarInput(){

// 	console.log("MODIFICAR INPUT NAUMENTO");

// 	var cantBulto = parseInt(cantidad_bulto.value);
// 	var nueBulto = parseInt(nuevoBulto.value);

// 	var stockActual = parseInt(resultadoStockActual.value);

// 	var bultosActual = parseInt(resultadoBultos.value);


// 	var resultado = cantBulto * nueBulto;

// 	// resultadoStockActual.value = resultado + resultadoStockActual.value;

// 	// resultadoBultos.value = nuevoBulto + resultadoBultos.value;


// 	resultadoStockActual.value = stockActual + (nueBulto * cantBulto);



// }


/* =======================================
Cambio de porcentaje
========================================*/
$(".nuevoPorcentaje").change(function(){
if($(".porcentaje").prop("checked")){
    
    var valorPorcentaje=$(this).val();
    
    var porcentaje=Number($("#nuevoPrecioCompra").val()*(valorPorcentaje/100))+ Number($("#nuevoPrecioCompra").val());

    var editarPorcentaje=Number($("#editarPrecioCompra").val()*(valorPorcentaje/100))+ Number($("#editarPrecioCompra").val());

    $("#nuevoPrecioVenta").val(porcentaje);
    $("#nuevoPrecioVenta").prop("readonly",true);	

    $("#editarPrecioVenta").val(editarPorcentaje);
    $("#editarPrecioVenta").prop("readonly",true);	
}
});

$(".porcentaje").on("ifUnchecked",function(){

$("#nuevoPrecioVenta").prop("readonly",false);
$("#editarPrecioVenta").prop("readonly",false);
})
$(".porcentaje").on("ifChecked",function(){

$("#nuevoPrecioVenta").prop("readonly",true);
$("#editarPrecioVenta").prop("readonly",true);
})

/* ================================================
    Subiendo la foto del producto
================================================*/
$(".nuevaImagen").change(function(){

    var imagen=this.files[0];
    console.log("imagen",imagen);
/* ================================================
    Validamos el formato de la imagen sea PNG o JPEG
================================================*/
if(imagen["type"]!="image/jpeg"&&imagen["type"]!="image/png"){
    $(".nuevaImagen").val("");

    swal({
        title:"!Error al subir la imagen ¡",
        text: "¡La imagen debe estar en formato JPG/PNG! ",
        type: "error",
        confirmButtonText: "¡Cerrar!"
    });
}else if(imagen["size"]>2000000){
    $(".nuevaImagen").val("");
    swal({
        title:"!Error al subir la imagen ¡",
        text: "¡La imagen no debe pesar mas de 2MB! ",
        type: "error",
        confirmButtonText: "¡Cerrar!"
    });
}else{
    var datosImagen=new FileReader;
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load",function(event){

        var rutaImagen=event.target.result;

        $(".previsualizar").attr("src",rutaImagen);

    });
}
});

// ...existing code...
// Agregar: previsualizar y validar imagen del modal "Editar"
$(".editarImagen").change(function(){

    var imagen = this.files[0];
    if(!imagen) return;

    /* Validar formato */
    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
        $(".editarImagen").val("");
        swal({
            title:"!Error al subir la imagen ¡",
            text: "¡La imagen debe estar en formato JPG/PNG! ",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
        return;
    }

    /* Validar tamaño (2MB) */
    if(imagen["size"] > 2000000){
        $(".editarImagen").val("");
        swal({
            title:"!Error al subir la imagen ¡",
            text: "¡La imagen no debe pesar mas de 2MB! ",
            type: "error",
            confirmButtonText: "¡Cerrar!"
        });
        return;
    }

    /* Previsualizar */
    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function(event){
        var rutaImagen = event.target.result;
        $(".previsualizarEditar").attr("src", rutaImagen);
    });

});

$(".tablaProductos tbody").on("click","button.btnAumentarProducto",function(){

	// var idProducto=$(this).attr("idProducto");
	// console.log("idproducto",idProducto);

	// var datos=new FormData();

	// datos.append("idProducto",idProducto);

	// $.ajax({
	// 	url: "ajax/productos.ajax.php",
	// 	method: "POST",
	// 	data: datos,
	// 	cache: false,
	// 	contentType: false,
	// 	processData: false,
	// 	dataType: "json",
	// 	success: function(respuesta){
			
	// 		var datosCategoria=new FormData();
	// 		datosCategoria.append("idCategoria",respuesta["id_categoria"]);
		
	// 		var datosMarca=new FormData();
	// 		datosMarca.append("idMarca",respuesta["id_marca"]);

	// 		$.ajax({
	// 			url: "ajax/categorias.ajax.php",
	// 			method: "POST",
	// 			data: datosCategoria,
	// 			cache: false,
	// 			contentType: false,
	// 			processData: false,
	// 			dataType: "json",
	// 			success: function(respuesta){
	// 				console.log("categoria:",respuesta["categoria"]);
	// 				$("#editarCategoria").val(respuesta["id"]);
	// 				$("#editarCategoria").html(respuesta["categoria"]);}
	// 		});
	// 		$.ajax({
	// 			url: "ajax/marcas.ajax.php",
	// 			method: "POST",
	// 			data: datosMarca,
	// 			cache: false,
	// 			contentType: false,
	// 			processData: false,
	// 			dataType: "json",
	// 			success: function(respuesta){
	// 				console.log("marca:",respuesta["marca"]);
	// 				$("#editarMarca").val(respuesta["id"]);
	// 				$("#editarMarca").html(respuesta["marca"]);
	// 			}
	// 		})	


	// 		$("#editarCodigo").val(respuesta["codigo"]);
	// 		$("#editarDescripcion").val(respuesta["descripcion"]);
	// 		$("#editarStock").val(respuesta["stock"]);
	// 		$("#editarPrecioCompra").val(respuesta["precio_compra"]);
	// 		$("#editarPrecioVenta").val(respuesta["precio_venta"]);
	// 		$("#editarBultosCompra").val(respuesta["bultos"]);
	// 		$("#editarCantidadCompra").val(respuesta["cantidad_bulto"]);
	// 		$("#editarStockInicial").val(respuesta["stock_inicial"]);
	// 		$("#editarObservacion").val(respuesta["observacion"]);
			

	// 		// if(respuesta["imagen"]!=""){
	// 		// 	$("#imagenActual").val(respuesta["imagen"]);

	// 		// 	$(".previsualizar").attr("src",respuesta["imagen"])
	// 		// }
	// 	}	
	// })


})



/* ===============================
	Editar producto 
=============================*/

$(".tablaProductos tbody").on("click","button.btnEditarProducto",function(){

    var idProducto = $(this).attr("idProducto");
    console.log("idproducto", idProducto);


    // $("#editarImagen").val("");        // si usas id

    $(".editarImagen").val("");
    // 👉 Guardamos la fila de DataTables que estamos editando
    filaEditando = tablaProductos.row( $(this).closest('tr') );

    var datos = new FormData();
    datos.append("idProducto", idProducto);

    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            // rellenar categoría, marca, etc (dejas tu código igual)
            var datosCategoria=new FormData();
            datosCategoria.append("idCategoria",respuesta["id_categoria"]);
        
            var datosMarca=new FormData();
            datosMarca.append("idMarca",respuesta["id_marca"]);

            $.ajax({
                url: "ajax/categorias.ajax.php",
                method: "POST",
                data: datosCategoria,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    $("#editarCategoria").val(respuesta["id"]);
                    $("#editarCategoria").html(respuesta["categoria"]);
                }
            });

            $.ajax({
                url: "ajax/marcas.ajax.php",
                method: "POST",
                data: datosMarca,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    $("#editarMarca").val(respuesta["id"]);
                    $("#editarMarca").html(respuesta["marca"]);
                }
            });

            // 👉 Guardamos el id en el hidden
            $("#idProductoEditar").val(idProducto);

            // rellenar inputs del modal (igual que ya lo tenías)
            $("#editarCodigo").val(respuesta["codigo"]);
            $("#editarDescripcion").val(respuesta["descripcion"]);
            $("#editarStock").val(respuesta["stock"]);
            $("#editarPrecioCompra").val(respuesta["precio_compra"]);
            $("#editarPrecioVenta").val(respuesta["precio_venta"]);
            $("#editarBultosCompra").val(respuesta["bultos"]);
            $("#editarCantidadCompra").val(respuesta["cantidad_bulto"]);
            $("#editarStockInicial").val(respuesta["stock_inicial"]);
            $("#editarObservacion").val(respuesta["observacion"]);

            // Imagen actual
            if (respuesta["imagen"] && respuesta["imagen"] !== "") {
                $("#imagenActual").val(respuesta["imagen"]);
                $(".previsualizarEditar").attr("src", respuesta["imagen"]);
            } else {
                var imgDefault = "vistas/img/productos/default/anonymous.png";
                $("#imagenActual").val(imgDefault);
                $(".previsualizarEditar").attr("src", imgDefault);
            }
        }
    });
});

/* ===============================
	Eliminar producto 
=============================*/
$(".tablaProductos tbody").on("click","button.btnEliminarProducto",function(){
    var idProducto=$(this).attr("idProducto");
    var codigo=$(this).attr("codigo");
    var imagen=$(this).attr("imagen");
    
    swal({
        title:"¿Está seguro de borrar el producto?",
        text: "¡Si no lo está puede cancelar la acción! ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: "¡Si, borrar producto!"
    }).then((result)=>{
        if(result.value){
            window.location="index.php?ruta=productos&idProducto="+idProducto+"&imagen="+imagen+"&codigo="+codigo;
        }
    })
})

$(".tablaProductos tbody").on("click", ".imgTablaProducto", function(){

    var src = $(this).data("imagen-grande") || $(this).attr("src");

    $("#imagenProductoGrande").attr("src", src);

    $("#descargarImagenProducto")
        .attr("href", src)
        .attr("download", src.split('/').pop());

    $("#modalImagenProducto").modal("show");
});

/* =======================================
   Enviar formulario EDITAR por AJAX
=======================================*/
$("#formEditarProducto").on("submit", function(e){
    e.preventDefault(); // 👈 evita que recargue la página

    var form = this;
    var datos = new FormData(form);
    if (filaEditando) {
    datos.append("dt_index", filaEditando.data()[0]); // la columna 0 es el "#"
    }
    $.ajax({
        url: "ajax/producto-editar.ajax.php", // este PHP hará la actualización
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            if(respuesta.ok){

                if (filaEditando) {
                    // respuesta.row = array con las 11 columnas de la fila
                    filaEditando.data(respuesta.row).draw(false);
                }

                $("#modalEditarProducto").modal("hide");

                swal({
                    type: "success",
                    title: "¡Producto actualizado correctamente!",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });

            } else {

                swal({
                    type: "error",
                    title: "Error al editar",
                    text: respuesta.mensaje || "Intente nuevamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                });

            }
        },
        error: function(){
            swal({
                type: "error",
                title: "Error en el servidor",
                text: "No se pudo editar el producto",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
            });
        }
    });
});

function validarCodigoProducto($input, esEdicion) {

    var codigo = $input.val().trim();

    // Si está vacío, no validamos
    if (codigo === "") {
        $input.closest(".form-group").removeClass("has-error");
        return;
    }

    var datos = new FormData();
    datos.append("codigoValidar", codigo);

    if (esEdicion) {
        datos.append("idProductoActual", $("#idProductoEditar").val());
    }

    $.ajax({
        url: "ajax/productos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta){

            if (respuesta.repetido) {

                $input.closest(".form-group").addClass("has-error");

                swal({
                    type: "error",
                    title: "Código repetido",
                    text: "Ya existe un producto con el código " + codigo,
                    confirmButtonText: "Cerrar"
                });

                // Vaciar y enfocar para obligar a cambiar
                $input.val("").focus();

            } else {
                $input.closest(".form-group").removeClass("has-error");
            }
        }
    });
}
// Validación en vivo al CREAR producto
$(document).on("change", "#nuevoCodigo", function(){
    validarCodigoProducto($(this), false);
});

// Validación en vivo al EDITAR producto (si algún día lo dejas editable)
$(document).on("change", "#editarCodigo", function(){
    validarCodigoProducto($(this), true);
});


// ===== Ingreso stock: autocalcular unidades =====
var ingresoCantidadManual = false;

function recalcularCantidadIngreso() {
  var cajas = Number($("#cajasIngreso").val());
  var upc   = Number($("#unidadesCajaIngreso").val());
  if (cajas > 0 && upc > 0) {
    $("#cantidadUnidadesIngreso").val(cajas * upc);
    return true;
  }
  return false;
}

// Si el usuario escribe manualmente en cantidad, dejamos de autocalcular (hasta que lo borre)
$(document).on("input", "#cantidadUnidadesIngreso", function(){
  ingresoCantidadManual = $(this).val().trim() !== "";
});

function setFilaActual(btn){
  var tr = $(btn).closest("tr");
  if(tr.hasClass("child")) tr = tr.prev(); // DataTables responsive
  filaStockActual = tr; // <- aquí guardas la fila que luego actualizarás
}


// Abrir modal INGRESO
$(".tablaProductos tbody").on("click", ".btnIngresoStock", function(){

  setFilaActual(this);
  ingresoCantidadManual = false;
  $("#idProductoIngreso").val($(this).attr("idProducto"));
  $("#descProductoIngreso").val($(this).attr("descripcion") + " (" + $(this).attr("codigo") + ")");
  $("#stockActualIngreso").val($(this).attr("stock"));

  $("#cajasIngreso").val("");
  $("#unidadesCajaIngreso").val("");
  $("#cantidadUnidadesIngreso").val("");
  $("#costoDocenaIngreso").val("");
  $("#obsIngreso").val("");

  $("#modalIngresoStock").modal("show");
});

// Autocalcular unidades = cajas * unidades_por_caja
$(document).on("input", "#cajasIngreso, #unidadesCajaIngreso", function(){
  if (ingresoCantidadManual) return;
  recalcularCantidadIngreso();
});

// Si todavía NO hay cajas/upc válidos y el usuario no escribió manual, limpia cantidad
$(document).on("change", "#cajasIngreso, #unidadesCajaIngreso", function(){
  if (ingresoCantidadManual) return;

  var cajas = Number($("#cajasIngreso").val());
  var upc   = Number($("#unidadesCajaIngreso").val());

  if (!(cajas > 0 && upc > 0)) {
    $("#cantidadUnidadesIngreso").val("");
  }
});

// Abrir modal SALIDA
$(".tablaProductos tbody").on("click", ".btnSalidaStock", function(){
  setFilaActual(this);
  $("#idProductoSalida").val($(this).attr("idProducto"));
  $("#descProductoSalida").val($(this).attr("descripcion") + " (" + $(this).attr("codigo") + ")");
  $("#stockActualSalida").val($(this).attr("stock"));

  $("#cantidadUnidadesSalida").val("");
  $("#motivoSalida").val("MERMA");
  $("#obsSalida").val("");

  $("#modalSalidaStock").modal("show");
});

// ENVIAR INGRESO (sin recargar)
$(document).on("submit", "#formIngresoStock", function(e){
  e.preventDefault();

  var fd = new FormData(this);
  fd.append("tipo", "INGRESO");

  $.ajax({
    url: "ajax/movimientos_stock.ajax.php",
    method: "POST",
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(r){

      if(!r.ok){
        swal({ type:"error", title:"No se pudo registrar", text: r.mensaje || "Error" });
        return;
      }

      // actualizar solo la fila
      if(filaStockActual){
        var row = tablaProductos.row(filaStockActual);
        var data = row.data();
        data[7] = String(r.stock_nuevo);  // col Stock :contentReference[oaicite:10]{index=10}
        row.data(data).draw(false);

        $(row.node()).find(".btnIngresoStock, .btnSalidaStock").attr("stock", r.stock_nuevo);
      }

      $("#modalIngresoStock").modal("hide");
      $("#formIngresoStock")[0].reset();

      swal({ type:"success", title:"Ingreso registrado", text:"Stock actualizado a " + r.stock_nuevo, timer: 900, showConfirmButton:false });
    },
    error: function(){
      swal({ type:"error", title:"Error servidor", text:"No se pudo registrar el ingreso" });
    }
  });
});

// ENVIAR SALIDA (sin recargar)
$(document).on("submit", "#formSalidaStock", function(e){
  e.preventDefault();

  var fd = new FormData(this);
  fd.append("tipo", "SALIDA");

  $.ajax({
    url: "ajax/movimientos_stock.ajax.php",
    method: "POST",
    data: fd,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(r){

      if(!r.ok){
        swal({ type:"error", title:"No se pudo registrar", text: r.mensaje || "Error" });
        return;
      }

      if(filaStockActual){
        var row = tablaProductos.row(filaStockActual);
        var data = row.data();

        // 6 = columna Stock en tu datatable 
        data[7] = String(r.stock_nuevo);

        // 10 = columna Acciones: ahí está el HTML de los botones (+/-) con stock='...' 
        data[11] = String(data[11]).replace(/stock='-?\d+'/g, "stock='"+r.stock_nuevo+"'");

        // redibuja SOLO esa fila
        row.data(data).draw(false);


        $(row.node()).find(".btnIngresoStock, .btnSalidaStock").attr("stock", r.stock_nuevo);
      }

      $("#modalSalidaStock").modal("hide");
      $("#formSalidaStock")[0].reset();

      swal({ type:"success", title:"Salida registrada", text:"Stock actualizado a " + r.stock_nuevo, timer: 900, showConfirmButton:false });
    },
    error: function(){
      swal({ type:"error", title:"Error servidor", text:"No se pudo registrar la salida" });
    }
  });
});
var tablaKardexProducto = null;

$(".tablaProductos tbody").on("click", ".btnKardexStock", function(){

  var idProducto = $(this).attr("idProducto");
  var codigo = $(this).attr("codigo");
  var desc = $(this).attr("descripcion");

  $("#kardexTitulo").text(desc + " (" + codigo + ")");
  $("#modalKardexProducto").modal("show");

  // destruir si ya existía (para reabrir otro producto)
  if(tablaKardexProducto){
    tablaKardexProducto.destroy();
    $("#tablaKardexProducto tbody").empty();
  }

  tablaKardexProducto = $("#tablaKardexProducto").DataTable({
    ajax: "ajax/datatable-movimientos-stock.ajax.php?idProducto=" + idProducto,
    deferRender: true,
    retrieve: true,
    processing: true,
    order: [[1, "desc"]],
      // ✅ Botones
    dom: "<'row'<'col-sm-6'l><'col-sm-6 text-right'Bf>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    buttons: [
      {
        extend: "excelHtml5",
        text: '<i class="fa fa-file-excel-o"></i> Excel',
        className: "btn btn-success btn-sm",
        title: null,
        filename: function () {
          var t = ($("#kardexTitulo").text() || "kardex")
            .trim()
            .replace(/\s+/g, "_");
          return "movimientos_" + t;
        },
        exportOptions: {
          columns: ":visible",
          modifier: { search: "applied", order: "applied", page: "all" }
        }
      }
    ],

    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible",
      sInfo: "Mostrando _START_ a _END_ de _TOTAL_",
      sInfoEmpty: "Mostrando 0 a 0 de 0",
      sInfoFiltered: "(filtrado de _MAX_ registros)",
      sSearch: "Buscar:",
      oPaginate: { sFirst:"Primero", sLast:"Último", sNext:"Siguiente", sPrevious:"Anterior" }
    }
  });

});

// opcional: limpiar al cerrar
$("#modalKardexProducto").on("hidden.bs.modal", function(){
  if(tablaKardexProducto){
    tablaKardexProducto.destroy();
    tablaKardexProducto = null;
    $("#tablaKardexProducto tbody").empty();
  }
});


function filtrarSubcategorias(padreId) {

  var $hija = $("#nuevaCategoria");

  // Reset visual
  $hija.val("");
  $hija.find("option").hide();
  $hija.find("option:first").show(); // "Seleccionar subcategoría"

  if(!padreId){
    $hija.prop("disabled", true);
    return;
  }

  $hija.prop("disabled", false);
  $hija.find('option[data-padre="' + padreId + '"]').show();

  // Autoseleccionar la primera hija (y dispara tu lógica de código)
  var $first = $hija.find('option[data-padre="' + padreId + '"]:first');
  if($first.length){
    $hija.val($first.val()).trigger("change");
  }
}

$(document).on("change", "#nuevaCategoriaPadre", function(){
  filtrarSubcategorias($(this).val());
});


function actualizarBotonCosto() {
  var visible = tablaProductos.column(8).visible(); // 8 = Precio compra
  $("#btnToggleCostoCompra").html(
    visible
      ? '<i class="fa fa-eye-slash"></i> Ocultar costo compra'
      : '<i class="fa fa-eye"></i> Mostrar costo compra'
  );
}


$(document).on("click", "#btnToggleCostoCompra", function(){
  var col = tablaProductos.column(8);
  col.visible(!col.visible(), false); // false = no recalcular todo
  tablaProductos.columns.adjust().draw(false);
  actualizarBotonCosto();
});

// al cargar
tablaProductos.on('init', function(){
  // Asegura que al iniciar quede oculto (incluso si stateSave trae otra cosa)
  tablaProductos.column(8).visible(false);
  actualizarBotonCosto();
});
function dtExact(colIdx, value){
  if(value === ""){
    tablaProductos.column(colIdx).search("").draw();
    return;
  }
  var v = $.fn.dataTable.util.escapeRegex(value);
  tablaProductos.column(colIdx).search("^"+v+"$", true, false).draw();
}

function filtrarOpcionesHijas(padreId){
  var $h = $("#filtroCategoriaHijaProductos");

  $h.val("");
  $h.find("option").hide();
  $h.find("option:first").show(); // "Todas"

  if(!padreId){
    $h.prop("disabled", true);
    return;
  }

  $h.prop("disabled", false);
  $h.find('option[data-padre="'+padreId+'"]').show();
}

// Padre
$(document).on("change", "#filtroCategoriaPadreProductos", function(){
  var padreTexto = $(this).val(); // coincide con texto en columna 6
  var padreId = $(this).find(":selected").data("id") || "";

  dtExact(6, padreTexto);     // columna Cat Padre
  dtExact(5, "");             // limpia subcategoría
  filtrarOpcionesHijas(padreId);
});

// Subcategoría
$(document).on("change", "#filtroCategoriaHijaProductos", function(){
  dtExact(5, $(this).val());  // columna Categoría (hija)
});

// Marca
$(document).on("change", "#filtroMarcaProductos", function(){
  dtExact(4, $(this).val());  // columna Marca
});


});