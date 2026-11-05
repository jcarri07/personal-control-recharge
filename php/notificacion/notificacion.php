<div class="dropdown-toggle" data-toggle="dropdown" style="text-align: center;">
    <i class="feather icon-bell"></i>
</div>
<?php
date_default_timezone_set("America/Caracas");
include_once "../database/conexion.php";

// 1. DEFINICIÓN DE FUNCIONES (Primero para que siempre estén disponibles)
if (!function_exists('formatearFecha')) {
    function formatearFecha($fecha_str) {
        if (empty($fecha_str)) return '';
        try {
            $meses = [
                1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
                5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
                9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
            ];
            $fecha = new DateTime($fecha_str);
            return $fecha->format('d') . ' de ' . $meses[(int)$fecha->format('n')] . ' del ' . $fecha->format('Y');
        } catch (Exception $e) {
            return (string)$fecha_str;
        }
    }
}

if (!function_exists('notificacion')) {
    function notificacion($conn, $tipo_usuario, $id_usuario)
    {
        $re  = null;
        $res = null;
        $num_r  = 0;
        $num_re = 0;

        if ($tipo_usuario == 'admin') {
            // Notificaciones de solicitudes pendientes de supervisión
            $stmt_re = $conn->prepare(
                "SELECT s.tipo_solicitud, da.foto, s.created_date, s.motivo, s.descripcion, u.nombres, u.apellidos
                 FROM solicitud s
                 JOIN usuario u ON s.id_usuario = u.id_usuario
                 JOIN datos_personales da ON da.id_usuario = u.id_usuario
                 WHERE s.is_read IS NULL
                   AND s.estatus = 'pendiente'
                   AND NOT s.estatus_supervisor = 'pendiente'"
            );
            $stmt_re->execute();
            $re = $stmt_re->get_result();

            // Notificaciones para admin cuando su propia solicitud fue respondida
            $stmt_res = $conn->prepare(
                "SELECT s.tipo_solicitud, da.foto, s.created_date, s.motivo, s.descripcion,
                        u.nombres, u.apellidos, s.estatus
                 FROM solicitud s
                 JOIN usuario u ON s.id_usuario = u.id_usuario
                 JOIN datos_personales da ON da.id_usuario = u.id_usuario
                 WHERE s.id_usuario = ?
                   AND s.is_read IS NULL
                   AND (s.estatus_supervisor != 'pendiente' OR s.estatus != 'pendiente')"
            );
            $stmt_res->bind_param("i", $id_usuario);
            $stmt_res->execute();
            $res = $stmt_res->get_result();
            $num_r = $re->num_rows;
        }

        if ($tipo_usuario == 'empleado') {
            $stmt_res = $conn->prepare(
                "SELECT s.tipo_solicitud, da.foto, s.created_date, s.motivo, s.descripcion,
                        u.nombres, u.apellidos, s.estatus
                 FROM solicitud s
                 JOIN usuario u ON s.id_usuario = u.id_usuario
                 JOIN datos_personales da ON da.id_usuario = u.id_usuario
                 WHERE s.id_usuario = ?
                   AND s.is_read IS NULL
                   AND (s.estatus_supervisor != 'pendiente' OR s.estatus != 'pendiente')"
            );
            $stmt_res->bind_param("i", $id_usuario);
            $stmt_res->execute();
            $res = $stmt_res->get_result();
        }

        if ($tipo_usuario == 'jefe') {
            $stmt_re = $conn->prepare(
                "SELECT s.tipo_solicitud, da.foto, s.created_date, s.motivo, s.descripcion, u.nombres, u.apellidos
                 FROM solicitud s
                 JOIN usuario u ON s.id_usuario = u.id_usuario
                 JOIN datos_personales da ON da.id_usuario = u.id_usuario
                 WHERE s.supervisor = ?
                   AND s.is_read IS NULL
                   AND s.estatus_supervisor = 'pendiente'"
            );
            $stmt_re->bind_param("i", $id_usuario);
            $stmt_re->execute();
            $re = $stmt_re->get_result();

            $stmt_res = $conn->prepare(
                "SELECT s.tipo_solicitud, da.foto, s.created_date, s.motivo, s.descripcion,
                        u.nombres, u.apellidos, s.estatus
                 FROM solicitud s
                 JOIN usuario u ON s.id_usuario = u.id_usuario
                 JOIN datos_personales da ON da.id_usuario = u.id_usuario
                 WHERE s.id_usuario = ?
                   AND s.is_read IS NULL
                   AND (s.estatus_supervisor != 'pendiente' OR s.estatus != 'pendiente')"
            );
            $stmt_res->bind_param("i", $id_usuario);
            $stmt_res->execute();
            $res = $stmt_res->get_result();
            $num_r = $re->num_rows;
        }

        $num_re = ($res !== null) ? $res->num_rows : 0;

        if (($num_r + $num_re) == 0) { ?>
            <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
                <li style="padding: 5px 10px;">
                    <h6>No tiene notificaciones</h6>
                </li>
            </ul>
        <?php
        } else { ?>
            <span class="badge bg-c-pink" style="right: 2px;z-index:-1;"><?php echo $num_r + $num_re; ?></span>
            <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
                <?php
                if ($num_re >= 1) {
                    while ($row = $res->fetch_array()) { ?>
                        <li style="padding: 5px 10px;">
                            <a href="../home/solicitudes.php" class="media" style="width:100%;padding-top:5px">
                                <?php
                                $foto_safe    = htmlspecialchars($row["foto"]     ?? '', ENT_QUOTES, 'UTF-8');
                                $nombres_safe = htmlspecialchars($row["nombres"]  ?? '', ENT_QUOTES, 'UTF-8');
                                $apellidos_safe = htmlspecialchars($row["apellidos"] ?? '', ENT_QUOTES, 'UTF-8');
                                $estatus_safe = htmlspecialchars($row["estatus"]  ?? '', ENT_QUOTES, 'UTF-8');
                                ?>
                                <img class="d-flex align-self-center img-radius" src="../assets/empleados-images/<?php echo $foto_safe; ?>" alt="Foto empleado">
                                <div class="media-body row" style="height: 90px;">
                                    <h5 class="notification-user col-12"><?php echo $nombres_safe . " " . $apellidos_safe; ?></h5>
                                    <p class="notification-msg col-12"><?php echo $estatus_safe; ?></p>
                                    <div class="col-12" style="width: 100%;text-align: right;">
                                        <span class="notification-time"><?php echo formatearFecha($row["created_date"]); ?></span>
                                    </div>
                                </div>
                            </a>
                        </li><?php
                    }
                }
                if ($num_r >= 1 && $re !== null) {
                    while ($row = $re->fetch_array()) { ?>
                        <li style="padding: 5px 10px;">
                            <a href="../home/solicitudes.php" class="media" style="width:100%;padding-top:5px">
                                <?php
                                $foto_safe    = htmlspecialchars($row["foto"]          ?? '', ENT_QUOTES, 'UTF-8');
                                $nombres_safe = htmlspecialchars($row["nombres"]       ?? '', ENT_QUOTES, 'UTF-8');
                                $apellidos_safe = htmlspecialchars($row["apellidos"]   ?? '', ENT_QUOTES, 'UTF-8');
                                $tipo_safe    = htmlspecialchars($row["tipo_solicitud"] ?? '', ENT_QUOTES, 'UTF-8');
                                ?>
                                <img class="d-flex align-self-center img-radius" src="../assets/empleados-images/<?php echo $foto_safe; ?>" alt="Foto empleado">
                                <div class="media-body row" style="height: 90px;">
                                    <h5 class="notification-user col-12"><?php echo $nombres_safe . " " . $apellidos_safe; ?></h5>
                                    <p class="notification-msg col-12"><?php echo $tipo_safe; ?></p>
                                    <div class="col-12" style="width: 100%;text-align: right;">
                                        <span class="notification-time"><?php echo formatearFecha($row["created_date"]); ?></span>
                                    </div>
                                </div>
                            </a>
                        </li><?php
                    }
                }
                ?>
            </ul>
        <?php
        }
    }
}

// 2. EJECUCIÓN LÓGICA
$cargo = '';
$id_usuario   = $_SESSION['id_usuario']   ?? '';
$id_unidad    = $_SESSION["id_unidad"]    ?? '';
$tipo_usuario = $_SESSION["tipo_usuario"] ?? '';

if (!isset($_SESSION["cargo"])) {
    if ($tipo_usuario != "admin") {
        $stmt = $conn->prepare("SELECT cargo FROM datos_abae WHERE id_unidad = ? AND id_usuario = ?");
        $stmt->bind_param("si", $id_unidad, $id_usuario);
        $stmt->execute();
        $res = $stmt->get_result();
        $num_r = $res->num_rows;

        if ($num_r >= 1) {
            $obj = $res->fetch_object();
            $cargo = $obj->cargo;
            $_SESSION["cargo"] = $cargo;
            notificacion($conn, $tipo_usuario, $id_usuario);
        } else { ?>
            <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="border-radius:5px">
                <li>
                    <h6>No ha registrado su informacion ABAE</h6>
                </li>
            </ul>
        <?php }
    } else {
        notificacion($conn, $tipo_usuario, $id_usuario);
    }
} else {
    notificacion($conn, $tipo_usuario, $id_usuario);
}
?>
