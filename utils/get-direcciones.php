<?php
// Realizar la conexión con la base de datos
require_once '../database/conexion.php';

// Obtener el ID de la sede seleccionada
$sedeId = $_POST['sedeId'];

// Realizar la consulta para obtener las direcciones correspondientes a la sede
$sql = "SELECT * FROM direccion;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Generar las opciones de las direcciones
    $options = "<option value=''>Seleccionar Dirección</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id_direccion'] . "'>" . $row['nombre'] . "</option>";
    }
} else {
    $options = "<option value=''>No hay direcciones disponibles</option>";
}

// Retornar las opciones
echo $options;

// Cerrar la conexión
$stmt->close();
$conn->close();
?> 
