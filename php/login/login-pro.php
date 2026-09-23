<?php
require_once "../../database/conexion.php";
if (!isset($_SESSION)) {
    session_start();
}
$user = $_POST["user"];
$contra = $_POST["password"];

$res = mysqli_query($conn, "SELECT u.id_usuario, u.nombres, u.apellidos, u.cedula, u.user, u.tipo_usuario, d.cargo 
                           FROM usuario u
                           LEFT JOIN datos_abae d ON u.id_usuario = d.id_usuario
                           WHERE u.user='$user' AND u.pass='$contra';");


if (mysqli_num_rows($res) >= 1) {
    $obj = mysqli_fetch_object($res);
    $_SESSION["id_usuario"] = $obj->id_usuario;
    $_SESSION["nombre"] = $obj->nombres;
    $_SESSION["apellido"] = $obj->apellidos;
    $_SESSION["cedula"] = $obj->cedula;
    $_SESSION["usuario"] = $obj->user;
    $_SESSION["tipo_usuario"] = $obj->tipo_usuario;
    if ($obj->cargo != null) {
        $_SESSION["cargo"] = $obj->cargo;
    } else {
        $_SESSION["cargo"] = 'Sin asignar';
    }

    $res2 = mysqli_query($conn, "SELECT d.id_unidad 
                           FROM datos_abae d, usuario us
                           WHERE us.id_usuario='$obj->id_usuario' AND d.id_usuario = us.id_usuario");
    //Agregar la unidad a la session                       
    $obj2 = mysqli_fetch_object($res2);
    $_SESSION["unidad"] = $obj2->id_unidad;


    $re = mysqli_query($conn, "SELECT u.nombre, u.id_unidad
                            FROM unidad u
                            JOIN datos_abae d ON d.id_unidad = u.id_unidad
                            JOIN usuario us ON us.id_usuario = d.id_usuario
                            WHERE us.id_usuario = '$obj->id_usuario';");

    if (mysqli_num_rows($re) >= 1) {
        $aux = mysqli_fetch_object($re);
        $_SESSION["unidad"] = $aux->nombre;
        $_SESSION["id_unidad"] = $aux->id_unidad;
    }
    echo "si";
} else {
    echo "no";
};
closeConection($conn);

