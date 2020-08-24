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
if ($_SESSION['ventas']==1)
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




                    <script src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<style> #map { width: 25%; height: 300px; border: 1px solid #d0d0d0; } </style> 
<script> 
function localize() { 
if (navigator.geolocation) { 
navigator.geolocation.getCurrentPosition(mapa,error); 
} else { 
alert('Tu navegador no soporta geolocalizacion.'); 
} 
} 
function mapa(pos) { /************************ Aqui están las variables que te interesan***********************************/ 
var latitud = pos.coords.latitude; 
var longitud = pos.coords.longitude; 
var precision = pos.coords.accuracy; 
var contenedor = document.getElementById("map") 

document.getElementById("lti").innerHTML=latitud;
document.getElementById("lgi").innerHTML=longitud;  
document.getElementById("psc").innerHTML=precision; 

var centro = new google.maps.LatLng(latitud,longitud); 
var propiedades = { zoom: 15, center: centro, mapTypeId: google.maps.MapTypeId.ROADMAP }; 
var map = new google.maps.Map(contenedor, propiedades); 
var marcador = new google.maps.Marker({ position: centro, map: map, title: "Tu posicion actual" }); 
} 


function error(errorCode) { 
if(errorCode.code == 1) 
  alert("No has permitido buscar tu localizacion") 
else if (errorCode.code==2) 
  alert("Posicion no disponible") 
else 
  alert("Ha ocurrido un error") 
} 
</script> 

</head> 
<body onLoad="localize()"> 

<h1>Mi Ubicación</h1>
<p>Latitud: <span id="lti"></span></p>
<p>Longitud: <span id="lgi"></span></p>
<p>Precisi&oacute;n: <span id="psc"></span></p> 
<div id="map" ></div> 
</body> 

                   
                    </div>
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
<script type="text/javascript" src="scripts/cliente.js"></script>
<?php 
}
ob_end_flush();
?>