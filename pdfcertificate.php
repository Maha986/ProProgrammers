<?php 
require ("fpdf/fpdf.php");
$pdf=new FPDF('L','mm','A4');
$pdf->AddPage();
$pdf->Image('http://localhost/Web_Engineering/webproj/certificate.php',0,0,420,297,'jpg');
// $pdf->Image('https://proprogrammers.azurewebsites.net/certificate.php',0,0,300,210,'jpg');
$pdf->Output();
?>