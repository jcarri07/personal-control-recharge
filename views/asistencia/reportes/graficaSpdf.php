<div id="can" class="convert" style="height:500px; width:900px; position:absolute; top:-100%;">

</div>
<div id="ca" class="convert2" style="height:500px; width:900px; position:absolute; top:-100%;"></div>

<link rel="stylesheet" href="../../../assets/css/style-spinner.css">

<div class="loaderPDF">
    <div class="lds-dual-ring"></div>
</div>
<?php
?>
<script src="../../../js/html2canvas.min.js"></script>
<script src="../../../assets/apexchartsjs/apexcharts.min.js"></script>
<script src="../../../js/dayjs.js"></script>
<script src="../../../files/bower_components/jquery/js/jquery.min.js"></script>
<script>
<?php
require_once '../../../database/conexion.php';

//setlocale(LC_TIME, "Spanish");
date_default_timezone_set("America/Caracas");
/*$list = array(
"Vacaciones" => 0,
"Estudios" => 0,
"Asistente" => 0,
"Otro" => 0,
"Consulta Médica" => 0,
"Permiso Especial" => 0,
);*/
$lista = array(
    "Vacaciones" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Estudios" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Asistente" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Otro" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Consulta Médica" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Permiso Especial" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    ),
    "Inasistencia" => array(
        "1" => 0,
        "2" => 0,
        "3" => 0,
        "4" => 0,
        "5" => 0,
        "6" => 0,
        "7" => 0,
        "8" => 0,
        "9" => 0,
        "10" => 0,
        "11" => 0,
        "12" => 0,
        "13" => 0,
        "14" => 0,
        "15" => 0,
        "16" => 0,
        "17" => 0,
        "18" => 0,
        "19" => 0,
        "20" => 0,
        "21" => 0,
        "22" => 0,
        "23" => 0,
        "24" => 0,
        "25" => 0,
        "26" => 0,
        "27" => 0,
        "28" => 0,
        "29" => 0,
        "30" => 0,
        "31" => 0,
    )
);

$sema = array(
    "Mon" => "Lu.",
    "Tue" => "Ma.",
    "Wed" => "Mi.",
    "Thu" => "Ju.",
    "Fri" => "Vi.",
    "Sat" => "Sa.",
    "Sun" => "Do.",
);
$nombre = array();
$apellido = array();
$id = array();
$siglas = array();
$porcentajes = array();


function get_days_of_week($month_num, $week_num)
{
$year = date('Y');
$first_day_of_month = date('N', strtotime("$year-$month_num-01"));
$days_in_month = date('t', strtotime("$year-$month_num-01"));
$days = array();
for ($day = 1; $day <= $days_in_month; $day++) {
    $week_of_month = ceil(($day + $first_day_of_month - 1) / 7);
    if ($week_of_month == $week_num) {
        $days[] = $day;
    }
}
return $days;
};

function laborales($month_num, $week_num)
{
    $year = date('Y');
    $first_day_of_month = date('N', strtotime("$year-$month_num-01"));
    $days_in_month = date('t', strtotime("$year-$month_num-01"));
    $days = array();
    
    for ($day = 1; $day <= $days_in_month; $day++) {
        // Calculamos la semana del mes para el día actual
        $week_of_month = ceil(($day + $first_day_of_month - 1) / 7);
        
        // Verificamos si el día está en la semana que nos interesa
        if ($week_of_month == $week_num) {
            // Verificamos si el día no es sábado ni domingo
            $day_of_week = date('N', strtotime("$year-$month_num-$day"));
            if ($day_of_week != 6 && $day_of_week != 7) {
                $days[] = $day;
            }
        }
    }
    
    // Retornamos la cantidad de días sin contar sábados y domingos
    return count($days);
}

$id_unidad = $_GET['id_unidad'];
$tipo = $_GET['tipo'];
$unidad = $_GET['unidad'];
$numero_semana = $_GET['num'];
$fecha = $_GET['fecha'];
$mes = $_GET['mes']; //mes de consulta
$d = new DateTime($fecha);
$me = $d->format('m'); //mes consulta
$dias = $d->format('t');
$anio = $d->format('Y'); // año consulta
$da = new DateTime();
$dia = $da->format('j');

$dias_semana = get_days_of_week($me, $numero_semana);
$cantidad = count($dias_semana) - 1;
$lab = laborales($me, $numero_semana);

    // Último día del mes
$ultimo_dia_mes = date("Y-m-t", strtotime("$anio-$me-01"));
$ultimo_m = date("t-m-Y", strtotime("$anio-$me-01"));

// Primer día de la semana
$primer_dia_semana = date("Y-m-d", strtotime("$anio-$me-$dias_semana[0]"));

// Último día de la semana
$ultimo_dia_semana = date('Y-m-d', strtotime("{$primer_dia_semana} + " . $cantidad . " days"));
$ultimo_dia_semana = ($ultimo_dia_semana > $ultimo_dia_mes) ? $ultimo_dia_mes : $ultimo_dia_semana;

$primer_d = date("d-m-Y", strtotime("$anio-$me-$dias_semana[0]"));

// Último día de la semana
$ultimo_d = date('d-m-Y', strtotime("{$primer_dia_semana} + " . $cantidad . " days"));
$ultimo_d = ($ultimo_dia_semana > $ultimo_dia_mes) ? $ultimo_m : $ultimo_d;

//GROUP BY dia,u.id_usuario,a.condicion
if ($tipo == 'Director') {
    if ($id_unidad == '0') {
        $queryUnidades = mysqli_query($conn, "SELECT u.id_usuario, a.condicion, DAY(a.fecha) AS dia
        FROM usuario u
        JOIN actividad a ON a.id_usuario = u.id_usuario AND MONTH(a.fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND a.estatus = 'A' AND YEAR(a.fecha) = '$anio'
        WHERE u.estatus = 'A' 
        ORDER BY DAY(fecha) ASC;");
        


        /****AQUI HAGO LA CONSULTA Y GUARDO LA LISTA DE ASISTENCIAS Y INASISTENCIAS****/
        $queryAsistencia = mysqli_query($conn, "SELECT u.siglas,((COUNT(IF(a.id_actividad > 0, 1, 0)) * 100 ) / (t.total_trabajadores * $lab))  AS porcentaje_asistencias
                                        FROM
                                            (
                                                SELECT id_unidad, COUNT(*) AS total_trabajadores
                                                FROM usuario
                                                WHERE NOT id_unidad = '$id_unidad' AND estatus = 'A'
                                                GROUP BY id_unidad
                                            ) AS t, unidad u, usuario us, (SELECT id_actividad,fecha,condicion, id_usuario FROM actividad WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) GROUP BY id_actividad,condicion,DAY(fecha)) AS a
                                        WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente'
                                        GROUP BY u.id_unidad
                                        ORDER BY u.id_unidad ASC;");
        $querySiglas = mysqli_query($conn, "SELECT siglas FROM unidad WHERE estatus = 'A' ORDER BY id_unidad ASC;");
        $i = 0;
        while ($row = mysqli_fetch_array($querySiglas)) {
            $siglas[$i] = $row['siglas'];
            $i++;
        }
        opcionesAll($queryAsistencia, $siglas,$primer_d,$ultimo_d);
    } else {
        $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                                            FROM unidad i
                                            JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo'
                                            JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
                                            WHERE i.id_unidad = '$id_unidad' AND i.estatus = 'A'                                    
                                            ORDER BY a.fecha ASC;");


        $queryAsistencia = mysqli_query($conn, "SELECT us.nombre, us.apellido,((COUNT(IF(a.id_actividad > 0, 1, 0)) * 100 ) / (t.total_trabajadores * $lab)) AS porcentaje_asistencias
                                                FROM  (SELECT id_actividad,fecha,condicion, id_usuario 
                                                        FROM actividad WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana'
                                                        GROUP BY id_actividad,condicion,DAY(fecha)) AS a,usuario us
                                                WHERE us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente' AND us.id_unidad = '$id_unidad' AND us.estatus = 'A' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
                                                GROUP BY us.id_usuario
                                                ORDER BY us.nombre ASC;");
        $queryNombres = mysqli_query($conn, "SELECT nombre, apellido,id_usuario FROM usuario WHERE id_unidad = '$id_unidad' AND estatus = 'A' ORDER BY nombre ASC;");
        $i = 0;
        while ($row = mysqli_fetch_array($queryNombres)) {
            $nombre[$i] = $row['nombre'];
            $apellido[$i] = $row['apellido'];
            $id[$i] = $row['id_usuario'];
            $i++;
        }
        opcionesInd($queryAsistencia, $nombre, $apellido, $id,$primer_d,$ultimo_d);
    }
}
if ($tipo == 'jefe') {
    $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                                    FROM datos_abae i
                                    JOIN usuario u ON i.id_usuario = u.id_usuario AND u.estatus = 'A'  
                                    JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
                                    WHERE i.id_unidad = '$unidad' AND NOT u.tipo_usuario = 'Director' AND i.estatus = 'A' 
                                    
                                    ORDER BY a.fecha ASC;");

    $queryAsistencia = mysqli_query($conn, "SELECT us.nombres, us.apellidos,(COUNT(IF(a.id_actividad > 0, 1, 0)) / $lab) * 100 AS porcentaje_asistencias
                                            FROM usuario us, (SELECT id_actividad,fecha,condicion, id_usuario 
                                                        FROM actividad WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana'
                                                        GROUP BY id_usuario,condicion,DAY(fecha)) AS a, datos_abae da
                                                WHERE us.id_usuario = a.id_usuario AND da.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente' AND da.id_unidad = '$unidad' AND us.estatus = 'A' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
                                            GROUP BY us.id_usuario
                                            ORDER BY us.nombres ASC;");
    $queryNombres = mysqli_query($conn, "SELECT u.nombres, u.apellidos,u.id_usuario FROM usuario u, datos_abae d WHERE u.id_usuario = d.id_usuario AND d.id_unidad = '$unidad' AND u.estatus = 'A' ORDER BY u.nombres ASC;");
    $i = 0;
    while ($row = mysqli_fetch_array($queryNombres)) {
        $nombre[$i] = $row['nombre'];
        $apellido[$i] = $row['apellido'];
        $id[$i] = $row['id_usuario'];
        $i++;
    }
    opcionesInd($queryAsistencia, $nombre, $apellido, $id,$primer_d,$ultimo_d);
}
$i = 0;
while ($row = mysqli_fetch_array($queryUnidades)) {
    /*if ($row['dia'] >= $dia && $me == $mes) {
        break;
    }*/
    switch ($row['condicion']) {
        case 'Vacaciones':
            $lista['Vacaciones'][$row['dia']]++;
            //$lista['Vacaciones']['fecha'] = $row['fecha'];
            break;
        case 'Estudios':
            $lista['Estudios'][$row['dia']]++;
            //$lista['Estudios']['fecha'] = $row['fecha'];
            break;
        case 'Otro':
            $lista['Otro'][$row['dia']]++;
            //$lista['Otro']['fecha'] = $row['fecha'];
            break;
        case 'Asistente':
            $lista['Asistente'][$row['dia']]++;
            //$lista['Asistente']['fecha'] = $row['fecha'];
            break;
        case 'Consulta Médica':
            $lista['Consulta Médica'][$row['dia']]++;
            //$lista['Consulta Médica']['fecha'] = $row['fecha'];
            break;
        case 'Permiso Especial':
            $lista['Permiso Especial'][$row['dia']]++;
            //$lista['Permiso Especial']['fecha'] = $row['fecha'];
            break;
        default:
            //$lista['Inasistencia'][$i]+=$row['inactivo'];
            break;
    };
};



function opcionesAll($h, $si,$primer_d,$ultimo_d)
{
    while ($row = mysqli_fetch_array($h)) {
        $i = 0;
        while ($i < count($si)) {
            if ($si[$i] == $row['siglas']) {
                $porcentajes[$i] = $row['porcentaje_asistencias']>100 ? 100: $row['porcentaje_asistencias'];
            }
            $i++;
        }
    } ?>
/*grafica de asistencias de los trabajadores*/
var options = {
    chart: {
        toolbar: {
            show: false,
        },
        animations: {
            enabled: false,
        },
        height: 500,
        type: 'bar',
        stackType: '100%',
        stacked: true,
        zoom: {
            enabled: false
        },
    },
    colors: ["#008ffb", "#f60003"],
    dataLabels: {
        enabled: true,
        width: 2,
    },
    series: [{
            name: "Asistencias",
            data: [<?php $i = 0;
                    while ($i < count($si)) {
                        if (isset($porcentajes[$i])) {
                            echo round($porcentajes[$i], 2);
                        } else {
                            echo 0;
                        }
                        echo ',';
                        $i++;
                    }
                    ?>],
        },
        {
            name: "Inasistencias",
            data: [<?php $i = 0;
                    while ($i < count($si)) {
                        if (isset($porcentajes[$i])) {
                            echo 100 - round($porcentajes[$i], 2);
                        } else {
                            echo 100;
                        }
                        echo ',';
                        $i++;
                    }
                    ?>],
        }
    ],
    title: {
        text: 'Gráfica de Asistencias de dias laborales entre el <?php echo $primer_d?> y <?php echo $ultimo_d?>',
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#f3f6ff', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    xaxis: {
        type: 'category',
        categories: [<?php $i = 0;
                        while ($i < count($si)) {
                            echo "'" . $si[$i] . "'";
                            echo ',';
                            $i++;
                        }
                        ?>],
    }
}
var chart = new ApexCharts(
    document.querySelector("#can"),
    options
);
chart.render();
/*grafica de informes*/

    
    /*grafica de informes*/
<?php
};
function opcionesInd($h, $no, $ap, $id,$primer_d,$ultimo_d)
    {
        while ($row = mysqli_fetch_array($h)) {
            $i = 0;
            while ($i < count($no)) {
                if ($no[$i] == $row['nombre']) {
                    $porcentajes[$i] = $row['porcentaje_asistencias']>100 ? 100: $row['porcentaje_asistencias'];
                }
                $i++;
            }
        } ?>
        /*grafica de asistencias de los trabajadores*/
        var options = {
            chart: {
                toolbar: {
                    show: false,
                },
                animations: {
                    enabled: false,
                },
                height: 500,
                type: 'bar',
                stackType: '100%',
                stacked: true,
                zoom: {
                    enabled: false
                },
            },
            colors: ["#008ffb", "#f60003"],
            dataLabels: {
                enabled: true,
                width: 2,
            },
            series: [{
                    name: "Asistencias",
                    data: [<?php $i = 0;
                            while ($i < count($no)) {
                                if (isset($porcentajes[$i])) {
                                    echo round($porcentajes[$i], 2);
                                } else {
                                    echo 0;
                                }
                                echo ',';
                                $i++;
                            }
                            ?>],
                },
                {
                    name: "Inasistencias",
                    data: [<?php $i = 0;
                            while ($i < count($no)) {
                                if (isset($porcentajes[$i])) {
                                    echo 100 - round($porcentajes[$i], 2);
                                } else {
                                    echo 100;
                                }
                                echo ',';
                                $i++;
                            }
                            ?>],
                }
            ],
            title: {
                text: 'Gráfica de Asistencias de laborales entre el <?php echo $primer_d;?> y <?php echo $ultimo_d;?>',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f6ff', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                type: 'category',
                categories: [<?php $i = 0;
                                while ($i < count($no)) {
                                    echo "['" . $no[$i] . "','" . $ap[$i] . "']";
                                    echo ',';
                                    $i++;
                                }
                                ?>],
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#can"),
            options
        );
        chart.render();
        
        /*grafica de informes*/
    <?php
    } ?> 

var options2 = {
    chart: {
        toolbar: {
            show: false,
        },
        animations: {
            enabled: false,
        },
        height: 500,
        type: 'bar',
        stacked: true,
        zoom: {
            enabled: false
        },
    },
    colors: ["#008ffb", "#00e396", "#feb019", "#ff4560", "#775dd0", "#808991"],
    dataLabels: {
        enabled: true,
        width: 2,
    },
    series: [{
            name: "Vacaciones",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Vacaciones'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        },
        {
            name: "Asistencias",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Asistente'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        },
        {
            name: "Consultas Médicas",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Consulta Médica'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        },
        {
            name: "Permisos Especiales",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Permiso Especial'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        },
        {
            name: "Estudios",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Estudios'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        },
        {
            name: "Otros",
            data: [<?php $i = 1;
                    foreach ($dias_semana as $di) {
                        echo $lista['Otro'][$di];
                        echo ',';
                        $i++;
                    } ?>],
        }
    ],
    title: {
        text: 'Gráfica de Reportes de la Semana entre <?php echo $primer_d;?> y <?php echo $ultimo_d;?>',
        align: 'left'
    },
    grid: {
        row: {
            colors: ['#f3f6ff', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
    },
    plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',

            },
        },
        dataLabels: {

            enabled: true,
            offsetY: 5,
            style: {
                fontSize: "13px",
                fontWeight: 900,
                colors: ['#fff'],
            },

        },
    xaxis: {
        //type: 'datetime',
        categories: [<?php

                        foreach ($dias_semana as $di) {
                            echo '"';
                            $texto = $sema[date('D', strtotime("$anio-$me-$di"))];

                            echo $texto;
                            echo ' ';
                            echo strval($di);
                            echo '"';
                            echo ',';
                        }


                        ?>],
    }
}
var chart2 = new ApexCharts(
    document.querySelector("#ca"),
    options2
);
chart2.render();
console.log(<?php echo $cantidad;?>);
<?php closeConection($conn); ?>
const x = document.querySelector(".convert");
const y = document.querySelector(".convert2");
var i = 1;
html2canvas(x).then(function(canvas) { //PROBLEMAS
    //$("#ca").append(canvas);
    dataURL = canvas.toDataURL("image/jpeg", 0.9);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'guardar-imagen.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('imagen=' + dataURL + '&numero=' + 1);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            i++;
            //$("#can").remove();
            //window.close();
        } else {
            console.log(this.responseText);
        }
    }
});
html2canvas(y).then(function(canvas) {
    dataURL = canvas.toDataURL("image/jpeg", 0.9);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'guardar-imagen.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('imagen=' + dataURL + '&numero=' + 2);
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            //window.close();
            //$("#ca").remove();
            url = "Reporte-Semanal.php?uni=<?php echo $id_unidad; ?>&&unidad=<?php echo $unidad; ?>&&tipo=<?php echo $tipo ?>&&mes=<?php echo $mes ?>&&fecha=<?php echo $fecha ?>&&num=<?php echo $numero_semana ?>";
            //window.open(url, "_blank");
            window.location = url;
        } else {
            console.log(this.responseText);
        }
    }
});
$(document).ready(function() {
});
</script>