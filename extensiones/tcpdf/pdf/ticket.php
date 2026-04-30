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


class imprimirTicket{

    public $codigo;

    public function traerImpresionTicket(){

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

        require_once('tcpdf_include.php');

        $pdf = new TCPDF('P', 'mm', array(80, 500), true, 'UTF-8', false);
        // Desactivar la línea superior

        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        $pdf->SetAutoPageBreak(true, 0);
        
        // establecer los márgenes
        $pdf->SetMargins(5, 5, 5,0);

        
        // agregar el contenido del ticket
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 10, 'IMPORT EXPORT YSANLU', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 5, 'NOTA VENTA: '.$valorVenta, 0, 1, 'C');
        $pdf->Cell(0, 5, 'VENTA DE ZAPATILLAS IMPORTADAS ', 0, 1, 'C');
        $pdf->Cell(0, 5, 'Celular: 983822010 ', 0, 1, 'C');

        $pdf->Cell(0, 5, 'Cliente :'.$respuestaCliente["nombre"] , 0, 1, 'L');
        $pdf->Cell(0, 5, 'Destino :'.$respuestaCliente["ciudad"] , 0, 1, 'L');
        $pdf->Cell(0, 5, 'Fecha :'.$fecha , 0, 1, 'L');



        $pdf->SetFont('Helvetica', 'B', 8);

        // Establece el color de fondo y de texto para la fila
        $pdf->SetFillColor(0,0,0);
        $pdf->SetTextColor(255,255,255);
        
        // Dibuja la fila con los valores de celda
        $pdf->Cell(37, 5, 'Articulo', 1, 0, 'C', true);
        $pdf->Cell(5, 5, 'Ud', 1, 0, 'R', true);
        $pdf->Cell(16, 5, 'P.Doc', 1, 0, 'R', true);
        $pdf->Cell(12, 5, 'Total', 1, 1, 'R', true);
        
        // Restablece el color de fondo y de texto a los valores predeterminados
        $pdf->SetFillColor(255,255,255);
        $pdf->SetTextColor(0,0,0);
        
  
        $pdf->Cell(60,0,'','T');
        $pdf->Ln(2);
        foreach ($productos as $key => $item) {

            $descripcionHeight = 0; // Declaración de la variable


            

            $itemProducto = "descripcion";
            $valorProducto = $item["descripcion"];
            $orden = null;
            
            $totaldocena = number_format($item["cantidad"] / 12,1);
            
            // $cen = $cen + $totaldocena;
            
            $valorUnitario = number_format($item["precio"], 2);
            
            $precioTotal = number_format($item["total"], 2);
            
	        $val = $key +  1 ;

            
            $pdf->SetFont('Helvetica', '', 7);

            // Guarda la posición actual del cursor
            $currentY = $pdf->GetY();
            
            // Imprime la celda de descripción
            $pdf->MultiCell(35, 4, $item['descripcion'], 0, 'L');
            
            // Calcula la altura necesaria para la celda de descripción
            $descripcionHeight = $pdf->getStringHeight(35, $item['descripcion']);
            
            // Establece la posición de las siguientes celdas usando la posición guardada del cursor
            $pdf->SetXY(40, $currentY);
            $pdf->Cell(6, $descripcionHeight, $item['cantidad'], 0, 0, 'R');
            $pdf->SetXY(52, $currentY);
            $pdf->Cell(10, $descripcionHeight, $valorUnitario, 0, 0, 'R');
            $pdf->SetXY(64, $currentY);
            $pdf->Cell(12, $descripcionHeight, $precioTotal, 0, 0, 'R');


            // Mueve el cursor a la siguiente línea
            $pdf->Ln($descripcionHeight);

            
            if ($pdf->getY() + $descripcionHeight > $pdf->getPageHeight() - 20) {
                $pdf->AddPage();


            }
        }
     
    
        $pdf->SetFont('Helvetica', 'B', 7);

        if($impuesto==0){
      
            $pdf->MultiCell(35,4,"Total Dolar: ".$total,0,'L');

        }else{
       
            $pdf->MultiCell(35,4,"Total Dolar: ".$total,0,'L');
  
            $pdf->MultiCell(35,4,"Tipo Cambio: ".$impuesto,0,'L');
     
            $pdf->MultiCell(35,4,"Total Soles: ".$neto,0,'L');


        }
        $pdf->SetFont('Helvetica', 'A', 5);

        $pdf->MultiCell(35,4,"Obs: ".$respuestaVenta["observacion"],0,'L');

        $pdf->SetFont('helvetica', '', 7);
        $pdf->Cell(0, 10, 'GRACIAS POR SU COMPRA', 0, 1, 'C');

   
        ob_end_clean();
        $pdf->Output('ticket.pdf', 'I');

    }

}


$ticket = new  imprimirTicket();
$ticket -> codigo = $_GET["codigo"];
$ticket -> traerImpresionTicket();


