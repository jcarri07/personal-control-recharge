<?php

require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',7,0,213);
    //$this->Image('img/logoabae.jpg',16,16,8);
    $this->SetFont('Arial','B',16);
    $this->setXY(17,16);
    $this->MultiCell(180,12,utf8_decode('SOLICITUD Y AUTORIZACIÓN DE PERMISO'),0,'C');
    // cell(ancho, largo, contenido,borde?, salto de linea?)
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-30);
    // Arial italic 8
    $this->SetFont('Arial','B',10);
    // Número de página
    $this->SetX(75);
    $this->SetFillColor(105, 107, 108);
    $this->Cell(66,5,'',0,0,'C',0);
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();//hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage();//añade la pagina / en blanco
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,20);//salto de pagina automatico
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,7,utf8_decode('FECHA DE SOLICITUD:                        '),'B',1,'R',0);


$pdf->SetX(16);
$pdf->SetFillColor(33, 87, 146);//color de fondo rgb
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetDrawColor(0, 0, 0);//color de linea  rgb
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,7,'DATOS DEL TRABAJADOR','1',1,'C',1);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,'Nombre y Apellido','0',0,'C',0);
$pdf->Cell(60,7,'Cedula de Identidad','0',0,'C',0);
$pdf->Cell(60,7,'Cargo:','0',1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','',12);
$pdf->Cell(60,7,'','1',0,'C',0);
$pdf->Cell(60,7,'','1',0,'C',0);
$pdf->Cell(60,7,'','1',1,'C',0);


$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,utf8_decode('Unidad de Adscripción'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Supervisor Inmediato'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Cargo:'),'0',1,'C',0);
$pdf->SetFont('Arial','',12);
$pdf->SetX(16);
$pdf->Cell(60,7,'','1',0,'C',0);
$pdf->SetX(76);
$pdf->Cell(60,7,'','1',0,'C',0);
$pdf->Cell(60,7,'','1',1,'C',0);



$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('MOTIVO DEL PERMISO'),'1',1,'C',1);
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('NORMATIVA ABAE'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',9);
$pdf->SetX(18);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
$pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
$pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);

$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,10,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,101,3)."MEDIODIA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,99,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',1,'C',0);



$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,103,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',1,'C',0);


$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,110.5,3)."DIA COMPLETO"),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',126,118,3)."PERMISO REMUNERADO"),'1',1,'C',0);

$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(180,7,utf8_decode('PERMISO POR LEY'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',9);
$pdf->SetX(18);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',42,132,3)."LACTANCIA MATERNA"),'0',0,'C',0);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',132,132,3)."NACIMIENTO DE HIJO"),'0',0,'C',0);

$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,10,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,148.5,3)."MEDIODIA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,145.7,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',1,'C',0);



$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,151,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',1,'C',0);


$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,157,3)."DIA COMPLETO"),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',126,165,3)."PERMISO REMUNERADO"),'1',1,'C',0);

//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(180,7,utf8_decode('PERSONALES'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetFont('Arial','',9);
$pdf->SetX(18);
$pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',23,179,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',90,179,3)."CUIDADOS MEDICOS DE FAMILIARES"),'0',0,'C',0);
$pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',173,179,3)."OTROS"),'0',0,'C',0);

$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(30,10,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,195.5,3)."MEDIODIA"),'1',0,'C',0);
$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,193,3)."MAÑANA"),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRT',1,'C',0);



$pdf->SetX(46);
$pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,198,3)."TARDE"),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(40,5,utf8_decode(''),'LRB',1,'C',0);


$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,204.5,3)."DIA COMPLETO"),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
$pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);

//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(90,7,utf8_decode('TRABAJADOR:'),'1',0,'C',1);
$pdf->Cell(90,7,utf8_decode('SUPERVISOR INMEDIATO:'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetX(16);
$pdf->Cell(90,12,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(90,12,utf8_decode(''),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(90,5,utf8_decode('FIRMA:'),'LRB',0,'L',0);
$pdf->Cell(90,5,utf8_decode('FIRMA:'),'LRB',1,'L',0);


$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,8,utf8_decode('SOLO PARA USO DE LA DIRECCIÓN DE GESTIÓN HUMANA'),'1',1,'C',1);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(180,8,utf8_decode('RECIBIDO POR:'),'1',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(90,10,utf8_decode(''),'LR',0,'C',0);
$pdf->Cell(90,10,utf8_decode(''),'LR',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',0,'L',0);

$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FECHA:'),'LRB',1,'L',0);


// cell(ancho, largo, contenido,borde?, salto de linea?)


$pdf->Output();
?>