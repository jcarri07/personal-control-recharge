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

        $organismo = $_POST['organismo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_egreso = $_POST['fecha_egreso'];
        $cargo = $_POST['cargo'];
        $antecedentes_servicios = $_POST['antecedentes_servicios'];

        $sql = "INSERT INTO experiencia_instituciones_publicas (id_usuario, organismo, fecha_ingreso, fecha_egreso, cargo, antecedentes_servicios, estatus)
                VALUES ('$id', '$organismo', '$fecha_ingreso', '$fecha_egreso', '$cargo', '$antecedentes_servicios', 'activo');";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo 'si';
    }

    if($opc == "edit"){
        $id_experiencia = $_POST['id_experiencia'];
        $organismo = $_POST['organismo'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $fecha_egreso = $_POST['fecha_egreso'];
        $cargo = $_POST['cargo'];
        $antecedentes_servicios = $_POST['antecedentes_servicios'];


        $sql = "SELECT * FROM experiencia_instituciones_publicas WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        /*$id_datos_personales = $row['id_datos_personales'];

        function getSql($string, $id_datos_personales){
            return "UPDATE datos_personales SET $string WHERE id_datos_personales = '$id_datos_personales';";
        }*/

        $res = "";

        //Formación en el Exteior
        if($organismo != $row['organismo']){
            $sql = "UPDATE experiencia_instituciones_publicas SET organismo = '$organismo' WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
            $res = mysqli_query($conn, $sql);
        }
        if($fecha_ingreso != $row['fecha_ingreso']){
            $sql = "UPDATE experiencia_instituciones_publicas SET fecha_ingreso = '$fecha_ingreso' WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
            $res = mysqli_query($conn, $sql);
        }
        if($fecha_egreso != $row['fecha_egreso']){
            $sql = "UPDATE experiencia_instituciones_publicas SET fecha_egreso = '$fecha_egreso' WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
            $res = mysqli_query($conn, $sql);
        }
        if($cargo != $row['cargo']){
            $sql = "UPDATE experiencia_instituciones_publicas SET cargo = '$cargo' WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
            $res = mysqli_query($conn, $sql);
        }
        if($antecedentes_servicios != $row['antecedentes_servicios']){
            $sql = "UPDATE experiencia_instituciones_publicas SET antecedentes_servicios = '$antecedentes_servicios' WHERE id_experiencia_instituciones_publicas = '$id_experiencia';";
            $res = mysqli_query($conn, $sql);
        }


        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    if($opc == "estatus"){
        $estatus = $_POST['estatus'];
        $sql = "UPDATE experiencia_instituciones_publicas SET estatus = '$estatus' WHERE id_experiencia_instituciones_publicas = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo "si";
    }

    closeConection($conn);
?>