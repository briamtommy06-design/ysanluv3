 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrar ventas
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
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
        </div>
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive tablas">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Código factura</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Forma de pago</th>
                <th>Neto</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>                
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>1000123</td>
                <td>Juan Villegas</td>
                <td>Julio Gómez</td>
                <td>TC-12412425346</td>
                <td>$ 1,000.0</td>
                <td>$ 1,190.0</td>
                <td>2017-12-11 12:08:34</td>
                
                <td>
                  <div class="btn-group">
                    <button class="btn btn-info"><i class="fa fa-print"></i></button>
                    <button class="btn btn-danger"><i class="fa fa-times"></i></button>
                  </div>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>

    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
