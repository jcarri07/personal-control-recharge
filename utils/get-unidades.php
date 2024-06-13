<?php
require_once '../database/conexion.php';

// Obtener el ID de la dirección seleccionada
$direccionId = $_POST['direccionId'];

// Realizar la consulta para obtener las unidades correspondientes a la dirección
$sql = "SELECT * FROM unidad WHERE id_direccion = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $direccionId);
$stmt->execute();
$result = $stmt->get_result();

// Generar las opciones de las unidades
if ($result->num_rows > 0) {
    // Generar las opciones de las direcciones
    $options = "<option value=''>Seleccionar Unidad</option>";
    while ($row = $result->fetch_assoc()) {
        $options .= "<option value='" . $row['id_unidad'] . "'>" . $row['nombre'] . "</option>";
    }
} else {
    $options = "<option value=''>No hay unidades disponibles</option>";
}

// Retornar las opciones
echo $options;

// Cerrar la conexión
$stmt->close();
$conn->close();

