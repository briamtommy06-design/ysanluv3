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
      
    

      <div class="box">

      
    <div class="container-fluid">

        <!-- row para criterios de busqueda -->
        <div class="row">
       
          <div class="card card-info">
              <div class="card-header">
                  <h3 class="card-title">CRITERIOS DE BÚSQUEDA</h3>
  
              </div> <!-- ./ end card-header -->
              
              <div class="card-body">

              <div class="card-body">
            
                <form class="form-inline">

                  <div class="form-group mr-2">
                    <label for="serie">Serie Pedido:</label>
                    <input type="text" id="iptSeriePedido" class="form-control" data-index="0">
                  </div>
                  
                  <div class="form-group mr-2">
                    <label for="cliente">Cliente:</label>
                    <input type="text" id="iptNombreCliente" class="form-control" data-index="1">
                  </div>

                  <div class="form-group mr-2">
                    <label for="codigo">Código:</label>
                    <input type="text" id="iptCodigoBarras" class="form-control" data-index="3">
                  </div>

                </form>
              
              </div>



          </div>  

        </div>


    </div>



      <div class="box-header with-border">
      <button id="exportar-excel" class="btn btn-primary"><i class="fas fa-file-excel"></i> Exportar a Excel</button>
   
      </div>
        
        <div class="box-body">
            
          <table class="table table-bordered table-striped dt-responsive tablareportes"  widht="100%">
            
            <thead>
                    <tr>
                      <th style="width:30px">Num Nota </th>
                      <th style="width:30px">Nombre Cliente</th>
                      <th>Codigo</th>
                      <th>Descripcion</th>
                      <th style="width:30px">Cantidad</th>
                      <th style="width:30px">Precio</th>
                      <th style="width:30px">Importe</th>
                      <th>Fecha</th>

                    </tr>
              </thead>
                        
          </table>
        </div>

      </div>




    </section>

</div>