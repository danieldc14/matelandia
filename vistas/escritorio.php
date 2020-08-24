<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{
require 'header.php';

if ($_SESSION['escritorio']==1)
{
  require_once "../modelos/Consultas.php";
  

?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->

      <head>
<link href="../public/css/estilos.css" rel="stylesheet" type="text/css" media="screen" />
</head> 
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                      <center>
                         <img src="../public/img/logo.png" width="550" height="450">
               
 <section id="acerca-de">
        <div class="contenido-seccion">
            <div class="container">
                <div class="col-md-6">
                    <div class="texto-acerca-de">
                        <h3>"El éxito es el resultado de todos los esfuerzos diarios"</h3>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
                            <div class="container">
 
</div>


              <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                   
                    
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>

<script src="../public/js/chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script> 
<script type="text/javascript">



<?php 
}
ob_end_flush();
?>


