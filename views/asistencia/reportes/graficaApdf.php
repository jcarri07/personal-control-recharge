<div id="uno" class="convert" style="height:500px; width:900px; position:absolute; top:-100%;"></div>
<div id="dos" class="convert2" style="height:500px; width:900px; position:absolute; top:-100%;"></div>
<div id="tres" class="convert3" style="height:500px; width:900px; position:absolute; top:-100%;"></div>
<div id="cuatro" class="convert4" style="height:500px; width:900px; position:absolute; top:-100%;"></div>

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

    date_default_timezone_set("America/Caracas");
    setlocale(LC_TIME, "Spanish");
    $list = array(
        'Vacaciones' => 0,
        'Estudios' => 0,
        'Asistente' => 0,
        'Otro' => 0,
        'Consulta Médica' => 0,
        'Permiso Especial' => 0,
    );
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
        )
    );

    //$fecha = $_GET['fecha'];

    $siglas = array();
    $unidades = array();


    $anio = $_GET["anio"];
    $d = new DateTime($anio . "-12-31");
    $dias = $d->format('z'); //dias del año dado
    $da = new DateTime();
    $dia = $da->format('z'); //dias del año que se llevan actualmente

    $informeFechas = mysqli_query($conn, "SELECT condicion, MONTH(fecha) as mes, fecha
            FROM actividad
            WHERE YEAR(fecha) = '$anio' AND estatus = 'A'
            ORDER BY fecha ASC;");

    $informeUnidades = mysqli_query($conn, "SELECT a.condicion, siglas, a.fecha
            FROM actividad a
            JOIN usuario us ON us.id_usuario = a.id_usuario AND us.estatus = 'A'
            JOIN unidad u ON u.id_unidad = us.id_unidad AND u.estatus = 'A'
            WHERE YEAR(fecha) = '$anio' AND a.estatus = 'A'
            ORDER BY fecha ASC;");

    $add_where = $dias;
    if ($da->format('Y') == $anio && $da->format('m') <= 12 && $da->format('j') < 31) {
        $add_where = $dia;
    }

    /****AQUI HAGO LA CONSULTA Y GUARDO LA LISTA DE ASISTENCIAS Y INASISTENCIAS****/
    $AsistenciaUnidades = mysqli_query($conn, "SELECT u.siglas,COUNT(IF(a.id_actividad > 0, 1, 0)) / '$add_where' / t.total_trabajadores * 100 AS porcentaje_asistencias
                                            FROM
                                                (
                                                    SELECT id_unidad, COUNT(*) AS total_trabajadores
                                                    FROM usuario
                                                    WHERE NOT id_unidad = '0' AND estatus = 'A'
                                                    GROUP BY id_unidad
                                                ) AS t, unidad u, usuario us, (select id_actividad,fecha,condicion, id_usuario FROM actividad WHERE AND estatus = 'A' GROUP BY id_usuario,condicion,DAY(fecha)) AS a
                                            WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND a.condicion = 'Asistente'
                                            GROUP BY u.id_unidad
                                            ORDER BY u.id_unidad ASC;");

    $AsistenciaFechas = mysqli_query($conn, "SELECT MONTH(a.fecha) AS mes,COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha))) / t.total_trabajadores * 100 AS porcentaje_asistencias
                                            FROM
                                                (
                                                    SELECT id_unidad, COUNT(*) AS total_trabajadores
                                                    FROM usuario
                                                    WHERE NOT id_unidad = '0' AND estatus = 'A'
                                                    GROUP BY id_unidad
                                                ) AS t, unidad u, usuario us, (select id_actividad,fecha,condicion, id_usuario FROM actividad WHERE estatus = 'A' GROUP BY id_usuario,condicion,DAY(fecha)) AS a
                                            WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$anio' AND a.condicion = 'Asistente'
                                            GROUP BY mes
                                            ORDER BY u.id_unidad ASC;");

    $querySiglas = mysqli_query($conn, "SELECT siglas FROM unidad WHERE estatus = 'A' ORDER BY id_unidad ASC;");
    $i = 0;
    while ($row = mysqli_fetch_array($querySiglas)) {
        $siglas[$i] = $row['siglas'];
        $i++;
    }
    opcionesUnidad($AsistenciaUnidades, $siglas);
    opcionesFecha($AsistenciaFechas, $siglas);
    //opcionesFecha($queryAsistencia, $siglas);
    $i = 0;
    while ($i < count($siglas)) {
        $unidades[$siglas[$i]] = array();
        $unidades[$siglas[$i]] = $list;
        $i++;
    }
    ?> console.log(<?php echo json_encode($unidades); ?>);
    <?php
    while ($row = mysqli_fetch_array($informeFechas)) {


        switch ($row['condicion']) {
            case 'Vacaciones':
                $lista['Vacaciones'][$row['mes']]++;

                break;
            case 'Estudios':
                $lista['Estudios'][$row['mes']]++;

                break;
            case 'Otro':
                $lista['Otro'][$row['mes']]++;

                break;
            case 'Asistente':
                $lista['Asistente'][$row['mes']]++;

                break;
            case 'Consulta Médica':
                $lista['Consulta Médica'][$row['mes']]++;

                break;
            case 'Permiso Especial':
                $lista['Permiso Especial'][$row['mes']]++;

                break;
            default:
                break;
        };
    }
    while ($row = mysqli_fetch_array($informeUnidades)) {


        switch ($row['condicion']) {
            case 'Vacaciones':
                $unidades[$row['siglas']]['Vacaciones']++;

                break;
            case 'Estudios':
                $unidades[$row['siglas']]['Estudios']++;

                break;
            case 'Otro':
                $unidades[$row['siglas']]['Otro']++;

                break;
            case 'Asistente':
                $unidades[$row['siglas']]['Asistente']++;

                break;
            case 'Consulta Médica':
                $unidades[$row['siglas']]['Consulta Médica']++;

                break;
            case 'Permiso Especial':
                $unidades[$row['siglas']]['Permiso Especial']++;

                break;
            default:
                break;
        };
    }
    reportesUnidad($unidades, $siglas);
    reportesFecha($lista);
    function opcionesUnidad($h, $si)
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
                text: 'Asistencias en el Año por Unidad',
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
            document.querySelector("#uno"),
            options
        );
        chart.render();
    <?php }
    Conn::exit_db($conn);

    function opcionesFecha($h, $si)
    { 

        while ($row = mysqli_fetch_array($h)) {

                    $porcentajes[$row['mes']] = $row['porcentaje_asistencias'];

        }?>


        var options1 = {
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
                    data: [<?php $i = 1;
                            while ($i <= 12) {
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
                    data: [<?php $i = 1;
                            while ($i <= 12) {
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
                text: 'Asistencias en el Año por Mes',
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
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#dos"),
            options1
        );
        chart.render();
    <?php }


    function reportesFecha($lista)
    { ?>

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
                            while ($i < 13) {
                                echo $lista['Vacaciones'][$i];
                                echo ',';
                                $i++;
                            } ?>],



                },
                {
                    name: "Asistencias",
                    data: [<?php $i = 1;
                            while ($i < 13) {
                                echo $lista['Asistente'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Consultas Médicas",
                    data: [<?php $i = 1;
                            while ($i < 13) {
                                echo $lista['Consulta Médica'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Permisos Especiales",
                    data: [<?php $i = 1;
                            while ($i < 13) {
                                echo $lista['Permiso Especial'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Estudios",
                    data: [<?php $i = 1;
                            while ($i < 13) {
                                echo $lista['Estudios'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Otros",
                    data: [<?php $i = 1;
                            while ($i < 13) {
                                echo $lista['Otro'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                }
            ],
            title: {
                text: 'Gráfica de Reportes Realizados por Mes',
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
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#tres"),
            options
        );
        chart.render();
    <?php }

    function reportesUnidad($uni, $si)
    { ?>
        var options3 = {
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
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Vacaciones'];
                                echo ',';
                                $i++;
                            } ?>],



                },
                {
                    name: "Asistencias",
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Asistente'];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Consultas Médicas",
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Consulta Médica'];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Permisos Especiales",
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Permiso Especial'];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Estudios",
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Estudios'];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Otros",
                    data: [<?php $i = 0;
                            while ($i < count($si)) {
                                echo $uni[$si[$i]]['Otro'];
                                echo ',';
                                $i++;
                            } ?>],

                }
            ],
            title: {
                text: 'Gráfica de Reportes Realizados por Unidad',
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
            document.querySelector("#cuatro"),
            options3
        );
        chart.render();
    <?php } ?>

    const x = document.querySelector(".convert");
    const y = document.querySelector(".convert2");
    const w = document.querySelector(".convert3");
    const z = document.querySelector(".convert4");
    var i = 1;
    html2canvas(x).then(function(canvas) {

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

        //$("#ca").append(canvas);
        dataURL = canvas.toDataURL("image/jpeg", 0.9);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar-imagen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imagen=' + dataURL + '&numero=' + 2);
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
    html2canvas(w).then(function(canvas) {

        //$("#ca").append(canvas);
        dataURL = canvas.toDataURL("image/jpeg", 0.9);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar-imagen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imagen=' + dataURL + '&numero=' + 3);
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
    html2canvas(z).then(function(canvas) {

        dataURL = canvas.toDataURL("image/jpeg", 0.9);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar-imagen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imagen=' + dataURL + '&numero=' + 4);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                //window.close();
                url = "Reporte-Anual.php?anio=<?php echo $anio ?>";
                //window.open(url, "_blank");
                window.location = url;
            } else {
                console.log(this.responseText);
            }
        }


    });
</script>