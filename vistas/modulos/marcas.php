 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar Marcas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Administrar Marcas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarMarca">
          Agregar Marca
        </button>



        </div>
        <div class="box-body">
        <table class="table table-bordered table-striped dt-responsive tablas">
                <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Marca</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                  <tbody>
                    <?php
                      $item=null;
                      $valor = null;
                      $marca = ControladorMarcas::ctrMostrarMarcas($item,$valor);
                      foreach($marca as $key=> $value ){
                        /* var_dump($marca);*/
                        echo ' 
                        <tr>
                          <td>'.($key+1).'</td>
                          <td class="text-uppercase">'.$value["marca"].'</td>
                          <td>
                            <div class="btn-group">
                            <button class="btn btn-warning btnEditarMarca" 
                            idMarca="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarMarca" >
                            <i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarMarca" idMarca="'.$value["id"].'"><i class="fa fa-times"></i></button>
                            </div>
                          </td>
                          
                        </tr>';

                      }
                     

                    ?>
                   

                  </tbody>
                  
              </table>
        </div>
      
      </div>
    

    </section>

  </div>

   
  <!--================================================================
  =                     MODAL AGREGAR MARCA                 =
  ===================================================================-->

  <div id="modalAgregarMarca" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Marca</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
          <div class="modal-body">
            <div class="box-body">
              <!--entrada para el nombre-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <input type="text" class="form-control input-lg" name="nuevaMarca" placeholder="Ingresar Marca" required>

                  </div>
                </div>
             </div>
          </div>
          <!--================================================================
            =                     PIE DEL MODAL                           =
          ===================================================================-->
          <div class="modal-footer ">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar Marca</button>
          </div>
          <?php
            $crearMarca = new ControladorMarcas();
            $crearMarca -> ctrCrearMarca();


          ?>
        </form>  
      </div>

    </div>
  
  </div> 


   <!--================================================================
  =                     MODAL EDITAR CATEGORIA                      =
  ===================================================================-->

  <div id="modalEditarMarca" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modificar Marca</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
          <div class="modal-body">
            <div class="box-body">
              <!--entrada para el nombre-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <input type="text" class="form-control input-lg" name="editarMarca" id="editarMarca"  required>
                    <input type="hidden" class="form-control input-lg" name="idMarca" id="idMarca">

                  </div>
                </div>
             </div>
          </div>
          <!--================================================================
            =                     PIE DEL MODAL                           =
          ===================================================================-->
          <div class="modal-footer ">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </div>
         
         <?php
            $editarMarca = new ControladorMarcas();
            $editarMarca -> ctrEditarMarca();
         ?> 
        </form>  
      </div>

    </div>
  
  </div> 
  <?php
      $borrarMarca = new ControladorMarcas();
      $borrarMarca -> ctrBorrarMarca();
  ?> 