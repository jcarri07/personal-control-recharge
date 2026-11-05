<?php
require_once "../../database/conexion.php";

// [CRIT-02 FIX] Prepared statements + password_hash para prevenir SQL Injection
// y almacenar contraseñas de forma segura

$user    = trim($_POST["usuario"] ?? '');
$nombre  = trim($_POST["nombre"]  ?? '');
$apellido = trim($_POST["apellido"] ?? '');
$cedula  = trim($_POST["cedula"]  ?? '');
$email   = trim($_POST["email"]   ?? '');
$contra  = $_POST["pass"] ?? '';

// Hashear contraseña con bcrypt
$contraHash = password_hash($contra, PASSWORD_BCRYPT);

// Verificar cédula duplicada
$stmt = $conn->prepare("SELECT cedula FROM usuario WHERE cedula = ? LIMIT 1");
$stmt->bind_param("s", $cedula);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows >= 1) {
    echo 'existe_cedula';
    $stmt->close();
    closeConection($conn);
    return;
}

// Verificar usuario duplicado
$stmt2 = $conn->prepare("SELECT user FROM usuario WHERE user = ? LIMIT 1");
$stmt2->bind_param("s", $user);
$stmt2->execute();
$res2 = $stmt2->get_result();
if ($res2->num_rows >= 1) {
    echo 'existe_usuario';
    $stmt2->close();
    closeConection($conn);
    return;
}

// Insertar nuevo usuario con contraseña hasheada
$stmt3 = $conn->prepare("INSERT INTO usuario (nombres, apellidos, cedula, user, pass, tipo_usuario, estatus, correo)
                          VALUES (?, ?, ?, ?, ?, 'empleado', 'activo', ?)");
$stmt3->bind_param("ssssss", $nombre, $apellido, $cedula, $user, $contraHash, $email);
$res3 = $stmt3->execute();

if ($res3) {
    echo "si";
} else {
    echo "no";
}

$stmt3->close();
closeConection($conn);
