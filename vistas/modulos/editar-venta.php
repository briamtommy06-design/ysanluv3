 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Crear Venta
        
      </h1>
      <ol class="breadcrumb">

        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        
        <li class="active"> Crear Venta</li>
      
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
     
    <div class="row">
        
        <!-- FORMULARIO -->

      <div class="col-lg-5 col-xs-12">
        
        <div class="box box-success">
           
          <div class="box-header with-border"></div>
           
          <form role="form" method="post" class="formularioVenta">
             
           <div class="box-body">
                              
              <div class="box">

                  <?php

                    $item = "id";
                    $valor = $_GET["idVenta"];

                    $venta = ControladorVentas::ctrMostrarVentas($item, $valor);

                    $itemUsuario = "id";
                    $valorUsuario = $venta["id_vendedor"];

                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                    $itemCliente = "id";
                    $valorCliente = $venta["id_cliente"];

                    $cliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                    $porcentajeImpuesto = $venta["tipo_cambio"] ;


                  ?>

              
              
                  <!-- VENDEDOR -->
                  <div class="form-group">
                    
                    <div class = "input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $vendedor["nombre"]; ?>" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                        <input type="hidden" name="idVendedor" value="<?php echo $vendedor["id"]; ?>">

                      </div>
 
                  </div>


                  <!-- ENTRADA DEL CODIGO  -->
                  <div class="form-group">
                    
                    <div class = "input-group">

                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        
                        <input type="text" class="form-control" id="nuevaVenta" name="editarVenta" value="<?php echo $venta["codigo"]; ?>" readonly>
                    
                    </div>
 
                  </div>

                   <!-- ===========================
                    Entrada del cliente
                  ============================ -->
                  <div class="form-group">
                  
                    <div class="input-group">

                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      
                      <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>

                        <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nombre"]; ?></option>
                      
                      <?php 
                       
                       $item = null;
                       $valor = null;

                        $categorias = ControladorClientes::ctrMostrarClientes($item,$valor);
                      
                        foreach($categorias as $key => $value){

                          echo '<option value="'.$value["id"].'">'.$value["nombre"].'</option>';
                        }

                      ?>    

                      </select>


                      <span class="input-group-addon"><button type="button" class="btn btn-primary bg-blue" data-toggle="modal"
                      data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button></span>


                    </div>
                  
                  </div>
                    <!--=====================================
                    LABELS DETALLE
                    ======================================--> 
                  <div class="row" style = "padding:5px 15px">
                      
                        <div class = "col-xs-6" style="padding-right:0px">

                          <label>
                            <font style="vertical-align: inherit;">
                              
                              <font style="vertical-align: inherit;"> Descripción </font>

                            </font>
                          </label>

                        </div>
                        <div class = "col-xs-2" style="padding-right:0px">

                          <label>
                            <font style="vertical-align: inherit;">
                              
                              <font style="vertical-align: inherit;"> P.Docena </font>

                            </font>
                          </label>

                        </div>

                        <div class = "col-xs-2" style="padding-right:0px">

                          <label>
                            <font style="vertical-align: inherit;">
                              
                              <font style="vertical-align: inherit;"> Cantidad </font>

                            </font>
                          </label>

                        </div>
                            
                        <div class = "col-xs-2" style="padding-right:0px">

                          <label>
                            <font style="vertical-align: inherit;">
                              
                              <font style="vertical-align: inherit;"> Importe </font>

                            </font>
                          </label>

                        </div>
                        
                  </div>

                 
                    <!--=====================================
                    ENTRADA PARA AGREGAR PRODUCTO
                    ======================================--> 

                  <div class="form-group row nuevoProducto">         
                        
                  <?php

                    $listaProducto = json_decode($venta["productos"], true);

                    foreach ($listaProducto as $key => $value) {

                      $item = "id";
                      $valor = $value["id"];

                      $respuesta = ControladorProductos::ctrMostrarProductos($item, $valor);

                      $stockAntiguo = $respuesta["stock"] + $value["cantidad"];
                      
                      echo '<div class="row" style="padding:5px 15px">

                            <div class="col-xs-6" style="padding-right:0px">

                              <div class="input-group">

                                <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["id"].'"><i class="fa fa-times"></i></button></span>

                                <input type="text" class="form-control nuevaDescripcionProducto" idProducto="'.$value["id"].'" name="agregarProducto" value="'.$value["descripcion"].'" readonly required>

                              </div>

                            </div>

                            <div class="col-xs-2 ingresoPrecioVenta" style="padding-left:0px">
  
                              <div class="input-group">
                   
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                  
                                <input type="number" class="form-control nuevoPrecioVentaProducto" precioVenta="'.$value["precio"].'" name="nuevoPrecioVentaProducto" value="'.$value["precio"].'"  required>
                                
                                <input type="hidden" name="PrecioVentaActual" id="PrecioVentaActual" >
                              
                              </div>
                              
                            </div>
  



                            <div class="col-xs-2 CantidadNueva">

                              <input type="number" class="form-control nuevaCantidadProducto" name="nuevaCantidadProducto" min="1" value="'.$value["cantidad"].'" stock="'.$stockAntiguo.'" nuevoStock="'.$value["stock"].'" required>

                            </div>

                            <div class="col-xs-2 ingresoPrecio" style="padding-left:0px">

                              <div class="input-group">

                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                      
                                <input type="text" class="form-control nuevoPrecioProducto" precioReal="'.$respuesta["precio_venta"].'" name="nuevoPrecioProducto" value="'.$value["total"].'" readonly required>

                              </div>

                            </div>

                          </div>';
                    }


                    ?>
                        
                  </div>

                  <input type="hidden" id="listaProductos" name="listaProductos">


                  <!-- ===================================
                    Boton para agregar producto     
                  ==================================== -->
                  
                  <button type="button" class="btn btn-default hidden-lg btnAgregarProducto">Agregar producto</button>
                  
                  <hr>

                  <div class="row">

                  <!--=====================================
                  ENTRADA IMPUESTOS Y TOTAL
                  ======================================-->
                  
                  <div class="col-xs-4 pull-right">
                    
                    <table class="table">

                      <thead>

                        <tr>
                       
                          <th>Total</th>      
                        </tr>

                      </thead>

                      <tbody>
                      
                        <tr>
                          
                        <td style="width: 50%">
                            
                         
                            
                            <div class="input-group">
                           
                              <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>

                              <input type="text" class="form-control input-lg" id="nuevoTotalVenta" name="nuevoTotalVenta" total="<?php echo $venta["neto"]; ?>" value="<?php echo $venta["total"]; ?>" readonly required>

                              <input type="hidden" name="totalVenta" value="<?php echo $venta["total"]; ?>" id="totalVenta">
                              
                        
                            </div>

                          </td>

                        </tr>

                      </tbody>

                    </table>

                  </div>

                </div>

                <hr>

              <!--=====================================
                ENTRADA MÉTODO DE PAGO
                ======================================-->


                <div class="form-group row">
                    
                    <div class="col-xs-6" style="padding-right:0px">
                      
                        <div class="input-group">
                        
                            <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                          
                                <option value="">Seleccione método de pago</option>
                                <option value="Efectivo">Efectivo Soles</option>
                                <option value="TD">Deposito</option> 
                                <option value="EfectivoDolar"> Efectivo Dolar</option>       
                            </select>
                         
                        </div>
                    
                    </div>
                  
                    <div class="cajasMetodoPago"></div>

                    <input type="hidden" id="listaMetodoPago" name="listaMetodoPago">

                    <input type="hidden" id="listaTipoCambio" name = "listaTipoCambio">

                    <input type= "hidden" id= "listaTotalSoles" name = "listaTotalSoles"> 


                </div>

                <br>

                <div class="form-group row">
                    
                    <div class="col-xs-12 col-sm-12">
                        <label > Observacion</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                          <input type="text" class="form-control input-lg" id="observacionVenta" name="observacionVenta" placeholder="Ingrese Observacion"  value="<?php echo $venta["observacion"]; ?>" required>
                        </div>
                    </div>
  
                </div>             
  
              </div>
            <br>
           </div>

              <div class="box-footer">
                
                    <button type="submit" class="btn btn-primary pull-right" >Guardar Cambios</button>
                
              </div>

              </form>
            
                <?php

                $editarVenta = new ControladorVentas();
                $editarVenta -> ctrEditarVenta();

                ?>
                    

        </div>

      </div>

      <!-- TABLA DE PRODUCTOS -->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">  
          
          <div class="box-header with-border"></div>

            <div class="box-body">
              <table class="table table-bordered table-striped dt-responsive tablaVentas">
                <thead>
                  <tr>
                  <th style="width: 10px"></th>
                 
                  <th>Código</th>
                  <th>Descripción</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                  </tr>
                  
                </thead>
               
              </table>
            </div>



        </div>  
    
      </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!--================================================================
  =                     MODAL AGREGAR CLIENTE                         =
  ===================================================================-->

  <div id="modalAgregarCliente" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
    <div class="modal-content">
        <form role="form" method="post">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar cliente</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
          <div class="modal-body">
            <div class="box-body">
              <!--entrada para el nombre-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

                  </div>
                </div>
              <!--entrada para telefono-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-999'" data-mask required>

                  </div>
                </div>
                <!--entrada para la dirección-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar Dirección" required>

                  </div>
                </div>
                <!--entrada para la ciudad-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>
                     <select class="form-control input-lg" name="nuevaCiudad" >
                    
                    <option value="">Seleccionar Ciudad</option>
                    <option value="Tacna">Tacna</option>
                    <option value="Arequipa">Arequipa</option>
                    <option value="Puno">Puno</option>
                    <option value="Moquegua">Moquegua</option>
                    <option value="Lima">Lima</option>
                    <option value="Cusco">Cusco</option>

                  </select>
                  
                  </div>
                </div>
            </div>
          </div>
          <!--================================================================
            =                     PIE DEL MODAL                           =
          ===================================================================-->
          <div class="modal-footer ">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar cliente</button>
          </div>
        </form> 
        <?php
          $crearCliente=new ControladorClientes();
          $crearCliente->ctrCrearCliente();
        ?>
     
      </div>

    </div>
  
  </div> 
