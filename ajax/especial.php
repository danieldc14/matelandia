<?php 
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesi贸n
}
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../vistas/login.php");//Validamos el acceso solo a los usuarios logueados al sistema.
}
else
{
//Validamos el acceso solo al usuario logueado y autorizado.
if ($_SESSION['cambio']==1)
{
require_once "../modelos/Especial.php";

$venta=new Venta();


$idusuario1=$_SESSION["idusuario"];

$clave=isset($_POST["pass1"])? limpiarCadena($_POST["pass1"]):"";



switch ($_GET["op"]){
	case 'guardaryeditar':
			$clavehash=hash("SHA256",$clave);
			if (empty($idusuario)){
					$rspta=$venta->insertar($clavehash,$idusuario1);
					echo $rspta ? "Contraseña Actualizada" : "No se pudo actualizar la contraseña";
				}
				else {
					
				}
	break;

	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "Donacion anulada" : "Donacion no se puede anular";
	break;

	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $venta->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
                                   
                                    <th>Articulo</th>
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
 			if($reg->tipo_comprobante=='Ticket'){
 				$url='../reportes/exTicket.php?id=';
 			}
 			else{
 				$url='../reportes/exFactura.php?id=';
 			}

 			$data[]=array(
 				"0"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'),
 				"1"=>$reg->fecha,
 				"2"=>$reg->cliente,
 				"3"=>$reg->usuario,
 				"4"=>$reg->tipo_comprobante, 				
 				"5"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
 				'<span class="label bg-red">Pendiente</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Informaci贸n para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

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
	case 'selectGrupo':
		

		$rspta = $venta->listaGrup();

		while ($reg = $rspta->fetch_object())
				{
			echo '<option value=' . $reg->idciudadela . '>' . $reg->nombre . ' </option>';
				}
	break;
	
    case 'mostrar1':
		$rspta=$venta->mostrar1($num_documento);
 		echo json_encode($rspta);
	break;
	
	
	case 'listarArticulosVenta':
		require_once "../modelos/Articulo.php";
		$articulo=new Articulo();

		$rspta=$articulo->listarActivosVenta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idarticulo.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->nombre,
 				"2"=>$reg->stock,
 				"3"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px' >",
 				"4"=>$reg->categoria,
 				"5"=>$reg->codigo
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Informaci贸n para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
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