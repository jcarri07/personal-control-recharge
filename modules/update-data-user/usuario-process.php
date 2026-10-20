<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../../database/conexion.php';

// Verificar autenticación y permisos de admin
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo 'no_auth';
    exit();
}

if (mysqli_connect_errno()) {
    echo 'error_conexion';
    exit();
}

$opc = isset($_POST['opc']) ? trim($_POST['opc']) : '';

if ($opc === 'add') {
    $user         = isset($_POST['usuario']) ? mysqli_real_escape_string($conn, trim($_POST['usuario'])) : '';
    $cedula       = isset($_POST['cedula']) ? mysqli_real_escape_string($conn, trim($_POST['cedula'])) : '';
    $nombre       = isset($_POST['nombre']) ? mysqli_real_escape_string($conn, trim($_POST['nombre'])) : '';
    $apellido     = isset($_POST['apellido']) ? mysqli_real_escape_string($conn, trim($_POST['apellido'])) : '';
    $email        = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $tipo_usuario = isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario']) ? mysqli_real_escape_string($conn, trim($_POST['tipo_usuario'])) : 'empleado';
    $cargo        = isset($_POST['cargo']) ? mysqli_real_escape_string($conn, trim($_POST['cargo'])) : '';
    $estatus      = isset($_POST['estatus']) && !empty($_POST['estatus']) ? mysqli_real_escape_string($conn, trim($_POST['estatus'])) : 'activo';
    $contra       = isset($_POST['pass']) ? trim($_POST['pass']) : '';
    $confirm_pass = isset($_POST['confirm_pass']) ? trim($_POST['confirm_pass']) : '';

    if (empty($user) || empty($cedula) || empty($nombre) || empty($apellido) || empty($contra)) {
        echo 'campos_vacios';
        closeConection($conn);
        exit();
    }

    if ($contra !== $confirm_pass) {
        echo 'pass_mismatch';
        closeConection($conn);
        exit();
    }

    // Verificar si ya existe cédula
    $resCedula = mysqli_query($conn, "SELECT cedula FROM usuario WHERE cedula = '$cedula' LIMIT 1;");
    if (mysqli_num_rows($resCedula) > 0) {
        echo 'existe_cedula';
        closeConection($conn);
        exit();
    }

    // Verificar si ya existe nombre de usuario
    $resUser = mysqli_query($conn, "SELECT user FROM usuario WHERE user = '$user' LIMIT 1;");
    if (mysqli_num_rows($resUser) > 0) {
        echo 'existe_usuario';
        closeConection($conn);
        exit();
    }

    $contra_escaped = mysqli_real_escape_string($conn, $contra);

    $sqlInsert = "INSERT INTO usuario (nombres, apellidos, cedula, cargo, user, pass, tipo_usuario, estatus, id_jefe, step, correo) 
                  VALUES ('$nombre', '$apellido', '$cedula', '$cargo', '$user', '$contra_escaped', '$tipo_usuario', '$estatus', 0, 0, '$email');";

    $res = mysqli_query($conn, $sqlInsert);

    if ($res) {
        echo 'si';
    } else {
        echo 'error';
    }

    closeConection($conn);
    exit();
}

if ($opc === 'edit') {
    $id_usuario   = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;
    $user         = isset($_POST['usuario']) ? mysqli_real_escape_string($conn, trim($_POST['usuario'])) : '';
    $cedula       = isset($_POST['cedula']) ? mysqli_real_escape_string($conn, trim($_POST['cedula'])) : '';
    $nombre       = isset($_POST['nombre']) ? mysqli_real_escape_string($conn, trim($_POST['nombre'])) : '';
    $apellido     = isset($_POST['apellido']) ? mysqli_real_escape_string($conn, trim($_POST['apellido'])) : '';
    $email        = isset($_POST['email']) ? mysqli_real_escape_string($conn, trim($_POST['email'])) : '';
    $tipo_usuario = isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario']) ? mysqli_real_escape_string($conn, trim($_POST['tipo_usuario'])) : 'empleado';
    $cargo        = isset($_POST['cargo']) ? mysqli_real_escape_string($conn, trim($_POST['cargo'])) : '';
    $estatus      = isset($_POST['estatus']) && !empty($_POST['estatus']) ? mysqli_real_escape_string($conn, trim($_POST['estatus'])) : 'activo';
    $contra       = isset($_POST['pass']) ? trim($_POST['pass']) : '';
    $confirm_pass = isset($_POST['confirm_pass']) ? trim($_POST['confirm_pass']) : '';

    if ($id_usuario <= 0 || empty($user) || empty($cedula) || empty($nombre) || empty($apellido)) {
        echo 'campos_vacios';
        closeConection($conn);
        exit();
    }

    // Verificar si la cédula ya pertenece a otro usuario
    $resCedula = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE cedula = '$cedula' AND id_usuario != '$id_usuario' LIMIT 1;");
    if (mysqli_num_rows($resCedula) > 0) {
        echo 'existe_cedula';
        closeConection($conn);
        exit();
    }

    // Verificar si el username ya pertenece a otro usuario
    $resUser = mysqli_query($conn, "SELECT id_usuario FROM usuario WHERE user = '$user' AND id_usuario != '$id_usuario' LIMIT 1;");
    if (mysqli_num_rows($resUser) > 0) {
        echo 'existe_usuario';
        closeConection($conn);
        exit();
    }

    // Si se especificó contraseña nueva
    if (!empty($contra)) {
        if ($contra !== $confirm_pass) {
            echo 'pass_mismatch';
            closeConection($conn);
            exit();
        }
        $contra_escaped = mysqli_real_escape_string($conn, $contra);
        $sqlUpdate = "UPDATE usuario 
                      SET nombres = '$nombre', apellidos = '$apellido', cedula = '$cedula', cargo = '$cargo', 
                          user = '$user', pass = '$contra_escaped', tipo_usuario = '$tipo_usuario', estatus = '$estatus', correo = '$email' 
                      WHERE id_usuario = '$id_usuario';";
    } else {
        $sqlUpdate = "UPDATE usuario 
                      SET nombres = '$nombre', apellidos = '$apellido', cedula = '$cedula', cargo = '$cargo', 
                          user = '$user', tipo_usuario = '$tipo_usuario', estatus = '$estatus', correo = '$email' 
                      WHERE id_usuario = '$id_usuario';";
    }

    $res = mysqli_query($conn, $sqlUpdate);

    if ($res) {
        echo 'si';
    } else {
        echo 'error';
    }

    closeConection($conn);
    exit();
}

if ($opc === 'estatus') {
    $id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;
    $estatus    = isset($_POST['estatus']) && in_array($_POST['estatus'], ['activo', 'inactivo']) ? $_POST['estatus'] : 'activo';

    if ($id_usuario <= 0) {
        echo 'id_invalido';
        closeConection($conn);
        exit();
    }

    if ($id_usuario == $_SESSION['id_usuario'] && $estatus === 'inactivo') {
        echo 'auto_desactivar';
        closeConection($conn);
        exit();
    }

    $sqlUpdate = "UPDATE usuario SET estatus = '$estatus' WHERE id_usuario = '$id_usuario';";
    $res = mysqli_query($conn, $sqlUpdate);

    if ($res) {
        echo 'si';
    } else {
        echo 'error';
    }

    closeConection($conn);
    exit();
}

if ($opc === 'delete') {
    $id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;

    if ($id_usuario <= 0) {
        echo 'id_invalido';
        closeConection($conn);
        exit();
    }

    if ($id_usuario == $_SESSION['id_usuario']) {
        echo 'auto_eliminar';
        closeConection($conn);
        exit();
    }

    $sqlDelete = "DELETE FROM usuario WHERE id_usuario = '$id_usuario';";
    $res = mysqli_query($conn, $sqlDelete);

    if ($res) {
        echo 'si';
    } else {
        echo 'error';
    }

    closeConection($conn);
    exit();
}

echo 'opc_invalida';
closeConection($conn);
?>
