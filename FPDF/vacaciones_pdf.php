<?php
// ob_start();
require('fpdf.php');
require('bdd.php');
session_start();



$pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',7,0,213);
    /* $this->Image('img/logoabae.jpg',16,16,13);*/
    $this->SetFont('Arial','B',16);
    $this->setXY(17,16);
    $this->MultiCell(180,12,utf8_decode('SOLICITUD DE VACACIONES'),0,'C');
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
    $this->SetFillColor(155, 157, 158);
    $this->Cell(66,5,'',0,0,'C',0);
}
}
// print_r($_SESSION);
$solicitud = $_GET['id'];
$recibido= $_SESSION['nombre'] ." ".$_SESSION['apellido'] ;

$query = "SELECT * FROM solicitud WHERE id_solicitud ='$solicitud'";
$datos = $conn->query($query);
$row = $datos ->fetch_assoc();

$query_vacaciones = "SELECT * FROM datos_vacaciones WHERE id_solicitud ='$solicitud'";
$datos_vacaciones = $conn->query($query_vacaciones);
$rowVacaciones = $datos_vacaciones->fetch_assoc();

$fecha1 = date('d-m-Y', strtotime($row['fecha_inicio']));
$fecha2 = date('d-m-Y', strtotime($row['fecha_fin']));

$query1 = "SELECT * FROM usuario WHERE id_usuario ='$row[id_usuario]'";
$datos1 = $conn->query($query1);
$row1 = $datos1 ->fetch_assoc();

$query_datos_abae = "SELECT * FROM datos_abae WHERE id_usuario ='$row[id_usuario]'";
$datos_abae = $conn->query($query_datos_abae);
$row_datos_abae = $datos_abae->fetch_assoc();

$query_abae = "SELECT * FROM datos_abae WHERE id_usuario ='$row[id_usuario]'";
$datos_abae = $conn->query($query_abae);
$rowAbae = $datos_abae->fetch_assoc();

$query_experiencia = "SELECT * FROM experiencia_instituciones_publicas WHERE id_usuario ='$row[id_usuario]'";
$datos_experiencias = $conn->query($query_experiencia);
// $rowExpericncia = $datos_experiencias->fetch_assoc();
$numExperiencia = $datos_experiencias->num_rows;

$query2 = "SELECT * FROM unidad WHERE id_jefe ='$row1[id_jefe]'";
$datos2 = $conn->query($query2);
$row2 = $datos2 ->fetch_assoc();

$query3 = "SELECT * FROM usuario WHERE id_usuario='$row1[id_jefe]'";
$datos3 = $conn->query($query3);
$row3 = $datos3 ->fetch_assoc();

$query_datos_abae_jefe = "SELECT * FROM datos_abae WHERE id_usuario ='$row1[id_jefe]'";
$datos_abae_jefe = $conn->query($query_datos_abae_jefe);
$row_datos_abae_jefe = $datos_abae_jefe->fetch_assoc();

$query4 = "SELECT * FROM datos_personales WHERE id_usuario='$row1[id_jefe]'";
$datos4 = $conn->query($query4);
$row4 = $datos4 ->fetch_assoc();

$query5 = "SELECT * FROM datos_personales WHERE id_usuario='$row[id_usuario]'";
$datos5 = $conn->query($query5);
$row5 = $datos5 ->fetch_assoc();

$query6 = "SELECT * FROM datos_personales WHERE id_usuario='$row[aprobado_por]'";
$datos6 = $conn->query($query6);
$row6 = $datos6 ->fetch_assoc();

// Creación del objeto de la clase heredada
$pdf = new PDF();//hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage();//añade l apagina / en blanco
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,20);//salto de pagina automatico
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,7,utf8_decode(''),'',1,'R',0);


$pdf->SetX(16);
$pdf->SetFillColor(33, 87, 146);//color de fondo rgb
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetDrawColor(0, 0, 0);//color de linea  rgb
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,7,'1) Datos del Funcionario Solicitante','1',1,'C',1);

$pdf->SetX(16);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,'Nombre y Apellido','0',0,'C',0);
$pdf->Cell(60,7,'Cedula de Identidad','0',0,'C',0);
$pdf->Cell(60,7,'Cargo:',0,1,'C',0);
$pdf->SetX(16);
$pdf->SetFont('Arial','',12);
$pdf->Cell(60,7,$row1['nombres'] .' '. $row1['apellidos'],'1',0,'C',0);
$pdf->Cell(60,7,$row1['cedula'],'1',0,'C',0);
$pdf->Cell(60,7,$row_datos_abae['cargo'],'1',1,'C',0);


$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,utf8_decode('Unidad de Adscripción'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Supervisor Inmediato'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Cargo:'),'0',1,'C',0);
$pdf->SetFont('Arial','',12);
$pdf->SetX(76);
$pdf->Cell(60,15,$row3['nombres'] .' '. $row3['apellidos'],'1',0,'C',0);
$pdf->Cell(60,15,$row_datos_abae_jefe['cargo'],'1',0,'C',0);
$pdf->SetX(16);
$pdf->MultiCell(60,15,$row2['nombre'],1,'C');


$pdf->SetFont('Arial','B',11);
$pdf->SetX(16);
$pdf->Cell(63,27,utf8_decode('Fecha de Ingreso a la Institución'),'1',0,'C',0);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(15,18,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(15,18,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(20,18,utf8_decode('Año'),'1',0,'C',1);   
$pdf->Cell(67,9,utf8_decode('Periodo Vacacional:'),'LRT',1,'C',1);
$pdf->SetX(129);
$pdf->Cell(67,9,utf8_decode('Días a Disfrutar:'),'LRB',1,'C',1);

$fecha_sep = obtenerFechaSeparada($rowAbae['fecha_ingreso']);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(79);
$pdf->Cell(15,7,$fecha_sep['dia'],'1',0,'C',0);
$pdf->Cell(15,7,$fecha_sep['mes'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_sep['anio'],'1',0,'C',0);
$pdf->Cell(67,7,$row['dias_cant'],'1',1,'C',0);


$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('2) Antigüedad en la Administracion Pública Nacional'),'1',1,'C',1);
$pdf->SetX(16);
$pdf->Cell(75,15,utf8_decode('Institución'),'1',0,'C',1);
$pdf->Cell(52.5,8,utf8_decode('Fecha de Ingreso'),'1',0,'C',1);
$pdf->Cell(52.5,8,utf8_decode('Fecha de Egreso'),'1',1,'C',1);


$pdf->SetX(91);
$pdf->Cell(17.5,7 ,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(17.5,7,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(17.5,7,utf8_decode('Año'),'1',0,'C',1);
$pdf->Cell(17.5,7,utf8_decode('Día'),'1',0,'C',1);
$pdf->Cell(17.5,7,utf8_decode('Mes'),'1',0,'C',1);
$pdf->Cell(17.5,7,utf8_decode('Año'),'1',1,'C',1);

while ($experiencia = $datos_experiencias->fetch_assoc()) { 
    $pdf->SetX(16);
    $pdf->SetTextColor(0, 0, 0);//color de texto rgb
    $pdf->Cell(75,7,$experiencia['organismo'],'1',0,'C',0);
        $fecha_s = obtenerFechaSeparada($experiencia['fecha_ingreso']);
    $pdf->Cell(17.5,7,$fecha_s['dia'],'1',0,'C',0);
    $pdf->Cell(17.5,7,$fecha_s['mes'],'1',0,'C',0);
    $pdf->Cell(17.5,7,$fecha_s['anio'],'1',0,'C',0);
        $fecha_s = obtenerFechaSeparada($experiencia['fecha_egreso']);
    $pdf->Cell(17.5,7,$fecha_s['dia'],'1',0,'C',0);
    $pdf->Cell(17.5,7,$fecha_s['mes'],'1',0,'C',0);
    $pdf->Cell(17.5,7,$fecha_s['anio'],'1',1,'C',0);
}

for ($i=$numExperiencia; $i < 4; $i++) { 
    # code...
    $pdf->SetX(16);
    $pdf->Cell(75,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',0,'C',0);
    $pdf->Cell(17.5,7,utf8_decode(''),'1',1,'C',0);
}



$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,7,utf8_decode('Fecha Inicio'),'1',0,'C',1);
$pdf->Cell(60,7,utf8_decode('Fecha Culminación'),'1',0,'C',1);
$pdf->Cell(60,7,utf8_decode('Fecha de Reintegro'),'1',1,'C',1);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(20,7,utf8_decode('Día'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Año'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Día'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Año'),'1',0,'C',0);
$pdf->Cell(20,7 ,utf8_decode('Dia'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Mes'),'1',0,'C',0);
$pdf->Cell(20,7,utf8_decode('Año'),'1',1,'C',0);


$pdf->SetX(16);
$fecha_vaca = obtenerFechaSeparada($row['fecha_inicio']);
$pdf->Cell(20,7,$fecha_vaca['dia'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['mes'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['anio'],'1',0,'C',0);
$fecha_vaca = obtenerFechaSeparada($row['fecha_fin']);
$pdf->Cell(20,7,$fecha_vaca['dia'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['mes'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['anio'],'1',0,'C',0);
$fecha_vaca = obtenerFechaSeparada($rowVacaciones['fecha_reintegro']);
$pdf->Cell(20,7,$fecha_vaca['dia'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['mes'],'1',0,'C',0);
$pdf->Cell(20,7,$fecha_vaca['anio'],'1',1,'C',0);


$pdf->SetX(16);
$pdf->Cell(90,7,utf8_decode('Funcionario Solicitante:'),'1',0,'C',0);
$pdf->Cell(90,7,utf8_decode('Jefe de la Unidad Solicitante:'),'1',1,'C',0);


$pdf->SetX(16);
$pdf->Cell(90,25,utf8_decode($pdf->Image('../assets/firmas-images/'.$row5['firma'],45,183,30,18)),'LRT',0,'C',0);
$pdf->Cell(90,20,utf8_decode($pdf->Image('../assets/firmas-images/'.$row4['firma'],133,183,30,18)),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',0,'C',0);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',1,'C',0);


$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('4) SOLO PARA USO DE LA DIRECCIÓN DE GESTIÓN HUMANA'),'1',1,'C',1);

$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(90,7,utf8_decode('Solicitud Valida por Recursos Humanos'),'1',0,'C',0);
$pdf->Cell(90,7,utf8_decode('Recibido por:'),'1',1,'C',0);

$pdf->SetX(106);
$pdf->Cell(90,12.5,utf8_decode($pdf->Image('../assets/firmas-images/'.$row6['firma'],133,225,30,18)),'LRT',0,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,12.5,'SI'.$pdf->Image('img/check.jpeg',35,227.5,5),'LR',1,'L',0);


$pdf->SetX(16);
$pdf->Cell(90,12.5,utf8_decode('NO').$pdf->Image('img/Cuadro.jpeg',35,240,5),'LRB',0,'L',0);


$pdf->Cell(90,4.5,utf8_decode(''),'LR',1,'C',0);
$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',1,'C',0);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('Observaciones: '),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->MultiCell(180,8,$row['observacion'],'LRB','C',false);


// cell(ancho, largo, contenido,borde?, salto de linea?)
ob_end_clean();
$pdf->Output();

// ob_clean();

function obtenerFechaSeparada($fecha) {
    // Convierte la fecha en formato "YYYY-MM-DD" a un objeto de fecha en PHP
    $fechaObj = new DateTime($fecha);
    
    // Obtiene el día, el mes y el año por separado
    $dia = $fechaObj->format('d');
    $mes = $fechaObj->format('m');
    $anio = $fechaObj->format('Y');
    
    // Retorna un array con los valores del día, mes y año
    return array('dia' => $dia, 'mes' => $mes, 'anio' => $anio);
}
// ob_end_flush();
?>