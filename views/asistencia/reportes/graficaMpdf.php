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
    $nombre = array();
    $apellido = array();
    $id = array();
    $siglas = array();
    $porcentajes = array();

    $id_unidad = $_GET['id_unidad'];
    $tipo = $_GET['tipo'];
    $unidad = $_GET['unidad'];
    $fecha = $_GET['fecha'];
    $mes = $_GET['mes']; //mes de consulta
    $d = new DateTime($fecha);
    $me = $d->format('m'); //mes consulta
    $dias = $d->format('t');
    $anio = $d->format('Y'); // año consulta
    $da = new DateTime();
    $dia = $da->format('j');
    //GROUP BY dia,u.id_usuario,a.condicion
    if ($tipo == 'Director') {
        if ($id_unidad == '0') {
            $queryUnidades = mysqli_query($conn, "SELECT u.id_usuario, a.condicion, DAY(a.fecha) AS dia
            FROM usuario u
            JOIN actividad a ON a.id_usuario = u.id_usuario AND MONTH(a.fecha) = '$me' AND a.estatus = 'A' AND YEAR(a.fecha) = '$anio'
            WHERE u.estatus = 'A' 
            ORDER BY DAY(fecha) ASC;");
            
    
    
            /****AQUI HAGO LA CONSULTA Y GUARDO LA LISTA DE ASISTENCIAS Y INASISTENCIAS****/
            $queryAsistencia = mysqli_query($conn, "SELECT u.siglas,COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha))) / t.total_trabajadores * 100 AS porcentaje_asistencias
                                            FROM
                                                (
                                                    SELECT id_unidad, COUNT(*) AS total_trabajadores
                                                    FROM datos_abae
                                                    WHERE NOT id_unidad = '$id_unidad' AND estatus = 'A'
                                                    GROUP BY id_unidad
                                                ) AS t, unidad u, usuario us, (SELECT id_actividad,fecha,condicion, id_usuario FROM actividad WHERE estatus = 'A' GROUP BY id_usuario,condicion,DAY(fecha)) AS a
                                            WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente'
                                            GROUP BY u.id_unidad
                                            ORDER BY u.id_unidad ASC;");
            $querySiglas = mysqli_query($conn, "SELECT siglas FROM unidad WHERE estatus = 'A' ORDER BY id_unidad ASC;");
            $i = 0;
            while ($row = mysqli_fetch_array($querySiglas)) {
                $siglas[$i] = $row['siglas'];
                $i++;
            }
            opcionesAll($queryAsistencia, $siglas);
        } else {
            $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                                              FROM datos_abae i
                                              JOIN usuario u ON i.id_usuario = u.id_usuario AND u.estatus = 'A' AND NOT u.tipo = '$tipo'
                                              JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio'
                                              WHERE i.id_unidad = '$id_unidad' AND i.estatus = 'A'                                    
                                              ORDER BY a.fecha ASC;");


            $queryAsistencia = mysqli_query($conn, "SELECT us.nombres, us.apellidos,(COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha)))) * 100 AS porcentaje_asistencias
                                                    FROM  (SELECT id_actividad,fecha,condicion, id_usuario 
                                                            FROM actividad 
                                                            GROUP BY id_usuario,condicion,DAY(fecha)) AS a,usuario us
                                                    WHERE us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente' AND us.id_unidad = '$id_unidad' AND us.estatus = 'A'
                                                    GROUP BY us.id_usuario
                                                    ORDER BY us.nombre ASC;");
            $queryNombres = mysqli_query($conn, "SELECT u.nombres, u.apellidos,u.id_usuario FROM usuario u, datos_abae i WHERE i.id_unidad = '$id_unidad' AND u.id_usuario = i.id_usuario AND u.estatus = 'A' ORDER BY u.nombres ASC;");
            $i = 0;
            while ($row = mysqli_fetch_array($queryNombres)) {
                $nombre[$i] = $row['nombres'];
                $apellido[$i] = $row['apellidos'];
                $id[$i] = $row['id_usuario'];
                $i++;
            }
            opcionesInd($queryAsistencia, $nombre, $apellido, $id);
        }
    }
    if ($tipo == 'jefe') {
        $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                                        FROM datos_abae i
                                        JOIN usuario u ON i.id_usuario = u.id_usuario AND u.estatus = 'A'  
                                        JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A' AND MONTH(a.fecha) = '$me' AND YEAR(fecha) = '$anio'
                                        WHERE i.id_unidad = '$unidad' AND NOT u.tipo_usuario = 'Director' AND i.estatus = 'A' 
                                        
                                        ORDER BY a.fecha ASC;");

        $queryAsistencia = mysqli_query($conn, "SELECT us.nombres, us.apellidos,(COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha)))) * 100 AS porcentaje_asistencias
                                                FROM usuario us,datos_abae i, (SELECT id_actividad,fecha,condicion, id_usuario 
                                                            FROM actividad WHERE estatus = 'A'
                                                            GROUP BY id_usuario,condicion,DAY(fecha)) AS a
                                                 WHERE us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND MONTH(a.fecha) = '$me' AND a.condicion = 'Asistente' AND i.id_usuario = us.id_usuario AND i.id_unidad = '$unidad' AND us.estatus = 'A'
                                                GROUP BY us.id_usuario
                                                ORDER BY us.nombres ASC;");
        $queryNombres = mysqli_query($conn, "SELECT u.nombres, u.apellidos,u.id_usuario FROM usuario u, datos_abae i WHERE i.id_unidad = '$unidad' AND u.id_usuario = i.id_usuario AND u.estatus = 'A' ORDER BY u.nombres ASC;");
        $i = 0;
        while ($row = mysqli_fetch_array($queryNombres)) {
            $nombre[$i] = $row['nombres'];
            $apellido[$i] = $row['apellidos'];
            $id[$i] = $row['id_usuario'];
            $i++;
        }
        opcionesInd($queryAsistencia, $nombre, $apellido, $id);
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
    
    ?>
            <?php
    function opcionesAll($h, $si)
    {
        while ($row = mysqli_fetch_array($h)) {
            $i = 0;
            while ($i < count($si)) {
                if ($si[$i] == $row['siglas']) {
                    $porcentajes[$i] = $row['porcentaje_asistencias'];
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
            text: 'Gráfica de Asistencias del Mes',
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
    <?php
    }
    function opcionesInd($h, $no, $ap, $id)
    {
        while ($row = mysqli_fetch_array($h)) {
            $i = 0;
            while ($i < count($no)) {
                if ($no[$i] == $row['nombre']) {
                    $porcentajes[$i] = $row['porcentaje_asistencias'];
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
                text: 'Gráfica de Asistencias del Mes',
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
                        while ($i <= $dias) {
                            echo $lista['Vacaciones'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            },
            {
                name: "Asistencias",
                data: [<?php $i = 1;
                        while ($i <= $dias) {
                            echo $lista['Asistente'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            },
            {
                name: "Consultas Médicas",
                data: [<?php $i = 1;
                        while ($i <= $dias) {
                            echo $lista['Consulta Médica'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            },
            {
                name: "Permisos Especiales",
                data: [<?php $i = 1;
                        while ($i <= $dias) {
                            echo $lista['Permiso Especial'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            },
            {
                name: "Estudios",
                data: [<?php $i = 1;
                        while ($i <= $dias) {
                            echo $lista['Estudios'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            },
            {
                name: "Otros",
                data: [<?php $i = 1;
                        while ($i <= $dias) {
                            echo $lista['Otro'][$i];
                            echo ',';
                            $i++;
                        } ?>],
            }
        ],
        title: {
            text: 'Gráfica de Reportes del Mes',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f6ff', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            //type: 'datetime',
            categories: [<?php
                            $j = 1;
                            while ($j <= $dias) {
                                echo $j;
                                echo ',';
                                $j++;
                            }
                            ?>],
        }
    }
    var chart2 = new ApexCharts(
        document.querySelector("#ca"),
        options2
    );
    chart2.render();
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
                url = "Reporte-Mensual.php?uni=<?php echo $id_unidad; ?>&&unidad=<?php echo $unidad; ?>&&tipo=<?php echo $tipo ?>&&mes=<?php echo $mes ?>&&fecha=<?php echo $fecha ?>";
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