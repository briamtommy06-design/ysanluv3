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

$(function () {

	var filaEditando = null;

var tablaProductos = $('.tablaProductos').DataTable({
    ajax: {
        url: "ajax/datatable-productos.ajax.php",
        dataSrc: "data"
    },
    columns: [
        { data: 0,  defaultContent: "" }, // #
        { data: 1,  defaultContent: "" }, // Imagen
        { data: 2,  defaultContent: "" }, // Código
        { data: 3,  defaultContent: "" }, // Descripción
        { data: 4,  defaultContent: "" }, // Categoría
        { data: 5,  defaultContent: "" }, // Categoría padre
        { data: 6,  defaultContent: "" }, // Stock
        { data: 7,  defaultContent: "" }, // Precio compra
        { data: 8,  defaultContent: "" }, // Precio venta
        { data: 9,  defaultContent: "" }, // Agregado
        { data: 10, defaultContent: "" }  // Acciones
    ],
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

//INGRESAR PRODUCTO
// Obtener los elementos input que contienen los números que se multiplicarán
var input1 = document.getElementById("nuevoBultosCompra");
var input2 = document.getElementById("nuevoCantidadCompra");

// Obtener el elemento input donde se mostrará el resultado de la multiplicación
var resultadoInput = document.getElementById("nuevoStock");

// Agregar un evento change a cada input
input1.addEventListener("change", multiplicarInputs);
input2.addEventListener("change", multiplicarInputs);

// Función que se ejecutará cuando cambie alguno de los inputs
function multiplicarInputs() {
  // Obtener los valores de los inputs y multiplicarlos
  var valorInput1 = input1.value;
  var valorInput2 = input2.value;
  var resultado = valorInput1 * valorInput2;

  // Actualizar el valor del input de resultado con el valor de la multiplicación
  resultadoInput.value = resultado;
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


// Abrir modal INGRESO
$(".tablaProductos tbody").on("click", ".btnIngresoStock", function(){

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
  var cajas = Number($("#cajasIngreso").val());
  var upc   = Number($("#unidadesCajaIngreso").val());
  if(cajas > 0 && upc > 0){
    $("#cantidadUnidadesIngreso").val(cajas * upc);
  }
});

// Abrir modal SALIDA
$(".tablaProductos tbody").on("click", ".btnSalidaStock", function(){

  $("#idProductoSalida").val($(this).attr("idProducto"));
  $("#descProductoSalida").val($(this).attr("descripcion") + " (" + $(this).attr("codigo") + ")");
  $("#stockActualSalida").val($(this).attr("stock"));

  $("#cantidadUnidadesSalida").val("");
  $("#motivoSalida").val("MERMA");
  $("#obsSalida").val("");

  $("#modalSalidaStock").modal("show");
});

// ====== INGRESO / SALIDA STOCK (actualiza solo 1 fila) ======
var filaStock = null;

function getRowFromButton($btn){
  var tr = $btn.closest("tr");
  if (tr.hasClass("child")) tr = tr.prev(); // responsive
  return tablaProductos.row(tr);
}

function actualizarFilaSoloStock(nuevoStock){
  if(!filaStock) return;
  var data = filaStock.data();

  data[6] = String(nuevoStock); // col 6 = stock :contentReference[oaicite:7]{index=7}
  data[10] = String(data[10]).replace(/stock=(['"])[^'"]*\1/g, "stock='"+nuevoStock+"'"); // actualiza atributo en botones :contentReference[oaicite:8]{index=8}

  filaStock.data(data).draw(false);
}

$(".tablaProductos tbody").on("click", ".btnIngresoStock", function(){
  filaStock = getRowFromButton($(this));
});

$(".tablaProductos tbody").on("click", ".btnSalidaStock", function(){
  filaStock = getRowFromButton($(this));
});

$(document).on("submit", "#modalIngresoStock form", function(e){
  e.preventDefault();
  var fd = new FormData(this);
  fd.append("accion", "INGRESO");

  $.ajax({
    url: "ajax/movimientos_stock.ajax.php",
    method: "POST",
    data: fd,
    cache:false, contentType:false, processData:false,
    dataType:"json",
    success: function(r){
      if(!r || !r.ok){
        swal({type:"error", title:"Error", text:(r && r.mensaje) ? r.mensaje : "No se pudo registrar"});
        return;
      }
      actualizarFilaSoloStock(r.stock_nuevo);
      $("#modalIngresoStock").modal("hide");
      swal({type:"success", title:"Listo", text:"Ingreso registrado"});
    }
  });
});

$(document).on("submit", "#modalSalidaStock form", function(e){
  e.preventDefault();
  var fd = new FormData(this);
  fd.append("accion", "SALIDA");

  $.ajax({
    url: "ajax/movimientos_stock.ajax.php",
    method: "POST",
    data: fd,
    cache:false, contentType:false, processData:false,
    dataType:"json",
    success: function(r){
      if(!r || !r.ok){
        swal({type:"error", title:"Error", text:(r && r.mensaje) ? r.mensaje : "No se pudo registrar"});
        return;
      }
      actualizarFilaSoloStock(r.stock_nuevo);
      $("#modalSalidaStock").modal("hide");
      swal({type:"success", title:"Listo", text:"Salida registrada"});
    }
  });
});




});