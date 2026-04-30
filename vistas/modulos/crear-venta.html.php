 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Crear Venta
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
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
           
            <div class="box-body">
              <form role="form" method="post">
                
                <div class="box">
                        <!-- VENDEDOR -->
                  <div class="form-group">
                    
                    <div class = "input-group">

                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor" value="Usuario Administrador" readonly>

                    </div>
 
                  </div>


                           <!-- CODIGO VENTA -->
                    <div class="form-group">
                    
                    <div class = "input-group">

                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        <input type="text" class="form-control" id="nuevaVenta" name="nuevaVenta" value="1121321" readonly>

                    </div>
 
                  </div>

                   <!-- ===========================
                    Entrada del cliente
                  ============================ -->
                  <div class="form-group">
                  
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-users"></i></span>
                      <select class="form-control" id="seleccionarCliente" name="seleccionarCliente" required>

                        <option value="">Seleccionar cliente</option>
                      </select>

                      <span class="input-group-addon"><button type="button" class="btn btn-default btn-xs" data-toggle="modal"
                      data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button></span>

                    </div>
                  
                  </div>

                     <!-- ===========================
                      Entrada para agregar producto
                    ============================ -->
                    <div class="form-group row nuevoProducto">
                      <!-- Descripción del producto -->
                      <div class="col-xs-6" style=padding-right:0px">
                        <div class="input-group">
                          <span class="input-group-addon"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-times">
                          </i></button></span> 

                          <input type="text" class="form-control" id="agregarProducto" name="agregarProducto" placeholder="Descripción del producto" required>

                        </div>

                      </div>
                      <!-- Cantidad del producto -->  
                        <div class="col-xs-3">

                          <input type="number" class="form-control" id="nuevaCantidadProducto" name="nuevaCantidadProducto" placeholder="0" 
                          min="1" required>

                        </div>

                        <!-- Precio del producto -->
                        <div class="col-xs-3" style="padding-left:0px">

                          <div class="input-group">

                            <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                            <input type="number" class="form-control" id="nuevoPrecioProducto" name="nuevoPrecioProducto" placeholder="000000" 
                            min="1" required readonly>

                            
                          </div>

                        </div>
                        
                    </div>
                     <!-- ===================================
                      Boton para agregar producto     
                    ==================================== -->
                      <button type="button" class="btn btn-default hidden-lg">Agregar producto</button>
                      <hr>

                      <div class="row">

                        <!-- ===================================
                          Entrada impuestos y total     
                        ==================================== -->
                        <div class="col-xs-8 pull-right">
                          
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Tipo de cambio</th>
                                <th>Total</th>
                              </tr>
                            </thead>

                            <tbody>
                              <tr>
                                <td style="width:50%">
                                  <div class="input-group">
                                    <input type="number" class="form-control" id="nuevoImpuestoVenta" name="nuevoImpuestoVenta" placeholder="0" 
                                    min="0" required>

                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                  </div>
                                </td>

                                <td style="width:50%">
                                  <div class="input-group">

                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                    <input type="number" class="form-control" id="nuevoTotalVenta" name="nuevoTotalVenta" placeholder="00000" 
                                    min="1" required readonly>

                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>

                        
                        </div>

                      </div>
                      <hr>

                  <div class="form-group row">
                    <div class="col-xs-6" style="padding-right:0px">
                      <div class="input-group">
                        <select class="form-control" id="nuevoMetodoPago" name="nuevoMetodoPago" required>
                    
                          <option value="">Seleccione método de pago</option>
                          <option value="efectivo">Efectivo</option>
                          <option value="tarjetaCredito">Tarjeta de crédito</option>
                          <option value="tarjetaDebito">Tarjeta de débito</option>
                      
                        </select>
                      </div>
                      
                    </div>

                    <div class="col-xs-6" style="padding-left:0px">
                      <div class="input-group">

                        <input type="text" class="form-control" id="nuevoCodigoTransaccion" name="nuevoCodigoTransaccion" placeholder="Código de transacción">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        
                      </div>
                      
                    </div>

                  </div>
                  <br>
                </div>  
                </div>
                  <div class="box-footer">
                
                    <button type="submit" class="btn btn-primary pull-right" >Guardar venta</button>
                
                  </div>

              </form>

            

        </div>

      </div>

      <!-- TABLA DE PRODUCTOS -->

      <div class="col-lg-7 hidden-md hidden-sm hidden-xs">
        <div class="box box-warning">  
          
             <div class="box-header with-border">
            
            </div>

            <div class="box-body">
              <table class="table table-bordered table-striped dt-responsive tablas">
                <thead>
                  <th style="width: 10px"></th>
                  <th>Imagen</th>
                  <th>Código</th>
                  <th>Descripción</th>
                  <th>Stock</th>
                  <th>Acciones</th>
                </thead>
                <tbody>
                  <tr>
                    <td>1.</td>
                    <td><img src="vistas/img/productos/default/anonymous.png" class="img-thumbail" width="40px" alt=""></td>
                    <td>00123</td>
                    <td>Lorem ipsun lorem ipsun</td>
                    <td>20</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-primary">Agregar</button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
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
                <!--entrada para el Documento ID-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-key"></i></span>
                    <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>

                  </div>
                </div>
                <!--entrada para el email-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                    <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

                  </div>
                </div>
                <!--entrada para telefono-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

                  </div>
                </div>
                <!--entrada para la dirección-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar Dirección" required>

                  </div>
                </div>
                <!--entrada para la fecha de nacimiento-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha de nacimiento" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>

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