<div class="content-wrapper">

    <section class="content-header">

        <h1>
            Administrar Emisor     
        </h1>


        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active"> Administrar Emisor</li>
        </ol>
    
    </section>
    <!-- CONTENIDO -->

    <section class="content">

        <div class="box">

            <div class="box-header with-border">

                <button class="btn btn-primary" data-toggle="modal" data-target= "#modalAgregarEmisor">
                Agregar Emisor           
                </button>

            </div>

                <div class="box-body">

                    <table class="table table-bordered table-striped dt-responsive tablas">

                        <thead>

                            <tr>
                            <th style="width:10px">#</th>
                            <th>RUC</th>
                            <th>Nombre Comercial</th>
                            <th>Dirección</th>
                            <th>Ciudad</th>
                            <th>Total Boleta</th>
                            <th>Última Boleta</th>
                            <th>Ingreso al sistema</th>
                            <th>Acciones</th>
                            </tr>

                        </thead>

                        <tbody>


                        
                        </tbody>

                    </table>

                 </div>

        </div>

        

    </section>

</div>

<!-- 
MODAL AGREGAR EMISOR 
-->


  <!--================================================================
  =                     MODAL AGREGAR PRODUCTO                       =
  ===================================================================-->

  <div id="modalAgregarEmisor" class="modal fade" role=dialog>
    
    <div class="modal-dialog">
      <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">
          <!--================================================================
          =                     CABEZA DEL MODAL                           =
          ===================================================================-->
          <div class="modal-header" style="background:#3c8dbc;color:white">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Emisor</h4>
          </div>
          <!--================================================================
          =                     CUERPO DEL MODAL                           =
          ===================================================================-->
        
        <div class="modal-body">
            
            <div class="box-body">
                 
                <!--ENTRADA PARA EL RUC--> 
        
                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoRuc" name="nuevoRuc" placeholder="Ingresar RUC" required>
                      
                        
                    </div>

                </div>


                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoRazon_social" name="nuevoRazon_social" placeholder="Ingresar razon social" required>

                    </div>

                </div>

                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoNombre_comercial" name="nuevoNombre_comercial" placeholder="Ingresar Nombre Comercial" required>

                    </div>

                </div>

                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoDireccion" name="nuevoDireccion" placeholder="Ingresar Dirección" required>

                    </div>

                </div>

                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoUbigeo" name="nuevoUbigeo" placeholder="Ingresar ubigeo" required>

                    </div>

                </div>

                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoDepartamento" name="nuevoDepartamento" placeholder="Ingresar Departamento" required>

                    </div>

                </div>

                
                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoProvincia" name="nuevoProvincia" placeholder="Ingresar Provincia" required>

                    </div>

                </div>


                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoDistrito" name="nuevoDistrito" placeholder="Ingresar Distrito" required>

                    </div>

                </div>


                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoPais" name="nuevoPais" placeholder="Ingresar Pais" required>

                    </div>

                </div>

                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="text" class="form-control input-lg" id="nuevoUsuario_secundario" name="nuevoUsuario_secundario" placeholder="Ingresar Usuario Secundario" required>

                    </div>

                </div>

                
                <div class="form-group">
                    
                    <div class="input-group">
                    
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        
                        <input type="password" class="form-control input-lg" id="nuevoClave_usuario_secundario" name="nuevoClave_usuario_secundario" placeholder="Ingresar Clave Usuario" required>

                    </div>

                </div>

                <div class="form-group">

                    <div class="panel"> SUBIR CERTIFICADO DIGITAL</div>

                        <input type="file" class="nuevoCertificado" name="editarCertificado">


                </div>

            </div>

        </div>

        
            <!--================================================================
                =                     PIE DEL MODAL                           =
            ===================================================================-->
            <div class="modal-footer ">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

                <button type="submit" class="btn btn-primary">Guardar emisor</button>
            </div>


        </form>  

        <?php
         // $crearEmisor=new ControladorProductos();
          //$crearEmisor->ctrCrearProducto();

        ?>

      </div>

    </div>
  
  </div> 

