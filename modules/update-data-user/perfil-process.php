<?php 
if (!isset($_SESSION)) {
    session_start();
}

require_once '../../database/conexion.php';

if (!isset($_SESSION['id_usuario'])) {
    echo "no_auth";
    exit();
}

// Verificar la conexión
if (mysqli_connect_errno()) {
    error_log("Error de conexión BD: " . mysqli_connect_error());
    echo "Error de conexión";
    exit();
}

$id  = isset($_POST['id']) ? (int)$_POST['id'] : (int)$_SESSION['id_usuario'];
$opc = isset($_POST['opc']) ? trim($_POST['opc']) : '';

// Asegurar que un usuario normal solo modifique su propio perfil
if ($_SESSION['tipo_usuario'] !== 'admin' && $id !== (int)$_SESSION['id_usuario']) {
    $id = (int)$_SESSION['id_usuario'];
}

if ($opc === "edit") {
    $user = isset($_POST['user']) ? trim($_POST['user']) : '';
    $pass = isset($_POST['pass']) ? trim($_POST['pass']) : '';

    $stmt = $conn->prepare("SELECT user FROM usuario WHERE id_usuario = ? LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo "vacio";
        closeConection($conn);
        exit();
    }

    $modificado = false;

    // Actualizar nombre de usuario si cambió
    if (!empty($user) && $user !== $row['user']) {
        $stmtCheck = $conn->prepare("SELECT id_usuario FROM usuario WHERE user = ? AND id_usuario != ? AND estatus = 'activo' LIMIT 1");
        $stmtCheck->bind_param("si", $user, $id);
        $stmtCheck->execute();
        $resCheck = $stmtCheck->get_result();
        if ($resCheck->num_rows > 0) {
            $stmtCheck->close();
            echo "existe";
            closeConection($conn);
            exit();
        }
        $stmtCheck->close();

        $stmtUpUser = $conn->prepare("UPDATE usuario SET user = ? WHERE id_usuario = ?");
        $stmtUpUser->bind_param("si", $user, $id);
        if ($stmtUpUser->execute()) {
            $_SESSION['usuario'] = $user;
            $modificado = true;
        }
        $stmtUpUser->close();
    }

    // Actualizar contraseña cifrada si se especificó una nueva
    if (!empty($pass)) {
        $passHash = password_hash($pass, PASSWORD_BCRYPT);
        $stmtUpPass = $conn->prepare("UPDATE usuario SET pass = ? WHERE id_usuario = ?");
        $stmtUpPass->bind_param("si", $passHash, $id);
        if ($stmtUpPass->execute()) {
            $modificado = true;
        }
        $stmtUpPass->close();
    }

    if ($modificado) {
        echo "si";
    } else {
        echo "vacio";
    }
}

closeConection($conn);
?>
