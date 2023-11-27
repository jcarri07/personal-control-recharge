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

        $fecha_ingreso = $_POST['fecha_ingreso'];
        $cargo = $_POST['cargo'];
        $direccion = $_POST['direccion'];
        $unidad = $_POST['unidad'];
        $supervisor_inmediato = $_POST['supervisor_inmediato'];
        $fecha_inicio_admin_publica = $_POST['fecha_inicio_admin_publica'];
        $correo = $_POST['correo'];
        $telefono_oficina = $_POST['telefono_oficina'];
        $nombre_familiares = $_POST['nombre_familiares'];

        $sql = "SELECT id_jefe FROM usuario WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);
        $usuario = mysqli_fetch_array($query);

        $sql = "SELECT * FROM datos_abae WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        $id_datos_abae = $row['id_datos_abae'];
        $res = "";

        //Datos Institucionales
        if($fecha_ingreso != $row['fecha_ingreso']){
            $sql = "UPDATE datos_abae SET fecha_ingreso = '$fecha_ingreso' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($cargo != $row['cargo']){
            $sql = "UPDATE datos_abae SET cargo = '$cargo' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($direccion != $row['id_direccion']){
            $sql = "UPDATE datos_abae SET id_direccion = '$direccion' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($unidad != $row['id_unidad']){
            $sql = "UPDATE datos_abae SET id_unidad = '$unidad' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($fecha_inicio_admin_publica != $row['fecha_inicio_administracion']){
            $sql = "UPDATE datos_abae SET fecha_inicio_administracion = '$fecha_inicio_admin_publica' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($correo != $row['correo_abae']){
            $sql = "UPDATE datos_abae SET correo_abae = '$correo' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($telefono_oficina != $row['tlf_oficina']){
            $sql = "UPDATE datos_abae SET tlf_oficina = '$telefono_oficina' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }
        if($nombre_familiares != $row['nombres_familiares_abae']){
            $sql = "UPDATE datos_abae SET nombres_familiares_abae = '$nombre_familiares' WHERE id_datos_abae = '$id_datos_abae';";
            $res = mysqli_query($conn, $sql);
        }

        if($supervisor_inmediato != $usuario['id_jefe']){
            $sql = "UPDATE usuario SET id_jefe = '$supervisor_inmediato' WHERE id_usuario = '$id';";
            $res = mysqli_query($conn, $sql);
        }
        

        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    closeConection($conn);
?>