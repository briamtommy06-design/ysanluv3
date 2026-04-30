 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar categorias
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Administrar categorias</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
          Agregar categoria
        </button>



        </div>
        <div class="box-body">
          <div class="row" style="margin-bottom:10px;">
        <div class="col-md-4">
              <label>Filtrar por categoría padre</label>
              <select id="filtroCategoriaPadre" class="form-control">
                <option value="">Todas</option>
                <?php
                  $item = null;
                  $valor = null;
                  $categoriasPadre = ControladorCategorias::ctrMostrarCategorias($item,$valor);
                  foreach($categoriasPadre as $cat){
                    // solo las que no tienen padre (las "padre")
                    if($cat["id_padre"] == null){
                      echo '<option value="'.strtoupper($cat["categoria"]).'">'.strtoupper($cat["categoria"]).'</option>';
                    }
                  }
                ?>
              </select>
            </div>
          </div>

        <table class="table table-bordered table-striped dt-responsive tablas">
                <thead>
                <tr>
                  <th style="width:10px">#</th>
                  <th>Categoria</th>
                  <th>Categoria padre</th>
                  <th>Acciones</th>
                </tr>

                </thead>
                  <tbody>
                    <?php
                      $item=null;
                      $valor = null;
                      $categoria = ControladorCategorias::ctrMostrarCategorias($item,$valor);
                      foreach($categoria as $key=> $value ){
                        /* var_dump($categoria);*/
                        echo ' 
                        <tr>
                          <td>'.($key+1).'</td>
                          <td class="text-uppercase">'.$value["categoria"].'</td>
                           <td class="text-uppercase">'.( !empty($value["categoria_padre"]) ? $value["categoria_padre"] : 'SIN PADRE' ).'</td>
                          <td>
                            <div class="btn-group">
                            <button class="btn btn-warning btnEditarCategoria" 
                            idCategoria="'.$value["id"].'" data-toggle="modal" data-target="#modalEditarCategoria" >
                            <i class="fa fa-pencil"></i></button>
                            <button class="btn btn-danger btnEliminarCategoria" idCategoria="'.$value["id"].'"><i class="fa fa-times"></i></button>
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
  =                     MODAL AGREGAR CATEGORIA                      =
  ===================================================================-->

  <div id="modalAgregarCategoria" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Categoría</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
          <div class="modal-body">
            <div class="box-body">
      
                <!-- entrada para el nombre -->
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-th"></i></span>
                  <input type="text" class="form-control input-lg"
                        name="nuevaCategoria" placeholder="Ingresar Categoria" required>
                </div>
              </div>

              <!-- selección de categoría padre -->
              <div class="form-group">
                <label>Categoría padre (opcional)</label>
                <select class="form-control input-lg" name="idPadreCategoria">
                  <option value="">-- Sin categoría padre --</option>
                  <?php
                    $item = null;
                    $valor = null;
                    $categoriasPadre = ControladorCategorias::ctrMostrarCategorias($item,$valor);
                    foreach($categoriasPadre as $cat){
                      // Sólo mostrar como padres las que NO tienen padre
                      if ($cat["id_padre"] == null){
                        echo '<option value="'.$cat["id"].'">'.strtoupper($cat["categoria"]).'</option>';
                      }
                    }
                  ?>
                </select>
              </div>

             </div>
          </div>
          <!--================================================================
            =                     PIE DEL MODAL                           =
          ===================================================================-->
          <div class="modal-footer ">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-primary">Guardar Categoria</button>
          </div>
          <?php
            $crearCategoria = new ControladorCategorias();
            $crearCategoria -> ctrCrearCategoria();


          ?>
        </form>  
      </div>

    </div>
  
  </div> 


   <!--================================================================
  =                     MODAL EDITAR CATEGORIA                      =
  ===================================================================-->

  <div id="modalEditarCategoria" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post" id="formEditarCategoria">

          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modificar Categoría</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
            <div class="modal-body">
              <div class="box-body">

                <!-- Nombre categoría -->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <input type="text" class="form-control input-lg"
                          name="editarCategoria" id="editarCategoria" required>
                    <input type="hidden" class="form-control input-lg"
                          name="idCategoria" id="idCategoria">
                  </div>
                </div>

                <!-- Categoría padre -->
                <div class="form-group">
                  <label>Categoría padre (opcional)</label>
                  <select class="form-control input-lg" name="editarPadreCategoria" id="editarPadreCategoria">
                    <option value="">-- Sin categoría padre --</option>
                    <?php
                      $item = null;
                      $valor = null;
                      $categoriasPadre = ControladorCategorias::ctrMostrarCategorias($item,$valor);
                      foreach($categoriasPadre as $cat){
                        // sólo mostrar como posibles padres las que no tienen padre
                        if ($cat["id_padre"] == null){
                          echo '<option value="'.$cat["id"].'">'.strtoupper($cat["categoria"]).'</option>';
                        }
                      }
                    ?>
                  </select>
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
            $editarCategoria = new ControladorCategorias();
            $editarCategoria -> ctrEditarCategoria();
         ?> 
         
        </form>  
      </div>

    </div>
  
  </div> 
  <?php
      $borrarCategoria = new ControladorCategorias();
      $borrarCategoria -> ctrBorrarCategoria();
  ?> 