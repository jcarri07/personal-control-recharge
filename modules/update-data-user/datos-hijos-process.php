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

        $nombre = $_POST['nombre'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $cedula = $_POST['cedula'];
        $sexo = $_POST['sexo'];
        $educacion = $_POST['educacion'];
        $talla_camisa = $_POST['talla_camisa'];
        $talla_pantalon = $_POST['talla_pantalon'];
        $talla_calzado = $_POST['talla_calzado'];

        $sql = "INSERT INTO datos_hijos (id_usuario, nombre, fecha_nacimiento, cedula, sexo, grado_escolar_semestre, talla_camisa, talla_pantalon, talla_calzado, estatus, edad)
                VALUES ('$id', '$nombre', '$fecha_nacimiento', '$cedula', '$sexo', '$educacion', '$talla_camisa', '$talla_pantalon', '$talla_calzado', 'activo', '0');";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo 'si';
    }

    if($opc == "edit"){
        $id_hijo = $_POST['id_hijo'];
        $nombre = $_POST['nombre'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $cedula = $_POST['cedula'];
        $sexo = $_POST['sexo'];
        $educacion = $_POST['educacion'];
        $talla_camisa = $_POST['talla_camisa'];
        $talla_pantalon = $_POST['talla_pantalon'];
        $talla_calzado = $_POST['talla_calzado'];


        $sql = "SELECT * FROM datos_hijos WHERE id_datos_hijos = '$id_hijo';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        /*$id_datos_personales = $row['id_datos_personales'];

        function getSql($string, $id_datos_personales){
            return "UPDATE datos_personales SET $string WHERE id_datos_personales = '$id_datos_personales';";
        }*/

        $res = "";

        //Datos Personales
        if($nombre != $row['nombre']){
            $sql = "UPDATE datos_hijos SET nombre = '$nombre' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($fecha_nacimiento != $row['fecha_nacimiento']){
            $sql = "UPDATE datos_hijos SET fecha_nacimiento = '$fecha_nacimiento' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($cedula != $row['cedula']){
            $sql = "UPDATE datos_hijos SET cedula = '$cedula' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($sexo != $row['sexo']){
            $sql = "UPDATE datos_hijos SET sexo = '$sexo' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($educacion != $row['grado_escolar_semestre']){
            $sql = "UPDATE datos_hijos SET grado_escolar_semestre = '$educacion' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($talla_camisa != $row['talla_camisa']){
            $sql = "UPDATE datos_hijos SET talla_camisa = '$talla_camisa' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($talla_pantalon != $row['talla_pantalon']){
            $sql = "UPDATE datos_hijos SET talla_pantalon = '$talla_pantalon' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        if($talla_calzado != $row['talla_calzado']){
            $sql = "UPDATE datos_hijos SET talla_calzado = '$talla_calzado' WHERE id_datos_hijos = '$id_hijo';";
            $res = mysqli_query($conn, $sql);
        }
        


        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    if($opc == "estatus"){
        $estatus = $_POST['estatus'];
        $sql = "UPDATE datos_hijos SET estatus = '$estatus' WHERE id_datos_hijos = '$id';";
        $res = mysqli_query($conn, $sql);

        if($res == 1)
            echo "si";
    }

    closeConection($conn);
?>