<?php
require('../fpdf181/fpdf.php');
$sql1=$_GET['curso'];

class PDF extends FPDF
{
// Page header
function Header()
{

    // Logo
    
   $this->Image('../public/img/logo.png',18,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Reporte de Estudiantes',20,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',7);
    // Page number
    $this->Cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}
require('../config/Conexion.php');
$sql="SELECT u.nombre as nombreusuario, num_documento, direccion, c.nombre as nombrecurso, cargo FROM usuario u left join cursos c on c.id = curso where cargo='Estudiante' and curso=$sql1";
$resultado=$conexion->query($sql);


$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',10);
    $pdf->Cell(40 , 10,'Nombre', 1, 0, 'C', 0);
    $pdf->Cell(30 , 10, utf8_decode('Cédula'), 1, 0, 'C', 0);
    $pdf->Cell(70 , 10, utf8_decode('Dirección'), 1, 0, 'C', 0);
    $pdf->Cell(15 , 10,'Curso', 1, 1, 'C', 0);
while($row = $resultado->fetch_assoc())
{
	$pdf->Cell(40 , 10, $row['nombreusuario'], 1, 0, 'C', 0);
    $pdf->Cell(30 , 10, $row['num_documento'], 1, 0, 'C', 0);
     $pdf->Cell(70 , 10, $row['direccion'], 1, 0, 'C', 0);
	$pdf->Cell(15 , 10, $row['nombrecurso'], 1, 1, 'C', 0);
}

$pdf->Output();
?>