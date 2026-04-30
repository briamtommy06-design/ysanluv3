<header class="main-header">
<!-- LOGOTIPO-->


<a href="inicio" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SYS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>YSANLU </b>SYS</span>
</a>

<nav class="navbar navbar-static-top" role="navigation">
      <!-- Boton de navegacion -->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <!-- <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> -->

      </a>

       <!-- Perfil de usuario -->

       <div class="navbar-custom-menu" >
        <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php 
                    if( $_SESSION['foto'] != ''){
                        echo '<img src="'.$_SESSION['foto'].'" class="user-image" >';
             
                    }else{
                        
                        echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image" >';
                            
                    }
                ?>
           
             <span class="hidden-xs"><?php echo $_SESSION['nombre'] ?></span>
            </a> 


            <ul class="dropdown-menu">
                <li class="user-body">
                    
                <div class="pull-right">
                    <a href="salir" class="btn btn-default btn-flat">Salir</a>
                    </div>
                    
                </li>
             </ul>

            </li>

        </ul>
       </div>

        <!-- DropdownTogle -->

        
</nav>

</header>