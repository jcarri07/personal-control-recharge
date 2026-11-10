<?php
require_once "../../database/conexion.php";
if (!isset($_SESSION)) {
    session_start();
}

// [CRIT-01 FIX] Prepared statement + password_verify para prevenir SQL Injection
// Soporte dual: acepta bcrypt Y texto plano para retrocompatibilidad durante migración
$user  = trim($_POST["user"] ?? '');
$contra = $_POST["password"] ?? '';

$stmt = $conn->prepare("SELECT u.id_usuario, u.nombres, u.apellidos, u.cedula, u.user, u.pass, u.tipo_usuario, d.cargo
                        FROM usuario u
                        LEFT JOIN datos_abae d ON u.id_usuario = d.id_usuario
                        WHERE u.user = ?
                        LIMIT 1");
$stmt->bind_param("s", $user);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows >= 1) {
    $obj = $res->fetch_object();

    // [CRIT-01 FIX] Verificación estricta de contraseña cifrada con Bcrypt
    if (password_verify($contra, $obj->pass)) {
        $_SESSION["id_usuario"]   = $obj->id_usuario;
        $_SESSION["nombre"]       = $obj->nombres;
        $_SESSION["apellido"]     = $obj->apellidos;
        $_SESSION["cedula"]       = $obj->cedula;
        $_SESSION["usuario"]      = $obj->user;
        $_SESSION["tipo_usuario"] = $obj->tipo_usuario;
        $_SESSION["cargo"]        = $obj->cargo ?? 'Sin asignar';

        $stmt2 = $conn->prepare("SELECT d.id_unidad
                                 FROM datos_abae d
                                 JOIN usuario us ON us.id_usuario = d.id_usuario
                                 WHERE us.id_usuario = ?
                                 LIMIT 1");
        $stmt2->bind_param("i", $obj->id_usuario);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        if ($res2->num_rows >= 1) {
            $obj2 = $res2->fetch_object();
            $_SESSION["unidad"] = $obj2->id_unidad;
        } else {
            $_SESSION["unidad"] = 'Sin asignar';
        }

        $stmt3 = $conn->prepare("SELECT u.nombre, u.id_unidad
                                 FROM unidad u
                                 JOIN datos_abae d ON d.id_unidad = u.id_unidad
                                 JOIN usuario us ON us.id_usuario = d.id_usuario
                                 WHERE us.id_usuario = ?
                                 LIMIT 1");
        $stmt3->bind_param("i", $obj->id_usuario);
        $stmt3->execute();
        $re = $stmt3->get_result();
        if ($re->num_rows >= 1) {
            $aux = $re->fetch_object();
            $_SESSION["unidad"]    = $aux->nombre;
            $_SESSION["id_unidad"] = $aux->id_unidad;
        }
        echo "si";
    } else {
        echo "no";
    }
} else {
    echo "no";
}

closeConection($conn);
