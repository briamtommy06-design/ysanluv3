/*CARGAR TABLA DINAMICA DE PRODUCTOS
$.ajax({

    url: "ajax/datatable-ventas.ajax.php",
    success:function(respuesta){

        console.log("respuesta",respuesta);
    }
})*/

// VARIABLE LOCAL STORAGE
if(localStorage.getItem("capturarRango") != null){

	$("#daterange-btn span").html(localStorage.getItem("capturarRango"));

}else{

	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

}


$('.tablaVentas').DataTable( {
    "ajax": "ajax/datatable-ventas.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

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

} );

$('.tablaAdministrarVentas').DataTable( {
    "ajax": "ajax/administrar-ventas.ajax.php",
    "deferRender": true,
	"retrieve": true,
	"processing": true,
	 "language": {

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

} );

/*CARGAR TABLA DINAMICA DE PRODUCTOS*/

$(".tablaVentas tbody").on("click","button.agregarProducto", function(){

	var idProducto = $(this).attr("idProducto");
	console.log("idProducto",idProducto);
	
	var marcaproducto = $(this).attr("marcaproducto");
	var categoriaproducto = $(this).attr("categoriaproducto");
	$(this).removeClass("btn-primary agregarProducto");
	$(this).addClass("btn-default");

	var datos = new FormData();
	datos.append("idProducto",idProducto);
	var nombremarca;
	$.ajax({
		url:"ajax/productos.ajax.php",
		method : "POST",
		data : datos,
		cache: false,
		contentType : false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			var descripcion =  respuesta["codigo"] + " "  + respuesta["descripcion"];
		
			var stock = respuesta["stock"];
			var precio = respuesta["precio_venta"];
			var NuevoPrecioVenta;
			var nuevacantidad;
			
			if(stock == 0){
				
				swal({
					title: "No hay stock disponible",
					type : "error",
					confirmButtonText: "!Cerrar¡"
				});
				$("button[idProducto='"+idProducto+"']").addClass("btn-primary agregarProducto")
				return;
			}else if(stock <= 11) {

				nuevacantidad = stock;
				NuevoPrecioVenta = (precio/12) * nuevacantidad;

				
			}
			else if(stock >=12){
				nuevacantidad = 12;
				NuevoPrecioVenta = precio;
			}

			nuevoInventario = stock - nuevacantidad;
			
				 
		
			$(".nuevoProducto").append(

			
				'<div class="row" style="padding:5px 15px">'+

				'<!-- Descripción del producto -->'+
				
				'<div class="col-xs-6" style="padding-right:0px">'+
				
				  '<div class="input-group">'+
					
					'<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+idProducto+'"><i class="fa fa-times"></i></button></span>'+
  
					'<input type="text" class="form-control nuevaDescripcionProducto" idProducto="'+idProducto+'" name="agregarProducto" value="'+descripcion+'" readonly required>'+
  
				  '</div>'+
  
				'</div>'+

				'<!-- Precio  Venta del producto -->'+
  
				'<div class="col-xs-2 ingresoPrecioVenta" style="padding-left:0px">'+
  
				  '<div class="input-group">'+
  
					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
					   
					'<input type="number" class="form-control nuevoPrecioVentaProducto" precioVenta="'+precio+'" name="nuevoPrecioVentaProducto" value="'+precio+'"  required>'+

					'<input type="hidden" name="PrecioVentaActual" id="PrecioVentaActual" >'+
					

				 '</div>'+
				   
				'</div>'+
  
				'<!-- Cantidad del producto -->'+
  
				'<div class="col-xs-2 CantidadNueva">'+
				  
				   '<input type="number"   class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'+nuevacantidad+'" stock="'+stock+'" nuevoStock="'+Number(nuevoInventario)+'" required>'+
  
				'</div>' +
  
				'<!-- Precio del producto -->'+
  
				'<div class="col-xs-2 ingresoPrecio" style="padding-left:0px">'+
  
				  '<div class="input-group">'+
  
					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
					   
					'<input type="text" class="form-control nuevoPrecioProducto" precioReal="'+precio+'" name="nuevoPrecioProducto" value="'+NuevoPrecioVenta+'" readonly required>'+
	   
				  '</div>'+
				   
				'</div>'+

				
  
			  '</div>')

			  	// SUMAR TOTAL DE PRECIOS

				sumarTotalPrecios()

				 // AGREGAR IMPUESTO

				 // agregarImpuesto()


				 listarProductos()

				// PONER FORMATO AL PRECIO DE LOS PRODUCTOS
				$(".nuevoPrecioProducto").number(true, 2);

		}
	})		
});

/* CUANDO CARGUE LA TABLA CADA VES QUE SE NAVEGUE EN ELLA */

$(".tablaVentas").on("draw.dt", function(){
	if(localStorage.getItem("quitarProducto") != null){
	var listaIdProductos = JSON.parse(localStorage.getItem("quitarProducto"));
	for(var i=0;i< listaIdProductos.length; i++){
		$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").removeClass('btn-default');
		$("button.recuperarBoton[idProducto='"+listaIdProductos[i]["idProducto"]+"']").addClass('btn-primary agregarProducto');

	}
	
	}

})


/*QUITAR PRODUCTOS DE LA VENTA Y RECUPERAR BOTON*/

 var idQuitarProducto = [];
 localStorage.removeItem("quitarProducto");

$(".formularioVenta").on("click","button.quitarProducto", function(){

	$(this).parent().parent().parent().parent().remove();
	var idProducto = $(this).attr("idProducto");

	/*ALMACENAR EN EL LOCALSTORAGE EL ID DEL PRODUCTO A QUITAR*/
	
	if(localStorage.getItem("quitarProducto")== null){

		idQuitarProducto = [];
	}else{

		idQuitarProducto.concat(localStorage.getItem("quitarProducto"))
	} 

	idQuitarProducto.push({"idProducto":idProducto});

	localStorage.setItem("quitarProducto", JSON.stringify(idQuitarProducto));

	$("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');
	$("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');
	
	if($(".nuevoProducto").children().length == 0){

		$("#nuevoTotalVenta").val(0);
	}else{
		// SUMAR TOTAL DE PRECIOS
		sumarTotalPrecios()
		//agregarImpuesto()
		listarProductos()
	}
	



})


/*=============================================
AGREGANDO PRODUCTOS DESDE EL BOTÓN PARA DISPOSITIVOS
=============================================*/

var numProducto = 0;

$(".btnAgregarProducto").click(function(){

	numProducto ++;

	var datos = new FormData();
	datos.append("traerProductos", "ok");

	$.ajax({

		url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    $(".nuevoProducto").append(

          	'<div class="row" style="padding:5px 15px">'+

			  '<!-- Descripción del producto -->'+
	          
	          '<div class="col-xs-6" style="padding-right:0px">'+
	          
	            '<div class="input-group">'+
	              
	              '<span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto><i class="fa fa-times"></i></button></span>'+

	              '<select class="form-control nuevaDescripcionProducto nuevocodigo" codigo id="producto'+numProducto+'" idProducto name="nuevaDescripcionProducto" required>'+

	              '<option>Seleccione el producto</option>'+

	              '</select>'+  

	            '</div>'+

	          '</div>'+

			  '<!-- Precio  Venta del producto -->'+
  
				'<div class="col-xs-2 ingresoPrecioVenta" style="padding-left:0px">'+
  
				  '<div class="input-group">'+
  
					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
					   
					'<input type="number" class="form-control nuevoPrecioVentaProducto" precioVenta name="nuevoPrecioVentaProducto" value=  required>'+

					'<input type="hidden" name="PrecioVentaActual" id="PrecioVentaActual" >'+
					

				 '</div>'+
				   
				'</div>'+



	          '<!-- Cantidad del producto -->'+

	          '<div class="col-xs-2 ingresoCantidad">'+
	            
	             '<input type="number"  class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="1" stock nuevoStock required>'+

	          '</div>' +

	          '<!-- Precio del producto -->'+

	          '<div class="col-xs-2 ingresoPrecio" style="padding-left:0px">'+

	            '<div class="input-group">'+

	              '<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+
	                 
	              '<input type="text" class="form-control nuevoPrecioProducto" precioReal="" name="nuevoPrecioProducto"  required>'+
	 
	            '</div>'+
	             
	          '</div>'+

	        '</div>');

			 // AGREGAR LOS PRODUCTOS AL SELECT 

	         respuesta.forEach(funcionForEach);

	         function funcionForEach(item, index){

	         	if(item.stock != 0){

		         	$("#producto"+numProducto).append(

						'<option idProducto="'+item.id+'" value="'+item.descripcion+'">'+item.descripcion+'</option>'
		         	)

		         }

	         }

			 	// SUMAR TOTAL DE PRECIOS

			sumarTotalPrecios()
		
		//	agregarImpuesto()

	        // PONER FORMATO AL PRECIO DE LOS PRODUCTOS
			$(".nuevoPrecioProducto").number(true, 2);





		}
	})

})

/*=============================================
SELECCIONAR PRODUCTO
=============================================*/

$(".formularioVenta").on("change", "select.nuevaDescripcionProducto", function(){

	var nombreProducto = $(this).val();

	var nuevaDescripcionProducto = $(this).parent().parent().parent().children().children().children(".nuevaDescripcionProducto");

	var nuevoPrecioProducto = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var nuevaCantidadProducto = $(this).parent().parent().parent().children(".ingresoCantidad").children(".nuevaCantidadProducto");

	var datos = new FormData();
    datos.append("nombreProducto", nombreProducto);


	  $.ajax({

     	url:"ajax/productos.ajax.php",
      	method: "POST",
      	data: datos,
      	cache: false,
      	contentType: false,
      	processData: false,
      	dataType:"json",
      	success:function(respuesta){
      	    
      	    $(nuevaDescripcionProducto).attr("idProducto", respuesta["id"]);
			$(nuevaDescripcionProducto).attr("codigo", respuesta["codigo"]);
      	    $(nuevaCantidadProducto).attr("stock", respuesta["stock"]);
      	    $(nuevaCantidadProducto).attr("nuevoStock", Number(respuesta["stock"])-1);
      	    $(nuevoPrecioProducto).val(respuesta["precio_venta"]);
      	    $(nuevoPrecioProducto).attr("precioReal", respuesta["precio_venta"]);

  	      // AGRUPAR PRODUCTOS EN FORMATO JSON

	        listarProductos()

      	}

      })
})



/*=============================================
MODIFICAR LA CANTIDAD
=============================================*/
$(".formularioVenta").on("change", "input.nuevaCantidadProducto", function(e){

	var precio = $(this).parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");

	var precioVenta = $(this).parent().parent().children(".ingresoPrecioVenta").children().children(".nuevoPrecioVentaProducto");
	
	var precioFinal = $(this).val() * precioVenta.val()/12;
	console.log(precioVenta.val());
	
	precio.val(precioFinal);

	var nuevoStock = Number($(this).attr("stock")) - $(this).val();
	var nuevopreciofinal;

	$(this).attr("nuevoStock", nuevoStock);
	$(".nuevoPrecioProducto").number(true, 2);

	if(Number($(this).val()) > Number($(this).attr("stock"))){

		/*=============================================
		SI LA CANTIDAD ES SUPERIOR AL STOCK REGRESAR VALORES INICIALES
		=============================================*/
		if(Number($(this).attr("stock"))<=11){
		
			$(this).val(Number($(this).attr("stock")));

			// nuevopreciofinal = $(this).attr("stock") * precioVenta.val()/12;
			// precio.val(nuevopreciofinal);
			$(this).attr("nuevoStock", 0);

		}else if (Number($(this).attr("stock"))>=12){

			$(this).val(Number($(this).attr("stock")));
			
			// nuevopreciofinal =  precioVenta.val();
			// precio.val(nuevopreciofinal);
			variable = $(this).attr("stock") - $(this).val();
			$(this).attr("nuevoStock", variable);
			console.log("mayor a 12");
		}




		sumarTotalPrecios();


		swal({
	      title: "La cantidad supera el Stock",
	      text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
	      type: "error",
	      confirmButtonText: "¡Cerrar!"
	    });

	    return;

	}
			// SUMAR TOTAL DE PRECIOS

		sumarTotalPrecios()
		//agregarImpuesto()
		listarProductos()

});




$(".formularioVenta").on("change", "input.nuevoPrecioVentaProducto", function(){


	var precio2 = $(this).parent().parent().parent().children(".ingresoPrecio").children().children(".nuevoPrecioProducto");
	var cantidad2 = $(this).parent().parent().parent().children(".CantidadNueva").children(".nuevaCantidadProducto");
	console.log(cantidad2.val());
	var precioFinal2 = ($(this).val()/12)*cantidad2.val();
	precio2.val(precioFinal2);
	sumarTotalPrecios()
	//agregarImpuesto()
	listarProductos()
	console.log("precioventa total",precio2.val(precioFinal2));

})

/*=============================================
SUMAR TODOS LOS PRECIOS
=============================================*/
function toNum(v){
  v = (v ?? "").toString().replace(/,/g, "");
  var n = parseFloat(v);
  return isNaN(n) ? 0 : n;
}

function sumarTotalPrecios(){

  var precioItem = $(".nuevoPrecioProducto");
  var sumaTotalPrecio = 0;

  for (var i = 0; i < precioItem.length; i++){
    sumaTotalPrecio += toNum($(precioItem[i]).val());
  }

  // Guardar SIN redondear a entero
  $("#nuevoTotalVenta").val(sumaTotalPrecio.toFixed(2));
  $("#totalVenta").val(sumaTotalPrecio.toFixed(2));
  $("#nuevoTotalVenta").attr("total", sumaTotalPrecio);

  // Si quieres que se vea bonito en pantalla:
  $("#nuevoTotalVenta").number(true, 2);
}

/*=============================================
FUNCIÓN AGREGAR IMPUESTO
=============================================*/

function agregarImpuesto(){

	var impuesto = $("#nuevoImpuestoVenta").val();
	var precioTotal = $("#nuevoTotalVenta").attr("total");

	var precioImpuesto = Number(precioTotal * impuesto);
		
	var totalConImpuesto =  Number(precioTotal * impuesto);

	$("#nuevoTotalVenta").val(totalConImpuesto);

	$("#totalVenta").val(totalConImpuesto);

	$("#nuevoPrecioImpuesto").val(impuesto);

	$("#nuevoPrecioNeto").val(precioTotal);

}

/*=============================================
CUANDO CAMBIA EL IMPUESTO
=============================================*/

$("#nuevoImpuestoVenta").change(function(){

	//agregarImpuesto();

});
/*=============================================
FORMATO AL PRECIO FINAL
=============================================*/

$("#nuevoTotalVenta").number(true, 2);

/*=============================================
SELECCIONAR MÉTODO DE PAGO
=============================================*/

$("#nuevoMetodoPago").change(function(){

	var metodo = $(this).val();
	//$("#nuevoImpuestoVenta").attr('readonly',false);
	var sumadetalle = $("#nuevoTotalVenta").val();


	if(metodo == "Efectivo"){

		
		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			 '<div class="col-xs-4">'+ 

			 	'<div class="input-group">'+ 

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+ 

			 		'<input type="number"  step ="0.01" class="form-control" id="nuevoValorEfectivo" placeholder="000000" required>'+

			 	'</div>'+

			 '</div>'+

			 '<div class="col-xs-4" id="capturarCambioEfectivo" style="padding-left:0px">'+

			 	'<div class="input-group">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control" id="nuevoCambioEfectivo" placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 )

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


      	// Listar método en la entrada
      	listarMetodos()

	}else if (metodo == "EfectivoDolar"){
	
		$(this).parent().parent().removeClass("col-xs-6");

		$(this).parent().parent().addClass("col-xs-4");

		$(this).parent().parent().parent().children(".cajasMetodoPago").html(

			'<div class="col-xs-4">'+

				'<div class = "input-group">'+

					'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

					'<input type="text" class="form-control" id="nuevocambiodolar" placeholder = "0000000" required>'+

				'</div>'+

			'</div>'+


			 '<div class="col-xs-4 pull-right" id="capturarCambioEfectivoDolar" style="padding-left:0px">'+

			 	'<div class="input-group ">'+

			 		'<span class="input-group-addon"><i class="ion ion-social-usd"></i></span>'+

			 		'<input type="text" class="form-control " id="CambioEfectivoDolar" placeholder="000000" readonly required>'+

			 	'</div>'+

			 '</div>'

		 )

		// Agregar formato al precio

		$('#nuevoValorEfectivo').number( true, 2);
      	$('#nuevoCambioEfectivo').number( true, 2);


      	// Listar método en la entrada
      	listarMetodos()
	}
		  
	else if ( metodo == "TD"){
		

		$(this).parent().parent().removeClass('col-xs-4');

		$(this).parent().parent().addClass('col-xs-6');

		 $(this).parent().parent().parent().children('.cajasMetodoPago').html(

		 	'<div class="col-xs-6" style="padding-left:0px">'+
                        
                '<div class="input-group">'+
                     
                  '<input type="text"  class="form-control" id="nuevoCodigoTransaccion" placeholder="Código transacción"  required>'+
                       
                  '<span class="input-group-addon"><i class="fa fa-lock"></i></span>'+
                  
                '</div>'+

              '</div>')

	}

})

/*=============================================
TIPO DE CAMBIO
=============================================*/
$(".formularioVenta").on("change", "input#nuevoValorEfectivo", function(){

	var efectivo = $(this).val();

	var cambio =  Number(efectivo) * Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivo = $(this).parent().parent().parent().children('#capturarCambioEfectivo').children().children('#nuevoCambioEfectivo');

	nuevoCambioEfectivo.val(Math.round(cambio));
	listarMetodos()
	

	$("#listaTipoCambio").val($(this).val());
	$("#listaTotalSoles").val(Math.round(cambio));


})

/*=======================
CAMBIO EFECTIVO DOLAR
=========================*/
$(".formularioVenta").on("change","input#nuevocambiodolar",function(){

	var efectivodolar = $(this).val();

	var cambiodolar = Number(efectivodolar)-Number($('#nuevoTotalVenta').val());

	var nuevoCambioEfectivoDolar = $(this).parent().parent().parent().children('#capturarCambioEfectivoDolar').children().children('#CambioEfectivoDolar');

	nuevoCambioEfectivoDolar.val(cambiodolar);

	console.log("ingreso de efectivo",cambiodolar);
	console.log(nuevoCambioEfectivoDolar.val(cambiodolar));
	listarMetodos()

	

})


/*=============================================
CAMBIO EN TRANSACCION
=============================================*/
$(".formularioVenta").on("change", "input#nuevoCodigoTransaccion", function(){

	listarMetodos()

})

/* LISTAR TODOS LOS PRODUCTOS */

function listarProductos(){

    var listaProductos = [];

    var descripcion = $(".nuevaDescripcionProducto");
    var cantidad    = $(".nuevaCantidadProducto");
    var precioventa = $(".nuevoPrecioVentaProducto");
    var precio      = $(".nuevoPrecioProducto");
    
    for (var i = 0; i < descripcion.length; i++) {

        var cant   = Number($(cantidad[i]).val());
        var stock0 = Number($(cantidad[i]).attr("stock"));    // stock SIN esta venta

        listaProductos.push({
            "id"         : $(descripcion[i]).attr("idProducto"),
            "descripcion": $(descripcion[i]).val(),
            "cantidad"   : cant,
            "stock"      : stock0 - cant,                     // 👈 SIEMPRE recalculado
            "precio"     : $(precioventa[i]).val(),
            "total"      : $(precio[i]).val(),
        });
    }

    console.log("listaProductos", JSON.stringify(listaProductos));
    $("#listaProductos").val(JSON.stringify(listaProductos));
}

function listarMetodos(){
	
	var listarMetodos="";
	if($("#nuevoMetodoPago").val()== "Efectivo"){
		
		$("#listaMetodoPago").val("Efectivo Soles");
		

	}else if($("#nuevoMetodoPago").val()== "EfectivoDolar"){

		$("#listaMetodoPago").val("Efectivo Dolar");
		
		$("#listaTipoCambio").val(0);
		$("#listaTotalSoles").val(0);

	}else if($("#nuevoMetodoPago").val() == "TD" ){

		$("#listaMetodoPago").val($("#nuevoMetodoPago").val()+"-"+$("#nuevoCodigoTransaccion").val());
		$("#listaTipoCambio").val(0);
		$("#listaTotalSoles").val(0);

	}
}

/*=============================================
BOTON EDITAR VENTA
=============================================*/
$(".tablaAdministrarVentas").on("click", ".btnEditarVenta", function(){

	var idVenta = $(this).attr("idVenta");

	window.location = "index.php?ruta=editar-venta&idVenta="+idVenta;


})

/*=============================================
FUNCIÓN PARA DESACTIVAR LOS BOTONES AGREGAR CUANDO EL PRODUCTO YA HABÍA SIDO SELECCIONADO EN LA CARPETA
=============================================*/

function quitarAgregarProducto(){

	//Capturamos todos los id de productos que fueron elegidos en la venta
	var idProductos = $(".quitarProducto");

	//Capturamos todos los botones de agregar que aparecen en la tabla
	var botonesTabla = $(".tablaVentas tbody button.agregarProducto");

	//Recorremos en un ciclo para obtener los diferentes idProductos que fueron agregados a la venta
	for(var i = 0; i < idProductos.length; i++){

		//Capturamos los Id de los productos agregados a la venta
		var boton = $(idProductos[i]).attr("idProducto");
		
		//Hacemos un recorrido por la tabla que aparece para desactivar los botones de agregar
		for(var j = 0; j < botonesTabla.length; j ++){

			if($(botonesTabla[j]).attr("idProducto") == boton){

				$(botonesTabla[j]).removeClass("btn-primary agregarProducto");
				$(botonesTabla[j]).addClass("btn-default");

			}
		}

	}
	
}

/*=============================================
CADA VEZ QUE CARGUE LA TABLA CUANDO NAVEGAMOS EN ELLA EJECUTAR LA FUNCIÓN:
=============================================*/

$('.tablaVentas').on( 'draw.dt', function(){

	quitarAgregarProducto();

})



/*=============================================
BORRAR VENTA
=============================================*/
$(".tablaAdministrarVentas").on("click", ".btnEliminarVenta", function(){

	var idVenta = $(this).attr("idVenta");
  
	swal({
		  title: '¿Está seguro de borrar la venta?',
		  text: "¡Si no lo está puede cancelar la accíón!",
		  type: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  cancelButtonText: 'Cancelar',
		  confirmButtonText: 'Si, borrar venta!'
		}).then(function(result){
		  if (result.value) {
			
			  window.location = "index.php?ruta=ventas&idVenta="+idVenta;
		  }
  
	})
  
  })
  

/*=============================================
IMPRIMIR FACTURA
=============================================*/

$(".tablaAdministrarVentas").on("click",".btnImprimirFactura",function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/tcpdf/pdf/prueba.php?codigo="+codigoVenta, "_blank");
})


$(".tablaAdministrarVentas").on("click",".btnImprimirTicket",function(){

	var codigoVenta = $(this).attr("codigoVenta");

	window.open("extensiones/tcpdf/pdf/ticket.php?codigo="+codigoVenta, "_blank");
})



/*=============================================
RANGO DE FECHAS
=============================================*/
 //Date range as a button
 $('#daterange-btn').daterangepicker(
	{
		ranges   : {
			'Hoy'       : [moment(), moment()],
			'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
			'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
			'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
			'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		  },
		  startDate: moment(),
		  endDate  : moment()
	},
	function (start, end) {
	 	
		$('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	  	
	 	var fechaInicial = start.format('YYYY-MM-DD');

		var fechaFinal = end.format('YYYY-MM-DD');

		var capturarRango = $("#daterange-btn span").html();
	
		localStorage.setItem("capturarRango", capturarRango);

		window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}
  )


/*=============================================
CANCELAR RANGO DE FECHAS
=============================================*/

$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click", function(){

	localStorage.removeItem("capturarRango");
	localStorage.clear();
	window.location = "ventas";
})

/*=============================================
CAPTURAR HOY
=============================================*/

// $(".daterangepicker.opensleft .ranges li").on("click", function(){

// 	var textoHoy = $(this).attr("data-range-key");
// 	console.log($(this).attr("data-range-key"));
	
// 	if(textoHoy == "Hoy"){

// 		var d = new Date();
		
// 		var dia = d.getDate();
// 		var mes = d.getMonth()+1;
// 		var año = d.getFullYear();

// 		if(mes < 10){

// 			var fechaInicial = año+"-0"+mes+"-"+dia;
// 			var fechaFinal = año+"-0"+mes+"-"+dia;

// 		}else if(dia < 10){

// 			var fechaInicial = año+"-"+mes+"-0"+dia;
// 			var fechaFinal = año+"-"+mes+"-0"+dia;

// 		}else if(mes < 10 && dia < 10){

// 			var fechaInicial = año+"-0"+mes+"-0"+dia;
// 			var fechaFinal = año+"-0"+mes+"-0"+dia;

// 		}else{

// 			var fechaInicial = año+"-"+mes+"-"+dia;
// 	    	var fechaFinal = año+"-"+mes+"-"+dia;

// 		}	

//     	localStorage.setItem("capturarRango", "Hoy");

//     	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

// 	}

// })


$(".daterangepicker.opensleft .ranges li").on("click", function(){

	var textoHoy = $(this).attr("data-range-key");

	if(textoHoy == "Hoy"){

		var d = new Date();
		
		var dia = d.getDate();
		var mes = d.getMonth()+1;
		var año = d.getFullYear();

		// if(mes < 10){

		// 	var fechaInicial = año+"-0"+mes+"-"+dia;
		// 	var fechaFinal = año+"-0"+mes+"-"+dia;

		// }else if(dia < 10){

		// 	var fechaInicial = año+"-"+mes+"-0"+dia;
		// 	var fechaFinal = año+"-"+mes+"-0"+dia;

		// }else if(mes < 10 && dia < 10){

		// 	var fechaInicial = año+"-0"+mes+"-0"+dia;
		// 	var fechaFinal = año+"-0"+mes+"-0"+dia;

		// }else{

		// 	var fechaInicial = año+"-"+mes+"-"+dia;
	 //    	var fechaFinal = año+"-"+mes+"-"+dia;

		// }

		dia = ("0"+dia).slice(-2);
		mes = ("0"+mes).slice(-2);

		var fechaInicial = año+"-"+mes+"-"+dia;
		var fechaFinal = año+"-"+mes+"-"+dia;	

    	localStorage.setItem("capturarRango", "Hoy");

    	window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

	}

})

// $(document).on("click",".btnEstadoVenta",function(){
//     var idVenta = $(this).attr("idVenta");
//     var estadoVenta = $(this).attr("estadoVenta");
//     var datos = new FormData();
//     datos.append("idVenta",idVenta);
//     datos.append("estadoVenta",estadoVenta);



//     $.ajax({
//         url:"ajax/ventas.ajax.php",
//         method : "POST",
//         data : datos,
//         cache : false,
//         contentType : false,
//         processData : false,
//         success: function(respuesta){
// 			console.log("btn estado click",idVenta,"-",estadoVenta);

// 			console.log(respuesta);

// 			swal({
// 				type:"success",
// 				title:"!El venta se actualizo ¡",
// 				showConfirmButton: true,
// 				confirmButtonText: "Cerrar",
// 				closeOnConfirm: false
// 			}).then((result)=>{
// 				if(result.value){
// 					window.location="ventas";
// 				}
// 			});

//         }
//     })
//     if(estadoVenta == 0){
//         $(this).removeClass('btn-success');
//         $(this).addClass('btn-danger');
//         $(this).html('No Entregado');
//         $(this).attr('estadoVenta',1);

//     }else
//     {
//         $(this).removeClass('btn-danger');
//         $(this).addClass('btn-success');
//         $(this).html('Entregado');
//         $(this).attr('estadoVenta',0);
//     }


// })

$(document).on("click", ".btnEstadoVenta", function () {

  const $btn = $(this);
  const idVenta = $btn.attr("idVenta");
  const estadoVenta = $btn.attr("estadoVenta"); // OJO: en tu tabla este valor es EL QUE SE VA A GUARDAR (0 o 1)

  const datos = new FormData();
  datos.append("idVenta", idVenta);
  datos.append("estadoVenta", estadoVenta);

  $.ajax({
    url: "ajax/ventas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function () {

      const tabla = $(".tablaAdministrarVentas").DataTable();

      // Soporte para responsive (si el row está “colapsado”)
      let $tr = $btn.closest("tr");
      if ($tr.hasClass("child")) $tr = $tr.prev();

      const row = tabla.row($tr);

      // Columna donde está el botón (la celda clickeada)
      const cellIndex = tabla.cell($btn.closest("td")).index();
      const col = cellIndex ? cellIndex.column : null;

      // Nuevo HTML (después de guardar)
      let nuevoHtml = "";
      if (estadoVenta == "0") {
        // Guardaste 0 => ahora debe verse "No entregado" y el próximo click enviará 1
        nuevoHtml = `<button class="btn btn-danger btn-xs btnEstadoVenta"
                          idVenta="${idVenta}" estadoVenta="1">No entregado</button>`;
      } else {
        // Guardaste 1 => ahora debe verse "Entregado" y el próximo click enviará 0
        nuevoHtml = `<button class="btn btn-success btn-xs btnEstadoVenta"
                          idVenta="${idVenta}" estadoVenta="0">Entregado</button>`;
      }

      // ✅ Actualiza solo esa celda
      if (col !== null) {
        tabla.cell(row.index(), col).data(nuevoHtml).draw(false);
      } else {
        // Fallback si DataTables no logró ubicar la celda
        $btn.closest("td").html(nuevoHtml);
        tabla.rows(row.index()).invalidate("dom").draw(false);
      }
    },
    error: function (xhr) {
      console.log("Error AJAX:", xhr.responseText);
    }
  });

});
