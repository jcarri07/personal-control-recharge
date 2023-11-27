<?php
require_once "../../database/conexion.php";

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

$año_actual = mysqli_real_escape_string($conn, trim($_POST['año_actual']));
$año_siguiente = mysqli_real_escape_string($conn, trim($_POST['año_siguiente']));

$query = mysqli_query($conn, "UPDATE feriados SET days_actual = '$año_actual', days_siguiente = '$año_siguiente' WHERE id = 1");

if($query){
    echo '1';
}else{
    echo '0';
}

?>