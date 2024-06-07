<?php

require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',16,0,256);
    //$this->Image('img/logoabae.jpg',16,16,13);
    $this->SetFont('Arial','B',14);
    $this->setXY(16,16);
    $this->MultiCell(180,8,utf8_decode('SOLICITUD Y AUTORIZACIÓN DE PERMISO'),0,'C');
    // cell(ancho, largo, contenido,borde?, salto de linea?)
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 8
    $this->SetFont('Arial','',6);
    // Número de página
    $this->SetX(95);
    $this->SetFillColor(198, 217, 241);
    $this->Cell(98,5,'Forma: ABAE-FO-001-2016',0,0,'R',0);
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
$pdf->Cell(180,8,'DATOS DEL TRABAJADOR SOLICITANTE','1',1,'C',1);

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
$pdf->SetFillColor(141, 179, 226);//color de fondo rgb
$pdf->Cell(180,8,utf8_decode('MOTIVO DEL PERMISO'),'1',1,'C',1);
$pdf->SetX(16);
$pdf->SetFillColor(198, 217, 241);//color de fondo rgb
$pdf->Cell(180,8,utf8_decode('NORMATIVA ABAE'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',8);
$pdf->SetX(20);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',20,89.4,3)."POR DOCENCIA"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,89.4,3)."POR ESTUDIOS"),'0',0,'C',0);
$pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',80,89.4,3)."CONSULTA MÉDICA"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',117,89.4,3)."MATRIMONIO"),'0',0,'C',0);
$pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',146,89.4,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetFont('Arial','',8);
$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,12,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,104.3,3)."MEDIO DÍA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,101.5,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,107.3,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRB',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,113.5,3)."DÍA COMPLETO"),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',130,120,3)."PERMISO REMUNERADO"),'1',1,'C',0);

$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(180,8,utf8_decode('PERMISO POR LEY'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',8);
$pdf->SetX(18);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',42,135,3)."LACTANCIA MATERNA"),'0',0,'C',0);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',132,135,3)."NACIMIENTO DE HIJO"),'0',0,'C',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetFont('Arial','',8);
$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,12,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,150.2,3)."MEDIO DÍA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,147.5,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,153.2,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRB',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,159.5,3)."DÍA COMPLETO"),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',130,166,3)."PERMISO REMUNERADO"),'1',1,'C',0);

//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(180,8,utf8_decode('PERSONALES'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',8);
$pdf->SetX(18);
$pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',23,181.3,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',92,181.3,3)."CUIDADOS MÉDICOS DE FAMILIARES"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',173,181.3,3)."OTROS"),'0',0,'C',0);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetFont('Arial','',8);
$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,12,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,196,3)."MEDIO DÍA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,193.5,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(46);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,199,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRB',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,205.5,3)."DÍA COMPLETO"),'1',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(60,6,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',85,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
$pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',178,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);

//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(90,8,utf8_decode('Funcionario Solicitante:'),'1',0,'L',1);
$pdf->Cell(90,8,utf8_decode('Jefe de la Unidad Solicitante:'),'1',1,'L',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(90,8,utf8_decode(''),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','',10);
$pdf->Cell(90,8,utf8_decode('Firma:'),'LRB',0,'L',0);
$pdf->Cell(90,8,utf8_decode('Firma y Sello:'),'LRB',1,'L',0);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,8,utf8_decode('Solo Para Uso de la Dirección Gestión Humana'),'1',1,'C',1);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,8,utf8_decode('Recibido Por:'),'1',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(180,10,utf8_decode(''),'LR',0,'C',0);
$pdf->Cell(180,10,utf8_decode(''),'LR',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('Firma, Fecha y Sello:'),'LRB',0,'L',0);



// cell(ancho, largo, contenido,borde?, salto de linea?)


$pdf->Output();
?>