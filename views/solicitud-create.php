<?php
require_once('../database/conexion.php');
// session_start();

$id = $_SESSION['id_usuario'];

$query_periodos = mysqli_query($conn, "SELECT SUM(cant_periodos) AS periodos FROM datos_vacaciones,
(SELECT * FROM solicitud WHERE id_usuario LIKE '$id' AND tipo_solicitud LIKE 'Vacaciones' AND estatus LIKE 'aprobada') AS vacas
WHERE datos_vacaciones.`id_solicitud` LIKE vacas.id_solicitud")
    or die('error: ' . mysqli_error($conn));
$data_periodo = mysqli_fetch_assoc($query_periodos);

$periodosCumplidos = $data_periodo['periodos'];
$periodosExperiencia = 0;

$query_experiencia = "SELECT * FROM experiencia_instituciones_publicas WHERE id_usuario ='$id'";
$datos_experiencias = $conn->query($query_experiencia);
// $rowExpericncia = $datos_experiencias->fetch_assoc();

$query_abae = "SELECT * FROM datos_abae WHERE id_usuario ='$id'";
$datos_abae = $conn->query($query_abae);
$rowAbae = $datos_abae->fetch_assoc();

$periodosActuales = get_periodos($rowAbae['fecha_ingreso']); 

while ($row = $datos_experiencias->fetch_assoc()) {
    $periodosExperiencia += get_periodos($row['fecha_ingreso'], $row['fecha_egreso']);
}

$periodosDisponibles = ($periodosActuales - $periodosCumplidos);

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

// if ($_POST['tipo_sol'] == 'vacaciones') {
//     $consulta = "SELECT * FROM vacaciones WHERE estado = 'pendiente'";
//     $resultado = mysqli_query($conexion, $consulta);

//     if (mysqli_num_rows($resultado) > 0) {
//         // Aquí puedes mostrar el modal indicando que hay una solicitud pendiente
//         echo '<script>$("#modalPendiente").modal("show");</script>';
//     }
// }

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
                                <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-9">
                        <div class="mail-box-head row">
                            <div class="col-md-12">
                                <form class="f-right">
                                    <div class="right-icon-control">
                                        <!--<input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends-2">
                                                                        <div class="form-icon">
                                                                            <i class="icofont icofont-search"></i>
                                                                        </div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Left-side section start -->
                    <div class="col-lg-12 col-xl-2">
                        <div class="user-body">
                            <div class="p-20 text-center">
                            </div>
                            <!--
                            <ul class="page-list nav nav-tabs flex-column">
                                <li class="nav-item mail-section">
                                    <a class="nav-link" href="solicitudes.php">
                                        <i class="icofont icofont-inbox"></i> Solicitudes
                                        <span class="label label-primary f-right">6</span>
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" href="solicitudes.php">
                                        <i class="icofont icofont-star"></i> Pendientes
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" href="solicitudes.php">
                                        <i class="icofont icofont-file-text"></i> Aprobadas
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" href="solicitudes.php">
                                        <i class="icofont icofont-paper-plane"></i> No aprobadas
                                    </a>
                                </li>
                                <li class="nav-item mail-section">
                                    <a class="nav-link" href="solicitudes.php">
                                        <i class="icofont icofont-ui-delete"></i> Trash
                                        <span class="label label-info f-right">30</span>
                                    </a>
                                </li>
                            </ul>
                            <ul class="p-20 label-list">
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

                    <div class="col-lg-12 col-xl-8">
                        <div class="mail-body">
                            <div class="mail-body">

                                <div class="mail-body-content">

                                    <!--<div class="form-group">
                                                                            <input type="text" class="form-control" placeholder="Tipo de solicitud">
                                                                        </div>-->
                                    <form method="POST" action="../default/proses_solicitud.php" enctype="multipart/form-data">
                                        <div class="col-sm-12 col-xl-12 m-b-30">
                                            <h2 class="sub-title">Tipo de solicitud</h2>
                                            <select name="tipo_sol" id="tipo_sol" class="form-control form-control-primary" onchange="cambiar_form()" required>
                                                <option value="">Seleccione</option>
                                                <?php
                                                $query = mysqli_query($conn, "SELECT * FROM tipo_solicitud WHERE estatus='activa'")
                                                    or die('error ' . mysqli_error($conn));
                                                while ($data = mysqli_fetch_assoc($query)) {
                                                    echo "<option value=\"$data[nombre]\">$data[nombre]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        $query1 = mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario = '$_SESSION[id_usuario]'")
                                            or die('error ' . mysqli_error($conn));
                                        $data1 = mysqli_fetch_assoc($query1) ?>


                                        <div class="form-group" id="form_reposo" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h2 class="sub-title">A partir de:</h2>
                                                    <input type="date" id="fechain" name="fecha_ini" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <h2 class="sub-title">Hasta:</h2>
                                                    <input type="date" id="fechafin" name="fecha_fin" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="form_permisos" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                            <h2 class="sub-title">Motivo del permiso:</h2>
                                            <select name="subject_per" id="subject_per" class="form-control form-control-primary">
                                                <option value="">Seleccione</option>
                                                <option value="Por Docencia">Por Docencia</option>
                                                <option value="Por Estudios">Por Estudios</option>
                                                <option value="Consulta Medica">Consulta Medica</option>
                                                <option value="Matrimonio">Matrimonio</option>
                                                <option value="Fallecimiento de Familiar">Fallecimiento de Familiar</option>
                                                <option value="Lactancia Materna">Lactancia Materna</option>
                                                <option value="Nacimiento de Hijo">Nacimiento de Hijo</option>
                                                <option value="Diligencia Personales">Diligencia Personales</option>
                                                <option value="Cuidados Medicos de Familiares">Cuidados Medicos de Familiares</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                            </div>
                                            <div class="col-md-6">
                                                    <h2 class="sub-title">Horario:</h2>
                                                    <select name="horario" id="horario" class="form-control form-control-primary">
                                                    <option value="">Seleccione</option>
                                                    <option value="Mediodia (Mañana)">Mediodia (Mañana)</option>
                                                    <option value="Mediodia (Tarde)">Mediodia (Tarde)</option>
                                                    <option value="Dia Completo">Dia Completo</option>
                                                  </select>
                                                </div>

                                            </div>
                                           <br> 
                                           <div class="row">
                                                <div class="col-md-6">
                                                    <h2 class="sub-title">A partir de:</h2>
                                                    <input type="date" id="fechain" name="fecha_ini" class="form-control">
                                                </div>

                                                <div class="col-md-6">
                                                    <h2 class="sub-title">Hasta:</h2>
                                                    <input type="date" id="fechafin" name="fecha_fin" class="form-control">
                                                </div>

                                               

                                            </div>
                                        </div>

                                        <div class="form-group" id="form_vacaciones" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h2 class="sub-title">Periodos disponibles:</h2>
                                                    <input type="text" id="peri_disp" name="peri_dips" class="form-control" value="<?php echo $periodosDisponibles ?>" disabled>
                                                </div>
                                                <div class="col-md-4">
                                                    <h2 class="sub-title">Periodos a disfrutar:</h2>
                                                    <select name="peri_disfrute" id="peri_disfrute" class="form-control form-control-primary" onchange="cambiar_form()">
                                                        <option value="1">1</option>
                                                        <?php for ($i = 2; $i <= $periodosDisponibles; $i++) { ?>
                                                            <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <h2 class="sub-title">Fecha de inicio de vacaciones:</h2>
                                                    <input type="date" id="fecha_ini" name="fecha_ini_vaca" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Motivo" style="display:;" required>
                                            <input type="text" id="jefe" name="jefe" value="<?php echo $data1['id_jefe'] ?>" class="form-control" style="display:none;">
                                        </div></br> </br>

                                        <div class="row w-100 align-items-center">
                                            <div class="col text-center">
                                                <button type="submit" class="btn btn-primary btn-round" name="Guardar">Solicitar</button>
                                                <a href="../home/solicitudes.php" class="btn btn-inverse btn-round">Cancelar</a>
                                            </div>
                                        </div>



                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Right-side section end -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page-body end -->
</div>
</div>

<!-- INICIO DE MODALES -->

<div class="modal fade" id="modalPendiente" tabindex="-1" role="dialog" aria-labelledby="modalPendienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPendienteLabel">Solicitud Pendiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Hay una solicitud de vacaciones pendiente que aún no ha sido aprobada.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="feather icon-alert-circle"></i>
                </div>
                <h4 class="modal-title w-100">Solicitud Pendiente!</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Hay una solicitud de vacaciones pendiente que aún no ha sido aprobada.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div id="fechaModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="feather icon-alert-circle"></i>
                </div>
                <h4 class="modal-title w-100">Atención!</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Sus vacaciones no pueden iniciar en fines de semana o días feriados.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div id="ocupateModal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="feather icon-alert-circle"></i>
                </div>
                <h4 class="modal-title w-100">Atención!</h4>
            </div>
            <div class="modal-body">
                <p class="text-center">Éste período coincide con el siguiente período vacacional:</p>
                <br>
                <div class="form-group">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h2 class="sub-title">Desde:</h2>
                            <input type="date" id="modal_fecha_ini" name="" class="form-control modal_fecha_ini" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h2 class="sub-title">Hasta:</h2>
                            <input type="date" id="modal_fecha_fin" name="" class="form-control modal_fecha_fin" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- FIN DE MODALES -->

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    // console.log("aaaaaa");

    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');

    function cambiar_form() {
        // console.log("Alooooooooo");
        // var cod = document.getElementById("tipo_sol").value;
        // console.log(cod);
        // if (cod == "Reposo") {
        //     div = document.getElementById('form_reposo');
        //     div.style.display = '';
        //     div = document.getElementById('form_vacaciones');
        //     div.style.display = 'none';
        // //    alert(cod);
        // }

        // if (cod == "Constancia") {
        //     div = document.getElementById('form_reposo');
        //     div.style.display = 'none';
        //     div = document.getElementById('form_vacaciones');
        //     div.style.display = 'none';
        // }



    }
</script>