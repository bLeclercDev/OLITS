<?php
require('fpdf\fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','I',16);//fpdf.org/fr/doc/setfont.htm
//$pdf->Image('Arial','I',16);// fpdf.org/en/doc/image.htm
$pdf->Cell(110,10,'Hedfsdfd !'); // fpdf.org/fr/doc/cell.htm
$pdf->Output(); // affiche le pdf

?>