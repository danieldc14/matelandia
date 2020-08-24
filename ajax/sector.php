<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../vistas/login.php");//Validamos el acceso solo a los usuarios logueados al sistema.
}
else
{
//Validamos el acceso solo al usuario logueado y autorizado.
if ($_SESSION['cursos']==1)
{
require_once "../modelos/Sector.php";

$venta=new Venta();
$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

$precio_venta=0;


switch ($_GET["op"]){
	case 'guardaryeditar':
		
			$rspta=$venta->insertar($nombre,$descripcion);
			echo $rspta ? "Curso creado" : "No se pudieron registrar todos los datos del curso";
	
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Donacion anulada" : "Donacion no se puede anular";
	break;
    case 'selectbodega':
		

		$rspta = $venta->listarB($grupo);

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->idbodega . '>' . $reg->nombre . '</option>';
				}
	break;
	case 'mostrar':
		$rspta=$venta->mostrar($id);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                    
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td>'.$reg->nombre.'</td><td>'.$reg->cantidad.'</td></tr>';
					$total=$total+($reg->precio_venta*$reg->cantidad-$reg->descuento);
				}
		
	break;

	case 'listar':
		$rspta=$venta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			

 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id.')"><i class="fa fa-eye"></i></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->descripcion,
 				"3"=>$reg->estado
 				
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case 'selectGrupo':
		
        echo '<option value="0">Seleccione:</option>';
		$rspta = $venta->listaGrup();

		while ($reg = $rspta->fetch_object())
				{
				
				echo '<option value=' . $reg->id . '>' . $reg->grupo_entrega . '</option>';
				}
	break;

	case 'selectCliente':
		require_once "../modelos/Persona.php";
		$persona = new Persona();

		$rspta = $persona->listarC();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value="0">Seleccione:</option>';
				echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
				}
	break;

	
	case "selectCategoria":
		
		

		$rspta = $persona->select();
         echo '<option value="0">Seleccione:</option>';
		while ($reg = $rspta->fetch_object())
				{
				   
					echo '<option value=' . $reg->idciudadela . '>' . $reg->nombre . ' </option>';
				}
	break;
}
//Fin de las validaciones de acceso
}
else
{
  require 'noacceso.php';
}
}
ob_end_flush();
?>