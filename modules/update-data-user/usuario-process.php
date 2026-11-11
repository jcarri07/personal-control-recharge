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

    try {
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
    } catch (mysqli_sql_exception $e) {
        error_log("Error SQL al crear usuario: " . $e->getMessage());
        if ($e->getCode() == 1406 || strpos($e->getMessage(), 'Data too long') !== false) {
            echo 'error_cargo_largo';
        } else {
            echo 'error_bd';
        }
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

    try {
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
    } catch (mysqli_sql_exception $e) {
        error_log("Error SQL al editar usuario: " . $e->getMessage());
        if ($e->getCode() == 1406 || strpos($e->getMessage(), 'Data too long') !== false) {
            echo 'error_cargo_largo';
        } else {
            echo 'error_bd';
        }
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

    try {
        $stmtUp = $conn->prepare("UPDATE usuario SET estatus = ? WHERE id_usuario = ?");
        $stmtUp->bind_param("si", $estatus, $id_usuario);
        $res = $stmtUp->execute();
        $stmtUp->close();

        if ($res) {
            echo 'si';
        } else {
            echo 'error';
        }
    } catch (mysqli_sql_exception $e) {
        error_log("Error SQL al actualizar estatus de usuario: " . $e->getMessage());
        echo 'error_bd';
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

    try {
        // Verificar si el usuario tiene registros o historial en otras tablas
        $tablasCheck = [
            'datos_personales'                   => 'Datos personales / expediente',
            'datos_abae'                         => 'Datos institucionales (ABAE)',
            'actividad'                          => 'Actividades registradas',
            'solicitud'                          => 'Solicitudes tramitadas',
            'nucleo_familiar'                    => 'Núcleo familiar',
            'datos_hijos'                        => 'Datos de hijos',
            'experiencia_instituciones_publicas' => 'Experiencia laboral',
            'nivel_academico'                    => 'Nivel académico',
            'cursos_realizados'                  => 'Cursos realizados',
            'certificados_actividades'           => 'Certificados de cursos',
            'formacion_actual'                   => 'Formación actual',
            'formacion_exterior'                 => 'Formación exterior',
            'datos_militar'                      => 'Datos militares',
            'otros_datos_usuario'                => 'Otros datos'
        ];

        $motivos = [];
        foreach ($tablasCheck as $tabla => $desc) {
            $checkStmt = $conn->prepare("SELECT 1 FROM `$tabla` WHERE id_usuario = ? LIMIT 1");
            if ($checkStmt) {
                $checkStmt->bind_param("i", $id_usuario);
                $checkStmt->execute();
                $resCheck = $checkStmt->get_result();
                if ($resCheck && $resCheck->num_rows > 0) {
                    $motivos[] = $desc;
                }
                $checkStmt->close();
            }
        }

        // Verificar si es supervisor (jefe) de otros usuarios
        $checkJefe = $conn->prepare("SELECT 1 FROM `usuario` WHERE id_jefe = ? AND id_usuario != ? LIMIT 1");
        if ($checkJefe) {
            $checkJefe->bind_param("ii", $id_usuario, $id_usuario);
            $checkJefe->execute();
            $resJefe = $checkJefe->get_result();
            if ($resJefe && $resJefe->num_rows > 0) {
                $motivos[] = 'Personal subordinado asignado (figura como supervisor)';
            }
            $checkJefe->close();
        }

        if (!empty($motivos)) {
            echo 'tiene_relaciones:' . implode(', ', $motivos);
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
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1451) {
            echo 'tiene_relaciones:Registros vinculados en base de datos';
        } else {
            error_log("Error SQL al eliminar usuario: " . $e->getMessage());
            echo 'error_bd';
        }
    }

    closeConection($conn);
    exit();
}

echo 'opc_invalida';
closeConection($conn);
?>
