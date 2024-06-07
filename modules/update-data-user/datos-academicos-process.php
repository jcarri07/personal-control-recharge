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

        $especializacion = $_POST['especializacion'];
        $titulo = $_POST['titulo'];
        $anio = $_POST['anio'];
        $institucion = $_POST['institucion'];

        $sql = "SELECT * FROM nivel_academico WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);

        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);

            $id_nivel_academico = $row['id_nivel_academico'];
            $res = "";

            //Datos Academicos
            if($especializacion != $row['especializacion']){
                $sql = "UPDATE nivel_academico SET especializacion = '$especializacion' WHERE id_nivel_academico = '$id_nivel_academico';";
                $res = mysqli_query($conn, $sql);
            }
            if($titulo != $row['titulo_obtenido']){
                $sql = "UPDATE nivel_academico SET titulo_obtenido = '$titulo' WHERE id_nivel_academico = '$id_nivel_academico';";
                $res = mysqli_query($conn, $sql);
            }
            if($anio != $row['anio_egreso']){
                $sql = "UPDATE nivel_academico SET anio_egreso = '$anio' WHERE id_nivel_academico = '$id_nivel_academico';";
                $res = mysqli_query($conn, $sql);
            }
            if($institucion != $row['instituto_universitario']){
                $sql = "UPDATE nivel_academico SET instituto_universitario = '$institucion' WHERE id_nivel_academico = '$id_nivel_academico';";
                $res = mysqli_query($conn, $sql);
            }
            

            if($res == 1)
                echo "si";
            if($res == "")
                echo "vacio";
        }
        else {
            $sql = "INSERT INTO nivel_academico (id_usuario, especializacion, titulo_obtenido, anio_egreso, instituto_universitario, estatus) VALUES ('$id', '$especializacion', '$titulo', '$anio', '$institucion', 'A');";
            $res = mysqli_query($conn, $sql);

            if($res == 1)
                echo "si";
        }
    }

    closeConection($conn);
?>