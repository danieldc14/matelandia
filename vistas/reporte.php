<?php


include ("../config/Conexion.php");
//include("count.php");
$usuarios = "select c.nombre as nombrecurso, c.id as idcursos, count(u.nombre) from cursos c left join usuario u on c.id=curso where cargo ='Estudiante' group by curso";
//query nuevo 


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
if ($_SESSION['acceso']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h4 class="box-title">Reporte</h4>
                          <br/>
                      
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
   

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <title>Reporte</title>
  </head>
  <body>
    <!--tabla-->
    <br>
    <center>
      <table class="table table-bordered">
  <thead>
    <tr>
     
      <th scope="col">Grados</th>
      <th scope="col">Información</th>
      <th scope="col">Reporte</th>
    </tr>
  </thead>
  <tbody>
   

    <?php $resultado=mysqli_query($conexion,$usuarios);
    while($row=mysqli_fetch_assoc($resultado)){
    ?>
    <tr>
 
      <td><?php echo $row["nombrecurso"];?></td>
      <td><?php echo "Cantidad de Estudiantes Registrados: "; echo $row['count(u.nombre)'];?></td>
    

     <td> <a href="reportepdf.php?curso=<?php echo $row["idcursos"];?>" target="_blank" class="btn btn-primary" >Descargar</a></td>


    </tr>
      <?php } ?>
  </tbody>
</table>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
  </body>
</html>

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


<?php 
}
ob_end_flush();
?>