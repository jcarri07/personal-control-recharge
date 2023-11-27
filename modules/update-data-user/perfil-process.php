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

        $user = $_POST['user'];
        $pass = $_POST['pass'];
        

        $sql = "SELECT user FROM usuario WHERE id_usuario = '$id';";
        $query = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);

        $res = "";
        if($user != $row['user']){
            $sql = "SELECT user FROM usuario WHERE user = '$user' AND estatus = 'activo';";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                echo "existe";
                exit;
            }
            else{
                $sql = "UPDATE usuario SET user = '$user' WHERE id_usuario = '$id';";
                $res = mysqli_query($conn, $sql);
            }
        }
        if($pass != ""){
            $sql = "UPDATE usuario SET pass = '$pass' WHERE id_usuario = '$id';";
            $res = mysqli_query($conn, $sql);
        }


        if($res == 1)
            echo "si";
        if($res == "")
            echo "vacio";
    }

    closeConection($conn);
?>