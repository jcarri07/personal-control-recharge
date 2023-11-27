<?php
require_once('../database/conexion.php');
//session_start();

// INICIO DE LA VERIFICACIÓN EN LA API DE LOS DIAS FERIADOS, PARA QUE SEAN CARGADOS EN LA BASE DE DATOS SI NO EXISTEN , Y DE EXISTIR QUE LOS ACTUALICE.
$query = "SELECT * FROM feriados WHERE id = 1";
$resultado = mysqli_query($conn, $query);
// date("m-d") == "01-01"
if (mysqli_num_rows($resultado) > 0) {
    $registro = mysqli_fetch_assoc($resultado);
    $anioActual = date('Y');
    $anioRegistro = date('Y', strtotime($registro['fecha_actualizacion']));

    if ($anioRegistro < $anioActual) {
        $dias_feriados = actualizar_feriados($conn);
        $año_uno = mysqli_real_escape_string($conn, $dias_feriados["año_uno"]);
        $año_dos = mysqli_real_escape_string($conn, $dias_feriados["año_dos"]);

        mysqli_query($conn, "UPDATE feriados SET days_actual = '$año_uno', days_siguiente = '$año_dos', fecha_actualizacion = CURDATE() WHERE id = 1");
    }
} else {
    $dias_feriados = crear_feriados();
    $año_uno = mysqli_real_escape_string($conn, $dias_feriados["año_uno"]);
    $año_dos = mysqli_real_escape_string($conn, $dias_feriados["año_dos"]);

    mysqli_query($conn, "INSERT INTO feriados (id,days_actual,days_siguiente,fecha_actualizacion) VALUES (1, '$año_uno', '$año_dos', CURDATE())");
}

function crear_feriados()
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

    $feriados_siguiente = calculate_feriados(($año + 1));
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

// FIN DE LA VERIFICACION EN LA API DE LOS FERIADOS

?>
<div class="page-wrapper">

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Adminty - Premium Admin Template by Colorlib </title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="#">
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="#">
        <!-- Favicon icon -->
        <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="..\files\bower_components\bootstrap\css\bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="..\files\assets\icon\themify-icons\themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="..\files\assets\icon\icofont\css\icofont.css">
        <!-- feather Awesome -->
        <link rel="stylesheet" type="text/css" href="..\files\assets\icon\feather\css\feather.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\new-style.css">

        <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">




        <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\pages\data-table\css\buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css">

        <script src="../files/bower_components/jquery/js/jquery.min.js"></script>
        <script src="../files/bower_components/datatables.net/js/jquery.dataTables.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\jszip.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\pdfmake.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\vfs_fonts.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\buttons.print.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\buttons.html5.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js" defer></script>

        <script>
            function iniciarTabla(id) {
                $('#' + id).DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Entradas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    },
                });
            }

            $(document).ready(function() {
                /*iniciarTabla("tabla_1");
                iniciarTabla("tabla_2");
                iniciarTabla("tabla_3");
                iniciarTabla("tabla_4");
                iniciarTabla("tabla_5");
                iniciarTabla("tabla_6");
                iniciarTabla("tabla_7");
                iniciarTabla("tabla_8");
                iniciarTabla("tabla_9");
                iniciarTabla("tabla_10");
                iniciarTabla("tabla_11");
                iniciarTabla("tabla_12");
                iniciarTabla("tabla_13");
                iniciarTabla("tabla_14");
                iniciarTabla("tabla_15");
                iniciarTabla("tabla_16");*/
            });
        </script>



    </head>

    <?php
    if (empty($_GET['alert'])) {
        echo "";
    } elseif ($_GET['alert'] == 1) {
        echo " <div class='alert alert-success icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                     <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                     <p><strong>Solicitud enviada.</strong> Su requerimiento ha sido enviado para su revisión</p>
                                    </div>";
    } elseif ($_GET['alert'] == 2) {
        echo "<div class='alert alert-warning icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                    <p><strong>Error!</strong> No se pudo completar la solicitud</p>
                                   </div> ";
    } elseif ($_GET['alert'] == 3) {
        echo " <div class='alert alert-success icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                     <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                     <p><strong>Solicitud aprobada.</strong></p>
                                    </div>";
    } elseif ($_GET['alert'] == 4) {
        echo " <div class='alert alert-success icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                     <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                     <p><strong>La solicitud fue rechazada.</strong></p>
                                    </div>";
    }

    if ($_SESSION['tipo_usuario'] == "admin") {
    ?>

        <!-- Page-body start -->
        <div class="page-body">
            <div class="card">
                <!-- Email-card start -->
                <div class="card-block email-card">
                    <div class="row">
                        <div class="col-lg-12 col-xl-3">
                            <div class="user-head row">
                                <div class="user-face">
                                    <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-9">
                            <div class="mail-box-head row">
                                <div class="col-md-12">
                                    <form class="f-right">
                                        <div class="right-icon-control">
                                            <div class="form-icon">
                                                <i class="icofont icofont-search"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $todas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus_supervisor='aprobada'");
                    $value = mysqli_fetch_assoc($todas);

                    //echo "<script>console.log('Console: " .$value['id_solicitud']. "' );</script>";
                    $pendientes = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'pendiente' AND estatus_supervisor='aprobada'");
                    $value1 = mysqli_fetch_assoc($pendientes);

                    $aprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'aprobada' AND estatus_supervisor='aprobada'");
                    $value2 = mysqli_fetch_assoc($aprobadas);

                    $noaprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'rechazada' AND estatus_supervisor='aprobada'");
                    $value3 = mysqli_fetch_assoc($noaprobadas);

                    ?>

                    <div class="row">
                        <!-- Left-side section start -->
                        <div class="col-lg-12 col-xl-3">
                            <div class="user-body">
                                <div class="p-20 text-center">
                                    <!-- <a href="../home/solicitudes-create.php" class="btn btn-danger">Solicitar</a>-->
                                </div>
                                <ul class="page-list nav nav-tabs flex-column" id="pills-tab" role="tablist">
                                    <li class="nav-item mail-section">
                                        <a class="nav-link active" data-toggle="pill" href="#e-inbox" role="tab">
                                            <i class="icofont icofont-document-folder"></i> Solicitudes
                                            <span class="label label-primary f-right"><?php echo ($value['id_solicitud']); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item mail-section">
                                        <a class="nav-link" data-toggle="pill" href="#e-starred" role="tab">
                                            <i class="icofont icofont-eye-alt"></i> Pendientes
                                            <span class="label label-primary f-right"><?php echo ($value1['id_solicitud']); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item mail-section">
                                        <a class="nav-link" data-toggle="pill" href="#e-drafts" role="tab">
                                            <i class="icofont  icofont-check-circled"></i> Aprobadas
                                            <span class="label label-primary f-right"><?php echo ($value2['id_solicitud']); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item mail-section">
                                        <a class="nav-link" data-toggle="pill" href="#e-sent" role="tab">
                                            <i class="icofont icofont-not-allowed"></i> Rechazadas
                                            <span class="label label-primary f-right"><?php echo ($value3['id_solicitud']); ?></span>
                                        </a>
                                    </li>

                                </ul>
                                <!-- <ul class="p-20 label-list">
                                                                <li>
                                                                    <h5>Labels</h5>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-work" href="">Work</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-design" href="">Design</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-family" href="">Family</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-friends" href="">Friends</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-office" href="">Office</a>
                                                                </li>
                                                            </ul>-->
                            </div>
                        </div>
                        <!-- Left-side section end -->
                        <!-- Right-side section start -->

                        <div class="col-lg-12 col-xl-9">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="e-inbox" role="tabpanel">

                                    <div class="mail-body">
                                        <!--  <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive">
                                                <table id="tabla_1" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">ÍTEMM</th>
                                                            <th style="text-align: center">SOLICITUD</th>
                                                            <th style="text-align: center">SOLICITANTE</th>
                                                            <th style="text-align: center">ESTADO</th>
                                                            <th style="text-align: center">FECHA</th>
                                                            <th style="text-align: center">OPCIONES</th>
                                                        </tr>
                                                    </thead>

                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus_supervisor='aprobada' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));


                                                    while ($data = mysqli_fetch_assoc($query)) {

                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);


                                                        echo
                                                        "                              <form method='POST'>
                                                                                        <tr style='text-align: center'>
                                                                                        <td>
                                                                                            <div>
                                                                                                <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                    <label>
                                                                                                        <input type='checkbox' value=''>
                                                                                                        <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <i class='icofont text-warning'></i>
                                                                                            </div>
                                                                                        </td>                                                                              
                                                                                      
                                                                                        <td><a class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                        <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                        <td><a class='email-name'>$data[estatus]</a></td>
                                                                                        <td> <a class='email-time'> " . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</a></td>
                                                                                        <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>
                                                                                        </tr>
                                                                                        </form>
                                                                                        ";
                                                    }
                                                    ?>

                                                    <!--<td><a href="solicitudes-read.php" class="email-name">Google Inc</a></td>
                                                                                    <td><a href="solicitudes-read.php" class="email-name">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a></td>
                                                                                    <td class="email-attch"><a href="#"><i class="icofont icofont-clip"></i></a></td>
                                                                                    <td class="email-time">08:01 AM</td>
                                                                                </tr>-->

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="e-starred" role="tabpanel">
                                    <div class="mail-body">
                                        <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-star"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                        <div class="mail-body-content">
                                            <div class="table-responsive">
                                                <table id="tabla_2" class="table">

                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">ÍTEM</th>
                                                            <th style="text-align: center">SOLICITUD</th>
                                                            <th style="text-align: center">SOLICITANTE</th>
                                                            <th style="text-align: center">ESTADO</th>
                                                            <th style="text-align: center">FECHA</th>
                                                            <th style="text-align: center">OPCIONES</th>
                                                        </tr>
                                                    </thead>

                                                    <tr class="read">
                                                        <?php

                                                        $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus= 'pendiente' AND estatus_supervisor='aprobada' ORDER BY id_solicitud DESC")
                                                            or die('error: ' . mysqli_error($conn));


                                                        while ($data = mysqli_fetch_assoc($query)) {
                                                            $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                                or die('error: ' . mysqli_error($conn));

                                                            $nombre = mysqli_fetch_assoc($query1);

                                                            echo

                                                            "                              <form method='POST'>

                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                        }
                                                        ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="e-drafts" role="tabpanel">

                                    <div class="mail-body">
                                        <!--<div class="mail-body-header">
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div> -->
                                        <div class="mail-body-content">
                                            <div class="table-responsive">
                                                <table id="tabla_3" class="table">

                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">ÍTEM</th>
                                                            <th style="text-align: center">SOLICITUD</th>
                                                            <th style="text-align: center">SOLICITANTE</th>
                                                            <th style="text-align: center">ESTADO</th>
                                                            <th style="text-align: center">FECHA</th>
                                                            <th style="text-align: center">OPCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus = 'aprobada' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));


                                                    while ($data = mysqli_fetch_assoc($query)) {

                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);

                                                        echo
                                                        "                              <form method='POST'>
                                                                                    <tr style='text-align: center'>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                <label>
                                                                                                    <input type='checkbox' value=''>
                                                                                                    <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <i class='icofont text-warning'></i>
                                                                                        </div>
                                                                                    </td>
                                                                                                                                                                            

                                                                                    <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                    <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                    <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                    <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                    <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                    </tr>
                                                                                    </form>

                                                                                    ";
                                                    }
                                                    ?>


                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="e-sent" role="tabpanel">

                                    <div class="mail-body">
                                        <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                        <div class="mail-body-content">
                                            <div class="table-responsive">
                                                <table id="tabla_4" class="table">

                                                    <thead>
                                                        <tr>
                                                            <th style="text-align: center">ÍTEM</th>
                                                            <th style="text-align: center">SOLICITUD</th>
                                                            <th style="text-align: center">SOLICITANTE</th>
                                                            <th style="text-align: center">ESTADO</th>
                                                            <th style="text-align: center">FECHA</th>
                                                            <th style="text-align: center">OPCIONES</th>
                                                        </tr>
                                                    </thead>
                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus= 'rechazada' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));


                                                    while ($data = mysqli_fetch_assoc($query)) {

                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);

                                                        echo
                                                        "                              <form method='POST'>
                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                    }
                                                    ?>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right-side section end -->
                    </div>
                </div>
                <!-- Email-card end -->
            </div>
        </div>
        <!-- Page-body start -->
</div>
<?php
    } else if ($_SESSION['tipo_usuario'] == "empleado") {

?>


    <!-- Page-body start -->
    <div class="page-body">
        <div class="card">
            <!-- Email-card start -->
            <div class="card-block email-card">
                <div class="row">
                    <div class="col-lg-12 col-xl-3">
                        <div class="user-head row">
                            <div class="user-face">
                                <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-9">
                        <div class="mail-box-head row">
                            <div class="col-md-12">
                                <form class="f-right">
                                    <div class="right-icon-control">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

                $todas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE id_usuario='$_SESSION[id_usuario]'");
                $value = mysqli_fetch_assoc($todas);

                //echo "<script>console.log('Console: " .$value['id_solicitud']. "' );</script>";
                $pendientes = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'pendiente' AND estatus_supervisor != 'rechazada' AND id_usuario='$_SESSION[id_usuario]'");
                $value1 = mysqli_fetch_assoc($pendientes);

                $aprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'aprobada' AND id_usuario='$_SESSION[id_usuario]'");
                $value2 = mysqli_fetch_assoc($aprobadas);

                $noaprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE (estatus = 'rechazada' OR estatus_supervisor = 'rechazada') AND id_usuario='$_SESSION[id_usuario]'");
                $value3 = mysqli_fetch_assoc($noaprobadas);

                ?>

                <div class="row">
                    <!-- Left-side section start -->
                    <div class="col-lg-12 col-xl-3">
                        <div class="user-body">
                            <div class="p-20 text-center">
                                <a href="../home/solicitudes-create.php" class="btn btn-danger">Solicitar</a>
                            </div>
                            <ul class="page-list nav nav-tabs flex-column" id="pills-tab" role="tablist">
                                <li class="nav-item mail-section">
                                    <a class="nav-link active" data-toggle="pill" href="#e-inbox" role="tab">
                                        <i class="icofont icofont-document-folder"></i> Solicitudes
                                        <span class="label label-primary f-right"><?php echo ($value['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-starred" role="tab">
                                        <i class="icofont icofont-eye-alt"></i> Pendientes
                                        <span class="label label-primary f-right"><?php echo ($value1['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-drafts" role="tab">
                                        <i class="icofont  icofont-check-circled"></i> Aprobadas
                                        <span class="label label-primary f-right"><?php echo ($value2['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-sent" role="tab">
                                        <i class="icofont icofont-not-allowed"></i> Rechazadas
                                        <span class="label label-primary f-right"><?php echo ($value3['id_solicitud']); ?></span>
                                    </a>
                                </li>

                            </ul>
                            <!-- <ul class="p-20 label-list">
                                                                <li>
                                                                    <h5>Labels</h5>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-work" href="">Work</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-design" href="">Design</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-family" href="">Family</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-friends" href="">Friends</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-office" href="">Office</a>
                                                                </li>
                                                            </ul>-->
                        </div>
                    </div>
                    <!-- Left-side section end -->
                    <!-- Right-side section start -->

                    <div class="col-lg-12 col-xl-9">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="e-inbox" role="tabpanel">

                                <div class="mail-body">
                                    <!--  <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="card-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="tabla_5" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);


                                                    echo
                                                    "                              <form method='POST'>
                                                                                        <tr style='text-align: center'>
                                                                                        <td>
                                                                                            <div>
                                                                                                <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                    <label>
                                                                                                        <input type='checkbox' value=''>
                                                                                                        <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <i class='icofont text-warning'></i>
                                                                                            </div>
                                                                                        </td>                                                                              
                                                                                      
                                                                                        <td><a class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                        <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                        <td><a class='email-name'>$data[estatus]</a></td>
                                                                                        <td> <a class='email-time'> " . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</a></td>
                                                                                        <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;' style='margin-left: 3px;'></i></button> </td>
                                                                                        </tr>
                                                                                        </form>
                                                                                        ";
                                                }
                                                ?>

                                                <!--<td><a href="solicitudes-read.php" class="email-name">Google Inc</a></td>
                                                                                    <td><a href="solicitudes-read.php" class="email-name">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a></td>
                                                                                    <td class="email-attch"><a href="#"><i class="icofont icofont-clip"></i></a></td>
                                                                                    <td class="email-time">08:01 AM</td>
                                                                                </tr>-->

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-starred" role="tabpanel">
                                <div class="mail-body">
                                    <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-star"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_6" class="table table-striped table-bordered nowrap">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <tr class="read">
                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus= 'pendiente' AND estatus_supervisor != 'rechazada' AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));




                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);
                                                        echo

                                                        "                              <form method='POST'>

                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                    }
                                                    ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-drafts" role="tabpanel">

                                <div class="mail-body">
                                    <!--<div class="mail-body-header">
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_7" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus = 'aprobada' AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                    <tr style='text-align: center'>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                <label>
                                                                                                    <input type='checkbox' value=''>
                                                                                                    <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <i class='icofont text-warning'></i>
                                                                                        </div>
                                                                                    </td>
                                                                                                                                                                            

                                                                                    <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                    <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                    <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                    <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                    <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                    </tr>
                                                                                    </form>

                                                                                    ";
                                                }
                                                ?>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-sent" role="tabpanel">

                                <div class="mail-body">
                                    <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_8" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE (estatus = 'rechazada' OR estatus_supervisor = 'rechazada') AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                }
                                                ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right-side section end -->
                </div>
            </div>
            <!-- Email-card end -->
        </div>
    </div>
    <!-- Page-body start -->
    </div>
<?php
    }
    if ($_SESSION['tipo_usuario'] == "jefe") {

?>

    <!-- Page-body start -->
    <div class="page-body">
        <div class="card">
            <!-- Email-card start -->
            <div class="card-block email-card">
                <div class="row">
                    <div class="col-lg-12 col-xl-3">
                        <div class="user-head row">
                            <div class="user-face">
                                <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-9">
                        <div class="mail-box-head row">
                            <div class="col-md-12">
                                <form class="f-right">
                                    <div class="right-icon-control">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

                $todas_jefe = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE id_usuario='$_SESSION[id_usuario]'");
                $value_jefe = mysqli_fetch_assoc($todas_jefe);

                //echo "<script>console.log('Console: " .$value['id_solicitud']. "' );</script>";
                $pendientes_jefe = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'pendiente' AND estatus_supervisor != 'rechazada' AND id_usuario='$_SESSION[id_usuario]'");
                $value1_jeje = mysqli_fetch_assoc($pendientes_jefe);

                $aprobadas_jefe = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus = 'aprobada' AND id_usuario='$_SESSION[id_usuario]'");
                $value2_jefe = mysqli_fetch_assoc($aprobadas_jefe);

                $noaprobadas_jefe = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE (estatus = 'rechazada' OR estatus_supervisor = 'rechazada') AND id_usuario='$_SESSION[id_usuario]'");
                $value3_jefe = mysqli_fetch_assoc($noaprobadas_jefe);

                $todas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WhERE supervisor = '$_SESSION[id_usuario]'");
                $value = mysqli_fetch_assoc($todas);

                //echo "<script>console.log('Console: " .$value['id_solicitud']. "' );</script>";
                $pendientes = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus_supervisor = 'pendiente' AND supervisor = '$_SESSION[id_usuario]'");
                $value1 = mysqli_fetch_assoc($pendientes);

                $aprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus_supervisor = 'aprobada' AND supervisor = '$_SESSION[id_usuario]'");
                $value2 = mysqli_fetch_assoc($aprobadas);

                $noaprobadas = mysqli_query($conn, "SELECT COUNT(*) id_solicitud FROM solicitud WHERE estatus_supervisor = 'rechazada' AND supervisor = '$_SESSION[id_usuario]'");
                $value3 = mysqli_fetch_assoc($noaprobadas);

                ?>

                <div class="row">
                    <!-- Left-side section start -->
                    <div class="col-lg-12 col-xl-3">
                        <div class="user-body">
                            <div class="p-20 text-center">
                                <a href="../home/solicitudes-create.php" class="btn btn-danger">Solicitar</a>
                            </div>
                            <ul class="page-list nav nav-tabs flex-column" id="pills-tab" role="tablist">

                                <li class="nav-item mail-section">
                                    <a class="nav-link active" data-toggle="pill" href="#tab-todas" role="tab">
                                        <i class="icofont icofont-document-folder"></i> Mis solicitudes
                                        <span class="label label-primary f-right"><?php echo ($value_jefe['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#tab-pendientes" role="tab">
                                        <i class="icofont icofont-eye-alt"></i> Pendientes
                                        <span class="label label-primary f-right"><?php echo ($value1_jeje['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#tab-aprobadas" role="tab">
                                        <i class="icofont  icofont-check-circled"></i> Aprobadas
                                        <span class="label label-primary f-right"><?php echo ($value2_jefe['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#tab-rechazadas" role="tab">
                                        <i class="icofont icofont-not-allowed"></i> Rechazadas
                                        <span class="label label-primary f-right"><?php echo ($value3_jefe['id_solicitud']); ?></span>
                                    </a>
                                </li>

                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" role="tab">
                                        <i class="icofont icofont-"></i>
                                    </a>
                                </li>

                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-inbox" role="tab">
                                        <i class="icofont icofont-document-folder"></i> Solicitudes
                                        <span class="label label-primary f-right"><?php echo ($value['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-starred" role="tab">
                                        <i class="icofont icofont-eye-alt"></i> Pendientes por revisar
                                        <span class="label label-primary f-right"><?php echo ($value1['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-drafts" role="tab">
                                        <i class="icofont  icofont-check-circled"></i> Aprobadas por mí
                                        <span class="label label-primary f-right"><?php echo ($value2['id_solicitud']); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" data-toggle="pill" href="#e-sent" role="tab">
                                        <i class="icofont icofont-not-allowed"></i> Rechazadas por mí
                                        <span class="label label-primary f-right"><?php echo ($value3['id_solicitud']); ?></span>
                                    </a>
                                </li>

                            </ul>
                            <!-- <ul class="p-20 label-list">
                                                                <li>
                                                                    <h5>Labels</h5>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-work" href="">Work</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-design" href="">Design</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-family" href="">Family</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-friends" href="">Friends</a>
                                                                </li>
                                                                <li>
                                                                    <a class="mail-office" href="">Office</a>
                                                                </li>
                                                            </ul>-->
                        </div>
                    </div>
                    <!-- Left-side section end -->
                    <!-- Right-side section start -->

                    <div class="col-lg-12 col-xl-9">
                        <div class="tab-content" id="pills-tabContent">
                            <!-- INICIO DE LAS MIAS COMO JEFE -->

                            <div class="tab-pane fade show active" id="tab-todas" role="tabpanel">
                                <div class="mail-body">
                                    <div class="card-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="tabla_9" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);


                                                    echo
                                                    "                              <form method='POST'>
                                                                                        <tr style='text-align: center'>
                                                                                        <td>
                                                                                            <div>
                                                                                                <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                    <label>
                                                                                                        <input type='checkbox' value=''>
                                                                                                        <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <i class='icofont text-warning'></i>
                                                                                            </div>
                                                                                        </td>                                                                              

                                                                                        <td><a class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                        <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                        <td><a class='email-name'>$data[estatus]</a></td>
                                                                                        <td> <a class='email-time'> " . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</a></td>
                                                                                        <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;' style='margin-left: 3px;'></i></button> </td>
                                                                                        </tr>
                                                                                        </form>
                                                                                        ";
                                                }
                                                ?>

                                                <!--<td><a href="solicitudes-read.php" class="email-name">Google Inc</a></td>
                                                                                    <td><a href="solicitudes-read.php" class="email-name">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a></td>
                                                                                    <td class="email-attch"><a href="#"><i class="icofont icofont-clip"></i></a></td>
                                                                                    <td class="email-time">08:01 AM</td>
                                                                                </tr>-->

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-pendientes" role="tabpanel">
                                <div class="mail-body">
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_10" class="table table-striped table-bordered nowrap">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <tr class="read">
                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus = 'pendiente' AND estatus_supervisor = 'pendiente' AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));




                                                    while ($data = mysqli_fetch_assoc($query)) {
                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);
                                                        echo

                                                        "                              <form method='POST'>

                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                    }
                                                    ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-aprobadas" role="tabpanel">
                                <div class="mail-body">
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_11" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus = 'aprobada' AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                    <tr style='text-align: center'>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                <label>
                                                                                                    <input type='checkbox' value=''>
                                                                                                    <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <i class='icofont text-warning'></i>
                                                                                        </div>
                                                                                    </td>
                                                                                                                                                                            

                                                                                    <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                    <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                    <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                    <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                    <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                    </tr>
                                                                                    </form>

                                                                                    ";
                                                }
                                                ?>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-rechazadas" role="tabpanel">
                                <div class="mail-body">
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_12" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE (estatus= 'rechazada' OR estatus_supervisor = 'rechazada') AND id_usuario='$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                }
                                                ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FIN DE LAS MIAS COMO JEFE -->

                            <div class="tab-pane fade" id="e-inbox" role="tabpanel">

                                <div class="mail-body">
                                    <!--  <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="card-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="tabla_13" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE supervisor = '$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);


                                                    echo
                                                    "                              <form method='POST'>
                                                                                        <tr style='text-align: center'>
                                                                                        <td>
                                                                                            <div>
                                                                                                <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                    <label>
                                                                                                        <input type='checkbox' value=''>
                                                                                                        <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                    </label>
                                                                                                </div>
                                                                                                <i class='icofont text-warning'></i>
                                                                                            </div>
                                                                                        </td>                                                                              
                                                                                        
                                                                                        <td><a class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                        <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                        <td><a class='email-name'>$data[estatus_supervisor]</a></td>
                                                                                        <td> <a class='email-time'> " . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</a></td>
                                                                                        <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>
                                                                                        </tr>
                                                                                        </form>
                                                                                        ";
                                                }
                                                ?>

                                                <!--<td><a href="solicitudes-read.php" class="email-name">Google Inc</a></td>
                                                                                    <td><a href="solicitudes-read.php" class="email-name">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</a></td>
                                                                                    <td class="email-attch"><a href="#"><i class="icofont icofont-clip"></i></a></td>
                                                                                    <td class="email-time">08:01 AM</td>
                                                                                </tr>-->

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-starred" role="tabpanel">
                                <div class="mail-body">
                                    <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-star"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_14" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>

                                                <tr class="read">
                                                    <?php

                                                    $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus_supervisor= 'pendiente' AND supervisor = '$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                        or die('error: ' . mysqli_error($conn));


                                                    while ($data = mysqli_fetch_assoc($query)) {

                                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                            or die('error: ' . mysqli_error($conn));

                                                        $nombre = mysqli_fetch_assoc($query1);

                                                        echo

                                                        "                              <form method='POST'>

                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus_supervisor]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                    }
                                                    ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-drafts" role="tabpanel">

                                <div class="mail-body">
                                    <!--<div class="mail-body-header">
                                        <button type="button" class="btn btn-success btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-inbox"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_15" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus_supervisor = 'aprobada' AND supervisor = '$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                    <tr style='text-align: center'>
                                                                                    <td>
                                                                                        <div>
                                                                                            <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                <label>
                                                                                                    <input type='checkbox' value=''>
                                                                                                    <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                </label>
                                                                                            </div>
                                                                                            <i class='icofont text-warning'></i>
                                                                                        </div>
                                                                                    </td>
                                                                                                                                                                            

                                                                                    <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                    <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                    <td><a  class='email-name'>$data[estatus_supervisor]</a></td>
                                                                                    <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                    <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                    </tr>
                                                                                    </form>

                                                                                    ";
                                                }
                                                ?>


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="e-sent" role="tabpanel">

                                <div class="mail-body">
                                    <!-- <div class="mail-body-header">
                                        <button type="button" class="btn btn-primary btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-exclamation-circle"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-xs waves-effect waves-light">
                                            <i class="icofont icofont-ui-delete"></i>
                                        </button>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont icofont-ui-folder"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                        <div class="btn-group dropdown-split-primary">
                                            <button type="button" class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                More
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item waves-effect waves-light" href="#">Action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Another action</a>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item waves-effect waves-light" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="mail-body-content">
                                        <div class="table-responsive">
                                            <table id="tabla_16" class="table">

                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">ÍTEM</th>
                                                        <th style="text-align: center">SOLICITUD</th>
                                                        <th style="text-align: center">SOLICITANTE</th>
                                                        <th style="text-align: center">ESTADO</th>
                                                        <th style="text-align: center">FECHA</th>
                                                        <th style="text-align: center">OPCIONES</th>
                                                    </tr>
                                                </thead>
                                                <?php

                                                $query = mysqli_query($conn, "SELECT * FROM solicitud WHERE estatus_supervisor= 'rechazada' AND supervisor = '$_SESSION[id_usuario]' ORDER BY id_solicitud DESC")
                                                    or die('error: ' . mysqli_error($conn));


                                                while ($data = mysqli_fetch_assoc($query)) {

                                                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='$data[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));

                                                    $nombre = mysqli_fetch_assoc($query1);

                                                    echo
                                                    "                              <form method='POST'>
                                                                                            <tr style='text-align: center'>
                                                                                            <td>
                                                                                                <div>
                                                                                                    <div class='checkbox-fade fade-in-primary checkbox'>
                                                                                                        <label>
                                                                                                            <input type='checkbox' value=''>
                                                                                                            <span class='cr'><i class='cr-icon icofont icofont-verification-check txt-primary'></i></span>
                                                                                                        </label>
                                                                                                    </div>
                                                                                                    <i class='icofont text-warning'></i>
                                                                                                </div>
                                                                                            </td>
                                                                                                                                                                                    

                                                                                            <td><a  class='email-name'>$data[tipo_solicitud]</a></td>
                                                                                            <td><a class='email-name'>$nombre[nombres] $nombre[apellidos]</a></td>
                                                                                            <td><a  class='email-name'>$data[estatus_supervisor]</a></td>
                                                                                            <td class='email-time'>" . date('d-m-Y H:i:s', strtotime($data['created_date'])) . "</td>
                                                                                            <td> <button type='submit' formaction='solicitudes-read.php' formmethod='POST' name='id' value='$data[id_solicitud]' class='btn btn-info btn-outline-info btn-icon'><i class='icofont icofont-eye-alt' style='margin-left: 3px;'></i></button> </td>

                                                                                            </tr>
                                                                                            </form>

                                                                                            ";
                                                }
                                                ?>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right-side section end -->
                </div>
            </div>
            <!-- Email-card end -->
        </div>
    </div>
    <!-- Page-body start -->
    </div>




<?php
    }


?>