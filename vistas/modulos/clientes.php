 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Clientes
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Administrar Clientes</li>
      </ol>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
          Agregar Cliente
        </button>



        </div>
        <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas">
                <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>Dirección</th>
                  <th>Ciudad</th>
                  <th>Total compras</th>
                  <th>Última compra</th>
                  <th>Ingreso al sistema</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                  <tbody>
                    <?php
                      $item  = null;
                      $valor = null;
                      
                      $clientes=ControladorClientes::ctrMostrarClientes($item,$valor);

                      foreach($clientes as $key=>$value){
                        echo '
                        <tr>
                        <td>'.($key+1).'</td>
                        <td>'.$value['nombre'].'</td>
                        <td>'.$value['telefono'].'</td>
                        <td>'.$value['direccion'].'</td>
                        <td>'.$value['ciudad'].'</td>
                        <td>'.$value['compras'].'</td>
                        <td>'.$value['ultima_compra'].'</td>
                        <td>'.$value['fecha'].'</td>
                        
                      
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-warning btnEditarCliente" data-toggle="modal" data-target="#modalEditarCliente" idCliente="'.$value['id'].'"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarCliente" idCliente="'.$value['id'].'"><i class="fa fa-times"></i></button>
                          </div>
                        </td>
                        
                        
                        
                        </tr>

                        ';

                      }
                    
                    ?>
                   

                  </tbody>
                  
              </table>
        </div>
      
      </div>
    

    </section>

  </div>
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
                <!--entrada para la fecha de Ciudad-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>

                    <select class="form-control input-lg" name="nuevaCiudad" placeholder="Ingresar ciudad"  required>
                    
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
<!--================================================================
  =                     MODAL EDITAR CLIENTE                         =
  ===================================================================-->

  <div id="modalEditarCliente" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar cliente</h4>
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
                    <input type="text" class="form-control input-lg" name="editarCliente" id="editarCliente" required>
                    <input type="hidden" id="idCliente" name="idCliente">
                  </div>
                </div>
                           
                <!--entrada para telefono-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                    <input type="text" class="form-control input-lg" name="editarTelefono" id="editarTelefono" data-inputmask="'mask':'(999) 999-999'" data-mask required>

                  </div>
                </div>
                <!--entrada para la dirección-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                    <input type="text" class="form-control input-lg" name="editarDireccion" id="editarDireccion" required>

                  </div>
                </div>
                <!--entrada para la ciudad-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-building-o"></i></span>


                    <select class="form-control input-lg" name="nuevaCiudad" name="editarCiudad" id="editarCiudad" required>
                    
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

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form> 
          
        <?php
          $editarCliente=new ControladorClientes();
          $editarCliente->ctrEditarCliente();
        ?>
      </div>

    </div>
  
  </div> 

  <?php
    $eliminarCliente=new ControladorClientes();
    $eliminarCliente->ctrEliminarCliente();
  ?>
