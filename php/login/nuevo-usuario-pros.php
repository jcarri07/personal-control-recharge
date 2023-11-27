<?php 
require_once "../../database/conexion.php";
$user= $_POST["usuario"];
$nombre=$_POST["nombre"];
$contra=$_POST["pass"];
$apellido=$_POST["apellido"];
$cedula=$_POST["cedula"];
$email = $_POST["email"];

$res = mysqli_query($conn, "SELECT cedula FROM usuario WHERE cedula = '$cedula';");
$num_r= mysqli_num_rows($res);
if($num_r >= 1){
    echo 'existe_cedula';
    return;
}
else{
$res = mysqli_query($conn, "SELECT user FROM usuario WHERE user = '$user';");
$num_r= mysqli_num_rows($res);
if($num_r >= 1){
    echo 'existe_usuario';
    return;
}
else{

$res = mysqli_query($conn,"INSERT INTO usuario (nombres, apellidos, cedula, user, pass,tipo_usuario, estatus,correo) VALUES ('$nombre', '$apellido','$cedula','$user','$contra','empleado','activo','$email');");

if($res){
    echo "si";
}else{echo"no";};

}
closeConection($conn);
}
?>