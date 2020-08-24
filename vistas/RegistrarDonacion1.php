<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"]))
{
  header("Location: login.php");
}
else
{
require 'header.php';

if ($_SESSION['cursos']==1)
{
?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <style>
      
.panel-body {
  /* height: 480px; */
  height: calc(100vh - 325px);
  overflow-y: auto; 
}
.modal-body {
  /* height: 480px; */
  height: calc(100vh - 325px);
  overflow-y: auto; 
}
      </style>
      <div class="content-wrapper">        
        <!-- Main content -->
        <section class="content" >
            <div class="row" >
              <div class="col-md-12">
                  <div class="box"style="height: 600px;">
                    <div class="box-header with-border" >
                       
                          <h1>Asignación de Cursos</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="panel-body" style="height: 500px;">
                        
                                <form name="formulario" id="formulario" method="POST" enctype="multipart/form-data">
                             
                         
                        
                          
                             <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Periodo Lectivo*:</label>
                            
                            <input type="text" class="form-control" name="periodo" id="periodo"maxlength="100" placeholder="Periodo Lectivo" >
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nivel Academico:</label>
                            <select class="form-control select-picker" name="academico"  id="academico" >
                             <option value="primaria">Primaria</option>
                              <option value="secundaria">Secundaria</option>
                            
                              
                            </select>
                          </div>
                         
                          
                           <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Docente Asignado(*):</label>
                            <select id="profesor" name="profesor" class="form-control selectpicker" data-live-search="true" data-size="4"></select>
				                    </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Curso*:</label>
                           <select id="curso" name="curso" class="form-control selectpicker" data-live-search="true" data-size="4"></select>
                          </div>
                          
                          
                          
                          

                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            
                          </div>
                          <div id="result-username" class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
						  </div>
                        </form>
                               
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Seleccione un Artículo</h4>
        </div>
        <div class="modal-body">
          <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Stock</th>
               
            </thead>
            <tbody>
              
            </tbody>
            <tfoot>
               <th>Opciones</th>
                <th>Nombre</th>
                <th>Stock</th>
               
            </tfoot>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button"class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>        
      </div>
    </div>
  </div>  
  <!-- Fin modal -->
<?php
}
else
{
  require 'noacceso.php';
}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/venta1.js"></script>
<?php 
}
ob_end_flush();
?>
