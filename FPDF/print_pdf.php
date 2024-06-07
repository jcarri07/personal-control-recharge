<?php
require('fpdf.php');
require('bdd.php');
session_start();



$pdf = new FPDF();
/*$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();*/

class PDF extends FPDF
{

// Cabecera de página
function Header()
{
    $this->Image('img/membrete.png',7,0,213);
    /* $this->Image('img/logoabae.jpg',16,16,13);*/
    $this->SetFont('Arial','B',16);
    $this->setXY(17,16);
    $this->MultiCell(180,12,utf8_decode('NOTIFICACIÓN DE REPOSO MÉDICO Y/O CERTIFICADO DE INCAPACIDAD'),0,'C');
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
$solicitud = $_GET['id'];
$recibido= $_SESSION['nombre'] ." ".$_SESSION['apellido'] ;

$query = "SELECT * FROM solicitud WHERE id_solicitud ='$solicitud'";
$datos = $conn->query($query);
$row = $datos ->fetch_assoc();

$fecha1 = date('d-m-Y', strtotime($row['fecha_inicio']));
$fecha2 = date('d-m-Y', strtotime($row['fecha_fin']));

$query1 = "SELECT * FROM usuario WHERE id_usuario ='$row[id_usuario]'";
$datos1 = $conn->query($query1);
$row1 = $datos1 ->fetch_assoc();

$query_datos_abae = "SELECT * FROM datos_abae WHERE id_usuario ='$row[id_usuario]'";
$datos_abae = $conn->query($query_datos_abae);
$row_datos_abae = $datos_abae->fetch_assoc();

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
//echo "<script>console.log('Console: " . $firma. "' );</script>";

// Creación del objeto de la clase heredada
$pdf = new PDF();//hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage();//añade l apagina / en blanco
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,20);//salto de pagina automatico
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(180,7,utf8_decode('FECHA DE SOLICITUD: '.date('d-m-Y', strtotime($row['created_date']))),'B',1,'R',0);


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
$pdf->Cell(60,7,$row1['nombres'] .' '. $row1['apellidos'] ,'1',0,'C',0);
$pdf->Cell(60,7,$row1['cedula'] ,'1',0,'C',0);
$pdf->Cell(60,7,$row_datos_abae['cargo'] ,'1',1,'C',0);


$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,utf8_decode('Unidad de Adscripción'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Supervisor Inmediato'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Cargo:'),'0',1,'C',0);
$pdf->SetFont('Arial','',12);
$pdf->SetX(16);
$pdf->Cell(60,10,$row2['nombre'],'1',0,'C',0);
$pdf->SetX(76);
$pdf->Cell(60,10,$row3['nombres'] .' '. $row3['apellidos'],'1',0,'C',0);
$pdf->Cell(60,10,$row_datos_abae_jefe['cargo'],'1',1,'C',0);



$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('N° DE DIAS DE REPOSO'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);

if($row['dias_cant'] >= "3"){
$pdf->Cell(60,18,utf8_decode($pdf->Image('img/Cuadro.jpeg',20,98,5)."De 1 hasta 3 Dias"),'1',0,'C',0);
$pdf->Cell(60,18,utf8_decode('Cantidad de Dias Exactos'),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode('DESDE:'),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode('HASTA:'),'LRT',1,'C',0);
$pdf->SetX(136);
$pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);

$pdf->SetX(136);
$pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode(''),'LRB',1,'C',0);
$pdf->SetX(16);
$pdf->Cell(60,18,utf8_decode($pdf->Image('img/check.jpeg',20,116,5)."Superior de 3 Dias"),'1',0,'C',0);
$pdf->Cell(60,18,utf8_decode('Cantidad de Dias Exactos'),'1',0,'C',0);  
$pdf->Cell(30,6,utf8_decode('DESDE:'),'LRT',0,'C',0);
$pdf->Cell(30,6,utf8_decode('HASTA:'),'LRT',1,'C',0);
$pdf->SetX(136);
$pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
$pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);
$pdf->SetX(136);
$pdf->Cell(30,6,$fecha1,'1',0,'C',0);
$pdf->Cell(30,6,$fecha2,'1',1,'C',0);


}
else if($row['dias_cant'] <= "3"){
    
    $pdf->Cell(60,18,utf8_decode($pdf->Image('img/check.jpeg',20,98,5)."De 1 hasta 3 Dias"),'1',0,'C',0);
    $pdf->Cell(60,18,utf8_decode('Cantidad de Dias Exactos'),'1',0,'C',0);  
    $pdf->Cell(30,6,utf8_decode('DESDE:'),'LRT',0,'C',0);
    $pdf->Cell(30,6,utf8_decode('HASTA:'),'LRT',1,'C',0);
    $pdf->SetX(136);
    $pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
    $pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);
    
    $pdf->SetX(136);
    $pdf->Cell(30,6,utf8_decode($fecha1),'LRB',0,'C',0);
    $pdf->Cell(30,6,utf8_decode($fecha2),'LRB',1,'C',0);
   
    $pdf->SetX(16);
    $pdf->Cell(60,18,utf8_decode($pdf->Image('img/Cuadro.jpeg',20,116,5)."Superior de 3 Dias"),'1',0,'C',0);
    $pdf->Cell(60,18,utf8_decode('Cantidad de Dias Exactos'),'1',0,'C',0);  
    $pdf->Cell(30,6,utf8_decode('DESDE:'),'LRT',0,'C',0);
    $pdf->Cell(30,6,utf8_decode('HASTA:'),'LRT',1,'C',0);
    $pdf->SetX(136);
    $pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',0,'C',0);
    $pdf->Cell(30,6,utf8_decode('dd/mm/aaaa'),'LRB',1,'C',0);
    $pdf->SetX(136);    
    $pdf->Cell(30,6,utf8_decode(''),'LRB',0,'C',0);
    $pdf->Cell(30,6,utf8_decode(''),'LRB',1,'C',0);
}

$pdf->SetX(16);
$pdf->Cell(90,7,utf8_decode('TRABAJADOR:'),'1',0,'C',0);
$pdf->Cell(90,7,utf8_decode('SUPERVISOR INMEDIATO:'),'1',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,28,utf8_decode($pdf->Image('../assets/firmas-images/'.$row5['firma'],39,138,40)),'1',0,'C',0);
$pdf->Cell(90,20,utf8_decode($pdf->Image('../assets/firmas-images/'.$row4['firma'],130,138,40)),'LRT',1,'C',0);
$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',0,'L',0);
$pdf->Cell(90,8,utf8_decode('FIRMA:'),'LRB',1,'L',0);


$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('SOLO PARA USO DE LA DIRECCIÓN DE GESTIÓN HUMANA'),'1',1,'C',1);


$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('RECIBIDO POR:'.' '. $recibido),'1',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(90,20,utf8_decode($pdf->Image('../assets/firmas-images/'.$row6['firma'],55,180,40)),'LR',0,'C',0);
$pdf->Cell(90,20,utf8_decode(''),'LR',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',0,'L',0);

$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FECHA:  '.date('d-m-Y', strtotime($row['date_apro']))),'LRB',1,'L',0);
$pdf->SetX(16);
$pdf->Cell(180,8,utf8_decode('OBSERVACIONES: '.$row['observacion']),'LRT',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(180,4,'','LR',1,'C',0);

if($row['descripcion'] == "Por validar IVSS"){
$pdf->SetFont('Arial','B',10);
$pdf->SetX(16);
$pdf->Cell(9,9,$pdf->Image('img/Cuadro.jpeg',18,221,5),'L',0,'C',0);
$pdf->Cell(171,9,utf8_decode('No aplica validación por parte del IVSS (solo aplica para casos de aquellos reposos hasta 3 dias)'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,230,5),'L',0,'L',0);
$pdf->Cell(171,9,utf8_decode('Reposo validado IVSS'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,9,''.$pdf->Image('img/check.jpeg',18,239,5),'L',0,'L',0);
$pdf->Cell(171,9,utf8_decode('Por validar ante el IVSS'),'R',1,'L',0);

$pdf->SetX(16);
$pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,248,5),'LB',0,'L',0);
$pdf->Cell(171,9,utf8_decode('Reposo Extemporáneo'),'BR',1,'L',0);
}
else if($row['descripcion'] == "Validado IVSS"){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(16);
    $pdf->Cell(9,9,$pdf->Image('img/Cuadro.jpeg',18,221,5),'L',0,'C',0);
    $pdf->Cell(171,9,utf8_decode('No aplica validación por parte del IVSS (solo aplica para casos de aquellos reposos hasta 3 dias)'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/check.jpeg',18,230,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo validado IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,239,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Por validar ante el IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,248,5),'LB',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo Extemporáneo'),'BR',1,'L',0);
    }
else if($row['descripcion'] == "Extemporaneo"){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(16);
    $pdf->Cell(9,9,$pdf->Image('img/Cuadro.jpeg',18,221,5),'L',0,'C',0);
    $pdf->Cell(171,9,utf8_decode('No aplica validación por parte del IVSS (solo aplica para casos de aquellos reposos hasta 3 dias)'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,230,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo validado IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,239,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Por validar ante el IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/check.jpeg',18,248,5),'LB',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo Extemporáneo'),'BR',1,'L',0);
    }
    else if($row['descripcion'] == "No aplica validación IVSS"){
    $pdf->SetFont('Arial','B',10);
    $pdf->SetX(16);
    $pdf->Cell(9,9,$pdf->Image('img/check.jpeg',18,221,5),'L',0,'C',0);
    $pdf->Cell(171,9,utf8_decode('No aplica validación por parte del IVSS (solo aplica para casos de aquellos reposos hasta 3 dias)'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,230,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo validado IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,239,5),'L',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Por validar ante el IVSS'),'R',1,'L',0);
    
    $pdf->SetX(16);
    $pdf->Cell(9,9,''.$pdf->Image('img/Cuadro.jpeg',18,248,5),'LB',0,'L',0);
    $pdf->Cell(171,9,utf8_decode('Reposo Extemporáneo'),'BR',1,'L',0);
    }
// cell(ancho, largo, contenido,borde?, salto de linea?)

ob_end_clean();
$pdf->Output();
?>