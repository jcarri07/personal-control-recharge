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
        $estudios_en_curso = mysqli_real_escape_string($conn, $_POST['estudios_en_curso']);
        $anio_estimado_graduacion = mysqli_real_escape_string($conn, $_POST['anio_estimado_graduacion']);
        $instituto_universidad = mysqli_real_escape_string($conn, $_POST['instituto_universidad']);
        $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones']);

        $sql = "INSERT INTO formacion_actual (id_usuario, estudios_en_curso, anio_estimado_graduacion, instituto_universidad, observaciones, estatus)
                VALUES ('$id', '$estudios_en_curso', '$anio_estimado_graduacion', '$instituto_universidad', '$observaciones', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo 'si';
        else
            echo 'no';
    }

    if($opc == "edit"){
        $id_formacion_actual = mysqli_real_escape_string($conn, $_POST['id_formacion_actual']);
        $estudios_en_curso = mysqli_real_escape_string($conn, $_POST['estudios_en_curso']);
        $anio_estimado_graduacion = mysqli_real_escape_string($conn, $_POST['anio_estimado_graduacion']);
        $instituto_universidad = mysqli_real_escape_string($conn, $_POST['instituto_universidad']);
        $observaciones = mysqli_real_escape_string($conn, $_POST['observaciones']);

        $sql = "SELECT * FROM formacion_actual WHERE id_formacion_actual = '$id_formacion_actual';";
        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $changes = 0;

            if($estudios_en_curso != $row['estudios_en_curso']){
                $sql = "UPDATE formacion_actual SET estudios_en_curso = '$estudios_en_curso' WHERE id_formacion_actual = '$id_formacion_actual';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($anio_estimado_graduacion != $row['anio_estimado_graduacion']){
                $sql = "UPDATE formacion_actual SET anio_estimado_graduacion = '$anio_estimado_graduacion' WHERE id_formacion_actual = '$id_formacion_actual';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($instituto_universidad != $row['instituto_universidad']){
                $sql = "UPDATE formacion_actual SET instituto_universidad = '$instituto_universidad' WHERE id_formacion_actual = '$id_formacion_actual';";
                if(mysqli_query($conn, $sql)) $changes++;
            }
            if($observaciones != $row['observaciones']){
                $sql = "UPDATE formacion_actual SET observaciones = '$observaciones' WHERE id_formacion_actual = '$id_formacion_actual';";
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
        $sql = "UPDATE formacion_actual SET estatus = '$estatus' WHERE id_formacion_actual = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res)
            echo "si";
        else
            echo "no";
    }

    closeConection($conn);
?>
