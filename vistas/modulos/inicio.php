 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small>Informacion</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Tablero</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
          <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="totalProductos">15</h3>

                <p>Productos</p>
              </div>
              <div class="icon">
                <i class="ion ion-clipboard"></i>
              </div>
              <a href="productos" class="small-box-footer">Mas Info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- TARJETA TOTAL VENTAS -->
          <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="totalClientes">S./ 1,200.00</h3>

                <p>Clientes</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-cart"></i>
              </div>
              <a href="clientes" class="small-box-footer">Mas Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- TARJETA TOTAL VENTAS DIA ACTUAL -->
          <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3 id="totalVentasHoy">S./ 250.00</h3>

                <p>Ventas del día</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-calendar"></i>
              </div>
              <a href="ventas" class="small-box-footer">Mas Info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
      </div>

      <div class="row">
      <div class="col-lg-6">
          <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title">Pedidos no enviados</h3>
                  <div class="box-tools">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
                  <div class="table-responsive">
                      <table class="table" id="tbl_estado_ventas">
                          <thead>
                              <tr class="text-danger">
                                  <th>Nota pedido</th>
                                  <th>Cliente</th>
                                  <th>Fecha</th>
                                  <th>Estado</th>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-lg-6">
          <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title">Ranking Clientes</h3>
                  <div class="box-tools">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
              </div>
              <div class="box-body">
                  <div class="table-responsive">
                      <table class="table" id="tbl_top_cliente">
                          <thead>
                              <tr class="text-danger">
                                  <th>Nombre</th>
                                  <th>Ciudad</th>
                                  <th>Compras</th>
                                  <th>Ultima compra</th>
                              </tr>
                          </thead>
                          <tbody>

                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>


      </div>

      


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
