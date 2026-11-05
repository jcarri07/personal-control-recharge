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
    error_log("Error de conexión BD: " . mysqli_connect_error());
    echo 'error_conexion';
    exit();
}

$opc = isset($_POST['opc']) ? trim($_POST['opc']) : '';

if ($opc === 'add') {
    $user         = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $cedula       = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $nombre       = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido     = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email        = isset($_POST['email']) ? trim($_POST['email']) : '';
    $tipo_usuario = isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario']) ? trim($_POST['tipo_usuario']) : 'empleado';
    $cargo        = isset($_POST['cargo']) ? trim($_POST['cargo']) : '';
    $estatus      = isset($_POST['estatus']) && !empty($_POST['estatus']) ? trim($_POST['estatus']) : 'activo';
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
    $stmtCedula = $conn->prepare("SELECT cedula FROM usuario WHERE cedula = ? LIMIT 1");
    $stmtCedula->bind_param("s", $cedula);
    $stmtCedula->execute();
    $resCedula = $stmtCedula->get_result();
    if ($resCedula->num_rows > 0) {
        $stmtCedula->close();
        echo 'existe_cedula';
        closeConection($conn);
        exit();
    }
    $stmtCedula->close();

    // Verificar si ya existe nombre de usuario
    $stmtUser = $conn->prepare("SELECT user FROM usuario WHERE user = ? LIMIT 1");
    $stmtUser->bind_param("s", $user);
    $stmtUser->execute();
    $resUser = $stmtUser->get_result();
    if ($resUser->num_rows > 0) {
        $stmtUser->close();
        echo 'existe_usuario';
        closeConection($conn);
        exit();
    }
    $stmtUser->close();

    // Cifrar la contraseña con Bcrypt
    $contraHash = password_hash($contra, PASSWORD_BCRYPT);

    $stmtInsert = $conn->prepare("INSERT INTO usuario (nombres, apellidos, cedula, cargo, user, pass, tipo_usuario, estatus, id_jefe, step, correo) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0, ?)");
    $stmtInsert->bind_param("sssssssss", $nombre, $apellido, $cedula, $cargo, $user, $contraHash, $tipo_usuario, $estatus, $email);
    $res = $stmtInsert->execute();
    $stmtInsert->close();

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
    $user         = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
    $cedula       = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';
    $nombre       = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido     = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $email        = isset($_POST['email']) ? trim($_POST['email']) : '';
    $tipo_usuario = isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario']) ? trim($_POST['tipo_usuario']) : 'empleado';
    $cargo        = isset($_POST['cargo']) ? trim($_POST['cargo']) : '';
    $estatus      = isset($_POST['estatus']) && !empty($_POST['estatus']) ? trim($_POST['estatus']) : 'activo';
    $contra       = isset($_POST['pass']) ? trim($_POST['pass']) : '';
    $confirm_pass = isset($_POST['confirm_pass']) ? trim($_POST['confirm_pass']) : '';

    if ($id_usuario <= 0 || empty($user) || empty($cedula) || empty($nombre) || empty($apellido)) {
        echo 'campos_vacios';
        closeConection($conn);
        exit();
    }

    // Verificar si la cédula ya pertenece a otro usuario
    $stmtCedula = $conn->prepare("SELECT id_usuario FROM usuario WHERE cedula = ? AND id_usuario != ? LIMIT 1");
    $stmtCedula->bind_param("si", $cedula, $id_usuario);
    $stmtCedula->execute();
    $resCedula = $stmtCedula->get_result();
    if ($resCedula->num_rows > 0) {
        $stmtCedula->close();
        echo 'existe_cedula';
        closeConection($conn);
        exit();
    }
    $stmtCedula->close();

    // Verificar si el username ya pertenece a otro usuario
    $stmtUser = $conn->prepare("SELECT id_usuario FROM usuario WHERE user = ? AND id_usuario != ? LIMIT 1");
    $stmtUser->bind_param("si", $user, $id_usuario);
    $stmtUser->execute();
    $resUser = $stmtUser->get_result();
    if ($resUser->num_rows > 0) {
        $stmtUser->close();
        echo 'existe_usuario';
        closeConection($conn);
        exit();
    }
    $stmtUser->close();

    // Si el admin especificó una nueva contraseña para el usuario
    if (!empty($contra)) {
        if ($contra !== $confirm_pass) {
            echo 'pass_mismatch';
            closeConection($conn);
            exit();
        }
        // Cifrar la nueva contraseña con Bcrypt
        $contraHash = password_hash($contra, PASSWORD_BCRYPT);

        $stmtUp = $conn->prepare("UPDATE usuario 
                                  SET nombres = ?, apellidos = ?, cedula = ?, cargo = ?, 
                                      user = ?, pass = ?, tipo_usuario = ?, estatus = ?, correo = ? 
                                  WHERE id_usuario = ?");
        $stmtUp->bind_param("sssssssssi", $nombre, $apellido, $cedula, $cargo, $user, $contraHash, $tipo_usuario, $estatus, $email, $id_usuario);
    } else {
        // Mantener la contraseña actual sin cambios
        $stmtUp = $conn->prepare("UPDATE usuario 
                                  SET nombres = ?, apellidos = ?, cedula = ?, cargo = ?, 
                                      user = ?, tipo_usuario = ?, estatus = ?, correo = ? 
                                  WHERE id_usuario = ?");
        $stmtUp->bind_param("ssssssssi", $nombre, $apellido, $cedula, $cargo, $user, $tipo_usuario, $estatus, $email, $id_usuario);
    }

    $res = $stmtUp->execute();
    $stmtUp->close();

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

    $stmtUp = $conn->prepare("UPDATE usuario SET estatus = ? WHERE id_usuario = ?");
    $stmtUp->bind_param("si", $estatus, $id_usuario);
    $res = $stmtUp->execute();
    $stmtUp->close();

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

    $stmtDel = $conn->prepare("DELETE FROM usuario WHERE id_usuario = ?");
    $stmtDel->bind_param("i", $id_usuario);
    $res = $stmtDel->execute();
    $stmtDel->close();

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
