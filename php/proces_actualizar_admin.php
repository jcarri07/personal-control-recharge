<?php
require_once "../database/conexion.php";

if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
} else {
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
}

$user_nuevo = mysqli_real_escape_string($conn, trim($_POST['user']));

$query = mysqli_query($conn, "SELECT firma FROM datos_personales WHERE id_usuario = (SELECT id_usuario FROM usuario WHERE user = '$user_nuevo')")
or die('error ' . mysqli_error($conn));

$firma_nuevo_adm = mysqli_fetch_assoc($query);

$nombres = mysqli_query($conn, "UPDATE usuario SET nombres = (SELECT nombres FROM usuario WHERE user = '$user_nuevo'), apellidos = (SELECT apellidos FROM usuario WHERE user = '$user_nuevo') WHERE id_usuario = '{$_SESSION['id_usuario']}'") or die('error: ' . mysqli_error($conn));


$query2 = mysqli_query($conn, "UPDATE datos_personales SET firma = '{$firma_nuevo_adm['firma']}' WHERE id_usuario = '{$_SESSION['id_usuario']}'") or die('error: ' . mysqli_error($conn));


if ($query2) {

//header("location: ../home/solicitudes.php?alert=4");
echo "1";

} else {

    echo "0";

//header("location: ../home/solicitudes.php?alert=2");
}


?>