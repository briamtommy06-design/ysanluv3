<?php
require "controladores/plantilla.controlador.php";
require "controladores/usuarios.controlador.php";
require "controladores/categorias.controlador.php";
require "controladores/productos.controlador.php";
require "controladores/clientes.controlador.php";
require "controladores/ventas.controlador.php";
require "controladores/marcas.controlador.php";
require "controladores/movimientos_stock.controlador.php";

require "modelos/usuarios.modelo.php";
require "modelos/categorias.modelo.php";
require "modelos/productos.modelo.php";
require "modelos/clientes.modelo.php";
require "modelos/ventas.modelo.php";
require "modelos/marcas.modelo.php";
require "modelos/movimientos_stock.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla-> ctrPlantilla();
