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

        $facebook = $_POST['facebook'];
        $twitter = $_POST['twitter'];
        $instagram = $_POST['instagram'];
        $otras_redes = $_POST['otras_redes'];

        $posee_carnet_patria = $_POST['posee_carnet_patria'];
        $codigo_carnet_patria = $_POST['codigo_carnet_patria'];
        $serial_carnet_patria = $_POST['serial_carnet_patria'];
        $beneficios_patria = $_POST['beneficios_patria'];

        $posee_carnet_psuv = $_POST['posee_carnet_psuv'];
        $codigo_carnet_psuv = $_POST['codigo_carnet_psuv'];
        $serial_carnet_psuv = $_POST['serial_carnet_psuv'];
        $beneficios_psuv = $_POST['beneficios_psuv'];

        $pertenece_partido_politico = $_POST['pertenece_partido_politico'];
        $pertenece_movimiento_social = $_POST['pertenece_movimiento_social'];
        $pertenece_comuna = $_POST['pertenece_comuna'];
        $es_vocero_comuna = $_POST['es_vocero_comuna'];
        $recibe_clap = $_POST['recibe_clap'];

        $vivienda = $_POST['vivienda'];
        $tipo_vivienda = $_POST['tipo_vivienda'];
        $posee_vehiculo = $_POST['posee_vehiculo'];
        $tipo_vehiculo = $_POST['tipo_vehiculo'];

        $usa_transporte_publico = $_POST['usa_transporte_publico'];
        $tipo_transporte_publico = $_POST['tipo_transporte_publico'];
        $ruta_trabajo = $_POST['ruta_trabajo'];
        $deporte_actividad_cultural = $_POST['deporte_actividad_cultural'];

        $sql = "SELECT * FROM otros_datos_usuario WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);

        $res = "";
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_array($query);
            $id_otros_datos_usuario = $row['id_otros_datos_usuario'];

            //Otros Datos
            if($facebook != $row['facebook']){
                $sql = "UPDATE otros_datos_usuario SET facebook = '$facebook' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($twitter != $row['twitter']){
                $sql = "UPDATE otros_datos_usuario SET twitter = '$twitter' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($instagram != $row['instagram']){
                $sql = "UPDATE otros_datos_usuario SET instagram = '$instagram' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($otras_redes != $row['otras_redes']){
                $sql = "UPDATE otros_datos_usuario SET otras_redes = '$otras_redes' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }


            if($posee_carnet_patria != $row['tiene_carnet_patria']){
                $sql = "UPDATE otros_datos_usuario SET tiene_carnet_patria = '$posee_carnet_patria' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($codigo_carnet_patria != $row['codigo_carnet_patria']){
                $sql = "UPDATE otros_datos_usuario SET codigo_carnet_patria = '$codigo_carnet_patria' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($serial_carnet_patria != $row['serial_carnet_patria']){
                $sql = "UPDATE otros_datos_usuario SET serial_carnet_patria = '$serial_carnet_patria' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($beneficios_patria != $row['beneficios_patria']){
                $sql = "UPDATE otros_datos_usuario SET beneficios_patria = '$beneficios_patria' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }


            if($posee_carnet_psuv != $row['tiene_carnet_psuv']){
                $sql = "UPDATE otros_datos_usuario SET tiene_carnet_psuv = '$posee_carnet_psuv' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($codigo_carnet_psuv != $row['codigo_carnet_psuv']){
                $sql = "UPDATE otros_datos_usuario SET codigo_carnet_psuv = '$codigo_carnet_psuv' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($serial_carnet_psuv != $row['serial_carnet_psuv']){
                $sql = "UPDATE otros_datos_usuario SET serial_carnet_psuv = '$serial_carnet_psuv' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($beneficios_psuv != $row['beneficios_psuv']){
                $sql = "UPDATE otros_datos_usuario SET beneficios_psuv = '$beneficios_psuv' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }


            if($pertenece_partido_politico != $row['partido_politico']){
                $sql = "UPDATE otros_datos_usuario SET partido_politico = '$pertenece_partido_politico' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($pertenece_movimiento_social != $row['movimiento_social']){
                $sql = "UPDATE otros_datos_usuario SET movimiento_social = '$pertenece_movimiento_social' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($pertenece_comuna != $row['comuna']){
                $sql = "UPDATE otros_datos_usuario SET comuna = '$pertenece_comuna' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($es_vocero_comuna != $row['es_vocero_comuna']){
                $sql = "UPDATE otros_datos_usuario SET es_vocero_comuna = '$es_vocero_comuna' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($recibe_clap != $row['recibe_clap']){
                $sql = "UPDATE otros_datos_usuario SET recibe_clap = '$recibe_clap' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }


            if($vivienda != $row['vivienda']){
                $sql = "UPDATE otros_datos_usuario SET vivienda = '$vivienda' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($tipo_vivienda != $row['tipo_vivienda']){
                $sql = "UPDATE otros_datos_usuario SET tipo_vivienda = '$tipo_vivienda' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($posee_vehiculo != $row['posee_vehiculo']){
                $sql = "UPDATE otros_datos_usuario SET posee_vehiculo = '$posee_vehiculo' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($tipo_vehiculo != $row['tipo_vehiculo']){
                $sql = "UPDATE otros_datos_usuario SET tipo_vehiculo = '$tipo_vehiculo' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }


            if($usa_transporte_publico != $row['usa_transporte_publico']){
                $sql = "UPDATE otros_datos_usuario SET usa_transporte_publico = '$usa_transporte_publico' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($tipo_transporte_publico != $row['tipo_transporte_publico']){
                $sql = "UPDATE otros_datos_usuario SET tipo_transporte_publico = '$tipo_transporte_publico' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($ruta_trabajo != $row['ruta_trabajo']){
                $sql = "UPDATE otros_datos_usuario SET ruta_trabajo = '$ruta_trabajo' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
            if($deporte_actividad_cultural != $row['deporte_actividad_cutural']){
                $sql = "UPDATE otros_datos_usuario SET deporte_actividad_cutural = '$deporte_actividad_cultural' WHERE id_otros_datos_usuario = '$id_otros_datos_usuario';";
                $res = mysqli_query($conn, $sql);
            }
        }
        else{
            /*if($instituto != "" || $rango != "" || $fecha_inicio != "" || $fecha_fin != ""){
                $sql = "INSERT INTO datos_militar (id_usuario, fecha_inicio, fecha_fin, instituto_militar, rango, estatus)
                        VALUES ('$id', '$fecha_inicio', '$fecha_fin', '$instituto', '$rango', 'activo');";
                $res = mysqli_query($conn, $sql);
            }*/
        }

        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    closeConection($conn);
?>