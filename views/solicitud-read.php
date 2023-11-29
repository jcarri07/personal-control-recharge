<?php
require_once('../database/conexion.php');
// session_start();
// echo $_GET['id'];
$x = $_SESSION["id_usuario"];
$read = mysqli_query($conn, "UPDATE solicitud SET is_read = 1 WHERE id_usuario = '$x' AND (NOT estatus = 'pendiente' OR NOT estatus_supervisor = 'pendiente')");
$read = mysqli_query($conn, "UPDATE solicitud SET is_read = 1 WHERE supervisor = '$x' AND estatus = 'pendiente'");
?>


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
</head>

<?php

$query = mysqli_query($conn, "SELECT * FROM solicitud WHERE id_solicitud = '$_POST[id]'")
    or die('error: ' . mysqli_error($conn));
$data = mysqli_fetch_assoc($query);
// echo $data['id_solicitud'];
//cambia el dato "is_read"

if (1) {
?>

    <div class="page-wrapper">


        <!-- Page-body start -->
        <div class="page-body">
            <div class="card">

                <!-- Email-card start -->
                <div class="card-block email-card">
                    <div class="row">
                        <div class="col-lg-12 col-xl-3">
                            <div class="user-head row">
                                <div class="user-face">

                                    <?php if ($data['tipo_solicitud'] == 'Constancia') { ?> <?php } ?>

                                    <?php if ($_SESSION['tipo_usuario'] == "admin") { ?>
                                        <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60" <?php if ($data['tipo_solicitud'] == 'Reposo') { ?> onload="aprobadas_reposo(); radio_disable(); validacion()" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Vacaciones') { ?> onload="aprobadas_reposo(); validacion()" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Constancia') { ?> onload="aprobadas_constancia();" <?php } ?>  <?php if ($data['tipo_solicitud'] == 'Permisos') { ?> onload="aprobadas_reposo(); validacion();" <?php } ?>>
                                    <?php } else if (($_SESSION['tipo_usuario'] == "empleado") || ($_SESSION['tipo_usuario'] == "jefe" && $data['id_usuario'] == $_SESSION['id_usuario'])) { ?>
                                        <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60" <?php if ($data['tipo_solicitud'] == 'Reposo' || $data['tipo_solicitud'] == 'Permisos' ) { ?> onload="vista_empl();" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Vacaciones') { ?> onload="vista_empl();" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Constancia') { ?> onload="aprobadas_constancia(); validacion()" <?php } ?>>
                                    <?php } else { ?>
                                        <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60" <?php if ($data['tipo_solicitud'] == 'Reposo') { ?> onload=" radio_disable(); vista_jefe()" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Vacaciones' || $data['tipo_solicitud'] == 'Permisos') { ?> onload=" vista_jefe()" <?php } ?> <?php if ($data['tipo_solicitud'] == 'Constancia') { ?> onload="aprobadas_constancia(); validacion()" <?php } ?>>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-xl-9">
                            <div class="mail-box-head row">
                                <div class="col-md-12">
                                    <form class="f-right">
                                        <div class="right-icon-control">
                                            <div class="form-icon">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php


                    $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario = '$data[id_usuario]'")
                        or die('error: ' . mysqli_error($conn));
                    $datos = mysqli_fetch_assoc($query1);
                    $cargosql = mysqli_query($conn, "SELECT * FROM datos_abae WHERE id_usuario = '$data[id_usuario]'")
                        or die('error: ' . mysqli_error($conn));
                    $cargo = mysqli_fetch_assoc($cargosql);

                    ?>

                    <div class="row">
                        <!-- Left-side section start -->
                        <div class="col-lg-12 col-xl-12">

                            <div class="p-20 text-center">
                                <h3> Solicitud de <?php echo $data['tipo_solicitud'] ?>:</h3>

                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <h4 class="sub-title">Datos del Trabajador:</h4>
                                    <!-- <form> -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Nombres y Apellidos:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo $datos['nombres'] . ' ' . $datos['apellidos']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Cedula:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo $datos['cedula']; ?>" readonly>
                                            </div>
                                        </div>

                                        <?php
                                        $query2 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario = '$datos[id_jefe]'")
                                            or die('error: ' . mysqli_error($conn));
                                        $datos2 = mysqli_fetch_assoc($query2);


                                        $query3 = mysqli_query($conn, "SELECT nombre FROM unidad WHERE id_jefe = '$datos[id_jefe]'")
                                            or die('error: ' . mysqli_error($conn));
                                        $datos3 = mysqli_fetch_assoc($query3);

                                        ?>

                                        <div class="col-sm-6">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Supervisor:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo $datos2['nombres'] . ' ' . $datos2['apellidos']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Cargo:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo  $cargo['cargo']; ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Cargo:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo $datos2['cargo']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="input-group input-group-primary">
                                                <span class="input-group-addon">
                                                    <i>Unidad:</i>
                                                </span>
                                                <input type="text" class="form-control" value="<?php echo $datos3['nombre']; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6 mobile-inputs">

                                    <div class="form-group row">
                                        <h4 class="sub-title">Datos de la Solicitud:</h4>
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-3">
                                            <?php if (($_SESSION['tipo_usuario'] != "empleado") || ($_SESSION['tipo_usuario'] == "jefe" && $data['id_usuario'] == $_SESSION['id_usuario'])) { ?>
                                                <?php if (($_SESSION['tipo_usuario'] == "jefe" && $data['tipo_solicitud'] == 'Constancia') || ($_SESSION['tipo_usuario'] == "jefe" && $data['estatus'] == 'aprobada') || ($_SESSION['tipo_usuario'] == "jefe" && $data['id_usuario'] == $_SESSION['id_usuario'])) { ?>

                                                <?php } else { ?>
                                                    <button class="btn btn-info btn-outline-info" onclick="modificar()" id="modi" style="" data-toggle="tooltip" data-placement="top" title="" data-original-title="Modificar"><i class="icofont icofont-edit"></i></button>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($data['tipo_solicitud'] == 'Reposo') { ?>
                                                <a href="../FPDF/print_pdf.php?id=<?php echo $data['id_solicitud']; ?>" target="_blank" class="btn btn-info btn-outline-info" id="print" style="display:none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir"><i class="icofont icofont-print"></i></a>
                                            <?php } ?>
                                            <?php if ($data['tipo_solicitud'] == 'Vacaciones') { ?>
                                                <a href="../FPDF/vacaciones_pdf.php?id=<?php echo $data['id_solicitud']; ?>" target="_blank" class="btn btn-info btn-outline-info" id="print" style="display:none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir"><i class="icofont icofont-print"></i></a>
                                            <?php } ?>
                                            <?php if ($data['tipo_solicitud'] == 'Permisos') { ?>
                                                <a href="../FPDF/permiso_print.php?id=<?php echo $data['id_solicitud']; ?>" target="_blank" class="btn btn-info btn-outline-info" id="print" style="display:none;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Imprimir"><i class="icofont icofont-print"></i></a>
                                            <?php } ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label sub-title">Motivo:</label>
                                        <div class="col-sm-4">
                                            <textarea class="form-control max-textarea" maxlength="100" rows="3" readonly><?php echo $data['motivo']; ?> </textarea>
                                        </div>
                                        <?php if ($data['tipo_solicitud'] != 'Constancia') { ?>
                                            <label class="col-sm-2 col-form-label sub-title">Obs. del Supervisor:</label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control max-textarea" maxlength="100" rows="3" readonly><?php echo $data['obs_supervisor']; ?> </textarea>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label sub-title">Estado:</label>
                                        <div class="col-sm-4">
                                            <?php if (($_SESSION['tipo_usuario'] != "jefe") || ($_SESSION['tipo_usuario'] == "jefe" && $data['id_usuario'] == $_SESSION['id_usuario'])) { ?>
                                                <input type="text" id="status" class="form-control form-control-primary" value="<?php echo $data['estatus']; ?>" readonly>
                                            <?php } else { ?>
                                                <input type="text" id="supervisor" class="form-control form-control-primary" value="<?php echo $data['estatus_supervisor']; ?>" readonly>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if ($data['tipo_solicitud'] != 'Constancia') { ?>

                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label sub-title">Cantidad de dias exactos:</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="dias" class="form-control form-control-primary" value="<?php echo $data['dias_cant'] . ' dias'; ?>" readonly>
                                            </div>
                                        </div>

                                        <?php if ($data['tipo_solicitud'] == 'Reposo') { ?>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <label class="col-sm-4 col-form-label sub-title">Desde:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_inicio'])); ?>" readonly>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label class="col-sm-4 col-form-label sub-title">Hasta:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_fin'])); ?>" readonly>
                                                </div>
                                            </div>
                                        <?php
                                        } else if ($data['tipo_solicitud'] == 'Vacaciones') {
                                            $query_vacaciones = mysqli_query($conn, "SELECT * FROM datos_vacaciones WHERE id_solicitud = '$_POST[id]'")
                                                or die('error: ' . mysqli_error($conn));
                                            $data_vacaciones = mysqli_fetch_assoc($query_vacaciones);
                                        ?>

                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Desde:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_inicio'])); ?>" readonly>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Hasta:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_fin'])); ?>" readonly>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Reintegro:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data_vacaciones['fecha_reintegro'])); ?>" readonly>
                                                </div>
                                            </div>

                                        <?php } else { ?>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Desde:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_inicio'])); ?>" readonly>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Hasta:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo date('d-m-Y', strtotime($data['fecha_fin'])); ?>" readonly>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="col-sm-8 col-form-label sub-title">Horario:</label>
                                                    <input type="text" class="form-control form-control-primary" value="<?php echo $data['horario']; ?>" readonly>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } ?>

                                    <div class="form-radio">
                                        <form method="POST" action="../default/proses_solicitud.php?id=$data[id_solicitud]" enctype="multipart/form-data">
                                            <input type="text" value="<?php echo $data['id_solicitud']; ?>" name="id" style="display:none;">
                                            <div class="form-group">
                                                <div>
                                                    <label class="col-sm-8 col-form-label sub-title">Observaciones:</label>
                                                    <?php if ($_SESSION['tipo_usuario'] != "jefe") { ?>
                                                        <textarea name="subject" class="form-control max-textarea" id="obs" maxlength="100" rows="4" readonly><?php echo $data['observacion']; ?></textarea>
                                                    <?php } else { ?>
                                                        <textarea name="subject" class="form-control max-textarea" id="obser" maxlength="100" rows="4" readonly><?php echo $data['obs_supervisor']; ?></textarea>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <?php if ($data['tipo_solicitud'] != 'Constancia') { ?>

                                                <?php if ($data['tipo_solicitud'] == 'Reposo' && $_SESSION['tipo_usuario'] == "admin") { ?>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis" name="radio" <?php if($data['descripcion'] == "No aplica validación IVSS") {?> checked="checked" <?php } ?> value="No aplica validación IVSS">
                                                            <i class="helper"></i>No aplica validación por parte del IVSS (solo aplica para reposos de hasta 3 días)
                                                        </label>
                                                    </div>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis1" name="radio" <?php if($data['descripcion'] == "Validado IVSS") {?> checked="checked" <?php } ?> value="Validado IVSS">
                                                            <i class="helper"></i>Reposo validado por el IVSS
                                                        </label>
                                                    </div>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis2" name="radio" <?php if($data['descripcion'] == "Por validar IVSS") {?> checked="checked" <?php } ?> value="Por validar IVSS">
                                                            <i class="helper"></i>Por validar ante el IVSS
                                                        </label>
                                                    </div>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis3" name="radio" <?php if($data['descripcion'] == "Extemporaneo") {?> checked="checked" <?php } ?> value="Extemporaneo">
                                                            <i class="helper"></i>Reposo Extemporaneo
                                                        </label>
                                                    </div>
                                                <?php } ?>

                                                <?php if ($data['tipo_solicitud'] == 'Permisos' && $_SESSION['tipo_usuario'] == "admin") { ?>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis" name="radio" <?php if($data['descripcion'] == "Remunerado") {?> checked="checked" <?php } ?> value="Remunerado">
                                                            <i class="helper"></i>Remunerado
                                                        </label>
                                                    </div>
                                                    <div class="radio radiofill radio-inline">
                                                        <label>
                                                            <input type="radio" id="dis1" name="radio" <?php if($data['descripcion'] == "No remunerado") {?> checked="checked" <?php } ?> value="No remunerado">
                                                            <i class="helper"></i>No remunerado
                                                        </label>
                                                    </div>
                                                <?php } ?>

                                                </br></br></br>
                                                <?php if ($_SESSION['tipo_usuario'] != "jefe") { ?>
                                                    <?php
                                                    $query4 = mysqli_query($conn, "SELECT firma FROM datos_personales WHERE id_usuario = '$datos[id_jefe]'")
                                                        or die('error: ' . mysqli_error($conn));
                                                    $datos4 = mysqli_fetch_assoc($query4);

                                                    $query5 = mysqli_query($conn, "SELECT firma FROM datos_personales WHERE id_usuario = '$_SESSION[id_usuario]'")
                                                        or die('error: ' . mysqli_error($conn));
                                                    $datos5 = mysqli_fetch_assoc($query5);
                                                    ?>


                                                    <div class="form-group row" style="display:none;" id="val">
                                                        <label class="col-sm-3 col-form-label sub-title">Aprobador por:</label>
                                                        <div class="col-sm-8">
                                                        </div>
                                                        <div class="col-sm-2">
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label class="col-sm-8 col-form-label sub-title">Supervisor:</label></br>
                                                            <img src="..\assets\firmas-images\<?php echo $datos4['firma']; ?>" width="200" height="70">

                                                        </div>
                                                        <div class="col-sm-5">
                                                            <label class="col-sm-8 col-form-label sub-title">Gestion Humana:</label></br>
                                                            <img id="apro" src="..\assets\firmas-images\<?php echo $datos5['firma']; ?>" style="display:none;" width="200" height="70">
                                                        </div>
                                                    </div>

                                                    </br></br>
                                                <?php } ?>
                                            <?php } ?>

                                            <div class="w-100 align-center">
                                                <div class="col text-center">
                                                    <?php if (($_SESSION['tipo_usuario'] != "empleado") || ($_SESSION['tipo_usuario'] == "jefe" && $data['id_usuario'] == $_SESSION['id_usuario'])) { ?>
                                                        <button type="submit" class="btn btn-success btn-round" name="Aprobar" style="display:none;" id="aprobar">Aprobar</button>
                                                        <button type="submit" class="btn btn-primary btn-round" name="Rechazar" style="display:none;" id="rechazar">Rechazar</button>
                                                    <?php } ?>
                                                    <a href="../home/solicitudes.php" class="btn btn-inverse btn-round">Cancelar</a>
                                                </div></br>


                                        </form>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    </div>
    </div>

    </div>
    <!-- Page-body end -->
    </div>
    </div>

<?php
}
// DESDE AQUIIIIIIIIIIIIIIII***********************************************************************************************************************************************************************
?>


<script>
    console.log("prueba");
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');

    function radio_disable() {
        var cant = document.getElementById('dias').value;

        if (cant >= '3') {

            document.getElementById('dis').disabled = true;

        }

    }

    function modificar() {

        document.getElementById('aprobar').style.display = '';
        document.getElementById('rechazar').style.display = '';
        document.getElementById('obs').removeAttribute("readonly");
        document.getElementById('dis1').disabled = false;
        document.getElementById('dis2').disabled = false;
        document.getElementById('dis3').disabled = false;


    }

    function aprobadas_constancia() {


        // var constancia = document.getElementById('estatus').value;
        var constancia = document.getElementById('status').value;


        if (constancia == "pendiente") {

            document.getElementById('rechazar').style.display = '';
            document.getElementById('aprobar').style.display = '';
            document.getElementById('modificar').style.display = 'none';
            document.getElementById('obs').removeAttribute("readonly");



        } else {
            document.getElementById('aprobar').style.display = 'none';
            document.getElementById('rechazar').style.display = 'none';
            document.getElementById('modificar').style.display = '';
            document.getElementById('print').style.display = '';



        }


    }

    function aprobadas_reposo() {

        var reposo = document.getElementById('status').value;
        console.log("holaaa");

        if (reposo == "pendiente") {

            document.getElementById('rechazar').style.display = '';
            document.getElementById('aprobar').style.display = '';
            document.getElementById('modi').style.display = 'none';
        } else {
            document.getElementById('aprobar').style.display = 'none';
            document.getElementById('rechazar').style.display = 'none';
            document.getElementById('modi').style.display = '';
        }

    }

    function validacion() {

        var estado = document.getElementById('status').value;

        if (estado == "pendiente") {
            document.getElementById('val').style.display = '';
            document.getElementById('obs').removeAttribute("readonly");

        } else if (estado == "aprobada") {
            document.getElementById('val').style.display = '';
            document.getElementById('apro').style.display = '';
            document.getElementById('print').style.display = '';
            document.getElementById('dis').disabled = true;
            document.getElementById('dis1').disabled = true;
            document.getElementById('dis2').disabled = true;
            document.getElementById('dis3').disabled = true;

        } else if (estado == "rechazada") {
            document.getElementById('val').style.display = '';
            document.getElementById('apro').style.display = 'none';
            document.getElementById('print').style.display = 'none';
            document.getElementById('dis').disabled = true;
            document.getElementById('dis1').disabled = true;
            document.getElementById('dis2').disabled = true;
            document.getElementById('dis3').disabled = true;
        }
    }



    function vista_jefe() {

        var estado = document.getElementById('supervisor').value;
        if (estado == "pendiente") {

            document.getElementById('rechazar').style.display = '';
            document.getElementById('aprobar').style.display = '';
            document.getElementById('modi').style.display = 'none';
            document.getElementById('obser').removeAttribute("readonly");

        }
    }

    function vista_empl() {

        // var estado = document.getElementById('empleado').value;
        var estado = document.getElementById('status').value;

        if (estado == "aprobada") {

            document.getElementById('print').style.display = '';


        }
    }
</script>