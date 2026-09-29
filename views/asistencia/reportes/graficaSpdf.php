<div id="can" class="convert" style="height:500px; width:900px; position:absolute; top: -100%;">
</div>
<div id="ca" class="convert2" style="height:500px; width:900px; position:absolute; top: -100%;"></div>

<link rel="stylesheet" href="../../../assets/css/style-spinner.css">


<script src="../../../js/html2canvas.min.js"></script>
<script src="../../../assets/apexchartsjs/apexcharts.min.js"></script>
<script src="../../../js/dayjs.js"></script>
<script src="../../../files/bower_components/jquery/js/jquery.min.js"></script>


<div class="loaderPDF">
    <div class="lds-dual-ring"></div>
</div>

<?php
?>


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
    $categorias = [
        "Vacaciones",
        "Estudios",
        "Asistente",
        "Otro",
        "Consulta Médica",
        "Permiso Especial",
        "Inasistencia",
    ];

    $lista = [];
    foreach ($categorias as $categoria) {
        $lista[$categoria] = array_fill(1, 31, 0);
    }

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
    }

    function getDaysOfWeekOfMonth($year, $month, $week, $clip = true): array
    {
        $year  = (int) $year;
        $month = (int) $month;
        $week  = (int) $week;
        $firstOfMonth = new DateTime("$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01");
        $firstOfMonth->setTime(0, 0, 0);

        // Lunes de la semana que contiene el día 1
        $dow = (int) $firstOfMonth->format('N'); // 1=lunes ... 7=domingo
        $monday = clone $firstOfMonth;
        if ($dow !== 1) {
            $monday->modify('-' . ($dow - 1) . ' days');
        }

        // Avanzar (week - 1) semanas
        if ($week > 1) {
            $monday->modify('+' . ($week - 1) . ' weeks');
        }

        // Construir array de 7 días
        $days = [];
        $cursor = clone $monday;
        for ($i = 0; $i < 7; $i++) {
            if ($clip) {
                $sameMonth = ((int) $cursor->format('n') === $month)
                        && ((int) $cursor->format('Y') === $year);
                if ($sameMonth) {
                    $days[] = $cursor->format('Y-m-d');
                }
            } else {
                $days[] = $cursor->format('Y-m-d');
            }
            $cursor->modify('+1 day');
        }

        return $days;
    }



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
    // $me = $d->format('m'); //mes consulta
    $me = $mes;
    $dias = $d->format('t');
    // $anio = $d->format('Y'); // año consulta
    $anio = $_GET['anio'];
    $da = new DateTime();
    $dia = $da->format('j');
    $id_direccion = $_GET['id_direccion'];

    // $dias_semana = get_days_of_week($me, $numero_semana);
    // print_r($dias_semana);
    $dias_semana = getDaysOfWeekOfMonth($anio, $mes, $numero_semana);
    foreach($dias_semana as &$diaTemp) {
        $diaTemp = explode('-', $diaTemp)[2];
    }

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

    if($tipo == 'Jefe') {
        $id_unidad = $_GET['unidad'];
    }

    //GROUP BY dia,u.id_usuario,a.condicion
    if ($tipo == 'Director') {
        if ($id_unidad == '0') {
            $sql = "SELECT u.id_usuario, a.condicion, DAY(a.fecha) AS dia
                    FROM usuario u
                    JOIN actividad a ON a.id_usuario = u.id_usuario AND 
                        MONTH(a.fecha) = '$me' AND 
                        fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND 
                        a.estatus = 'A' AND 
                        YEAR(a.fecha) = '$anio'
                    JOIN datos_abae da ON da.id_usuario = u.id_usuario AND da.id_direccion = '$id_direccion'
                    WHERE u.estatus = 'activo'
                    ORDER BY DAY(fecha) ASC;";
            $queryUnidades = mysqli_query($conn, $sql);



            /****AQUI HAGO LA CONSULTA Y GUARDO LA LISTA DE ASISTENCIAS Y INASISTENCIAS****/
            // $sql = "SELECT u.siglas,((COUNT(IF(a.id_actividad > 0, 1, 0)) * 100 ) / (t.total_trabajadores * $lab))  AS porcentaje_asistencias
            //         FROM
            //             (
            //                 SELECT id_unidad, COUNT(*) AS total_trabajadores
            //                 FROM usuario
            //                 WHERE NOT id_unidad = '$id_unidad' AND estatus = 'A'
            //                 GROUP BY id_unidad
            //             ) AS t, unidad u, usuario us, (SELECT id_actividad,fecha,condicion, id_usuario FROM actividad WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) GROUP BY id_actividad,condicion,DAY(fecha)) AS a
            //         WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente'
            //         GROUP BY u.id_unidad
            //         ORDER BY u.id_unidad ASC;";
                    
            $sql = "SELECT u.siglas,((COUNT(IF(asistencias.id_actividad > 0, 1, 0)) * 100 ) / (trabajadores_por_unidad.total_trabajadores * $lab))  AS porcentaje_asistencias
                    FROM
                        (
                            SELECT id_unidad, COUNT(*) AS total_trabajadores
                            FROM usuario u, datos_abae da
                            WHERE u.id_usuario = da.id_usuario AND id_unidad <> '$id_unidad' AND u.estatus = 'activo' AND da.id_direccion = '$id_direccion'
                            GROUP BY id_unidad
                        ) AS trabajadores_por_unidad, 
                        (
                            SELECT id_actividad, fecha, condicion, id_usuario 
                            FROM actividad 
                            WHERE estatus = 'A' AND 
                                YEAR(fecha) = '$anio' AND 
                                MONTH(fecha) = '$me' AND 
                                fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND 
                                DAYOFWEEK(fecha) NOT IN (1, 7) 
                            GROUP BY id_actividad, condicion, DAY(fecha)
                        ) AS asistencias,
                        datos_abae da, unidad u, usuario us
                    WHERE trabajadores_por_unidad.id_unidad = da.id_unidad AND 
                        us.id_usuario = da.id_usuario AND  
                        u.id_unidad = da.id_unidad AND 
                        us.id_usuario = asistencias.id_usuario AND 
                        YEAR(asistencias.fecha) = '$anio' AND 
                        fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND 
                        MONTH(asistencias.fecha) = '$me' AND 
                        asistencias.condicion = 'Asistente'
                    GROUP BY u.id_unidad
                    ORDER BY u.id_unidad ASC;";
            $queryAsistencia = mysqli_query($conn, $sql);

            $sql = "SELECT siglas 
                    FROM unidad 
                    WHERE id_direccion = '$id_direccion'
                    ORDER BY id_unidad ASC;";
            $querySiglas = mysqli_query($conn, $sql);
            $i = 0;
            while ($row = mysqli_fetch_array($querySiglas)) {
                $siglas[$i] = $row['siglas'];
                $i++;
            }
            opcionesAll($queryAsistencia, $siglas,$primer_d, $ultimo_d);
        } else {

            
        }
    }
    if (($tipo == 'Jefe' || $tipo == 'Director') && $id_unidad != '0') {
        // $sql = "SELECT u.id_usuario, a.condicion, DAY(a.fecha) AS dia
        //         FROM usuario u
        //         JOIN actividad a ON a.id_usuario = u.id_usuario AND 
        //             MONTH(a.fecha) = '$me' AND 
        //             fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND 
        //             a.estatus = 'A' AND 
        //             YEAR(a.fecha) = '$anio'
        //         JOIN datos_abae da ON da.id_usuario = u.id_usuario AND da.id_direccion = '$id_direccion'
        //         WHERE u.estatus = 'activo'
        //         ORDER BY DAY(fecha) ASC;";

        // $sql = "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
        //         FROM unidad i
        //         JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo'
        //         JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
        //         WHERE i.id_unidad = '$id_unidad' AND i.estatus = 'A'                                    
        //         ORDER BY a.fecha ASC;";
        
        $sql = "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                FROM unidad i
                JOIN usuario u ON u.estatus = 'activo'
                JOIN datos_abae da ON da.id_usuario = u.id_usuario AND 
                    i.id_unidad = da.id_unidad AND 
                    da.id_unidad = '$id_unidad'
                    -- AND da.cargo <> '$tipo'
                JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
                WHERE i.id_unidad = '$id_unidad'                                  
                ORDER BY a.fecha ASC;";
        $queryUnidades = mysqli_query($conn, $sql);


        // $sql  = "SELECT us.nombre, us.apellido,((COUNT(IF(a.id_actividad > 0, 1, 0)) * 100 ) / (t.total_trabajadores * $lab)) AS porcentaje_asistencias
        //         FROM  (SELECT id_actividad,fecha,condicion, id_usuario 
        //                 FROM actividad WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana'
        //                 GROUP BY id_actividad,condicion,DAY(fecha)) AS a,usuario us
        //         WHERE us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente' AND us.id_unidad = '$id_unidad' AND us.estatus = 'A' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND DAYOFWEEK(fecha) NOT IN (1, 7) 
        //         GROUP BY us.id_usuario
        //         ORDER BY us.nombre ASC;";

        $sql = "SELECT us.nombres, us.apellidos, ((COUNT(IF(asistencias.id_actividad > 0, 1, 0)) * 100 ) / (trabajadores_por_unidad.total_trabajadores * $lab)) AS porcentaje_asistencias
            FROM 
            (
                SELECT id_unidad, COUNT(*) AS total_trabajadores
                FROM usuario u, datos_abae da
                WHERE u.id_usuario = da.id_usuario AND id_unidad = '$id_unidad' AND u.estatus = 'activo'
                GROUP BY id_unidad
            ) AS trabajadores_por_unidad, 
            (
                SELECT id_actividad, fecha, condicion, id_usuario 
                FROM actividad 
                WHERE estatus = 'A' AND YEAR(fecha) = '$anio' AND MONTH(fecha) = '$me' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana'
                GROUP BY id_actividad,condicion, DAY(fecha)
            ) AS asistencias, 
            usuario us, datos_abae da
            WHERE us.id_usuario = asistencias.id_usuario AND 
                da.id_usuario = us.id_usuario AND
                YEAR(asistencias.fecha) = '$anio' AND
                MONTH(asistencias.fecha) = '$me' AND 
                asistencias.condicion = 'Asistente' AND 
                da.id_unidad = '$id_unidad' AND 
                us.estatus = 'activo' AND 
                fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND 
                DAYOFWEEK(fecha) NOT IN (1, 7) 
            GROUP BY us.id_usuario
            ORDER BY us.nombres ASC;";

        $queryAsistencia = mysqli_query($conn, $sql);


        $sql = "SELECT nombres, apellidos, u.id_usuario 
                FROM usuario u, datos_abae da
                WHERE u.id_usuario = da.id_usuario AND da.id_unidad = '$id_unidad' AND u.estatus = 'activo'
                ORDER BY nombres ASC;";
        $queryNombres = mysqli_query($conn, $sql);
        $i = 0;
        while ($row = mysqli_fetch_array($queryNombres)) {
            $nombre[$i] = $row['nombres'];
            $apellido[$i] = $row['apellidos'];
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
                break;
            case 'Estudios':
                $lista['Estudios'][$row['dia']]++;
                break;
            case 'Otro':
                $lista['Otro'][$row['dia']]++;
                break;
            case 'Asistente':
                $lista['Asistente'][$row['dia']]++;
                break;
            case 'Consulta Médica':
                $lista['Consulta Médica'][$row['dia']]++;
                break;
            case 'Permiso Especial':
                $lista['Permiso Especial'][$row['dia']]++;
                break;
            default:
                break;
        };
    };



    
?>

<?php

    function opcionesAll($h, $si, $primer_d, $ultimo_d)
    {
        while ($row = mysqli_fetch_array($h)) {
            $i = 0;
            while ($i < count($si)) {
                if ($si[$i] == $row['siglas']) {
                    $porcentajes[$i] = $row['porcentaje_asistencias']>100 ? 100: $row['porcentaje_asistencias'];
                }
                $i++;
            }
        }
?>
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
    }

    function opcionesInd($h, $no, $ap, $id,$primer_d,$ultimo_d)
    {
        while ($row = mysqli_fetch_array($h)) {
            $i = 0;
            while ($i < count($no)) {
                if ($no[$i] == $row['nombres']) {
                    $porcentajes[$i] = $row['porcentaje_asistencias']>100 ? 100: $row['porcentaje_asistencias'];
                }
                $i++;
            }
        } 
?>
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
    } 
?> 

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
<?php 
    closeConection($conn); 
?>
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
                url = "Reporte-Semanal.php?uni=<?php echo $id_unidad; ?>&&unidad=<?php echo $unidad; ?>&&tipo=<?php echo $tipo ?>&&mes=<?php echo $mes ?>&&fecha=<?php echo $fecha ?>&&num=<?php echo $numero_semana ?>&anio=<?php echo $anio; ?>";
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