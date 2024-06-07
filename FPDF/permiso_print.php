<?php

require('fpdf.php');
require('bdd.php');
session_start();

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
$solicitud = $_GET['id'];
$recibido= $_SESSION['nombre'] ." ".$_SESSION['apellido'] ;


$query = "SELECT * FROM solicitud WHERE id_solicitud ='$solicitud'";
$datos = $conn->query($query);
$row = $datos ->fetch_assoc();

$fecha1 = date('d-m-Y', strtotime($row['fecha_inicio']));
$fecha2 = date('d-m-Y', strtotime($row['fecha_fin']));

if($row['motivo']== 'Lactancia Materna' || $row['motivo']== 'Nacimiento de Hijo'){
    $moti= 'Ley';
}elseif($row['motivo']== 'Diligencia Personales' || $row['motivo']== 'Cuidados Medicos de Familiares'  || $row['motivo']== 'Otros'){
    $moti= 'Personales';
}else{
    $moti= 'Normativa';
}

$query1 = "SELECT * FROM usuario WHERE id_usuario ='$row[id_usuario]'";
$datos1 = $conn->query($query1);
$row1 = $datos1 ->fetch_assoc();

$query2 = "SELECT * FROM unidad WHERE id_jefe ='$row1[id_jefe]'";
$datos2 = $conn->query($query2);
$row2 = $datos2 ->fetch_assoc();

$query3 = "SELECT * FROM usuario WHERE id_usuario='$row1[id_jefe]'";
$datos3 = $conn->query($query3);
$row3 = $datos3 ->fetch_assoc();

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
$pdf->AddPage();//añade la pagina / en blanco
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
$pdf->Cell(60,7,$row1['cargo'] ,'1',1,'C',0);

$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(60,7,utf8_decode('Unidad de Adscripción'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Supervisor Inmediato'),'0',0,'C',0);
$pdf->Cell(60,7,utf8_decode('Cargo:'),'0',1,'C',0);
$pdf->SetFont('Arial','',12);
$pdf->SetX(16);
$pdf->Cell(60,7,$row2['nombre'],'1',0,'C',0);
$pdf->SetX(76);
$pdf->Cell(60,7,$row3['nombres'] .' '. $row3['apellidos'],'1',0,'C',0);
$pdf->Cell(60,7,$row3['cargo'],'1',1,'C',0);

// echo "<script>console.log('Console: " . $row2 . "' );</script>";

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('MOTIVO DEL PERMISO'),'1',1,'C',1);
$pdf->SetX(16);
$pdf->Cell(180,7,utf8_decode('NORMATIVA ABAE'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb


if($row['motivo'] == 'Por Docencia'){
            $pdf->SetFont('Arial','',9);
            $pdf->SetX(18);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/check.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
            $pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
            $pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}
elseif($row['motivo'] == 'Por Estudios'){
            $pdf->SetFont('Arial','',9);
            $pdf->SetX(18);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/check.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
            $pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
            $pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}elseif($row['motivo'] == 'Consulta Medica'){
            $pdf->SetFont('Arial','',9);
            $pdf->SetX(18);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
            $pdf->Cell(36,6,utf8_decode($pdf->Image('img/check.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
            $pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}elseif($row['motivo'] == 'Matrimonio'){
            $pdf->SetFont('Arial','',9);
            $pdf->SetX(18);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
            $pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/check.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
            $pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}elseif($row['motivo'] == 'Fallecimiento de Familiar'){
            $pdf->SetFont('Arial','',9);
            $pdf->SetX(18);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
            $pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
            $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
            $pdf->Cell(50,6,utf8_decode($pdf->Image('img/check.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}else {
    $pdf->SetFont('Arial','',9);
    $pdf->SetX(18);
    $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',17,85.5,3)."POR DOCENCIA"),'0',0,'C',0);
    $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',47,85.5,3)."POR ESTUDIOS"),'0',0,'C',0);
    $pdf->Cell(36,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',77,85.5,3)."CONSULTA MEDICA"),'0',0,'C',0);
    $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',115,85.5,3)."MATRIMONIO"),'0',0,'C',0);
    $pdf->Cell(50,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',142,85.5,3)."FALLECIMIENTO DE FAMILIAR"),'0',0,'C',0);
}
    


$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

/*$pdf->SetX(16);
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
$pdf->Cell(180,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',126,118,3)."PERMISO REMUNERADO"),'1',1,'C',0);*/


if($row['horario'] == 'Dia Completo' && $moti == 'Normativa'){
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
    $pdf->Cell(60,8,utf8_decode($pdf->Image('img/check.jpeg',30,110.5,3)."DIA COMPLETO"),'1',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($fecha1),'1',0,'C',0);  
    $pdf->Cell(40,8,utf8_decode($fecha2),'LRT',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($row['dias_cant'].' días'),'LRT',1,'C',0);
    
    $pdf->SetX(16);
    $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,118,3)."PERMISO REMUNERADO"),'1',1,'C',0);

    }

    elseif($row['horario'] == 'Mediodia (Mañana)' && $moti == 'Normativa'){
        $pdf->SetX(16);
        $pdf->SetTextColor(0, 0, 0);//color de texto rgb
        $pdf->Cell(30,10,utf8_decode($pdf->Image('img/check.jpeg',19,101,3)."MEDIODIA"),'1',0,'C',0);
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,99,3)."MAÑANA"),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha1),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha2),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode('4 horas'),'LRT',1,'C',0);
        
        
        
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
        $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,118,3)."PERMISO REMUNERADO"),'1',1,'C',0);
    
        }

    elseif($row['horario'] == 'Mediodia (Tarde)' && $moti == 'Normativa'){
        $pdf->SetX(16);
        $pdf->SetTextColor(0, 0, 0);//color de texto rgb
        $pdf->Cell(30,10,utf8_decode($pdf->Image('img/Cuadro.jpeg',19,101,3)."MEDIODIA"),'1',0,'C',0);
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,99,3)."MAÑANA"),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha1),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha2),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode('4 horas'),'LRT',1,'C',0);



        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,103,3)."TARDE"),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',1,'C',0);


        $pdf->SetX(16);
        $pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,110.5,3)."DIA COMPLETO"),'1',0,'C',0);
        $pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
        $pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
        $pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);

        $pdf->SetX(16);
        $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,118,3)."PERMISO REMUNERADO"),'1',1,'C',0);
    
            }
            else{
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
                }


$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(180,7,utf8_decode('PERMISO POR LEY'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb


if($row['motivo'] == 'Lactancia Materna'){
$pdf->SetFont('Arial','',9);
$pdf->SetX(18);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/check.jpeg',42,132,3)."LACTANCIA MATERNA"),'0',0,'C',0);
$pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',132,132,3)."NACIMIENTO DE HIJO"),'0',0,'C',0);
}
elseif($row['motivo'] == 'Nacimiento de Hijo'){
    $pdf->SetFont('Arial','',9);
    $pdf->SetX(18);
    $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',42,132,3)."LACTANCIA MATERNA"),'0',0,'C',0);
    $pdf->Cell(90,6,utf8_decode($pdf->Image('img/check.jpeg',132,132,3)."NACIMIENTO DE HIJO"),'0',0,'C',0);
    }
else{
        $pdf->SetFont('Arial','',9);
        $pdf->SetX(18);
        $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',42,132,3)."LACTANCIA MATERNA"),'0',0,'C',0);
        $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',132,132,3)."NACIMIENTO DE HIJO"),'0',0,'C',0);
        }

$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

/*$pdf->SetX(16);
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
$pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);*/

if($row['horario'] == 'Dia Completo' && $moti == 'Ley'){
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
    $pdf->Cell(60,8,utf8_decode($pdf->Image('img/check.jpeg',30,157,3)."DIA COMPLETO"),'1',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($fecha1),'1',0,'C',0);  
    $pdf->Cell(40,8,utf8_decode($fecha2),'LRT',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($row['dias_cant'].' días'),'LRT',1,'C',0);
 
    $pdf->SetX(16);
    $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,165,3)."PERMISO REMUNERADO"),'1',1,'C',0);

    }

    elseif($row['horario'] == 'Mediodia (Mañana)'  && $moti == 'Ley'){
        $pdf->SetX(16);
        $pdf->SetTextColor(0, 0, 0);//color de texto rgb
        $pdf->Cell(30,10,utf8_decode($pdf->Image('img/check.jpeg',19,148.5,3)."MEDIODIA"),'1',0,'C',0);
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,145.7,3)."MAÑANA"),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha1),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha2),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode('4 horas'),'LRT',1,'C',0);
        
        
        
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
        $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,165,3)."PERMISO REMUNERADO"),'1',1,'C',0);
    
        }

    elseif($row['horario'] == 'Mediodia (Tarde)'  && $moti == 'Ley'){
        $pdf->SetX(16);
        $pdf->SetTextColor(0, 0, 0);//color de texto rgb
        $pdf->Cell(30,10,utf8_decode($pdf->Image('img/check.jpeg',19,148.5,3)."MEDIODIA"),'1',0,'C',0);
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,145.7,3)."MAÑANA"),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha1),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha2),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode('4 horas'),'LRT',1,'C',0);
        
        
        
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,151,3)."TARDE"),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',0,'C',0);
        $pdf->Cell(40,5,utf8_decode(''),'LRB',1,'C',0);
        
        
        $pdf->SetX(16);
        $pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,157,3)."DIA COMPLETO"),'1',0,'C',0);
        $pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
        $pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
        $pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);
     
        $pdf->SetX(16);
        $pdf->Cell(180,8,utf8_decode($pdf->Image('img/check.jpeg',126,165,3)."PERMISO REMUNERADO"),'1',1,'C',0);
    
            }
            else{
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
            
                }


//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(180,7,utf8_decode('PERSONALES'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

if($row['motivo'] == 'Diligencia Personales'){
        $pdf->SetFont('Arial','',9);
        $pdf->SetX(18);
        $pdf->Cell(60,6,utf8_decode($pdf->Image('img/check.jpeg',23,179,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
        $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',90,179,3)."CUIDADOS MEDICOS DE FAMILIARES"),'0',0,'C',0);
        $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',173,179,3)."OTROS"),'0',0,'C',0);
}elseif($row['motivo'] == 'Cuidados Medicos de Familiares') {
    
        $pdf->SetFont('Arial','',9);
        $pdf->SetX(18);
        $pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',23,179,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
        $pdf->Cell(90,6,utf8_decode($pdf->Image('img/check.jpeg',90,179,3)."CUIDADOS MEDICOS DE FAMILIARES"),'0',0,'C',0);
        $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',173,179,3)."OTROS"),'0',0,'C',0);

}elseif($row['motivo'] == 'Otros') {   
       $pdf->SetFont('Arial','',9);
        $pdf->SetX(18);
        $pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',23,179,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
        $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',90,179,3)."CUIDADOS MEDICOS DE FAMILIARES"),'0',0,'C',0);
        $pdf->Cell(30,6,utf8_decode($pdf->Image('img/check.jpeg',173,179,3)."OTROS"),'0',0,'C',0);
}else{   
    $pdf->SetFont('Arial','',9);
     $pdf->SetX(18);
     $pdf->Cell(60,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',23,179,3)."DILIGENCIAS PERSONALES"),'0',0,'C',0);
     $pdf->Cell(90,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',90,179,3)."CUIDADOS MEDICOS DE FAMILIARES"),'0',0,'C',0);
     $pdf->Cell(30,6,utf8_decode($pdf->Image('img/Cuadro.jpeg',173,179,3)."OTROS"),'0',0,'C',0);
}


$pdf->SetFont('Arial','B',9);
$pdf->SetX(16);
$pdf->Cell(180,6,utf8_decode(''),'1',1,'L',0);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb
$pdf->SetX(16);
$pdf->Cell(60,8,utf8_decode('HORARIO'),'1',0,'C',0);
$pdf->Cell(40,8,utf8_decode('DESDE: dd/mm/aaaa'),'1',0,'C',0);  
$pdf->Cell(40,8,utf8_decode('HASTA: dd/mm/aaaa'),'LRT',0,'C',0);
$pdf->Cell(40,8,utf8_decode('TOTAL DE HORAS / DÍAS'),'LRT',1,'C',0);

    if($row['horario'] == 'Dia Completo'  && $moti == 'Personales'){
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
    $pdf->Cell(60,8,utf8_decode($pdf->Image('img/check.jpeg',30,204.5,3)."DIA COMPLETO"),'1',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($fecha1),'1',0,'C',0);  
    $pdf->Cell(40,8,utf8_decode($fecha2),'LRT',0,'C',0);
    $pdf->Cell(40,8,utf8_decode($row['dias_cant'].' días'),'LRT',1,'C',0);

    if($row['descripcion'] == 'Remunerado' && $moti == 'Personales'){
        $pdf->SetX(16);
        $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
        $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
        }
        if($row['descripcion'] == 'No remunerado'){
            $pdf->SetX(16);
            $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
            $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
            }
    }

    elseif($row['horario'] == 'Mediodia (Mañana)' && $moti == 'Personales'){
        $pdf->SetX(16);
        $pdf->SetTextColor(0, 0, 0);//color de texto rgb
        $pdf->Cell(30,10,utf8_decode($pdf->Image('img/check.jpeg',19,195.5,3)."MEDIODIA"),'1',0,'C',0);
        $pdf->SetX(46);
        $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,193,3)."MAÑANA"),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha1),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode($fecha2),'LRT',0,'C',0);
        $pdf->Cell(40,5,utf8_decode('4 horas'),'LRT',1,'C',0);
        
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

        if($row['descripcion'] == 'Remunerado'){
            $pdf->SetX(16);
            $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
            $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
            }
            if($row['descripcion'] == 'No remunerado'){
                $pdf->SetX(16);
                $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
                $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
                }
        }

    elseif($row['horario'] == 'Mediodia (Tarde)' && $moti == 'Personales'){
            $pdf->SetX(16);
            $pdf->SetTextColor(0, 0, 0);//color de texto rgb
            $pdf->Cell(30,10,utf8_decode($pdf->Image('img/check.jpeg',19,195.5,3)."MEDIODIA"),'1',0,'C',0);
            $pdf->SetX(46);
            $pdf->Cell(30,5,utf8_decode($pdf->Image('img/Cuadro.jpeg',50,193,3)."MAÑANA"),'LRT',0,'C',0);
            $pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
            $pdf->Cell(40,5,utf8_decode(''),'LRT',0,'C',0);
            $pdf->Cell(40,5,utf8_decode(''),'LRT',1,'C',0);
            
            $pdf->SetX(46);
            $pdf->Cell(30,5,utf8_decode($pdf->Image('img/check.jpeg',50,198,3)."TARDE"),'LRB',0,'C',0);
            $pdf->Cell(40,5,utf8_decode($fecha1),'LRB',0,'C',0);
            $pdf->Cell(40,5,utf8_decode($fecha2),'LRB',0,'C',0);
            $pdf->Cell(40,5,utf8_decode('4 horas'),'LRB',1,'C',0);
            
            $pdf->SetX(16);
            $pdf->Cell(60,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',30,204.5,3)."DIA COMPLETO"),'1',0,'C',0);
            $pdf->Cell(40,8,utf8_decode(''),'1',0,'C',0);  
            $pdf->Cell(40,8,utf8_decode(''),'LRT',0,'C',0);
            $pdf->Cell(40,8,utf8_decode(''),'LRT',1,'C',0);

            if($row['descripcion'] == 'Remunerado'){
                $pdf->SetX(16);
                $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
                $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
                }
                if($row['descripcion'] == 'No remunerado'){
                    $pdf->SetX(16);
                    $pdf->Cell(90,8,utf8_decode($pdf->Image('img/Cuadro.jpeg',81,212.5,3)."PERMISO REMUNERADO"),'1',0,'C',0);
                    $pdf->Cell(90,8,utf8_decode($pdf->Image('img/check.jpeg',174,212.5,3)."PERMISO NO REMUNERADO"),'1',1,'C',0);
                    }
            }
            else{
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
                }


//----------
$pdf->SetX(16);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255, 255, 255);//color de texto rgb
$pdf->Cell(90,7,utf8_decode('TRABAJADOR:'),'1',0,'C',1);
$pdf->Cell(90,7,utf8_decode('SUPERVISOR INMEDIATO:'),'1',1,'C',1);
$pdf->SetTextColor(0, 0, 0);//color de texto rgb

$pdf->SetX(16);
$pdf->Cell(90,12,utf8_decode($pdf->Image('../assets/firmas-images/'.$row5['firma'],38,225.5,30)),'LRT',0,'C',0);
$pdf->Cell(90,12,utf8_decode($pdf->Image('../assets/firmas-images/'.$row4['firma'],128,225.5,30)),'LRT',1,'C',0);
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
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,8,utf8_decode('RECIBIDO POR:'.' '. $recibido),'1',1,'L',0);


$pdf->SetX(16);
$pdf->Cell(90,10,utf8_decode($pdf->Image('../assets/firmas-images/'.$row6['firma'],55,259,25)),'LR',0,'C',0);
$pdf->Cell(90,10,utf8_decode(''),'LR',1,'C',0);

$pdf->SetX(16);
$pdf->Cell(90,8,utf8_decode('FIRMA Y SELLO:'),'LRB',0,'L',0);

$pdf->SetX(106);
$pdf->Cell(90,8,utf8_decode('FECHA:  '.date('d-m-Y', strtotime($row['date_apro']))),'LRB',1,'L',0);



// cell(ancho, largo, contenido,borde?, salto de linea?)


$pdf->Output();
?>