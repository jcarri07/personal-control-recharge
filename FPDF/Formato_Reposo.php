<?php

require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',16,0,256);
    //$this->Image('img/logoabae.jpg',16,16,13);
    $this->SetFont('Arial','B',16);
    $this->setXY(16,16);
    $this->MultiCell(180,8,utf8_decode('NOTIFICACIÓN DE REPOSO MÉDICO Y/O CERTIFICADO DE INCAPACIDAD'),0,'C');
    // cell(ancho, largo, contenido,borde?, salto de linea?)
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-35);
    // Arial italic 8
    $this->SetFont('Arial','',6);
    // Número de página
    $this->SetX(95);
    $this->SetFillColor(0, 0, 0);
    $this->Cell(98,5,'ABAE-FO-002-2016',0,0,'R',0);

}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();//hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage();//añade la pagina / en blanco
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,20);//salto de pagina automatico
$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,8,utf8_decode('Fecha de Solicitud:                        '),'B',1,'R',0);


$pdf->SetX(16);
$pdf->SetFillColor(198, 217, 241);//color de fondo rgb
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetDrawColor(0, 0, 0);//color de linea  rgb
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,8,'DATOS DEL TRABAJADOR','1',1,'C',1);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,'Nombre y Apellido:','1',0,'C',0);
$pdf->Cell(60,8,'Cedula de Identidad:','1',0,'C',0);
$pdf->Cell(60,8,'Cargo:','1',1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,8,'','1',0,'C',0);
$pdf->Cell(60,8,'','1',0,'C',0);
$pdf->Cell(60,8,'','1',1,'C',0);


$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,utf8_decode('Unidad de Adscripción:'),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode('Supervisor Inmediato:'),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode('Cargo:'),'1',1,'C',0);
$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(60,8,'','1',0,'C',0);
$pdf->SetX(76);
$pdf->Cell(60,8,'','1',0,'C',0);
$pdf->Cell(60,8,'','1',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('N° DE DÍAS DE REPOSO'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetX(16);
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,24,utf8_decode($pdf->Image('img/Cuadro.jpeg',20,97,5)."De 1 hasta 3 Días"),'1',0,'C',0);
$pdf->Cell(60,24,utf8_decode('Cantidad de Días Exactos:'),'1',0,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,8,utf8_decode('DESDE:'),'LRT',0,'C',0);
$pdf->Cell(30,8,utf8_decode('HASTA:'),'LRT',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(136);
$pdf->Cell(30,8,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
$pdf->Cell(30,8,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);

$pdf->SetX(136);
$pdf->Cell(30,8,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,8,utf8_decode(''),'LRB',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,24,utf8_decode($pdf->Image('img/Cuadro.jpeg',20,121,5)."Superior a 3 Días"),'1',0,'C',0);
$pdf->Cell(60,24,utf8_decode('Cantidad de Días Exactos:'),'1',0,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,8,utf8_decode('DESDE:'),'LRT',0,'C',0);
$pdf->Cell(30,8,utf8_decode('HASTA:'),'LRT',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(136);
$pdf->Cell(30,8,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
$pdf->Cell(30,8,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);

$pdf->SetX(136);
$pdf->Cell(30,8,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,8,utf8_decode(''),'LRB',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('TRABAJADOR:'),'1',0,'L',0);
$pdf->Cell(90,8,utf8_decode('SUPERVISOR INMEDIATO:'),'1',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(90,20,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(90,20,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',0,'L',0);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',1,'L',0);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('SOLO PARA USO DE RECURSOS HUMANOS'),'1',1,'C',1);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('RECIBIDO POR:'),'1',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(90,20,utf8_decode(''),'LR',0,'C',0);
$pdf->Cell(90,20,utf8_decode(''),'LR',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',0,'L',0);

$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FECHA:'),'LRB',1,'L',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('OBSERVACIONES: '),'LRT',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(180,4,'','LR',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(9,8,$pdf->Image('img/Cuadro.jpeg',20,229,5),'L',0,'C',0);
$pdf->Cell(171,8,utf8_decode('No aplica validación por parte del IVSS (solo aplica para casos de aquellos reposos hasta 3 dias)'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,8,''.$pdf->Image('img/Cuadro.jpeg',20,237,5),'L',0,'L',0);
$pdf->Cell(171,8,utf8_decode('Reposo validado IVSS'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,8,''.$pdf->Image('img/Cuadro.jpeg',20,245,5),'L',0,'L',0);
$pdf->Cell(171,8,utf8_decode('Por validar ante el IVSS'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,8,''.$pdf->Image('img/Cuadro.jpeg',20,253,5),'LB',0,'L',0);
$pdf->Cell(171,8,utf8_decode('Reposo Extemporáneo'),'BR',1,'L',0);

// cell(ancho, largo, contenido,borde?, salto de linea?)


$pdf->Output();
?>