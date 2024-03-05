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

$user_nuevo = mysqli_real_escape_string($conn, trim($_POST['nombre']));

$query = mysqli_query($conn, "SELECT nombres, apellidos FROM usuario WHERE user = '$user_nuevo'")
or die('error ' . mysqli_error($conn));

if ($data = mysqli_fetch_assoc($query)) {
    echo $data['nombres'].' '. $data['apellidos'];
} else {
    echo '0';
}

?>