<?php

require_once '../../../database/conexion.php';

date_default_timezone_set("America/Caracas");
setlocale(LC_TIME, "Spanish");


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


$unidadSearch = $_POST['unidad'];
$cargo = $_POST['cargo'];
$id_unidad = $_POST['id_unidad'];
$id_direccion = $_POST['id_direccion'];
$trabajador_id = $_POST['trabajador_id'];
$cargo_search = $_POST['cargo_search'];
$fecha = new DateTime();
$anio = $fecha->format("Y");
$grafica = $_POST['grafica'];
$anioMes = $_POST['mes'];
$semana = $_POST['semana'];

$categorias = ['Vacaciones', 'Estudios', 'Asistente', 'Otro', 'Consulta Médica', 'Permiso Especial'];

$diasDelMes = 0;
$diasDeLaSemana = [];
$columnas = [];

$addWhereJoinDatosAbae = '';
$addWhere = '';

$primer_dia_semana = null;
$ultimo_dia_semana = null;

if($grafica == 'anio') {
    $rango = range(1, 12);

    $lista = [];
    foreach ($categorias as $categoria) {
        $lista[$categoria] = array_fill_keys($rango, 0);
    }
}

if($grafica == 'mes' || $grafica == 'semana') {
    $rango = range(1, 31);

    $lista = [];
    foreach ($categorias as $categoria) {
        $lista[$categoria] = array_fill_keys($rango, 0);
    }

    $d = new DateTime($anioMes);
    $diasDelMes = $d->format('t');

    $aux = explode("-", $anioMes);
    $anio = $aux[0];
    $mes = $aux[1];

    if($grafica == 'mes') {
        $addWhere .= " AND MONTH(a.fecha) = '$mes' ";
    }

    if($grafica == 'semana') {
        $diasDeLaSemana = [
            "Mon" => "Lu.",
            "Tue" => "Ma.",
            "Wed" => "Mi.",
            "Thu" => "Ju.",
            "Fri" => "Vi.",
            "Sat" => "Sa.",
            "Sun" => "Do.",
        ];

        $diasSemanaSearch = get_days_of_week($mes, $semana);
        $cantidad = count($diasSemanaSearch) - 1;

        $ultimo_dia_mes = date("Y-m-t", strtotime("$anio-$mes-01"));
        $primer_dia_semana = date("Y-m-d", strtotime("$anio-$mes-$diasSemanaSearch[0]"));

        $ultimo_dia_semana = date('Y-m-d', strtotime("{$primer_dia_semana} + " . $cantidad . " days"));
        $ultimo_dia_semana = ($ultimo_dia_semana > $ultimo_dia_mes) ? $ultimo_dia_mes : $ultimo_dia_semana;

        $addWhere .= " AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' ";

        $columnas = [];
        foreach ($diasSemanaSearch as $dia) {
            $texto = $diasDeLaSemana[date('D', strtotime("$anio-$mes-$dia"))];
            $columnas[] = $texto . ' ' . $dia;
        }
    }
}



if($cargo == 'Director') {
    if ($trabajador_id != '0') {
        $addWhere .= " AND a.id_usuario = '$trabajador_id' ";
    }
    else {
        if ($cargo_search != '0') {
            $addWhereJoinDatosAbae .= " AND da.id_direccion = '$id_direccion' AND NOT da.cargo = '$cargo' ";
            $addWhere .= " AND da.cargo = '$cargo_search' ";
        }
        else {
            $addWhereJoinDatosAbae .= " AND da.id_direccion = '$id_direccion' ";
        }

        // if ($cargo_search != '0') {
        //     $addWhere .= " AND da.id_direccion = '$id_direccion' AND da.cargo <> '$cargo' ";
        //     $addWhere .= " AND da.cargo = '$cargo_search' ";
        // }
        // else {
        //     $addWhere .= " AND da.id_direccion = '$id_direccion' ";
        // }

        if ($unidadSearch != '0') {
            $addWhere .= " AND da.id_unidad = '$unidadSearch' ";
        }
    }
}
else {
    if ($cargo == 'Jefe') {
        $addWhere .= " AND da.cargo <> 'Director' ";
        if ($trabajador_id != '0') {
            $addWhere .= " AND a.id_usuario = '$trabajador_id' ";
        } else {
            $addWhere .= " AND da.id_unidad = '$id_unidad' ";
        }
    }
}

$sql = "SELECT a.id_usuario, condicion, MONTH(fecha) as mes, fecha, DAY(fecha) as dia
        FROM actividad a
        INNER JOIN datos_abae da ON a.id_usuario = da.id_usuario $addWhereJoinDatosAbae
        WHERE a.estatus = 'A' AND YEAR(fecha) = '$anio' $addWhere
        GROUP BY id_usuario, condicion, fecha
        ORDER BY fecha ASC;";
$query = mysqli_query($conn, $sql);

if($grafica == 'anio') {
    while ($row = mysqli_fetch_array($query)) {
        $categoria = $row['condicion'];
        if (isset($lista[$categoria])) {
            $lista[$categoria][$row['mes']]++;
            $lista[$categoria]['fecha'] = $row['fecha'];
        }
    }
}

if($grafica == 'mes' || $grafica == 'semana') {
    while ($row = mysqli_fetch_array($query)) {
        $categoria = $row['condicion'];
        if (isset($lista[$categoria])) {
            $lista[$categoria][$row['dia']]++;
        }
    }
}
closeConection($conn);
?>
<!-- <script srs="js/dayjs.js"></script> -->
<script>
    var categorias = <?php echo json_encode($categorias); ?>;
    var lista = <?php echo json_encode($lista); ?>;
    var grafica = "<?php echo $grafica; ?>";
    var columnas = [];

    if(grafica == 'anio') {
        var series = categorias.map(function(categoria) {
            var data = [];
            for (var mes = 1; mes <= 12; mes++) {
                data.push(lista[categoria][mes] || 0);
            }
            return {
                name: categoria,
                data: data
            };
        });
        columnas = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    }

    if(grafica == 'mes') {
        const diasDelMes = "<?php echo $diasDelMes; ?>";
        var series = categorias.map(function(categoria) {
            var data = [];
            for (var dia = 1; dia <= diasDelMes; dia++) {
                data.push(lista[categoria][dia] || 0);
            }
            return {
                name: categoria,
                data: data
            };
        });

        for (var dia = 1; dia <= diasDelMes; dia++) {
            columnas.push(dia);
        }
    }

    if(grafica == 'semana') {
        const inicioSemana = "<?php echo $primer_dia_semana; ?>";
        const finSemana = "<?php echo $ultimo_dia_semana; ?>";

        const numeroPrimerDiaSemana = inicioSemana.split("-")[2];
        const numeroUltimoDiaSemana = finSemana.split("-")[2];

        var series = categorias.map(function(categoria) {
            var data = [];
            for (var dia = numeroPrimerDiaSemana; dia <= numeroUltimoDiaSemana; dia++) {
                data.push(lista[categoria][dia] || 0);
            }
            return {
                name: categoria,
                data: data
            };
        });

        columnas = <?php echo json_encode($columnas); ?>;
    }

    

    var options = {
        series: series,
        chart: {
            height: 500,
            width: '97%',
            type: 'bar',
            stacked: true,
            zoom: {
                enabled: false,
            },
        },

        colors: ["#008ffb", "#00e396", "#feb019", "#ff4560", "#775dd0", "#808991"],
        dataLabels: {
            enabled: false,
            width: 5,
        },
        stroke: {
            show: true,
            width: 1,
            colors: ['transparent']
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
        title: {
            text: 'Gráfica de Reportes',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f6ff', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: columnas
        },
    }

    var chart = new ApexCharts(document.querySelector("#grafica"), options);
    chart.render();
</script>
