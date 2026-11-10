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
    $anio = $_GET['anio'];
    // $d = new DateTime($fecha);
    // $me = $d->format('m'); //mes consulta
    // $dias = $d->format('t');
    // $anio = $d->format('Y'); // año consulta
    // $da = new DateTime();
    // $dia = $da->format('j');
    //GROUP BY dia,u.id_usuario,a.condicion
    $id_direccion = $_GET['id_direccion'];

    $fechaStr = $anio . '-' . ($mes < 10 ? '0' : '') . ($mes) . '-01'; 
    $fecha = new DateTime($fechaStr);
    $dias = $fecha->format('t');


    if ($tipo == 'Director') {
        if ($id_unidad == '0') {
            $sql = "SELECT u.id_usuario, a.condicion, DAY(a.fecha) AS dia
                    FROM usuario u
                    JOIN actividad a ON a.id_usuario = u.id_usuario AND 
                        MONTH(a.fecha) = '$mes' AND 
                        a.estatus = 'A' AND 
                        YEAR(a.fecha) = '$anio'
                    JOIN datos_abae da ON da.id_usuario = u.id_usuario AND da.id_direccion = '$id_direccion'
                    WHERE u.estatus = 'activo' 
                    ORDER BY DAY(fecha) ASC;";
            $queryUnidades = mysqli_query($conn, $sql);
            
    
    
            /****AQUI HAGO LA CONSULTA Y GUARDO LA LISTA DE ASISTENCIAS Y INASISTENCIAS****/
            $sql = "SELECT u.siglas,
                        COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha))) / trabajadores_por_unidad.total_trabajadores * 100 AS porcentaje_asistencias
                    FROM
                        (
                            SELECT id_unidad, COUNT(*) AS total_trabajadores
                            FROM datos_abae
                            WHERE id_unidad <> '0' AND id_direccion = '$id_direccion'
                            GROUP BY id_unidad
                        ) AS trabajadores_por_unidad, 
                        unidad u, 
                        usuario us, 
                        (
                            SELECT id_actividad, fecha, condicion, id_usuario 
                            FROM actividad 
                            WHERE estatus = 'A' 
                            GROUP BY id_usuario, condicion, DAY(fecha)
                        ) AS a,
                        datos_abae da
                    WHERE trabajadores_por_unidad.id_unidad = u.id_unidad AND 
                        u.id_unidad = da.id_unidad AND 
                        da.id_usuario = us.id_usuario AND
                        us.id_usuario = a.id_usuario AND 
                        YEAR(a.fecha) = '$anio' AND 
                        MONTH(a.fecha) = '$mes' AND 
                        a.condicion = 'Asistente'
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
            opcionesAll($queryAsistencia, $siglas);
        } else {
            
        }
    }
    if (($tipo == 'Jefe' || $tipo == 'Director') && $id_unidad != '0') {
        if($tipo == 'Jefe') {
            $id_unidad = $_GET['unidad'];
        }
        $sql ="SELECT a.id_usuario, a.condicion, DAY(a.fecha) AS dia
                FROM datos_abae i
                JOIN usuario u ON i.id_usuario = u.id_usuario AND 
                    u.estatus = 'activo' 
                    -- AND i.cargo <> '$tipo'
                JOIN actividad a ON u.id_usuario = a.id_usuario AND 
                    a.estatus = 'A' AND 
                    MONTH(a.fecha) = '$mes' AND 
                    YEAR(a.fecha) = '$anio'
                WHERE i.id_unidad = '$id_unidad' AND i.estatus = 'activo'                                    
                ORDER BY a.fecha ASC;";
        $queryUnidades = mysqli_query($conn, $sql);


        $sql = "SELECT us.nombres, 
                    us.apellidos, 
                    (COUNT(IF(a.id_actividad > 0, 1, 0)) / IF(MONTH(NOW()) = MONTH(a.fecha),DAY(NOW()),DAY(LAST_DAY(a.fecha)))) * 100 AS porcentaje_asistencias,
                    us.id_usuario
                FROM 
                    (
                        SELECT id_actividad, fecha, condicion, a.id_usuario 
                        FROM actividad a, datos_abae da
                        WHERE a.id_usuario = da.id_usuario AND
                            da.id_unidad = '$id_unidad'
                        GROUP BY id_usuario, condicion, DAY(fecha)
                    ) AS a, usuario us, datos_abae da
                WHERE us.id_usuario = a.id_usuario AND 
                    da.id_usuario = us.id_usuario AND
                    YEAR(a.fecha) = '$anio' AND 
                    MONTH(a.fecha) = '$mes' AND 
                    a.condicion = 'Asistente' AND 
                    da.id_unidad = '$id_unidad' AND 
                    us.estatus = 'activo'
                GROUP BY us.id_usuario
                ORDER BY us.nombres ASC;";
        $queryAsistencia = mysqli_query($conn, $sql);

        $sql = "SELECT u.nombres, u.apellidos, u.id_usuario 
                FROM usuario u, datos_abae da
                WHERE da.id_unidad = '$id_unidad' AND 
                    u.id_usuario = da.id_usuario AND 
                    u.estatus = 'activo' 
                ORDER BY u.nombres ASC;";
        $queryNombres = mysqli_query($conn, $sql);
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
                // if ($no[$i] == $row['nombres']) {
                if ($id[$i] == $row['id_usuario']) {
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
                url = "Reporte-Mensual.php?uni=<?php echo $id_unidad; ?>&&unidad=<?php echo $unidad; ?>&&tipo=<?php echo $tipo ?>&&mes=<?php echo $mes ?>&&fecha=<?php echo $fechaStr; ?>";
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