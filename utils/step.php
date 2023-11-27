<?php
    require_once '../database/conexion.php';
    session_start();
    $idUser = $_SESSION["id_usuario"];

    if (isset($_POST['parametro1']) && isset($_POST['parametro2'])) {
        // Obtén los valores de los parámetros
        $valor1 = $_POST['parametro1'];
        $valor2 = $_POST['parametro2'];

        // Realiza las operaciones de inserción o actualización en la base de datos
        if($valor2 == "children") {
            $sql2 = "UPDATE usuario SET step = '$valor1' WHERE step = 1 AND id_usuario = '$idUser'";
    
            // Ejecutar la consulta
            if ($conn->query($sql2) === TRUE) {
                echo "Se actualizó el campo 'step' exitosamente.";
            } else {
                echo "Error al actualizar el campo 'step': " . $conn->error;
            }
        }

        if($valor2 == "family") {
            $sql2 = "UPDATE usuario SET step = '$valor1' WHERE step = 2 AND id_usuario = '$idUser'";
    
            // Ejecutar la consulta
            if ($conn->query($sql2) === TRUE) {
                echo "Se actualizó el campo 'step' exitosamente.";
            } else {
                echo "Error al actualizar el campo 'step': " . $conn->error;
            }
        }

        if($valor2 == "exterior") {
            $sql2 = "UPDATE usuario SET step = '$valor1' WHERE step = 4 AND id_usuario = '$idUser'";
    
            // Ejecutar la consulta
            if ($conn->query($sql2) === TRUE) {
                echo "Se actualizó el campo 'step' exitosamente.";
            } else {
                echo "Error al actualizar el campo 'step': " . $conn->error;
            }
        }

        if($valor2 == "publica") {
            $sql2 = "UPDATE usuario SET step = '$valor1' WHERE step = 5 AND id_usuario = '$idUser'";
    
            // Ejecutar la consulta
            if ($conn->query($sql2) === TRUE) {
                echo "Se actualizó el campo 'step' exitosamente.";
            } else {
                echo "Error al actualizar el campo 'step': " . $conn->error;
            }
        }
        if($valor2 == "comision") {
            $sql2 = "UPDATE usuario SET step = '$valor1' WHERE step = 7 AND id_usuario = '$idUser'";
    
            // Ejecutar la consulta
            if ($conn->query($sql2) === TRUE) {
                echo "Se actualizó el campo 'step' exitosamente.";
            } else {
                echo "Error al actualizar el campo 'step': " . $conn->error;
            }
        }
    } else {
        // No se han recibido los parámetros esperados, maneja el caso de error
        $response = "Error en los parámetros"; // Puedes personalizar el mensaje de error
        echo $response;
    }
?>
