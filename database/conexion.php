<?php
require_once __DIR__ . '/../config/env.php';

// Datos de la base de datos obtenidos desde las variables de entorno (.env)
$host   = env('DB_HOST', 'localhost');
$user   = env('DB_USER', 'root');
$pass   = env('DB_PASS', '');
$dbname = env('DB_NAME', 'personal_control');
$port   = (int) env('DB_PORT', 3306);

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// Verificar si hay errores en la conexión
// [MED-02 FIX] No exponer detalles del error al usuario final — registrar en log del servidor
if (!$conn) {
    error_log("Error de conexión BD: " . mysqli_connect_error());
    die("Error de conexión. Por favor contacte al administrador.");
}

// Configurar charset a utf8mb4 para caracteres y acentos correctos
mysqli_set_charset($conn, "utf8mb4");

// Cerrar conexión
function closeConection($conn) {
    if ($conn) {
        mysqli_close($conn);
    }
}
