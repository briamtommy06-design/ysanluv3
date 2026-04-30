<?php

require_once "../../../controladores/ventas.controlador.php";
require_once "../../../modelos/ventas.modelo.php";

require_once "../../../controladores/clientes.controlador.php";
require_once "../../../modelos/clientes.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/productos.controlador.php";
require_once "../../../modelos/productos.modelo.php";

require_once "../../../controladores/categorias.controlador.php";
require_once "../../../modelos/categorias.modelo.php";

require_once "../../../controladores/marcas.controlador.php";
require_once "../../../modelos/marcas.modelo.php";

class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "codigo";
$valorVenta = $this->codigo;

$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);

$fecha = substr($respuestaVenta["fecha"],0,-8);
$productos = json_decode($respuestaVenta["productos"], true);
$neto = number_format($respuestaVenta["neto"],2);
$impuesto = number_format($respuestaVenta["tipo_cambio"],2);
$total = number_format($respuestaVenta["total"],2);
$observacion = substr($respuestaVenta["observacion"],0);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["id_cliente"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["id_vendedor"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);

//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:center; line-height:15px;">
					
					<br>
					IMPORT EXPORT YSANLU
					<br>
					VENTA DE ZAPATILLAS Y CASACAS IMPORTADAS
					<br>
					TACNA-TACNA-TACNA

				</div>

			</td>

			<td style="background-color:white; width:140px">
				
				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					RUC: 20602894861

					<br>
					DirecciÃ³n: Av.Coronel Mendoza
					<br>
					Gal.Cajamarca 1150 Int.103

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:right; line-height:15px;">
					
					<br>
					TelÃ©fono: 942654580
									
					<br>
					TelÃ©fono: 962743728
										
					<br>
					ventas-proskate@hotmail.com

				</div>
				
			</td>

			<td style="background-color:white; width:110px; text-align:center; color:red"><br><br>Pedido N.<br>$valorVenta</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"><img src="images/back.jpg"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $respuestaCliente[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text-align:right">
			
				Fecha: $fecha

			</td>

		</tr>

		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:540px">Destino: $respuestaCliente[ciudad]</td>

		</tr>

		<tr>
		
		<td style="border-bottom: 1px solid #666; background-color:white; width:540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:35px; text-align:left">N.</td>
		<td style="border: 1px solid #666; background-color:white; width:260px; text-align:left">Producto</td>
		<td style="border: 1px solid #666; background-color:white; width:50px; text-align:left">Can</td>
		<td style="border: 1px solid #666; background-color:white; width:50px; text-align:left">Doc</td>
		<td style="border: 1px solid #666; background-color:white; width:65px; text-align:left">V.Doc</td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:left">Importe</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------
$cen = 0;
foreach ($productos as $key => $item) {

	$itemProducto = "descripcion";
	$valorProducto = $item["descripcion"];
	$orden = null;
	
	$totaldocena = number_format($item["cantidad"] / 12,1);
	
	$cen = $cen + $totaldocena;
	
	$valorUnitario = number_format($item["precio"], 2);
	
	$precioTotal = number_format($item["total"], 2);

	$val = $key +  1 ;

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:35px; text-align:left">
			$val
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:260px; text-align:left">
				  $item[descripcion] 
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:left">
				$item[cantidad]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:50px; text-align:left">
			$totaldocena
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:65px; text-align:left">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:left">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------
if($impuesto==0){
	$bloque5 = <<<EOF

	
	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:left"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left"></td>

		</tr>

		<tr>
			
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:left">
			Docenas
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				$cen
			</td>

		</tr>

		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:left">
				Total Dolar :
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				$ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

} else{
$bloque5 = <<<EOF

	
	<table style="font-size:10px; padding:5px 10px;">
		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:left"></td>

			<td style="border-bottom: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left"></td>

		</tr>
		
		<tr>
			
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:left">
			Docenas
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				$cen
			</td>

		</tr>
		
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:left">
				Total Dolar :
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				$ $total
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:left">
				Tipo Cambio :
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				S/. $impuesto
			</td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:left">
				Total Soles:
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:left">
				S/. $neto
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

}

$bloque6 = <<<EOF
<table>
		
<tr>
	
	<td style="width:540px"><img src="images/back.jpg"></td>

</tr>

</table>

<h3>Observación:</h3>
<p>{$observacion}</p>
EOF;
$pdf->writeHTML($bloque6, false, false, false, false, '');

// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 
ob_end_clean();
$pdf->Output('factura.pdf', 'D');

}


}


	$factura = new imprimirFactura();
	$factura -> codigo = $_GET["codigo"];
	$factura -> traerImpresionFactura();





?>