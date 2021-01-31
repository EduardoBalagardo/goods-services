<?php
/**
 * Description of PDF
 *
 * @author CIL HR
 */
require_once './fpdf17/fpdf.php';

class PDF  extends FPDF{
 function Header(){

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 7);
    $pdf->SetFillColor(252, 252, 253);
    $pdf->SetY(15);
    $pdf->SetX(10);
    $pdf->Cell(25, 6, "Descripcion: ", 0, 'L', 1);
    $pdf->SetX(36);
    $pdf->Cell(25, 6, "RESUMEN DE NOMINA POR EMPLEADO Y CONCEPTO", 0, 'L', 1);
    $pdf->SetX(130);
    $pdf->Cell(25, 6, "Reporte: ", 0, 'L', 1);
    $pdf->SetX(146);
    $pdf->Cell(25, 6, "RepNomin ", 0, 'L', 1);
    //segundo renglon
    $pdf->SetY(19);
    $pdf->SetX(10);
    $pdf->Cell(25, 6, 'utf8_decode("Razón Social: ")', 0, 'L', 1);
    $pdf->SetX(36);
    $pdf->Cell(25, 6, 'utf8_decode("$row[razonsocial]")', 0, 'L', 1);
    $pdf->SetX(130);
    $pdf->Cell(25, 6, "Fecha: " . date('Y-d-m/h:m:s'), 0, 'L', 1);
    //tercero
    $pdf->SetY(23);
    //obtencion de periodos
    //$row = $newResNomin->getPeriodoFechas(231);
    //conversion de fechas Date a String PHP
    //$fechaInicio = substr($row["FechaInicio"]->format('d-m-Y H:i:s'), 0, 10);
    //$fechaFinal = substr($row["FechaFin"]->format('d-m-Y H:i:s'), 0, 10);
    $pdf->SetY(23);
    $pdf->SetX(10);
    $pdf->Cell(25, 6, 'utf8_decode("Periodo de Nomina: ")', 0, 'L', 1);
    $pdf->SetX(46);
    $pdf->Cell(25, 6, 'utf8_decode("$row[Nombre]")', 0, 'L', 1);
    $pdf->SetX(100);
    $pdf->Cell(25, 6, " Del  " . '$fechaInicio' . " al " . '$fechaFinal', 0, 'L', 1);
    $pdf->SetLineWidth(0.1);
    $pdf->Line(10, 30, 194, 30);
    ///HEADERS 
    $pdf->SetY(30);
    $pdf->SetFont('helvetica', 'b', 8);
    $pdf->SetMargins(0, 0);
    $pdf->SetFillColor(255, 235, 242);
    $pdf->SetX(10);
    $pdf->Cell(10, 4, 'Clave', 1, 0, 'L', 1);
    $pdf->SetX(20);
    $pdf->Cell(40, 4, 'Concepto', 1, 0, 'L', 1);
    $pdf->SetX(60);
    $pdf->Cell(18, 4, 'Importe', 1, 0, 'L', 1);
    $pdf->SetX(78);
    $pdf->Cell(11, 4, 'Dias', 1, 0, 'L', 1);
    $pdf->SetX(89);
    $pdf->Cell(10, 4, 'Horas', 1, 0, 'L', 1);
    //Hardcode Small Second Headers
    $pdf->SetMargins(0, 0);
    $pdf->SetFillColor(255, 235, 242);
    $pdf->SetX(105);
    $pdf->Cell(10, 4, 'Clave', 1, 0, 'L', 1);
    $pdf->SetX(115);
    $pdf->Cell(40, 4, 'Concepto', 1, 0, 'L', 1);
    $pdf->SetX(155);
    $pdf->Cell(18, 4, 'Importe', 1, 0, 'L', 1);
    $pdf->SetX(173);
    $pdf->Cell(11, 4, 'Dias', 1, 0, 'L', 1);
    $pdf->SetX(184);
    $pdf->Cell(10, 4, 'Horas', 1, 0, 'L', 1);
    $pdf->Ln(20);
}

//Page footer
function Footer(){
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();
?>
