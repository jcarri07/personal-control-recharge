<?php
date_default_timezone_set("America/Caracas");
setlocale(LC_TIME, "Spanish");
include_once "../database/conexion.php";
?>



<?php

//session_start();
?>
<div class="page-wrapper">

    <!-- Page-body start -->
    <div class="page-body">
        <div class="card">
            <!-- Email-card start -->
            <div class="card-block email-card">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="user-head row">
                            <div class="user-face">
                                <img src="..\files\assets\images\logo.png" alt="Theme-Logo" width="150" height="60">
                            </div>
                        </div>
                    </div>

                </div>
                <?php


                ?>

                <div class="row">
                    <?php
                    $cargo;
                    $id_usuario = $_SESSION['id_usuario'];

                    if (!isset($_SESSION["id_unidad"])) {
                        $id_unidad = "";
                    } else {
                        $id_unidad = $_SESSION["id_unidad"];
                    }

                    if (!isset($_SESSION["tipo_usuario"])) {
                        $tipo_usuario = "";
                    } else {
                        $tipo_usuario = $_SESSION["tipo_usuario"];
                    }

                    $id_usuario = $_SESSION["id_usuario"];

                    if (!isset($_SESSION["cargo"])) {
                        if ($tipo_usuario != "admin") {
                            $res = mysqli_query($conn, "SELECT cargo 
                                                    FROM datos_abae
                                                    WHERE id_unidad = '$id_unidad' AND id_usuario = '$id_usuario';");

                            $num_r = mysqli_num_rows($res);

                            if ($num_r >= 1) {
                                $obj = mysqli_fetch_object($res);
                                $cargo = $obj->cargo;
                                historial($conn, $tipo_usuario, $id_usuario);
                            } else { ?>

                                <ul class="" style="border-radius:5px">
                                    <li style="padding: 10px 10px;color:#808080;">
                                        <h5>No ha Registrado su Informacion ABAE</h5>

                                    </li>
                                </ul>
                            <?php }

                            $num_r = mysqli_num_rows($res);
                            
                        } else {
                            historial($conn, $tipo_usuario, $id_usuario);
                        }
                    } else {
                        historial($conn, $tipo_usuario, $id_usuario);
                    }
                    function historial($conn, $tipo_usuario, $id_usuario)
                    {
                        //$cargo = $_SESSION["cargo"];
                        $num_r = 0;
                        $num_re = 0;

                        if ($tipo_usuario == 'admin') {
                            //notificaciones si eres supervisor casi LISTO
                            $re = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date, s.date_apro,s.motivo,s.estatus,s.estatus_supervisor,u.nombres,u.apellidos, s.supervisor, t.nombreS, t.apellidoS 
                                                                FROM solicitud s
                                                                JOIN (SELECT nombres AS nombreS,apellidos AS apellidoS, id_usuario FROM usuario ) AS t ON s.supervisor = t.id_usuario
                                                                JOIN usuario u ON s.id_usuario = u.id_usuario
                                                                JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                                                JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                                                WHERE NOT s.estatus = 'pendiente'
                                                                ORDER BY s.date_apro DESC");

                            $num_r = mysqli_num_rows($re);
                        }
                        if ($tipo_usuario == 'empleado') {
                            //notificaciones si tienes respuesta del supervisor LISTO
                            $res = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date, s.date_apro,s.motivo,s.descripcion,u.nombres,u.apellidos,s.estatus,s.estatus_supervisor, s.supervisor, t.nombreS, t.apellidoS 
                                                                FROM solicitud s
                                                                JOIN (SELECT nombres AS nombreS,apellidos AS apellidoS, id_usuario FROM usuario ) AS t ON s.supervisor = t.id_usuario
                                                                JOIN usuario u ON s.id_usuario = u.id_usuario
                                                                JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                                                JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                                                WHERE s.id_usuario = '$id_usuario' AND NOT s.is_read IS NULL AND NOT s.estatus_supervisor = 'pendiente' AND NOT s.estatus = 'pendiente'
                                                                ORDER BY s.date_apro DESC");
                            $num_re = mysqli_num_rows($res);
                        }
                        if ($tipo_usuario == 'jefe') {
                            //notificaciones si eres supervisor LISTO
                            $re = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date, s.date_apro,s.motivo,s.estatus,s.estatus_supervisor,u.nombres,u.apellidos, s.supervisor, t.nombreS, t.apellidoS 
                                                                FROM solicitud s
                                                                JOIN (SELECT nombres AS nombreS,apellidos AS apellidoS, id_usuario FROM usuario WHERE id_usuario = '$id_usuario') AS t ON '$id_usuario' = t.id_usuario
                                                                JOIN usuario u ON s.id_usuario = u.id_usuario
                                                                JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                                                JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                                                WHERE s.supervisor = '$id_usuario' AND NOT s.estatus_supervisor = 'pendiente'
                                                                ORDER BY s.date_apro DESC");


                            //notificaciones si tienes respuesta del supervisor LISTO
                            $res = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date, s.date_apro,s.motivo,s.descripcion,u.nombres,u.apellidos,s.estatus,s.estatus_supervisor, s.supervisor, t.nombreS, t.apellidoS  
                                                                FROM solicitud s
                                                                JOIN (SELECT nombres AS nombreS,apellidos AS apellidoS, id_usuario FROM usuario ) AS t ON s.supervisor = t.id_usuario
                                                                JOIN usuario u ON s.id_usuario = u.id_usuario
                                                                JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                                                JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                                                WHERE s.id_usuario = '$id_usuario'AND NOT s.is_read IS NULL AND NOT s.estatus_supervisor = 'pendiente' AND NOT s.estatus = 'pendiente'
                                                                ORDER BY s.date_apro DESC");
                            $num_r = mysqli_num_rows($re);
                            $num_re = mysqli_num_rows($res);
                        }


                        

                        if (($num_r + $num_re) == 0) { ?>

                            <ul class="" style="border-radius:5px">
                                <li style="padding: 10px 10px;color:#808080;">
                                    <h5>No tiene historial de notificaciones</h5>

                                </li>
                            </ul>

                        <?php
                        } else { ?>
                            <div class="col-lg-12 col-xl-12">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="e-inbox" role="tabpanel">

                                        <div class="mail-body">

                                            <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                    <table id="tabla_1" class="table table-striped table-bordered nowrap ">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align: center">FOTO</th>
                                                                <th style="text-align: center">SOLICITUD</th>
                                                                <th style="text-align: center">SOLICITANTE</th>
                                                                <th style="text-align: center">SUPERVISOR</th>
                                                                <th style="text-align: center">RESPUESTA SUPERVISOR</th>
                                                                <th style="text-align: center">RESPUESTA ADMINISTRADOR</th>
                                                                <th style="text-align: center">FECHA DE CREACION</th>
                                                                <th style="text-align: center">FECHA DE REVISION</th>
                                                            </tr>
                                                        </thead>

                                                        <?php
                                                        if ($num_re >= 1) {

                                                            while ($row = mysqli_fetch_array($res)) { ?>
                                                                <tr class="text-center" style="vertical-align: middle;">
                                                                    <td style="vertical-align: middle;"><div style="width:80px;height:80px;overflow: hidden;border-radius:50%;text-align:center;"><img class="d- align-self-center img-radius" src="../assets/empleados-images/<?php echo $row['foto']; ?>" alt="User-Profile-Image" style="height: 80px;"></div> </td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['tipo_solicitud']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['nombres'] . " " . $row['apellidos']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['nombreS'] . " " . $row['apellidoS']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['estatus_supervisor']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['estatus']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo strftime("%d de %B del %Y", strtotime($row['created_date'])); ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo strftime("%d de %B del %Y", strtotime($row['date_apro'])); ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        }

                                                        if ($num_r >= 1) {

                                                            while ($row = mysqli_fetch_array($re)) { ?>
                                                                <tr class="text-center">
                                                                    <td style="vertical-align: middle;"><div style="width:80px;height:80px;overflow: hidden;border-radius:50%;text-align:center;"><img class="d-flex align-self-center img-radius" src="../assets/empleados-images/<?php echo $row['foto']; ?>" alt="User-Profile-Image" style="height: 80px;"> </div></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['tipo_solicitud']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['nombres'] . " " . $row['apellidos']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['nombreS'] . " " . $row['apellidoS']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['estatus_supervisor']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo $row['estatus']; ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo strftime("%d de %B del %Y", strtotime($row['created_date'])); ?></td>
                                                                    <td style="vertical-align: middle;"> <?php echo strftime("%d de %B del %Y", strtotime($row['date_apro'])); ?></td>
                                                                </tr>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <?php
                        }
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        iniciarTabla("tabla_1");

    });
</script>