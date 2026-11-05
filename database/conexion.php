<?php

// Datos de la base de datos
$host = "localhost"; // servidor
$user = "root"; // nombre de usuario
$pass = ""; // contraseña
$dbname = "personal_control"; // nombre de la base de datos

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verificar si hay errores en la conexión
// [MED-02 FIX] No exponer detalles del error al usuario final — registrar en log del servidor
if (!$conn) {
    error_log("Error de conexión BD: " . mysqli_connect_error());
    die("Error de conexión. Por favor contacte al administrador.");
}

// Si la conexión es exitosa, muestra un mensaje por consola
// echo "Conexión exitosa a la base de datos project-manager";

// Cerrar conexión
function closeConection($conn) {
    mysqli_close($conn);
}

?>
