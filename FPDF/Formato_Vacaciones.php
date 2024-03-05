<?php

require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',16,0,256);
    $this->SetFont('Arial','B',14);
    $this->setXY(16,16);
    $this->Cell(180,8,utf8_decode('SOLICITUD DE VACACIONES'),'0',1,'C',0);
    // cell(ancho, largo, contenido,borde?, salto de linea?)
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-22.7);
    // Arial italic 8
    $this->SetFont('Arial','',10);
    // Número de página
    $this->SetX(75);
    $this->SetFillColor(217, 217, 217);
    $this->Cell(70,5,'Original - Unidad de Recursos Humanos',0,0,'C',1);
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();//hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage();//añade l apagina / en blanco
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
$pdf->Cell(180,8,'1) Datos del Funcionario Solicitante','1',1,'C',1);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,'Nombre y Apellido:','1',0,'C',0);
$pdf->Cell(60,8,'Cedula de Identidad:','1',0,'C',0);
$pdf->Cell(60,8,'Cargo:','1',1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','',10);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode(''),'1',1,'C',0);


$pdf->SetX(16);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,utf8_decode('Unidad de Adscripción:'),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode('Supervisor Inmediato:'),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode('Cargo:'),'1',1,'C',0);
$pdf->SetFont('Arial','',10);
$pdf->SetX(76);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->SetX(16);
$pdf->MultiCell(60,8,utf8_decode(''),1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(60,24,utf8_decode('Fecha de Ingreso a la Institución'),'1',0,'C',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(20,16,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(20,16,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(20,16,utf8_decode('Año'),'1',0,'C',1);   
$pdf->Cell(60,8,utf8_decode('Periodo Vacacional:'),'LRT',1,'C',1);
$pdf->SetX(136);
$pdf->Cell(60,8,utf8_decode('Días a Disfrutar:'),'LRB',1,'C',1);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','',10);
$pdf->SetX(76);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(60,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('2) Antigüedad en la Administración Pública Nacional'),'1',1,'C',1);
$pdf->SetX(16);
$pdf->Cell(60,16,utf8_decode('Institución'),'1',0,'C',1);
$pdf->Cell(60,8,utf8_decode('Fecha de Ingreso'),'1',0,'C',1);
$pdf->Cell(60,8,utf8_decode('Fecha de Egreso'),'1',1,'C',1);

$pdf->SetX(76);
$pdf->Cell(20,8,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(20,8,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(20,8,utf8_decode('Año'),'1',0,'C',1);
$pdf->Cell(20,8,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(20,8,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(20,8,utf8_decode('Año'),'1',1,'C',1);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('Fecha Inicio'),'1',0,'C',1);
$pdf->Cell(60,8,utf8_decode('Fecha Culminación'),'1',0,'C',1);
$pdf->Cell(60,8,utf8_decode('Fecha de Reintegro'),'1',1,'C',1);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(20,8,utf8_decode('Día'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Año'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Día'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Año'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Dia'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode('Año'),'1',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',0,'C',0);
$pdf->Cell(20,8,utf8_decode(''),'1',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('Funcionario Solicitante:'),'1',0,'C',0);
$pdf->Cell(90,8,utf8_decode('Jefe de la Unidad Solicitante:'),'1',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(90,15,utf8_decode(''),'LRT',0,'C',0);
$pdf->Cell(90,15,utf8_decode(''),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',0,'L',0);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',1,'L',0);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('4) SOLO PARA USO DE LA DIRECCIÓN DE GESTIÓN HUMANA'),'1',1,'C',1);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('Solicitud Válida por Recursos Humanos'),'1',0,'C',0);
$pdf->Cell(90,8,utf8_decode('Recibido por:'),'1',1,'C',0);

$pdf->SetX(106);
$pdf->Cell(90,16,utf8_decode(''),'LRT',0,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(90,12,'SI'.$pdf->Image('img/Cuadro.jpeg',30,227,5),'LR',1,'L',0);


$pdf->SetX(16);
$pdf->Cell(90,12,utf8_decode('NO ').$pdf->Image('img/Cuadro.jpeg',30,238,5),'LRB',0,'L',0);


$pdf->Cell(90,4,utf8_decode(''),'LR',1,'C',0);
$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',1,'C',0);

$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('Observaciones: '),'LRT',1,'C',0);

$pdf->SetFont('Arial','',10);
$pdf->SetX(16);
$pdf->Cell(180,18,utf8_decode(''),'LRB',0,'C',0);


// cell(ancho, largo, contenido,borde?, salto de linea?)


$pdf->Output();
?>