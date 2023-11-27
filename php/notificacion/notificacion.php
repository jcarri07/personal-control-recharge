<div class="dropdown-toggle" data-toggle="dropdown">
    <i class="feather icon-bell"></i>
</div>
<?php
date_default_timezone_set("America/Caracas");
setlocale(LC_TIME, "Spanish");
include_once "../database/conexion.php";

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
        } else { ?>

            <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
                <li>
                    <h6>No ha registrado su informacion ABAE</h6>

                </li>
            </ul>

    <?php }

        $num_r = mysqli_num_rows($res);
    } else {notificacion($conn, $tipo_usuario, $id_usuario);}
}else { notificacion($conn, $tipo_usuario, $id_usuario);
}

function notificacion($conn, $tipo_usuario, $id_usuario)
{
    $num_r = 0;
    $num_re = 0;
    if ($tipo_usuario == 'admin') {
        //notificaciones si eres supervisor
        $re = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date,s.motivo,s.descripcion,u.nombres,u.apellidos 
                                            FROM solicitud s
                                            JOIN usuario u ON s.id_usuario = u.id_usuario
                                            JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                            JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                            WHERE s.is_read IS NULL AND s.estatus = 'pendiente' AND NOT s.estatus_supervisor = 'pendiente'");


        //notificaciones si tienes respuesta del supervisor
        $res = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date,s.motivo,s.descripcion,u.nombres,u.apellidos,s.estatus
                                            FROM solicitud s
                                            JOIN usuario u ON s.id_usuario = u.id_usuario
                                            JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                            JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                            WHERE s.id_usuario = '$id_usuario'AND s.is_read IS NULL AND NOT (NOT s.estatus_supervisor = 'pendiente' OR NOT s.estatus = 'pendiente')");
        $num_r = mysqli_num_rows($re);
    }
    if ($tipo_usuario == 'empleado') {
        //notificaciones si tienes respuesta del supervisor
        $res = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date,s.motivo,s.descripcion,u.nombres,u.apellidos,s.estatus 
                                            FROM solicitud s
                                            JOIN usuario u ON s.id_usuario = u.id_usuario
                                            JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                            JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                            WHERE s.id_usuario = '$id_usuario' AND s.is_read IS NULL AND (NOT s.estatus_supervisor = 'pendiente' OR NOT s.estatus = 'pendiente')");
    }
    if ($tipo_usuario == 'jefe') {
        //notificaciones si eres supervisor
        $re = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date,s.motivo,s.descripcion,u.nombres,u.apellidos 
                                            FROM solicitud s
                                            JOIN usuario u ON s.id_usuario = u.id_usuario
                                            JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                            JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                            WHERE s.supervisor = '$id_usuario' AND s.is_read IS NULL AND s.estatus_supervisor = 'pendiente'");


        //notificaciones si tienes respuesta del supervisor
        $res = mysqli_query($conn, "SELECT s.tipo_solicitud,da.foto,s.created_date,s.motivo,s.descripcion,u.nombres,u.apellidos,s.estatus 
                                            FROM solicitud s
                                            JOIN usuario u ON s.id_usuario = u.id_usuario
                                            JOIN datos_abae d ON d.id_usuario = s.id_usuario
                                            JOIN datos_personales da ON da.id_usuario = u.id_usuario
                                            WHERE s.id_usuario = '$id_usuario'AND s.is_read IS NULL AND (NOT s.estatus_supervisor = 'pendiente' OR NOT s.estatus = 'pendiente')");
        $num_r = mysqli_num_rows($re);
    }


    $num_re = mysqli_num_rows($res);

    if (($num_r + $num_re) == 0) { ?>

        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
            <li style="padding: 5px 10px;">
                <h6>No tiene notificaciones</h6>

            </li>
        </ul>

    <?php
    } else { ?>
        <span class="badge bg-c-pink"><?php echo $num_r + $num_re; ?></span>
        <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
            <?php
            if ($num_re >= 1) {

                while ($row = mysqli_fetch_array($res)) { ?>
                    <li style="padding: 5px 10px;">

                        <a href="../home/solicitudes.php" class="media" style="width:100%;padding-top:5px">
                            <img class="d-flex align-self-center img-radius" src="../assets/empleados-images/<?php echo $row["foto"]; ?>" alt="Generic placeholder image" >
                            <div class="media-body row" style="height: 90px;">

                                <h5 class="notification-user col-12"><?php echo $row["nombres"] . " " . $row["apellidos"]; ?></h5>
                                <p class="notification-msg col-12"><?php echo $row["estatus"]; ?></p>
                                <div class="col-12" style="width: 100%;text-align: right;">
                                    <span class="notification-time"><?php echo strftime("%d de %B del %Y", strtotime($row["created_date"])); ?></span>
                                </div>

                            </div>
                        </a>

                    </li><?php
                        }
                    }
                    if ($num_r >= 1) {
                        while ($row = mysqli_fetch_array($re)) { ?>
                    <li style="padding: 5px 10px;">

                        <a href="../home/solicitudes.php" class="media" style="width:100%;padding-top:5px">
                            <img class="d-flex align-self-center img-radius" src="../assets/empleados-images/<?php echo $row["foto"]; ?>" alt="Generic placeholder image" >
                            <div class="media-body row" style="height: 90px;">
                                <h5 class="notification-user col-12"><?php echo $row["nombres"] . " " . $row["apellidos"]; ?></h5>
                                <p class="notification-msg col-12"><?php echo $row["tipo_solicitud"]; ?></p>
                                <div class="col-12"style="width: 100%;text-align: right;">
                                    <span class="notification-time"><?php echo strftime("%d de %B del %Y", strtotime($row["created_date"])); ?></span>
                                </div>
                            </div>
                        </a>

                    </li><?php
                        }
                    }
                }
            }
                            ?>