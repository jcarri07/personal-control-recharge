<?php
require_once "../../database/conexion.php";

if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
} else {
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
}

$validacion = mysqli_real_escape_string($conn, trim($_POST['validacion']));

if ($validacion === 'ocupados') {
    $fecha_ini_vaca  = mysqli_real_escape_string($conn, trim($_POST['fecha_ini_vaca']));
    $periodos = mysqli_real_escape_string($conn, trim($_POST['peri_disfrute']));
    echo json_encode(verificarDisponibilidad($fecha_ini_vaca, $periodos, $conn));
}

if ($validacion === 'feriados') {
    $fecha_ini_vaca  = mysqli_real_escape_string($conn, trim($_POST['fecha_ini_vaca']));
    echo verificarFeriados($fecha_ini_vaca, $conn);
}

if ($validacion === 'pendientes') {
    $tipo_solicitud = mysqli_real_escape_string($conn, trim($_POST['valorSeleccionado']));
    echo verificarPendientes($tipo_solicitud, $conn);
}

// echo $fecha_ini_vaca;

function verificarDisponibilidad($fecha_ini_vaca, $periodos, $conn)
{

    // consulto los dias feriados
    $consulta = "SELECT days_actual, days_siguiente FROM feriados WHERE id = '1'";
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    $año_actual = array();
    $año_siguiente = array();

    $año_actual = json_decode($fila['days_actual']);
    $año_siguiente = json_decode($fila['days_siguiente']);

    $años_combinados = array();

    foreach ($año_actual as $days) {
        if($days->status == "activo"){
            $años_combinados[] = explode(" ", $days->date)[0];
        }
    }
    foreach ($año_siguiente as $days) {
        if($days->status == "activo"){
            $años_combinados[] = explode(" ", $days->date)[0];
        }
    }
    // fin de consulta

    $periodosExperiencia = 0;
    $id_usuario = $_SESSION['id_usuario'];
    $query_experiencia = "SELECT * FROM experiencia_instituciones_publicas WHERE id_usuario ='$id_usuario'";
    $datos_experiencias = $conn->query($query_experiencia);

    while ($row = $datos_experiencias->fetch_assoc()) {
        $periodosExperiencia += get_periodos($row['fecha_ingreso'], $row['fecha_egreso']);
    }

    $id = $_SESSION['id_usuario'];

    $query_periodos = mysqli_query($conn, "SELECT SUM(cant_periodos) AS periodos FROM datos_vacaciones,
        (SELECT * FROM solicitud WHERE id_usuario LIKE '$id' AND tipo_solicitud LIKE 'Vacaciones' AND estatus LIKE 'aprobada') AS vacas
        WHERE datos_vacaciones.`id_solicitud` LIKE vacas.id_solicitud")
        or die('error: ' . mysqli_error($conn));
    $data_periodo = mysqli_fetch_assoc($query_periodos);
    $periodosCumplidos = $data_periodo['periodos'];
    
    $periodosExperiencia = ($periodosExperiencia + $periodosCumplidos);
    
    $fecha_ini  = $fecha_ini_vaca;
    $cant_periodos = $periodos;

    $resultado = calcularVacaciones($fecha_ini, $cant_periodos, $periodosExperiencia, $años_combinados);
    $fechaFinal = $resultado['fechaFinal'];
    $diaReintegro = $resultado['diaReintegro'];
    // echo "Fecha final de las vacaciones: " . $fechaFinal . "\n";
    // echo "Día de reintegro: " . $diaReintegro . "\n";

    // // $fecha = mysqli_real_escape_string($conn, $fecha);
    // $consulta = "SELECT COUNT(*) AS total FROM solicitud WHERE id_usuario = '$_SESSION[id_usuario]' AND tipo_solicitud = 'Vacaciones' AND (estatus = 'pendiente' OR estatus = 'aprobada') AND '$fecha_ini_vaca' BETWEEN fecha_inicio AND fecha_fin";
    $consulta = "SELECT fecha_inicio, fecha_fin FROM solicitud WHERE id_usuario = '$_SESSION[id_usuario]' AND tipo_solicitud = 'Vacaciones' AND (estatus = 'pendiente' OR estatus = 'aprobada') 
        AND ( (('$fecha_ini_vaca' BETWEEN fecha_inicio AND fecha_fin) OR ('$fechaFinal' BETWEEN fecha_inicio AND fecha_fin)) OR ( ('$fecha_ini_vaca' < fecha_inicio) AND ('$fechaFinal' > fecha_fin) ) )";
    $resultado = mysqli_query($conn, $consulta);
    $resultado_solicitud = $resultado;
    $rows = mysqli_num_rows($resultado);
    // $fila = mysqli_fetch_assoc($resultado);


    if ($rows > 0) {
        // $consulta_fechas = "SELECT fecha_inicio, fecha_fin FROM solicitud WHERE id_usuario = '$_SESSION[id_usuario]' AND tipo_solicitud = 'Vacaciones' AND (estatus = 'pendiente' OR estatus = 'aprobada') AND '$fecha_ini_vaca' BETWEEN fecha_inicio AND fecha_fin";
        // $resultado_fechas = mysqli_query($conn, $consulta_fechas);
        $arrayFechas = array();
        // $fila_fechas = mysqli_fetch_assoc($resultado_fechas);
        while($fila = mysqli_fetch_assoc($resultado)){
            $arrayFechas[] = array(
                "fecha_inicio" => $fila['fecha_inicio'],
                "fecha_fin" => $fila['fecha_fin']
            );
        }

        return $arrayFechas; // Fecha no disponible
    } else {
        return 1; // Fecha disponible
    }
}

function verificarFeriados($fecha, $conn)
{

    $consulta = "SELECT days_actual, days_siguiente FROM feriados WHERE id = '1'";
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    $año_actual = array();
    $año_siguiente = array();

    $año_actual = json_decode($fila['days_actual']);
    $año_siguiente = json_decode($fila['days_siguiente']);

    $años_combinados = array();

    foreach ($año_actual as $days) {
        if($days->status == "activo"){
            $años_combinados[] = explode(" ", $days->date)[0];
        }
    }
    foreach ($año_siguiente as $days) {
        if($days->status == "activo"){
            $años_combinados[] = explode(" ", $days->date)[0];
        }
    }

    if (in_array($fecha, $años_combinados)) {
        return '1';
    } else {
        return $años_combinados;
    }
}

// FUNCIONES DE CALCULO DE VACACIONES


function calcularVacaciones($fechaInicio, $cantidadPeriodos, $periodosExperiencia, $años_combinados)
{
    $diasPorPeriodo = 20;
    $diasAñadidos = 0;

    for ($i = $periodosExperiencia; $i < ($periodosExperiencia + $cantidadPeriodos); $i++) {
        if($i < 14){
            $diasAñadidos += $i;
        }else{
            $diasAñadidos += 15;
        }
    }

    // Obtenemos la fecha de inicio en formato de objeto DateTime
    $fechaInicioObjeto = new DateTime($fechaInicio);

    // Calculamos la cantidad de días hábiles a sumar (considerando los días adicionales por periodo)
    $diasTotales = ($diasPorPeriodo * $cantidadPeriodos) + ($diasAñadidos);
    $diasDisfrute = $diasTotales;
    // Iteramos hasta encontrar la fecha de finalización
    while ($diasTotales > 0) {
        // Verificamos si el día es feriado, sábado o domingo
        if (!esDiaHabil($fechaInicioObjeto, $años_combinados)) {
            $fechaInicioObjeto->modify('+1 day');
            continue;
        }

        $diasTotales--;
        $fechaInicioObjeto->modify('+1 day');
    }

    // La fecha final es el último día hábil de las vacaciones
    $fechaFinal = $fechaInicioObjeto->modify('-1 day')->format('Y-m-d');

    // Calculamos el día de reintegro (primer día hábil después de las vacaciones)
    $diaReintegroObjeto = clone $fechaInicioObjeto;
    $diaReintegroObjeto->modify('+1 day');

    // En caso de que el día de reintegro sea un sábado o domingo, lo adelantamos al siguiente día hábil
    while (!esDiaHabil($diaReintegroObjeto, $años_combinados)) {
        $diaReintegroObjeto->modify('+1 day');
    }

    $diaReintegro = $diaReintegroObjeto->format('Y-m-d');

    return array('fechaFinal' => $fechaFinal, 'diaReintegro' => $diaReintegro, 'diasDisfrute' => $diasDisfrute);
}

function esDiaHabil($fecha, $años_combinados)
{
    // Verificar si es feriado, sábado o domingo
    $diaSemana = $fecha->format('N');

    if ($diaSemana == 6 || $diaSemana == 7) {
        return false; // Sábado o domingo
    }

    // Aquí puedes agregar la lógica para verificar si es un día feriado, por ejemplo, consultando una base de datos o un servicio externo.
    // Si tienes una lista predefinida de feriados, también puedes comparar la fecha con esa lista.
    // Por simplicidad, en este ejemplo solo se excluyen sábados y domingos.

    $feriados = $años_combinados;

    // Verificar si es un día feriado
    $fechaActual = $fecha->format('Y-m-d');
    if (in_array($fechaActual, $feriados)) {
        return false; // Día feriado
    }

    return true; // Día hábil
}

function calculate_feriados($año)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://anyapi.io/api/v1/holidays?country=VE&state=SOME_STRING_VALUE&region=SOME_STRING_VALUE&language=ES&year=" . $año . "&apiKey=hgtp8nbvs7o572e68nchos682p26u28rij4saf5pcg6k9pk42bpgo",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        return $response;
    }
}

function actualizar_feriados()
{
    $año = intval(date("Y"));
    $feriados_actual = calculate_feriados($año);
    $arreglo_actual = json_decode($feriados_actual, true);
    $holidays_actual = $arreglo_actual["holidays"];
    $array_holidays_actual = array();

    foreach ($holidays_actual as $holiday) {
        $nuevo_holiday = array(
            "name" => $holiday["name"],
            "date" => $holiday["date"],
            "status" => "activo"
        );
        $array_holidays_actual[] = $nuevo_holiday;
    }

    $nuevo_json_actual = json_encode($array_holidays_actual,  JSON_UNESCAPED_UNICODE);
    // echo $nuevo_json_actual;
    sleep(1);

    $feriados_siguiente = calculate_feriados(2024);
    $arreglo_siguiente = json_decode($feriados_siguiente, true);
    $holidays_siguiente = $arreglo_siguiente["holidays"];
    $array_holidays_siguiente = array();

    foreach ($holidays_siguiente as $holiday) {
        $nuevo_holiday = array(
            "name" => $holiday["name"],
            "date" => $holiday["date"],
            "status" => "activo"
        );
        $array_holidays_siguiente[] = $nuevo_holiday;
    }

    $nuevo_json_siguiente = json_encode($array_holidays_siguiente,  JSON_UNESCAPED_UNICODE);
    // echo $nuevo_json_siguiente;
    return array('año_uno' => $nuevo_json_actual, 'año_dos' => $nuevo_json_siguiente);
}

function get_periodos($fechaInicio, $fechaFin = null)
{

    $fechaInicio = new DateTime($fechaInicio); // Fecha de inicio

    if ($fechaFin === null) {
        $fechaFin = new DateTime(); // Fecha actual
    } else {
        $fechaFin = new DateTime($fechaFin); // Fecha de fin
    }

    $diferencia = date_diff($fechaFin, $fechaInicio); // Calcula la diferencia entre las fechas

    return $diferencia->y; // Retorna la diferencia en años

}

function verificarPendientes($tipo_solicitud, $conn){
    $consulta = "SELECT * FROM solicitud WHERE id_usuario = '$_SESSION[id_usuario]' AND tipo_solicitud = '$tipo_solicitud' AND estatus = 'pendiente' ";
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_num_rows($resultado);

    if($fila > 0){
        return '1';
    }else{
        return '0';
    }

}