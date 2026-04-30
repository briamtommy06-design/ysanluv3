 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar ventas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active"> Administrar ventas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="box">
        <div class="box-header with-border">
            <a href="crear-venta">
              <button class="btn btn-primary">
                Agregar venta
              </button>
            </a>
           
            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> Rango de fechas
                    </span>
                    <i class="fa fa-caret-down"></i>
            </button>
            
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablaAdministrarVentas">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Codigo factura</th>
                <th>Cliente</th>

                <th>Forma de pago</th>
                <th>Estado</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>                
              </tr>
            </thead>
           
          </table>
              <!-- <?php

              $eliminarVenta = new ControladorVentas();
              $eliminarVenta -> ctrEliminarVenta();

              ?> -->
        </div>

    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
