<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$idarticulo,$cantidad,$precio_venta,$descuento)
	{   
		
		$sqlsp="CALL SP_VERIFICA_AYUDA_BENEFICIARIO ($idcliente)";
		require_once "../config/global.php";
        $conexion = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $conexion, 'SET NAMES "'.DB_ENCODE.'"');
		$query = $conexion->query($sqlsp);
		while($row=$query->fetch_assoc()){
			$id=$row['Prueba'];
			if($id==1){
				echo("Ya se le asigno ayuda al beneficiario ");
			}else if($id==0) {
                     $sqlp=" CALL SP_VERIFICA_FECHA_ENTREGA_NULL ($idcliente)";
		             require_once "../config/global.php";
                     $conexion5 = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
                     mysqli_query( $conexion5, 'SET NAMES "'.DB_ENCODE.'"');
		             $query5 = $conexion5->query($sqlp);
		             while($row5=$query5->fetch_assoc()){
					         $id4=$row5['id'];
							 if($id4==0){
								 
								 $sqlp1=" select * from persona where idpersona='$idcliente'";
								 require_once "../config/global.php";
								 $conexion6 = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
								 mysqli_query( $conexion6, 'SET NAMES "'.DB_ENCODE.'"');
								 $query6 = $conexion6->query($sqlp1);
								 while($row6=$query6->fetch_assoc()){
									 $sector=$row6['sector'];
									 $sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
									  VALUES ('$idcliente','$idusuario','$tipo_comprobante','$sector','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Pendiente')";
									  //return ejecutarConsulta($sql);
									  $idventanew=ejecutarConsulta_retornarID($sql);
									  $sql2="update persona set Recibe_ayuda=1 where idpersona='$idcliente'";
									  ejecutarConsulta($sql2);
									 $num_elementos=0;
									 $sw=true;
									 while ($num_elementos < count($idarticulo))
										 {
											$sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
											ejecutarConsulta($sql_detalle) or $sw = false;
											$num_elementos=$num_elementos + 1;
										 }
										  return $sw;
							        }
							 }else if($id4==1){
								 $sqlp="select * from persona where idpersona='$idcliente'";
		             require_once "../config/global.php";
                     $conexion4 = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
                     mysqli_query( $conexion4, 'SET NAMES "'.DB_ENCODE.'"');
		             $query4 = $conexion4->query($sqlp);
		             while($row4=$query4->fetch_assoc()){		 
					 $fecha_actual=date("Y-m-d");
			         $duracion=$row4['duracion_kit'];
			         $fecha_entrega=$row4['fecha_entrega'];
			         $fecha_actual=date("Y-m-d");
	                 $array=explode("-",$fecha_actual);
		             $d1=$array[2];
                     $array1=explode("-",$fecha_entrega);				 
			         $d2=$array1[2];
				     $resta=$d2-$d1;
				     if ($resta>=$duracion){
						         $sqlp2=" select * from persona where idpersona='$idcliente'";
								 require_once "../config/global.php";
								 $conexion7 = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
								 mysqli_query( $conexion7, 'SET NAMES "'.DB_ENCODE.'"');
								 $query7 = $conexion7->query($sqlp2);
								 while($row7=$query7->fetch_assoc()){
									 $sector1=$row7['sector'];
									 $sql="INSERT INTO venta (idcliente,idusuario,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,estado)
									   VALUES ('$idcliente','$idusuario','$tipo_comprobante','$sector1','$num_comprobante','$fecha_hora','$impuesto','$total_venta','Pendiente')";
									   //return ejecutarConsulta($sql);
									   $idventanew=ejecutarConsulta_retornarID($sql);
									   $sql2="update persona set Recibe_ayuda=1 where idpersona='$idcliente'";
									   ejecutarConsulta($sql2);
									   $num_elementos=0;
									   $sw=true;
									   while ($num_elementos < count($idarticulo))
									  {
									   $sql_detalle = "INSERT INTO detalle_venta(idventa, idarticulo,cantidad,precio_venta,descuento) VALUES ('$idventanew', '$idarticulo[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";
									   ejecutarConsulta($sql_detalle) or $sw = false;
									   $num_elementos=$num_elementos + 1;
									  }
									 return $sw;
								}
				          }else {
					        echo("El beneficiario aun posee kit ");
				        }
		            }
				}
					 
			}
		}
	}
}
	//Implementamos un método para anular la venta
	public function anular($idventa)
	{
		$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,g.grupo_entrega as tipo_comprobante ,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN grupo_entrega g on v.tipo_comprobante=g.id WHERE v.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idventa)
	{
		$sql="SELECT dv.idventa,dv.idarticulo,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal FROM detalle_venta dv inner join articulo a on dv.idarticulo=a.idarticulo where dv.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,g.grupo_entrega as tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado FROM venta v INNER JOIN grupo_entrega g on v.tipo_comprobante=g.id INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario  ORDER by v.idventa desc";
		return ejecutarConsulta($sql);		
	}

	public function ventacabecera($idventa){
		$sql="SELECT v.idventa,v.idcliente,p.nombre as cliente,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,v.idusuario,u.nombre as usuario,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,date(v.fecha_hora) as fecha,v.impuesto,v.total_venta FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN usuario u ON v.idusuario=u.idusuario WHERE v.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}

	public function ventadetalle($idventa){
		$sql="SELECT a.nombre as articulo,a.codigo,d.cantidad,d.precio_venta,d.descuento,(d.cantidad*d.precio_venta-d.descuento) as subtotal FROM detalle_venta d INNER JOIN articulo a ON d.idarticulo=a.idarticulo WHERE d.idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
	public function listaGrup()
	{
		$sql="SELECT * FROM grupo_entrega";
		return ejecutarConsulta($sql);		
	}
	
}
?>