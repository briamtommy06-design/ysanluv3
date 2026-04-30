 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar productos
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Administrar productos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <div class="btn-group">
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
              <i class="fa fa-plus"></i> Agregar Producto
            </button>

            <button type="button" class="btn btn-default" id="btnToggleCostoCompra">
              <i class="fa fa-eye-slash"></i> Ocultar costo compra
            </button>

            <button type="button" class="btn btn-default" id="btnLimpiarFiltrosProductos">
              <i class="fa fa-eraser"></i> Limpiar
            </button>
          </div>
        </div>




        <div class="box-body">
 <div class="row" style="margin-bottom:12px;">

  <?php
    $item=null; $valor=null;
    $categorias = ControladorCategorias::ctrMostrarCategorias($item,$valor);

    $catsPadre = [];
    $catsHijas = [];
    foreach($categorias as $cat){
      if($cat["id_padre"] == null) $catsPadre[] = $cat;
      else $catsHijas[] = $cat;
    }

    $marcas = ControladorMarcas::ctrMostrarMarcas(null, null);
  ?>

  <div class="col-xs-12 col-sm-4">
    <div class="form-group">
      <label>Cat. padre</label>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
        <select id="filtroCategoriaPadreProductos" class="form-control">
          <option value="" data-id="">Todas</option>
          <?php foreach($catsPadre as $p): ?>
            <option value="<?= strtoupper($p["categoria"]) ?>" data-id="<?= $p["id"] ?>">
              <?= strtoupper($p["categoria"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <div class="col-xs-12 col-sm-4">
    <div class="form-group">
      <label>Subcategoría</label>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-th"></i></span>
        <select id="filtroCategoriaHijaProductos" class="form-control" disabled>
          <option value="">Todas</option>
          <?php foreach($catsHijas as $h): ?>
            <option value="<?= strtoupper($h["categoria"]) ?>"
                    data-padre="<?= $h["id_padre"] ?>"
                    style="display:none">
              <?= strtoupper($h["categoria"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <small class="help-block" style="margin:5px 0 0;">
        Elige primero la categoría padre.
      </small>
    </div>
  </div>

  <div class="col-xs-12 col-sm-4">
    <div class="form-group">
      <label>Marca</label>
      <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
        <select id="filtroMarcaProductos" class="form-control">
          <option value="">Todas</option>
          <?php foreach($marcas as $m): ?>
            <option value="<?= strtoupper($m["marca"]) ?>"><?= strtoupper($m["marca"]) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

</div>




          <table class="table table-bordered table-striped dt-responsive tablaProductos"  width="100%">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Imagen</th>
                <th>Código</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Categoría padre</th>
                <th>Stock</th>
                <th>Precio de compra</th>
                <th>Precio de venta</th>
                <th>Agregado</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>

        </div>
      
      </div>
    

    </section>


  </div>
  
  
<?php
$item = null; 
$valor = null;
$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

$catsPadre = [];
$catsHijas = [];

foreach ($categorias as $cat) {
  if ($cat["id_padre"] == null) {
    $catsPadre[] = $cat;
  } else {
    $catsHijas[] = $cat;
  }
}
?>


<div id="modalAgregarProducto" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <div class="modal-header" style="background:#3c8dbc;color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar producto</h4>
        </div>

        <!-- body con scroll -->
        <div class="modal-body" style="max-height:70vh; overflow:auto;">
          <div class="box-body">

            <!-- ================= CATEGORÍA ================= -->
            <div class="box box-primary" style="margin-bottom:12px;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-sitemap"></i> Categorías</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Categoría padre</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-sitemap"></i></span>
                        <select class="form-control input-lg" id="nuevaCategoriaPadre" required>
                          <option value="">Seleccionar categoría padre</option>
                          <?php foreach($catsPadre as $p): ?>
                            <option value="<?= $p["id"] ?>"><?= $p["categoria"] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Subcategoría</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                        <select class="form-control input-lg" name="nuevaCategoria" id="nuevaCategoria" required disabled>
                          <option value="">Seleccionar subcategoría</option>
                          <?php foreach($catsHijas as $h): ?>
                            <option value="<?= $h["id"] ?>" data-padre="<?= $h["id_padre"] ?>">
                              <?= $h["categoria"] ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <p class="help-block" style="margin:5px 0 0;">
                        Primero elige la categoría padre y luego su subcategoría.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ================= DATOS BÁSICOS ================= -->
            <div class="box box-info" style="margin-bottom:12px;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-tags"></i> Datos del producto</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Código</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        <input type="text" class="form-control input-lg" id="nuevoCodigo" name="nuevoCodigo" placeholder="Ingresar código" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Marca</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-bookmark"></i></span>
                        <select class="form-control input-lg" name="nuevaMarca" id="nuevaMarca" required>
                          <option value="">Seleccionar marca</option>
                          <?php
                            $item=null; $valor=null;
                            $categorias=ControladorMarcas::ctrMostrarMarcas($item,$valor);
                            foreach($categorias as $key=>$value){
                              echo '<option value="'.$value['id'].'">'.$value['marca'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12">
                    <div class="form-group">
                      <label>Descripción</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                        <input type="text" class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- ================= PRECIOS / COMPRA ================= -->
            <div class="box box-warning" style="margin-bottom:12px;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-money"></i> Precios & compra</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Precio compra</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                        <input type="text" class="form-control input-lg" id="nuevoPrecioCompra" name="nuevoPrecioCompra" min="0" step="any" placeholder="Precio de compra" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Precio venta</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                        <input type="text" class="form-control input-lg" id="nuevoPrecioVenta" name="nuevoPrecioVenta" min="0" step="any" placeholder="Precio de venta" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Bultos</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                        <input type="number" class="form-control input-lg" id="nuevoBultosCompra" name="nuevoBultosCompra" min="0" step="any" placeholder="Ingrese los bultos" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <div class="form-group">
                      <label>Cantidad por bulto</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-bar-chart-o"></i></span>
                        <input type="number" class="form-control input-lg" id="nuevoCantidadCompra" name="nuevoCantidadCompra" placeholder="Ingrese la cantidad por bulto" min="0" step="any" required>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <!-- ================= STOCK / OBS ================= -->
            <div class="box box-success" style="margin-bottom:12px;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-cubes"></i> Stock & observación</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-4">
                    <div class="form-group">
                      <label>Stock inicial</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                        <input type="number" step="1" class="form-control input-lg" name="nuevoStock" id="nuevoStock" min="0" placeholder="Stock inicial" required>
                      </div>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-8">
                    <div class="form-group">
                      <label>Observación</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                        <input type="text" class="form-control input-lg" id="nuevoObservacion" name="nuevoObservacion" placeholder="Ingrese observación" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ================= IMAGEN ================= -->
            <div class="box box-default" style="margin-bottom:0;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-image"></i> Imagen</h3>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-7">
                    <div class="form-group">
                      <label>Subir imagen</label>
                      <input type="file" class="nuevaImagen" name="nuevaImagen" accept="image/*">
                      <p class="help-block">Peso máximo recomendado 2MB. Formatos jpg / png.</p>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-5">
                    <label>Previsualización</label><br>
                    <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar"
                         style="width:120px;margin-top:5px;">
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-primary">Guardar producto</button>
        </div>

      </form>

      <?php
        $crearProducto=new ControladorProductos();
        $crearProducto->ctrCrearProducto();
      ?>

    </div>
  </div>
</div>



    <!--================================================================
  =                     MODAL EDITAR PRODUCTO                       =
  ===================================================================-->

  <div id="modalEditarProducto" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="formEditarProducto" role="form" method="post" enctype="multipart/form-data">

          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar producto</h4>
            <input type="hidden" id="idProductoEditar" name="idProductoEditar">

          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
          <div class="modal-body">
            <div class="box-body">
              <!--entrada para seleccionar la categoria --> 
              <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                    <select class="form-control input-lg" name="editarCategoria" readonly required>
                    
                      <option id="editarCategoria"></option>

                    </select>

                  </div>
                </div>
              <!--entrada para el código-->
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                    <input type="text" class="form-control input-lg" id="editarCodigo" name="editarCodigo"  readonly required>

                  </div>
                </div>


              <!--entrada para seleccionar la marca --> 
              <div class="form-group">
                  <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
                        <select class="form-control input-lg" name="editarMarca" readonly required>
                        
                         <option id="editarMarca"></option>
                        </select>

                   </div>
                        
              </div>

              <!--entrada para la descripción-->  
                <div class="form-group">
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                    <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required>

                  </div>
                </div>
                              
              





                <!--entrada para el precio de compra-->  
                <div class="form-group row">
                  <div class="col-xs-12 col-sm-6">

                  <label > Precio Compra</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span>
                      <input type="text" class="form-control input-lg" id="editarPrecioCompra" name="editarPrecioCompra" min="0" step="any" required>
                    </div>
                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <!--entrada para el precio de venta-->  

                    
                  <label > Precio Venta</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-arrow-down"></i></span>
                      <input type="text" class="form-control input-lg" id="editarPrecioVenta" name="editarPrecioVenta" min="0" step="any"  required>
                    </div>

                    <br>

                  
                  </div>
                </div>
 
              <div class="form-group row">

                  <div class="col-xs-12 col-sm-6">
                    <label > Bultos</label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-shopping-cart"></i></span>
                      <input type="number" class="form-control input-lg" id="editarBultosCompra" name="editarBultosCompra" min="0" step="any" readonly required>
                    </div>


                  </div>

                  <div class="col-xs-12 col-sm-6">
                    <label > Cantidad Bulto </label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-bar-chart-o"></i></span>
                        <input type="number" class="form-control input-lg" id="editarCantidadCompra" name="editarCantidadCompra" min="0" step="any"  readonly required>
                    </div>
                            

                  </div>


              </div>

                <!--entrada para la stock-->  
                <div class="form-group">
                <label > Stock Inicial</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                    <input type="number" class="form-control input-lg" id="editarStockInicial" name="editarStockInicial" min="0" readonly required>
                        
                  </div>
                </div>


                <!--entrada para la stock-->  
                <div class="form-group">
                <label > Stock Actual</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-cube"></i></span>
                    <input type="number" class="form-control input-lg" id="editarStock" name="editarStock" min="0" readonly required>
                        
                  </div>
                </div>





              <div class="form-group">
                <label > Observacion</label>
                  <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                    <input type="text" class="form-control input-lg" id="editarObservacion" name="editarObservacion"  required>
                        
                </div>
              </div>

              <div class="form-group">
                <div class="panel">IMAGEN ACTUAL</div>
                <input type="file" class="editarImagen" name="editarImagen" accept="image/*">
                <input type="hidden" id="imagenActual" name="imagenActual">
                <p class="help-block">Dejar vacío para mantener la imagen actual.</p>
                <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizarEditar" style="width:100px;margin-top:10px;">
                  <!-- <img src="vistas/img/productos/default/anonymous.png" class="img-thumbnail previsualizar" style="width:100px;margin-top:10p -->
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
          // $editarProducto=new ControladorProductos();
          // $editarProducto->ctrEditarProducto();

        ?>

      </div>

    </div>
  
  </div> 

  <!-- <div class="modal fade" id="modalImagenProducto" tabindex="-1" role="dialog">
  <div class="modal-dialog" style="max-width:600px;">
    <div class="modal-content">
      <div class="modal-body" style="text-align:center;">
        <img src="" id="imagenProductoGrande" class="img-responsive img-thumbnail" style="margin:0 auto;">
      </div>
    </div>
  </div>
</div> -->

<!-- MODAL IMAGEN PRODUCTO -->
<div id="modalImagenProducto" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document"><!-- sin modal-lg -->
    <div class="modal-content modal-imagen-content">
      
      <div class="modal-body">
        <img id="imagenProductoGrande"
             src=""
             class="img-responsive img-zoom-center"
             alt="Imagen del producto">
      </div>

      <div class="modal-footer text-center" style="justify-content:center;">
        <a id="descargarImagenProducto"
           href="#"
           download
           class="btn btn-primary btn-sm">
          <i class="fa fa-download"></i> Descargar imagen
        </a>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
          Cerrar
        </button>
      </div>

    </div>
  </div>
</div>

<!--  MODAL INGRESO STOCK -->
<div id="modalIngresoStock" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

     <form id="formIngresoStock" method="post">


        <div class="modal-header" style="background:#00a65a;color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ingreso de stock (Compra)</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <input type="hidden" name="idProductoIngreso" id="idProductoIngreso">

            <div class="form-group">
              <label>Producto</label>
              <input type="text" id="descProductoIngreso" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label>Stock actual</label>
              <input type="number" id="stockActualIngreso" class="form-control" readonly>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <label>Cajas</label>
                <input type="number" min="0" id="cajasIngreso" name="cajasIngreso" class="form-control" placeholder="Ej: 10">
              </div>
              <div class="col-xs-6">
                <label>Unid. por caja</label>
                <input type="number" min="0" id="unidadesCajaIngreso" name="unidadesCajaIngreso" class="form-control" placeholder="Ej: 24">
              </div>
            </div>

            <div class="form-group" style="margin-top:10px;">
              <label>Cantidad (unidades)</label>
              <input type="number" min="1" id="cantidadUnidadesIngreso" name="cantidadUnidadesIngreso"
                     class="form-control" required placeholder="Se calcula con cajas o ingrésalo manual">
              <small class="help-block">Stock siempre se maneja en unidades. Docenas = unidades / 12.</small>
            </div>

            <div class="row">
              <div class="col-xs-6">
                <label>Costo por docena</label>
                <input type="number" step="0.01" min="0" id="costoDocenaIngreso" name="costoDocenaIngreso"
                       class="form-control" placeholder="Ej: 40.00">
              </div>
              <div class="col-xs-6">
                <label>Moneda</label>
                <select id="monedaIngreso" name="monedaIngreso" class="form-control">
                  <option value="USD">USD ($)</option>
                  <option value="PEN">PEN (S/)</option>
                 
                </select>
              </div>
            </div>

            <div class="form-group" style="margin-top:10px;">
              <label>Observación (opcional)</label>
              <input type="text" class="form-control" id="obsIngreso" name="obsIngreso" placeholder="Ej: compra por caja, lote, etc.">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-success">Registrar ingreso</button>
        </div>

        <?php
          // $ing = new ControladorProductos();
          // $ing->ctrRegistrarIngresoStock();
        ?>

      </form>

    </div>
  </div>
</div>
<!-- MODAL SALIDA STOCK -->
<div id="modalSalidaStock" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

     <form id="formSalidaStock" method="post">


        <div class="modal-header" style="background:#dd4b39;color:white">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Salida de stock</h4>
        </div>

        <div class="modal-body">
          <div class="box-body">

            <input type="hidden" name="idProductoSalida" id="idProductoSalida">

            <div class="form-group">
              <label>Producto</label>
              <input type="text" id="descProductoSalida" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label>Stock actual</label>
              <input type="number" id="stockActualSalida" class="form-control" readonly>
            </div>

            <div class="form-group">
              <label>Cantidad (unidades)</label>
              <input type="number" min="1" id="cantidadUnidadesSalida" name="cantidadUnidadesSalida"
                     class="form-control" required>
            </div>

            <div class="form-group">
              <label>Motivo</label>
              <select id="motivoSalida" name="motivoSalida" class="form-control">
                <option value="MERMA">Merma / fallado</option>
                <option value="DEVOLUCION_PROVEEDOR">Devolución a proveedor</option>
                <option value="AJUSTE">Ajuste inventario</option>
                <option value="OTRO">Otro</option>
              </select>
            </div>

            <div class="form-group">
              <label>Observación (opcional)</label>
              <input type="text" class="form-control" id="obsSalida" name="obsSalida" placeholder="Ej: fallado, roto, devuelto, etc.">
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
          <button type="submit" class="btn btn-danger">Registrar salida</button>
        </div>

        <?php
          // $sal = new ControladorProductos();
          // $sal->ctrRegistrarSalidaStock();
        ?>

      </form>

    </div>
  </div>
</div> 

<!-- MODAL KARDEX -->
<div id="modalKardexProducto" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" style="width: 95%;">
    <div class="modal-content">

      <div class="modal-header" style="background:#00a0d2;color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          Kardex / Movimientos: <span id="kardexTitulo"></span>
        </h4>
      </div>

      <div class="modal-body">
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive" id="tablaKardexProducto" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Motivo</th>
                <th>Cajas</th>
                <th>UPC</th>
                <th>Unid.</th>
                <th>Doc.</th>
                <th>Stock Ant.</th>
                <th>Stock Nuevo</th>
                <th>Costo Doc.</th>
                <th>Moneda</th>
                <th>Usuario</th>
                <th>Obs.</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>




  <?php
          $eliminarProducto=new ControladorProductos();
          $eliminarProducto->ctrEliminarProducto();

  ?>