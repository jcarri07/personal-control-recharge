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

        $sql = "INSERT INTO cursos_realizados (id_usuario, nombre_curso, duracion, anio_curso, instituto_universidad, observaciones, estatus)
                VALUES ('$id', '$nombre_curso', '$duracion', '$anio_curso', '$instituto_universidad', '$observaciones', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo 'si';
        else
            echo 'no';
    }

    if($opc == "edit"){
        $id_curso_realizado = mysqli_real_escape_string($conn, $_POST['id_curso_realizado']);
        $nombre_curso = mysqli_real_escape_string($conn, $_POST['nombre_curso']);
        $duracion = mysqli_real_escape_string($conn, $_POST['duracion']);
        $anio_curso = mysqli_real_escape_string($conn, $_POST['anio_curso']);
        $instituto_universidad = mysqli_real_escape_string($conn, $_POST['instituto_universidad']);
        $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones']);

        $sql = "SELECT * FROM cursos_realizados WHERE id_curso_realizado = '$id_curso_realizado';";
        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $changes = 0;

            if($nombre_curso != $row['nombre_curso']){
                $sql = "UPDATE cursos_realizados SET nombre_curso = '$nombre_curso' WHERE id_curso_realizado = '$id_curso_realizado';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($duracion != $row['duracion']){
                $sql = "UPDATE cursos_realizados SET duracion = '$duracion' WHERE id_curso_realizado = '$id_curso_realizado';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($anio_curso != $row['anio_curso']){
                $sql = "UPDATE cursos_realizados SET anio_curso = '$anio_curso' WHERE id_curso_realizado = '$id_curso_realizado';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($instituto_universidad != $row['instituto_universidad']){
                $sql = "UPDATE cursos_realizados SET instituto_universidad = '$instituto_universidad' WHERE id_curso_realizado = '$id_curso_realizado';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($observaciones != $row['observaciones']){
                $sql = "UPDATE cursos_realizados SET observaciones = '$observaciones' WHERE id_curso_realizado = '$id_curso_realizado';";
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
        $sql = "UPDATE cursos_realizados SET estatus = '$estatus' WHERE id_curso_realizado = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo "si";
        else
            echo "no";
    }

    closeConection($conn);
?>
