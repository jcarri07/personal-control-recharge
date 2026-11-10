<?php 
    require_once '../../database/conexion.php';

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }

    $id = $_POST['id'];
    $opc = $_POST['opc'];

    if($opc == "add"){
        $nombre_curso = mysqli_real_escape_string($conn, $_POST['nombre_curso']);
        $duracion = mysqli_real_escape_string($conn, $_POST['duracion']);
        $anio_curso = mysqli_real_escape_string($conn, $_POST['anio_curso']);
        $instituto_universidad = mysqli_real_escape_string($conn, $_POST['instituto_universidad']);
        $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones']);

        $sql = "INSERT INTO certificados_actividades (id_usuario, nombre_curso, duracion, anio_curso, instituto_universidad, observaciones, estatus)
                VALUES ('$id', '$nombre_curso', '$duracion', '$anio_curso', '$instituto_universidad', '$observaciones', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo 'si';
        else
            echo 'no';
    }

    if($opc == "edit"){
        $id_certificado_actividad = mysqli_real_escape_string($conn, $_POST['id_certificado_actividad']);
        $nombre_curso = mysqli_real_escape_string($conn, $_POST['nombre_curso']);
        $duracion = mysqli_real_escape_string($conn, $_POST['duracion']);
        $anio_curso = mysqli_real_escape_string($conn, $_POST['anio_curso']);
        $instituto_universidad = mysqli_real_escape_string($conn, $_POST['instituto_universidad']);
        $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones']);

        $sql = "SELECT * FROM certificados_actividades WHERE id_certificado_actividad = '$id_certificado_actividad';";
        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $changes = 0;

            if($nombre_curso != $row['nombre_curso']){
                $sql = "UPDATE certificados_actividades SET nombre_curso = '$nombre_curso' WHERE id_certificado_actividad = '$id_certificado_actividad';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($duracion != $row['duracion']){
                $sql = "UPDATE certificados_actividades SET duracion = '$duracion' WHERE id_certificado_actividad = '$id_certificado_actividad';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($anio_curso != $row['anio_curso']){
                $sql = "UPDATE certificados_actividades SET anio_curso = '$anio_curso' WHERE id_certificado_actividad = '$id_certificado_actividad';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($instituto_universidad != $row['instituto_universidad']){
                $sql = "UPDATE certificados_actividades SET instituto_universidad = '$instituto_universidad' WHERE id_certificado_actividad = '$id_certificado_actividad';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($observaciones != $row['observaciones']){
                $sql = "UPDATE certificados_actividades SET observaciones = '$observaciones' WHERE id_certificado_actividad = '$id_certificado_actividad';";
                if(mysqli_query($conn, $sql)) $changes++;
            }

            if($changes > 0)
                echo "si";
            else
                echo "vacio";
        } else {
            echo "no";
        }
    }

    if($opc == "estatus"){
        $estatus = mysqli_real_escape_string($conn, $_POST['estatus']);
        $sql = "UPDATE certificados_actividades SET estatus = '$estatus' WHERE id_certificado_actividad = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo "si";
        else
            echo "no";
    }

    closeConection($conn);
?>
