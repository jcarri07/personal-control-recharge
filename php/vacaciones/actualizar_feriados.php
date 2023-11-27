<?php
require_once "../../database/conexion.php";

$dias_feriados = actualizar_feriados($conn);
$año_uno = mysqli_real_escape_string($conn, $dias_feriados["año_uno"]);
$año_dos = mysqli_real_escape_string($conn, $dias_feriados["año_dos"]);

mysqli_query($conn, "UPDATE feriados SET days_actual = '$año_uno', days_siguiente = '$año_dos', fecha_actualizacion = CURDATE() WHERE id = 1");

function actualizar_feriados($conn)
{
    $año = intval(date("Y"));
    $feriados_actual = calculate_feriados($año);
    $arreglo_actual = json_decode($feriados_actual, true);
    $holidays_actual = $arreglo_actual["holidays"];
    $array_holidays_actual = array();

    //consulta de los dias feriados en base de dato

    $consulta = "SELECT days_actual, days_siguiente FROM feriados WHERE id = '1'";
    $resultado = mysqli_query($conn, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    $año_actual = array();
    $año_siguiente = array();

    $año_actual = json_decode($fila['days_actual'], true, 512, JSON_UNESCAPED_UNICODE);
    $año_siguiente = json_decode($fila['days_siguiente'], true, 512, JSON_UNESCAPED_UNICODE);

    foreach ($holidays_actual as $holiday) {
        $encontrado = false;
        $status = "";
        foreach ($año_actual as $day_feriado) {
            if ($holiday["name"] === $day_feriado["name"]) {
                $encontrado = true;
                $status = $day_feriado["status"];
                break;
            }
        }
        if($encontrado){
            $nuevo_holiday = array(
                "name" => $holiday["name"],
                "date" => $holiday["date"],
                "status" => $status
            );
            $array_holidays_actual[] = $nuevo_holiday;
        }else{
            $nuevo_holiday = array(
                "name" => $holiday["name"],
                "date" => $holiday["date"],
                "status" => "activo"
            );
            $array_holidays_actual[] = $nuevo_holiday;
        }
    }

    $nuevo_json_actual = json_encode($array_holidays_actual,  JSON_UNESCAPED_UNICODE);
    // echo $nuevo_json_actual;
    sleep(1);

    $feriados_siguiente = calculate_feriados(($año + 1));
    $arreglo_siguiente = json_decode($feriados_siguiente, true);
    $holidays_siguiente = $arreglo_siguiente["holidays"];
    $array_holidays_siguiente = array();

    foreach ($holidays_siguiente as $holiday) {
        $encontrado = false;
        $status = "";
        foreach ($año_siguiente as $day_feriado) {
            if ($holiday["name"] === $day_feriado["name"]) {
                $encontrado = true;
                $status = $day_feriado["status"];
                break;
            }
        }
        if($encontrado){
            $nuevo_holiday = array(
                "name" => $holiday["name"],
                "date" => $holiday["date"],
                "status" => $status
            );
            $array_holidays_siguiente[] = $nuevo_holiday;
        }else{
            $nuevo_holiday = array(
                "name" => $holiday["name"],
                "date" => $holiday["date"],
                "status" => "activo"
            );
            $array_holidays_siguiente[] = $nuevo_holiday;
        }
    }

    $nuevo_json_siguiente = json_encode($array_holidays_siguiente,  JSON_UNESCAPED_UNICODE);
    // echo $nuevo_json_siguiente;
    return array('año_uno' => $nuevo_json_actual, 'año_dos' => $nuevo_json_siguiente);
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


    echo '1';


