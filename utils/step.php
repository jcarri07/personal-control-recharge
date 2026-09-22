<?php
    require_once __DIR__ . '/../database/conexion.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $idUser = $_SESSION["id_usuario"] ?? null;

    if (isset($_POST['parametro1']) && isset($_POST['parametro2'])) {
        // Obtén los valores de los parámetros
        $valor1 = intval($_POST['parametro1']);
        $valor2 = $_POST['parametro2'];

        // Realiza la actualización del campo step en la base de datos
        // Se actualiza si el valor nuevo es mayor al step actual del usuario
        $sql2 = "UPDATE usuario SET step = '$valor1' WHERE id_usuario = '$idUser' AND step < '$valor1'";

        // Ejecutar la consulta
        if ($conn->query($sql2) === TRUE) {
            echo "Se actualizó el campo 'step' exitosamente a " . $valor1;
        } else {
            echo "Error al actualizar el campo 'step': " . $conn->error;
        }
    } else {
        // No se han recibido los parámetros esperados, maneja el caso de error
        $response = "Error en los parámetros";
        echo $response;
    }
?>
