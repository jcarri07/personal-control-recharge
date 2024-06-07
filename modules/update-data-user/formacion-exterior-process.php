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

        $titulo = $_POST['titulo'];
        $anio = $_POST['anio'];
        $instituto = $_POST['instituto'];
        $pais = $_POST['pais'];

        $sql = "INSERT INTO formacion_exterior (id_usuario, titulo_obtenido, anio_egreso, instituto_universitario, pais, estatus)
                VALUES ('$id', '$titulo', '$anio', '$instituto', '$pais', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo 'si';
    }

    if($opc == "edit"){
        $id_formacion_exterior = $_POST['id_formacion_exterior'];
        $titulo = $_POST['titulo'];
        $anio = $_POST['anio'];
        $instituto = $_POST['instituto'];
        $pais = $_POST['pais'];


        $sql = "SELECT * FROM formacion_exterior WHERE id_formacion_exterior = '$id_formacion_exterior';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        /*$id_datos_personales = $row['id_datos_personales'];

        function getSql($string, $id_datos_personales){
            return "UPDATE datos_personales SET $string WHERE id_datos_personales = '$id_datos_personales';";
        }*/

        $res = "";

        //Formación en el Exteior
        if($titulo != $row['titulo_obtenido']){
            $sql = "UPDATE formacion_exterior SET titulo_obtenido = '$titulo' WHERE id_formacion_exterior = '$id_formacion_exterior';";
            $res = mysqli_query($conn, $sql);
        }
        if($anio != $row['anio_egreso']){
            $sql = "UPDATE formacion_exterior SET anio_egreso = '$anio' WHERE id_formacion_exterior = '$id_formacion_exterior';";
            $res = mysqli_query($conn, $sql);
        }
        if($instituto != $row['instituto_universitario']){
            $sql = "UPDATE formacion_exterior SET instituto_universitario = '$instituto' WHERE id_formacion_exterior = '$id_formacion_exterior';";
            $res = mysqli_query($conn, $sql);
        }
        if($pais != $row['pais']){
            $sql = "UPDATE formacion_exterior SET pais = '$pais' WHERE id_formacion_exterior = '$id_formacion_exterior';";
            $res = mysqli_query($conn, $sql);
        }


        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    if($opc == "estatus"){
        $estatus = $_POST['estatus'];
        $sql = "UPDATE formacion_exterior SET estatus = '$estatus' WHERE id_formacion_exterior = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo "si";
    }

    closeConection($conn);
?>