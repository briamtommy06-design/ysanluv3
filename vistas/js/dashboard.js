

$(document).ready(function() {


        /* =======================================================
    SOLICITUD AJAX TARJETAS INFORMATIVAS
    =======================================================*/

    $.ajax({
        url: "ajax/dashboard.ajax.php",
        method: 'POST',
        dataType: 'json',
        success: function(respuesta) {



            $("#totalProductos").html(respuesta[0]['totalproductos']);
            $("#totalClientes").html(respuesta[0]['totalclientes']);
            $("#totalVentasHoy").html('$. ' + respuesta[0]['totalVentasHoy'].toString().replace(
                /\d(?=(\d{3})+\.)/g, "$&,"))
        }

    })

    setInterval(() => {

            
        $.ajax({
            url: "ajax/dashboard.ajax.php",
            method: 'POST',
            dataType: 'json',
            success: function(respuesta) {


                console.log("getdashboard : ",respuesta);
                $("#totalProductos").html(respuesta[0]['totalproductos']);
                $("#totalClientes").html(respuesta[0]['totalclientes']);
                $("#totalVentasHoy").html('$. ' + respuesta[0]['totalVentasHoy'].toString().replace(
                    /\d(?=(\d{3})+\.)/g, "$&,"))
            }

        })

    }, 10000);

    $.ajax({
        url: "ajax/dashboard.ajax.php",
        type: "POST",
        data: {
            'accion': 1 // listar los 10 productos mas vendidos
        },
        dataType:'json',
        success:function(respuesta){
            console.log("respuesta",respuesta);

            for (let i = 0; i < respuesta.length; i++) {
                let estado = respuesta[i]["estado"] == 1 ? '<span class="label label-success">Enviado</span>' : '<span class="label label-danger">No enviado</span>';
                filas = '<tr>'+
                  '<td>'+ respuesta[i]["codigo"] + '</td>'+
                  '<td>'+ respuesta[i]["nombre"] + '</td>'+
                  '<td>'+ respuesta[i]["fecha"] + '</td>'+
                  '<td>'+ estado + '</td>'+
                '</tr>';
                $("#tbl_estado_ventas").append(filas);
              }
              
            
        }
    });

    
    $.ajax({
        url: "ajax/dashboard.ajax.php",
        type: "POST",
        data: {
            'accion': 2 
        },
        dataType:'json',
        success:function(respuesta){
            console.log("respuesta",respuesta);

            for (let i = 0; i < respuesta.length; i++) {
                  filas = '<tr>'+
                  '<td>'+ respuesta[i]["nombre"] + '</td>'+
                  '<td>'+ respuesta[i]["ciudad"] + '</td>'+
                  '<td>'+ respuesta[i]["compras"] + '</td>'+
                  '<td>'+ respuesta[i]["ultima_compra"] + '</td>'+
                '</tr>';
                $("#tbl_top_cliente").append(filas);
              }
 
            
        }
    });



})