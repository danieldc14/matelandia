<?php
require('../fpdf181/fpdf.php');
$sql1=$_GET['idusuario'];

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
//    $this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
  //  $this->Cell(30,10,'Reporte',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
}
}
require('../config/Conexion.php');
$sql="SELECT * FROM usuario where idusuario=$sql1";
$resultado=$cn->query($sql);


$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

while($row = $resultado->fetch_assoc())
{
	$pdf->Cell(90 , 10, $row['nombre'], 1, 0, 'c', 0);
	$pdf->Cell(20 , 10, $row['curso'], 1, 1, 'c', 0);
}

$pdf->Output();
?>