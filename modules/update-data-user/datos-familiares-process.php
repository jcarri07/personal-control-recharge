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

        $parentesco = $_POST['parentesco'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $cedula = $_POST['cedula'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $estado_civil = $_POST['estado_civil'];
        $sexo = $_POST['sexo'];
        $educacion = $_POST['educacion'];

        $sql = "INSERT INTO nucleo_familiar (id_usuario, nombre, apellido, parentesco, cedula, fecha_nacimiento, sexo, estado_civil, grado_instruccion, estatus)
                VALUES ('$id', '$nombre', '$apellido', '$parentesco', '$cedula', '$fecha_nacimiento', '$sexo', '$estado_civil', '$educacion', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo 'si';
    }

    if($opc == "edit"){
        $id_familiar = $_POST['id_familiar'];
        $parentesco = $_POST['parentesco'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $cedula = $_POST['cedula'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $estado_civil = $_POST['estado_civil'];
        $sexo = $_POST['sexo'];
        $educacion = $_POST['educacion'];


        $sql = "SELECT * FROM nucleo_familiar WHERE id_nucleo_familiar = '$id_familiar';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        /*$id_datos_personales = $row['id_datos_personales'];

        function getSql($string, $id_datos_personales){
            return "UPDATE datos_personales SET $string WHERE id_datos_personales = '$id_datos_personales';";
        }*/

        $res = "";

        if($nombre != $row['nombre']){
            $sql = "UPDATE nucleo_familiar SET nombre = '$nombre' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($apellido != $row['apellido']){
            $sql = "UPDATE nucleo_familiar SET apellido = '$apellido' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($parentesco != $row['parentesco']){
            $sql = "UPDATE nucleo_familiar SET parentesco = '$parentesco' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($cedula != $row['cedula']){
            $sql = "UPDATE nucleo_familiar SET cedula = '$cedula' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($fecha_nacimiento != $row['fecha_nacimiento']){
            $sql = "UPDATE nucleo_familiar SET fecha_nacimiento = '$fecha_nacimiento' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($sexo != $row['sexo']){
            $sql = "UPDATE nucleo_familiar SET sexo = '$sexo' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($estado_civil != $row['estado_civil']){
            $sql = "UPDATE nucleo_familiar SET estado_civil = '$estado_civil' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        if($educacion != $row['grado_instruccion']){
            $sql = "UPDATE nucleo_familiar SET grado_instruccion = '$educacion' WHERE id_nucleo_familiar = '$id_familiar';";
            $res = mysqli_query($conn, $sql);
        }
        


        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    closeConection($conn);
?>