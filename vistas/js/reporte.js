$.ajax({
    url: "ajax/datatable-reportes.ajax.php",
    success:function(respuesta){

        console.log("reportes js",respuesta);
    }
})



table=$('.tablareportes').DataTable({
    "ajax": "ajax/datatable-reportes.ajax.php",
    "deferRender":true,
    "retrieve":true,
    "processing": true,
	"order": [[ 0, "desc" ]],



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

	},
	buttons: [
		{
			extend: 'excelHtml5',
			text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
			titleAttr: 'Exportar a Excel',
			className: 'btn btn-primary'
		}
	]
	
} );


$("#iptCodigoBarras").keyup(function() {
	table.column($(this).data('index')).search(this.value).draw();
})


$("#iptSeriePedido").keyup(function() {
	table.column($(this).data('index')).search(this.value).draw();
})

$("#iptNombreCliente").keyup(function() {
	table.column($(this).data('index')).search(this.value).draw();
})

$('#exportar-excel').on('click', function() {
	$('.tablareportes').DataTable().button('.buttons-excel').trigger();
});