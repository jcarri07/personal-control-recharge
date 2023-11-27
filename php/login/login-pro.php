<?php
require_once "../../database/conexion.php";
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$user = $_POST["user"];
$contra = $_POST["password"];

$res = mysqli_query($conn, "SELECT * 
                           FROM usuario 
                           WHERE user='$user' AND pass='$contra';");
$num_r = mysqli_num_rows($res);


if ($num_r >= 1) {
    $obj = mysqli_fetch_object($res);
    $_SESSION["id_usuario"] = $obj->id_usuario;
    $_SESSION["nombre"] = $obj->nombres;
    $_SESSION["apellido"] = $obj->apellidos;
    $_SESSION["cedula"] = $obj->cedula;
    $_SESSION["usuario"] = $obj->user;
    $_SESSION["tipo_usuario"] = $obj->tipo_usuario;

    $re = mysqli_query($conn, "SELECT u.nombre, u.id_unidad
                            FROM unidad u
                            JOIN datos_abae d ON d.id_unidad = u.id_unidad
                            JOIN usuario us ON us.id_usuario = d.id_usuario
                            WHERE us.id_usuario = '$obj->id_usuario';");

    if (mysqli_num_rows($re) >= 1) {
        $aux = mysqli_fetch_object($re);
        $_SESSION["unidad"] = $aux->nombre;
        $_SESSION["id_unidad"] = $aux->id_unidad;

        $res = mysqli_query($conn, "SELECT cargo 
                            FROM datos_abae
                            WHERE id_unidad = '$aux->id_unidad' AND id_usuario = '$obj->id_usuario';");
        if (mysqli_num_rows($res) >= 1) {
            $aux = mysqli_fetch_object($res);
            $_SESSION["cargo"] = $aux->cargo;
        }
    }
    echo "si";
} else {
    echo "no";
};
closeConection($conn);

