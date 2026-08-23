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

    /*$lista = array(
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
    );
    $nombre = array();
    $apellido = array();
    $id = array();
    $siglas = array();
    $porcentajes = array();


    $id_unidad = $_GET['uni'];
    $tipo = $_GET['tipo'];
    $unidad = $_GET['unidad'];
    $fecha = $_GET['fecha'];
    $dia = $_GET['dia'];
    $d = new DateTime($fecha);
    $me = $d->format('m');
    $dias = $d->format('t');
    $anio = $d->format('Y');

    if ($tipo == 'Director') {

        if ($id_unidad == '0') {
            $queryUnidades = mysqli_query($conn, "SELECT u.id_unidad,a.condicion
            FROM actividad a
            JOIN usuario u ON u.id_usuario = a.id_usuario
            WHERE DAY(a.fecha) = '$dia' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND a.estatus = 'A'
            ORDER BY u.id_unidad ASC;");

            $queryAsistencia = mysqli_query($conn, "SELECT u.siglas,IF(COUNT(a.id_actividad) > 0, 1, 0) /  1 / t.total_trabajadores * 100 AS porcentaje_asistencias
                                                    FROM
                                                    (
                                                        SELECT id_unidad,COUNT(*) AS total_trabajadores
                                                        FROM usuario
                                                        GROUP BY id_unidad
                                                    ) AS t,unidad u, usuario us, actividad a        
                                                    WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND DAY(a.fecha) = '$dia' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND a.condicion = 'Asistente'
                                                    GROUP BY u.id_unidad
                                                    ORDER BY u.id_unidad ASC;");

            $querySiglas = mysqli_query($conn, "SELECT siglas FROM unidad WHERE estatus = 'A'ORDER BY id_unidad ASC;");
            $i = 0;
            while ($row = mysqli_fetch_array($querySiglas)) {
                $siglas[$i] = $row['siglas'];
                $i++;
            }
            opcionesAll($queryAsistencia, $siglas);     
            ReportesAll(total($lista, $queryUnidades), $siglas);
        } else {
            $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario,a.condicion, DAY(a.fecha) AS dia
                                              FROM unidad i
                                              JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo' 
                                              JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A'
                                              WHERE i.id_unidad = '$id_unidad' AND i.estatus = 'A' AND DAY(fecha) = '$dia' AND MONTH(fecha) = '$me' AND YEAR(fecha) = '$anio'
                                              ORDER BY a.id_usuario ASC;");
            $queryAsistencia = mysqli_query($conn, "SELECT us.nombre, us.apellido,IF(COUNT(a.id_actividad) > 0, 1, 0) * 100 AS porcentaje_asistencias
                                                    FROM
                                                    (
                                                        SELECT id_unidad,COUNT(*) AS total_trabajadores
                                                        FROM usuario
                                                        GROUP BY id_unidad
                                                    ) AS t,unidad u, usuario us, actividad a        
                                                    WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND DAY(a.fecha) = '$dia' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND a.condicion = 'Asistente' AND t.id_unidad = '$id_unidad'
                                                    GROUP BY us.id_usuario
                                                    ORDER BY u.id_unidad ASC;");

            $queryNombres = mysqli_query($conn, "SELECT nombre, apellido,id_usuario FROM usuario WHERE id_unidad = '$id_unidad' estatus = 'A' ORDER BY id_usuario ASC;");
            $i = 1;
            while ($row = mysqli_fetch_array($queryNombres)) {
                $nombre[$i] = $row['nombre'];
                $apellido[$i] = $row['apellido'];
                $id[$i] = $row['id_usuario'];
                $i++;
            }
            opcionesInd($queryAsistencia, $nombre, $apellido);
            ReportesInd(individual($lista, $queryUnidades),$nombre,$apellido,$id);
        }
    }
    if ($tipo == 'Jefe') {
        $queryUnidades = mysqli_query($conn, "SELECT a.id_usuario,a.condicion, DAY(a.fecha) AS dia
                                        FROM unidad i
                                        JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A'  
                                        JOIN actividad a ON u.id_usuario = a.id_usuario AND a.estatus = 'A'
                                        WHERE i.id_unidad = '$unidad' AND NOT u.tipo = 'Director' AND DAY(fecha) = '$dia' AND MONTH(fecha) = '$me' AND YEAR(fecha) = '$anio'
                                        ORDER BY a.id_usuario ASC;");

        $queryAsistencia = mysqli_query($conn, "SELECT us.nombre, us.apellido,IF(COUNT(a.id_actividad) > 0, 1, 0) * 100 AS porcentaje_asistencias
                                                FROM
                                                (
                                                    SELECT id_unidad,COUNT(*) AS total_trabajadores
                                                    FROM usuario
                                                    WHERE NOT id_unidad = '0'
                                                    GROUP BY id_unidad
                                                ) AS t,unidad u, usuario us, actividad a        
                                                WHERE t.id_unidad = u.id_unidad AND u.id_unidad = us.id_unidad AND us.id_usuario = a.id_usuario AND DAY(a.fecha) = '$dia' AND MONTH(a.fecha) = '$me' AND YEAR(a.fecha) = '$anio' AND a.condicion = 'Asistente' AND t.id_unidad = '$unidad'
                                                GROUP BY us.id_usuario
                                                ORDER BY us.id_usuario ASC;");

        $queryNombres = mysqli_query($conn, "SELECT nombre, apellido, id_usuario FROM usuario WHERE id_unidad = '$unidad' estatus = 'A' ORDER BY id_usuario ASC;");
        $i = 1;
        while ($row = mysqli_fetch_array($queryNombres)) {
            $nombre[$i] = $row['nombre'];
            $apellido[$i] = $row['apellido'];
            $id[$i] = $row['id_usuario'];
            $i++;
        }
        opcionesInd($queryAsistencia, $nombre, $apellido);
        ReportesInd(individual($lista, $queryUnidades),$nombre,$apellido,$id);
    }

    function total($lista, $queryUnidades)
    {
        while ($row = mysqli_fetch_array($queryUnidades)) {


            switch ($row['condicion']) {
                case 'Vacaciones':
                    $lista['Vacaciones'][$row['id_unidad']] += 1;
                    //$lista['Vacaciones']['fecha'] = $row['fecha'];
                    break;
                case 'Estudios':
                    $lista['Estudios'][$row['id_unidad']] += 1;
                    //$lista['Estudios']['fecha'] = $row['fecha'];
                    break;
                case 'Otro':
                    $lista['Otro'][$row['id_unidad']] += 1;
                    //$lista['Otro']['fecha'] = $row['fecha'];
                    break;
                case 'Asistente':
                    $lista['Asistente'][$row['id_unidad']] += 1;
                    //$lista['Asistente']['fecha'] = $row['fecha'];
                    break;
                case 'Consulta Médica':
                    $lista['Consulta Médica'][$row['id_unidad']] += 1;
                    //$lista['Consulta Médica']['fecha'] = $row['fecha'];
                    break;
                case 'Permiso Especial':
                    $lista['Permiso Especial'][$row['id_unidad']] += 1;
                    //$lista['Permiso Especial']['fecha'] = $row['fecha'];
                    break;
                default:
                    break;
            };
        }
        return $lista;
    }
    function individual($lista, $queryUnidades)
    {
        while ($row = mysqli_fetch_array($queryUnidades)) {


            switch ($row['condicion']) {
                case 'Vacaciones':
                    $lista['Vacaciones'][$row['id_usuario']] += 1;
                    //$lista['Vacaciones']['fecha'] = $row['fecha'];
                    break;
                case 'Estudios':
                    $lista['Estudios'][$row['id_usuario']] += 1;
                    //$lista['Estudios']['fecha'] = $row['fecha'];
                    break;
                case 'Otro':
                    $lista['Otro'][$row['id_usuario']] += 1;
                    //$lista['Otro']['fecha'] = $row['fecha'];
                    break;
                case 'Asistente':
                    $lista['Asistente'][$row['id_usuario']] += 1;
                    //$lista['Asistente']['fecha'] = $row['fecha'];
                    break;
                case 'Consulta Médica':
                    $lista['Consulta Médica'][$row['id_usuario']] += 1;
                    //$lista['Consulta Médica']['fecha'] = $row['fecha'];
                    break;
                case 'Permiso Especial':
                    $lista['Permiso Especial'][$row['id_usuario']] += 1;
                    //$lista['Permiso Especial']['fecha'] = $row['fecha'];
                    break;
                default:
                    break;
            };
        }return $lista;
    }
    



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
                text: 'Asistencias del Dia',
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
    <?php }

    function opcionesInd($h, $no, $ape)
    {

        $i = 1;
        while ($row = mysqli_fetch_array($h)) {
            $i = 1;
            while ($i <= count($no)) {
                if ($no[$i] == $row['nombre']) {
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
                stacked:true,
                zoom: {
                    enabled: false
                },

            },
            colors: ["#008ffb", "#f60003"],
            dataLabels: {
                enabled: true,
                width: 2,
            },
            labels: ["Asistencias", "Inasistencias"],
            series: [{
                    name: "Asistencias",
                    data: [<?php $i = 1;
                            while ($i <= count($no)) {
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
                            while ($i <= count($no)) {
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
                text: 'Asistencias del Dia',
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
                categories: [<?php $i = 1;
                                while ($i <= count($no)) {
                                    echo "['" . $no[$i] . "','" . $ape[$i] . "']";
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
        
    <?php  }
    function ReportesAll($h, $si)
    {
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
                            while ($i <= count($si)) {
                                echo $h['Vacaciones'][$i];
                                echo ',';
                                $i++;
                            } ?>],



                },
                {
                    name: "Asistencias",
                    data: [<?php $i = 1;
                            while ($i <= count($si)) {
                                echo $h['Asistente'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Consultas Médicas",
                    data: [<?php $i = 1;
                            while ($i <= count($si)) {
                                echo $h['Consulta Médica'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Permisos Especiales",
                    data: [<?php $i = 1;
                            while ($i <= count($si)) {
                                echo $h['Permiso Especial'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Estudios",
                    data: [<?php $i = 1;
                            while ($i <= count($si)) {
                                echo $h['Estudios'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Otros",
                    data: [<?php $i = 1;
                            while ($i <= count($si)) {
                                echo $h['Otro'][$i];
                                echo ',';
                                $i++;
                            } ?>],

                }
            ],
            title: {
                text: 'Cantidad de Reportes del Dia',
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
                                $i = 0;
                                while ($i < count($si)) {
                                    echo "'" . $si[$i] . "'";
                                    echo ',';
                                    $i++;
                                }
                                ?>],
            }
        }

        var chart2 = new ApexCharts(
            document.querySelector("#ca"),
            options2
        );
        chart2.render();

    <?php }
    function ReportesInd($h, $nom,$ape,$id)
    {?>
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
                            while ($i <= count($nom)) {
                                echo $h['Vacaciones'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],



                },
                {
                    name: "Asistencias",
                    data: [<?php $i = 1;
                            while ($i <= count($nom)) {
                                echo $h['Asistente'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Consultas Médicas",
                    data: [<?php $i = 1;
                            while ($i <= count($nom)) {
                                echo $h['Consulta Médica'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Permisos Especiales",
                    data: [<?php $i = 1;
                            while ($i <= count($nom)) {
                                echo $h['Permiso Especial'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Estudios",
                    data: [<?php $i = 1;
                            while ($i <= count($nom)) {
                                echo $h['Estudios'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],

                },
                {
                    name: "Otros",
                    data: [<?php $i = 1;
                            while ($i <= count($nom)) {
                                echo $h['Otro'][$id[$i]];
                                echo ',';
                                $i++;
                            } ?>],

                }
            ],
            title: {
                text: 'Cantidad de Reportes del Dia',
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
                                $i = 1;
                                while ($i <= count($nom)) {
                                    echo "'" . $nom[$i] ." ".$ape[$i]."'";
                                    echo ',';
                                    $i++;
                                }
                                ?>],
            }
        }

        var chart2 = new ApexCharts(
            document.querySelector("#ca"),
            options2
        );
        chart2.render();
        console.log((<?php echo json_encode($nom); ?>))
    <?php }
    closeConection($conn); ?>

    const x = document.querySelector(".convert");
    const y = document.querySelector(".convert2");


    html2canvas(x).then(function(canvas) { //PROBLEMAS
        //console.log(canvas);
        //$("#ca").append(canvas);
        var dataURL = canvas.toDataURL("image/jpeg");

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar-imagen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imagen=' + canvas.toDataURL("image/jpeg", 0.9) + '&numero=' + 1);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                //$("#can").remove();
            }
        }

    });

    html2canvas(y).then(function(canvas) { //PROBLEMAS
        //console.log(canvas);
        //$("#ca").append(canvas);
        var dataURL = canvas.toDataURL("image/jpeg");

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'guardar-imagen.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('imagen=' + canvas.toDataURL("image/jpeg", 0.9) + '&numero=' + 2);
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //console.log(this.responseText);
                //$("#ca").remove();
                url = "Reporte-Diario.php?uni=<?php echo $id_unidad; ?>&&unidad=<?php echo $unidad; ?>&&tipo=<?php echo $tipo ?>&&dia=<?php echo $dia ?>&&fecha=<?php echo $fecha ?>";
                //window.open(url, "_blank");
                window.location = url;
                //window.close();
            }
        }

    });


    $(document).ready(function() {});
</script>