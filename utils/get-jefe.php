<?php
require_once '../database/conexion.php';

// Obtener el ID de la unidad seleccionada
$idUnidad = $_POST['idUnidad'];
$value = 0;

// Realizar la primera consulta para obtener el id_jefe
$sql = "SELECT id_jefe FROM unidad WHERE id_unidad LIKE ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUnidad);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar una variable para almacenar el id_jefe
$idJefe = null;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idJefe = $row['id_jefe'];
}

// Realizar la segunda consulta utilizando el id_jefe
$sql = "SELECT id_usuario, nombres, apellidos, cargo FROM usuario WHERE (id_usuario IS NOT NULL OR id_usuario != '') AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idJefe);
$stmt->execute();
$result = $stmt->get_result();

// Inicializar un array para almacenar los datos que deseas devolver
$data = array();

if ($result->num_rows > 0) {
    // $options = "<option value=''>Seleccionar...</option>";
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'id_usuario' => $row['id_usuario'],
            'nombres' => $row['nombres'],
            'cargo' => $row['cargo'],
            'apellidos' => utf8_encode($row['apellidos'])
        );
        $options .= "<option value='" . $row['id_usuario'] . "'>" . $row['nombres'] . " " . $row['apellidos'] . " " . "<b>(" . $row['cargo'] . ")</b>" . "</option>";
    }
    $options .= "<option value='$value'>Soy el Nuevo Supervisor de esta UNIDA/DIRECCION</option>";
} else {
    $data[] = array(
        'id_usuario' => '',
        'cargo' => 'No hay unidades disponibles'
    );
}
// Devolver los datos en formato JSON
echo json_encode($data);
echo $options;

// Cerrar la conexión
$stmt->close();
$conn->close();
