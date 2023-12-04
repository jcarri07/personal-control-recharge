
<?php

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
require_once "../database/conexion.php";

// if (date("m-d") == "01-01") {
//     $dias_feriados = actualizar_feriados();
//     $año_uno = mysqli_real_escape_string($conn, $dias_feriados["año_uno"]);
//     $año_dos = mysqli_real_escape_string($conn, $dias_feriados["año_dos"]);

//     mysqli_query($conn, "UPDATE feriados SET days_actual = '$año_uno', days_siguiente = '$año_dos' WHERE id = 1");
// }

$user = $_SESSION['id_usuario'];
$tipo_user = $_SESSION['tipo_usuario'];

$años_combinados = array();

if (isset($_POST['Guardar'])) {

    $tipo_solicitud  = mysqli_real_escape_string($conn, trim($_POST['tipo_sol']));
    $fecha_ini  = mysqli_real_escape_string($conn, trim($_POST['fecha_ini']));
    $fecha_fin  = mysqli_real_escape_string($conn, trim($_POST['fecha_fin']));
    $subject  = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $supervisor  = mysqli_real_escape_string($conn, trim($_POST['jefe']));
    $motivo_permisos  = mysqli_real_escape_string($conn, trim($_POST['subject_per']));
    $horario  = mysqli_real_escape_string($conn, trim($_POST['horario']));

    $fecha_reintegro = "";
    $periodos = 0;

    $fecha1 = new DateTime($fecha_ini);
    $fecha2 =  new DateTime($fecha_fin);
    $diff = $fecha1->diff($fecha2);

    $diff = ($diff->days) + 1;

    $estatus  = "pendiente";

    if ($tipo_solicitud == "Constancia") {
        $estatus_supervisor  = "aprobada";
    } else {
        $estatus_supervisor  = "pendiente";
        if ($tipo_solicitud == "Vacaciones") {

            // consulto los dias feriados
            $consulta = "SELECT days_actual, days_siguiente FROM feriados WHERE id = '1'";
            $resultado = mysqli_query($conn, $consulta);
            $fila = mysqli_fetch_assoc($resultado);

            $año_actual = array();
            $año_siguiente = array();

            $año_actual = json_decode($fila['days_actual']);
            $año_siguiente = json_decode($fila['days_siguiente']);

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

            $fecha_ini  = mysqli_real_escape_string($conn, trim($_POST['fecha_ini_vaca']));
            $cant_periodos = mysqli_real_escape_string($conn, trim($_POST['peri_disfrute']));
            $periodos = $cant_periodos;

            $resultado = calcularVacaciones($fecha_ini, $cant_periodos, $periodosExperiencia, $años_combinados);
            $fechaFinal = $resultado['fechaFinal'];
            $diaReintegro = $resultado['diaReintegro'];
            $diff = $resultado['diasDisfrute'];
            $fecha_fin = $fechaFinal;
            $fecha_reintegro = $diaReintegro;
            // echo "Fecha final de las vacaciones: " . $fechaFinal . "\n";
            // echo "Día de reintegro: " . $diaReintegro . "\n";

            // echo "       " . $fecha_ini_vaca . " " . $cant_periodos;
            // echo implode(" ",$años_combinados);

        }
    }


    if($tipo_solicitud == "Permisos"){
        $subject = $motivo_permisos;
        $fecha_ini  = mysqli_real_escape_string($conn, trim($_POST['fecha_ini_per']));
        $fecha_fin  = mysqli_real_escape_string($conn, trim($_POST['fecha_fin_per']));
    }

    // echo $fecha_ini. "Hola" . $fecha_fin." ". $subject;

    $query = mysqli_query($conn, "INSERT INTO solicitud(id_usuario,tipo_solicitud,motivo,fecha_inicio,fecha_fin,dias_cant,horario,created_date,estatus,estatus_supervisor,supervisor) 
                                            VALUES('$user','$tipo_solicitud','$subject','$fecha_ini','$fecha_fin','$diff','$horario',NOW(),'$estatus','$estatus_supervisor','$supervisor')")
        or die('error' . mysqli_error($conn));

   


    if ($query) {
        if($tipo_solicitud == "Vacaciones"){
            $id = mysqli_insert_id($conn);
            $query2 = mysqli_query($conn, "INSERT INTO datos_vacaciones(id_solicitud, fecha_reintegro, cant_periodos)
                                            VALUES('$id', '$fecha_reintegro', '$periodos')")
            or die('error' . mysqli_error($conn));
            if(!$query2){
                header("location: ../home/solicitudes.php?alert=2");
            }
        }
        header("location: ../home/solicitudes.php?alert=1");
    } else {

        header("location: ../home/solicitudes.php?alert=2");
    }
}

if (isset($_POST['Aprobar']) && $tipo_user == "admin") {

    if (isset($_POST['id'])) {

        $id_solicitud = mysqli_real_escape_string($conn, trim($_POST['id']));
        $descripcion  = mysqli_real_escape_string($conn, trim($_POST['radio']));
        $subject  = mysqli_real_escape_string($conn, trim($_POST['subject']));
        $id_solicitud  = mysqli_real_escape_string($conn, trim($_POST['id']));


        $query = mysqli_query($conn, "UPDATE solicitud SET 
                                                                    estatus                 = 'aprobada',
                                                                    descripcion             = '$descripcion',
                                                                    observacion            = '$subject',
                                                                    date_apro             = NOW(),
                                                                    is_read = NULL,
                                                                    aprobado_por         = '$user'
                                                              WHERE id_solicitud       = '$id_solicitud'")
            or die('error: ' . mysqli_error($conn));

        if ($query) {

            header("location: ../home/solicitudes.php?alert=3");
        } else {

            header("location: ../home/solicitudes.php?alert=2");
        }
    }
}
if (isset($_POST['Rechazar']) && $tipo_user == "admin") {

    if (isset($_POST['id'])) {

        $id_solicitud = mysqli_real_escape_string($conn, trim($_POST['id']));
        $descripcion  = mysqli_real_escape_string($conn, trim($_POST['radio']));
        $subject  = mysqli_real_escape_string($conn, trim($_POST['subject']));
        $id_solicitud  = mysqli_real_escape_string($conn, trim($_POST['id']));



        $query = mysqli_query($conn, "UPDATE solicitud SET 
                                                                    estatus      =            'rechazada',
                                                                    descripcion             = '$descripcion',
                                                                    is_read = NULL,
                                                                    observacion            = '$subject'
                                                              WHERE id_solicitud       = '$id_solicitud'")
            or die('error: ' . mysqli_error($conn));

        if ($query) {

            header("location: ../home/solicitudes.php?alert=4");
        } else {

            header("location: ../home/solicitudes.php?alert=2");
        }
    }
}

if (isset($_POST['Aprobar']) && $tipo_user == "jefe") {

    if (isset($_POST['id'])) {

        $id_solicitud = mysqli_real_escape_string($conn, trim($_POST['id']));
        $descripcion  = mysqli_real_escape_string($conn, trim($_POST['radio']));
        $subject  = mysqli_real_escape_string($conn, trim($_POST['subject']));
        $id_solicitud  = mysqli_real_escape_string($conn, trim($_POST['id']));



        $query = mysqli_query($conn, "UPDATE solicitud SET 
                                                                    estatus_supervisor      = 'aprobada',
                                                                    estatus      =            'pendiente',
                                                                    descripcion             = '$descripcion',
                                                                    is_read = NULL,
                                                                    obs_supervisor             = '$subject'
                                                              WHERE id_solicitud       = '$id_solicitud'")
            or die('error: ' . mysqli_error($conn));

        if ($query) {

            header("location: ../home/solicitudes.php?alert=3");
        } else {

            header("location: ../home/solicitudes.php?alert=2");
        }
    }
}
if (isset($_POST['Rechazar']) && $tipo_user == "jefe") {

    if (isset($_POST['id'])) {

        $id_solicitud = mysqli_real_escape_string($conn, trim($_POST['id']));
        $descripcion  = mysqli_real_escape_string($conn, trim($_POST['radio']));
        $subject  = mysqli_real_escape_string($conn, trim($_POST['subject']));
        $id_solicitud  = mysqli_real_escape_string($conn, trim($_POST['id']));



        $query = mysqli_query($conn, "UPDATE solicitud SET 
                                                                    estatus_supervisor      = 'rechazada',
                                                                    estatus      =            'pendiente',
                                                                    descripcion             = '$descripcion',
                                                                    is_read = NULL,
                                                                    obs_supervisor            = '$subject'
                                                              WHERE id_solicitud       = '$id_solicitud'")
            or die('error: ' . mysqli_error($conn));

        if ($query) {

            header("location: ../home/solicitudes.php?alert=4");
        } else {

            header("location: ../home/solicitudes.php?alert=2");
        }
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
    // echo "diasDisfrute: " . $diasDisfrute;
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

// function calculate_feriados($año)
// {
//     $curl = curl_init();

//     curl_setopt_array($curl, [
//         CURLOPT_URL => "https://anyapi.io/api/v1/holidays?country=VE&state=SOME_STRING_VALUE&region=SOME_STRING_VALUE&language=ES&year=" . $año . "&apiKey=hgtp8nbvs7o572e68nchos682p26u28rij4saf5pcg6k9pk42bpgo",
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => "",
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 30,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => "GET",
//     ]);

//     $response = curl_exec($curl);
//     $err = curl_error($curl);

//     curl_close($curl);

//     if ($err) {
//         echo "cURL Error #:" . $err;
//     } else {
//         return $response;
//     }
// }

// function actualizar_feriados()
// {
//     $año = intval(date("Y"));
//     $feriados_actual = calculate_feriados($año);
//     $arreglo_actual = json_decode($feriados_actual, true);
//     $holidays_actual = $arreglo_actual["holidays"];
//     $array_holidays_actual = array();

//     foreach ($holidays_actual as $holiday) {
//         $nuevo_holiday = array(
//             "name" => $holiday["name"],
//             "date" => $holiday["date"],
//             "status" => "activo"
//         );
//         $array_holidays_actual[] = $nuevo_holiday;
//     }

//     $nuevo_json_actual = json_encode($array_holidays_actual,  JSON_UNESCAPED_UNICODE);
//     // echo $nuevo_json_actual;
//     sleep(1);

//     $feriados_siguiente = calculate_feriados(($año+1));
//     $arreglo_siguiente = json_decode($feriados_siguiente, true);
//     $holidays_siguiente = $arreglo_siguiente["holidays"];
//     $array_holidays_siguiente = array();

//     foreach ($holidays_siguiente as $holiday) {
//         $nuevo_holiday = array(
//             "name" => $holiday["name"],
//             "date" => $holiday["date"],
//             "status" => "activo"
//         );
//         $array_holidays_siguiente[] = $nuevo_holiday;
//     }

//     $nuevo_json_siguiente = json_encode($array_holidays_siguiente,  JSON_UNESCAPED_UNICODE);
//     // echo $nuevo_json_siguiente;
//     return array('año_uno' => $nuevo_json_actual, 'año_dos' => $nuevo_json_siguiente);
// }

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


?>


