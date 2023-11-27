<?php 
    require_once '../../database/conexion.php';

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }

    $id = $_POST['id'];
    $opc = $_POST['opc'];

    if($opc == "edit"){

        $instituto = $_POST['instituto'];
        $rango = $_POST['rango'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        $sql = "SELECT * FROM datos_militar WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);

        $res = "";
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_array($query);
            $id_datos_militar = $row['id_datos_militar'];

            //Datos Militar
            if($instituto != $row['instituto_militar']){
                $sql = "UPDATE datos_militar SET instituto_militar = '$instituto' WHERE id_datos_militar = '$id_datos_militar';";
                $res = mysqli_query($conn, $sql);
            }
            if($rango != $row['rango']){
                $sql = "UPDATE datos_militar SET rango = '$rango' WHERE id_datos_militar = '$id_datos_militar';";
                $res = mysqli_query($conn, $sql);
            }
            if($fecha_inicio != $row['fecha_inicio']){
                $sql = "UPDATE datos_militar SET fecha_inicio = '$fecha_inicio' WHERE id_datos_militar = '$id_datos_militar';";
                $res = mysqli_query($conn, $sql);
            }
            if($fecha_fin != $row['fecha_fin']){
                $sql = "UPDATE datos_militar SET fecha_fin = '$fecha_fin' WHERE id_datos_militar = '$id_datos_militar';";
                $res = mysqli_query($conn, $sql);
            }
        }
        else{
            if($instituto != "" || $rango != "" || $fecha_inicio != "" || $fecha_fin != ""){
                $sql = "INSERT INTO datos_militar (id_usuario, fecha_inicio, fecha_fin, instituto_militar, rango, estatus)
                        VALUES ('$id', '$fecha_inicio', '$fecha_fin', '$instituto', '$rango', 'activo');";
                $res = mysqli_query($conn, $sql);
            }
        }

        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    closeConection($conn);
?>