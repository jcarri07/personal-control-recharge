<?php
require_once '../../database/conexion.php';

// [CRIT-03 FIX] Reemplazado concatenación directa de $_POST por mysqli_real_escape_string
// en todas las queries de actualización de datos personales

if (mysqli_connect_errno()) {
    // [MED-02 FIX] No exponer detalles del error al usuario
    error_log("Error de conexión: " . mysqli_connect_error());
    echo "Error de conexión. Contacte al administrador.";
    exit();
}

// Función auxiliar de escape
function esc($conn, $val) {
    return mysqli_real_escape_string($conn, trim((string)$val));
}

$id  = esc($conn, $_POST['id'] ?? '');
$opc = esc($conn, $_POST['opc'] ?? '');

if ($opc == "edit") {

    $nombre                     = esc($conn, $_POST['nombre'] ?? '');
    $apellido                   = esc($conn, $_POST['apellido'] ?? '');
    $cedula                     = esc($conn, $_POST['cedula'] ?? '');
    $correo                     = esc($conn, $_POST['correo'] ?? '');
    $rif                        = esc($conn, $_POST['rif'] ?? '');
    $lugar_nacimiento           = esc($conn, $_POST['lugar_nacimiento'] ?? '');
    $fecha_nacimiento           = esc($conn, $_POST['fecha_nacimiento'] ?? '');
    $sexo                       = esc($conn, $_POST['sexo'] ?? '');
    $estado_civil               = esc($conn, $_POST['estado_civil'] ?? '');
    $municipio                  = esc($conn, $_POST['municipio'] ?? '');
    $direccion_domicilio        = esc($conn, $_POST['direccion_domicilio'] ?? '');
    $telefono                   = esc($conn, $_POST['telefono'] ?? '');
    $celular                    = esc($conn, $_POST['celular'] ?? '');
    $telefono_emergencia        = esc($conn, $_POST['telefono_emergencia'] ?? '');
    $nombre_contacto_emergencia = esc($conn, $_POST['nombre_contacto_emergencia'] ?? '');
    $alergias                   = esc($conn, $_POST['alergias'] ?? '');
    $tipo_sangre                = esc($conn, $_POST['tipo_sangre'] ?? '');
    $padece_enfermedad_cronica  = esc($conn, $_POST['padece_enfermedad_cronica'] ?? '');
    $describa_enfermedad_cronica = esc($conn, $_POST['describa_enfermedad_cronica'] ?? '');
    $nombre_conyugue            = esc($conn, $_POST['nombre_conyugue'] ?? '');
    $perfil_dominante           = esc($conn, $_POST['perfil_dominante'] ?? '');
    $esta_embarazada            = esc($conn, $_POST['esta_embarazada'] ?? '');
    $meses_gestacion            = esc($conn, $_POST['meses_gestacion'] ?? '');
    $talla_camisa               = esc($conn, $_POST['talla_camisa'] ?? '');
    $talla_pantalon             = esc($conn, $_POST['talla_pantalon'] ?? '');
    $talla_calzado              = esc($conn, $_POST['talla_calzado'] ?? '');
    $estatura                   = esc($conn, $_POST['estatura'] ?? '');
    $peso                       = esc($conn, $_POST['peso'] ?? '');

    $sql = "SELECT * FROM usuario WHERE id_usuario = '$id';";
    $query = mysqli_query($conn, $sql);
    $row_usuario = mysqli_fetch_array($query);

    $sql = "SELECT * FROM datos_personales WHERE id_usuario = '$id' ORDER BY id_datos_personales DESC LIMIT 1;";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    $id_datos_personales = esc($conn, $row['id_datos_personales'] ?? '');

    function getSql($string, $id_datos_personales, $id_usuario = '')
    {
        if (!empty($id_datos_personales)) {
            return "UPDATE datos_personales SET $string WHERE id_datos_personales = '$id_datos_personales';";
        } elseif (!empty($id_usuario)) {
            return "UPDATE datos_personales SET $string WHERE id_usuario = '$id_usuario';";
        }
        return "";
    }

    $res = "";

    //Datos Personales
    if ($nombre != $row_usuario['nombres']) {
        $sql = "UPDATE usuario SET nombres = '$nombre' WHERE id_usuario = '$id';";
        $res = mysqli_query($conn, $sql);
    }
    if ($apellido != $row_usuario['apellidos']) {
        $sql = "UPDATE usuario SET apellidos = '$apellido' WHERE id_usuario = '$id';";
        $res = mysqli_query($conn, $sql);
    }
    if ($cedula != $row_usuario['cedula']) {
        $sql = "UPDATE usuario SET cedula = '$cedula' WHERE id_usuario = '$id';";
        $res = mysqli_query($conn, $sql);
    }
    if ($correo != $row_usuario['correo']) {
        $sql = "UPDATE usuario SET correo = '$correo' WHERE id_usuario = '$id';";
        $res = mysqli_query($conn, $sql);
    }

    if ($rif != $row['rif']) {
        $sql = getSql("rif = '$rif'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($lugar_nacimiento != $row['lugar_nacimiento']) {
        $sql = getSql("lugar_nacimiento = '$lugar_nacimiento'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($fecha_nacimiento != $row['fecha_nacimiento']) {
        $sql = getSql("fecha_nacimiento = '$fecha_nacimiento'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($sexo != $row['sexo']) {
        $sql = getSql("sexo = '$sexo'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($estado_civil != $row['estado_civil']) {
        $sql = getSql("estado_civil = '$estado_civil'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }

    //Direccion y Contacto
    if ($municipio != $row['id_municipio']) {
        $sql = getSql("id_municipio = '$municipio'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($direccion_domicilio != $row['domicilio']) {
        $sql = getSql("domicilio = '$direccion_domicilio'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($telefono != $row['telefono_habitacion']) {
        $sql = getSql("telefono_habitacion = '$telefono'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($celular != $row['telefono_movil']) {
        $sql = getSql("telefono_movil = '$celular'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($telefono_emergencia != $row['telefono_emergencia']) {
        $sql = getSql("telefono_emergencia = '$telefono_emergencia'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($nombre_contacto_emergencia != $row['contacto_emergencia']) {
        $sql = getSql("contacto_emergencia = '$nombre_contacto_emergencia'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }

    //Datos Medicos
    if ($alergias != $row['alergias']) {
        $sql = getSql("alergias = '$alergias'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($tipo_sangre != $row['tipo_sangre']) {
        $sql = getSql("tipo_sangre = '$tipo_sangre'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($padece_enfermedad_cronica != $row['padece_enfermedad_cronica']) {
        $sql = getSql("padece_enfermedad_cronica = '$padece_enfermedad_cronica'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($describa_enfermedad_cronica != $row['enfermedad_cronica']) {
        $sql = getSql("enfermedad_cronica = '$describa_enfermedad_cronica'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($nombre_conyugue != $row['nombre_conyugue']) {
        $sql = getSql("nombre_conyugue = '$nombre_conyugue'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($perfil_dominante != $row['perfil_dominante']) {
        $sql = getSql("perfil_dominante = '$perfil_dominante'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($esta_embarazada != $row['esta_embarazada']) {
        $sql = getSql("esta_embarazada = '$esta_embarazada'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($meses_gestacion != $row['meses_gestacion']) {
        $sql = getSql("meses_gestacion = '$meses_gestacion'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }

    //Tallas y Medidas
    if ($talla_camisa != $row['talla_camisa']) {
        $sql = getSql("talla_camisa = '$talla_camisa'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($talla_pantalon != $row['talla_pantalon']) {
        $sql = getSql("talla_pantalon = '$talla_pantalon'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($talla_calzado != $row['talla_calzado']) {
        $sql = getSql("talla_calzado = '$talla_calzado'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($estatura != $row['estatura']) {
        $sql = getSql("estatura = '$estatura'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }
    if ($peso != $row['peso']) {
        $sql = getSql("peso = '$peso'", $id_datos_personales);
        $res = mysqli_query($conn, $sql);
    }

    // Tipos y extensiones permitidas
    $allowedExts  = ['jpg', 'jpeg', 'png', 'webp'];
    $allowedMimes = ['image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/webp'];

    // Upload de firma con validación robusta de tipo MIME
    if (isset($_FILES['firma']) && $_FILES['firma']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['firma']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['firma']['name'];
            $extensionArchivo = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            $mime = '';
            if (class_exists('finfo')) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($_FILES['firma']['tmp_name']);
            } elseif (function_exists('mime_content_type')) {
                $mime = mime_content_type($_FILES['firma']['tmp_name']);
            } else {
                $mime = $_FILES['firma']['type'] ?? '';
            }

            if (empty($mime) || $mime === 'application/octet-stream') {
                $imgInfo = @getimagesize($_FILES['firma']['tmp_name']);
                if ($imgInfo && isset($imgInfo['mime'])) {
                    $mime = $imgInfo['mime'];
                }
            }

            if (in_array($extensionArchivo, $allowedExts) && (empty($mime) || in_array($mime, $allowedMimes))) {
                $destDir = __DIR__ . '/../../assets/firmas-images';
                if (!is_dir($destDir)) {
                    @mkdir($destDir, 0777, true);
                }
                $file = "firma_user_" . $id . "_" . uniqid() . "." . $extensionArchivo;
                $ruta_img = $destDir . DIRECTORY_SEPARATOR . $file;

                if (move_uploaded_file($_FILES['firma']['tmp_name'], $ruta_img)) {
                    $sql = "UPDATE datos_personales SET firma = '$file' WHERE id_usuario = '$id'";
                    if (!empty($id_datos_personales)) {
                        $sql .= " OR id_datos_personales = '$id_datos_personales'";
                    }
                    $resFirma = mysqli_query($conn, $sql);
                    if ($resFirma) {
                        $res = true;
                    }
                } else {
                    error_log("Error al guardar firma en: " . $ruta_img);
                }
            }
        }
    }

    // Upload de foto con validación robusta de tipo MIME
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['foto']['name'];
            $extensionArchivo = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            $mime = '';
            if (class_exists('finfo')) {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime  = $finfo->file($_FILES['foto']['tmp_name']);
            } elseif (function_exists('mime_content_type')) {
                $mime = mime_content_type($_FILES['foto']['tmp_name']);
            } else {
                $mime = $_FILES['foto']['type'] ?? '';
            }

            if (empty($mime) || $mime === 'application/octet-stream') {
                $imgInfo = @getimagesize($_FILES['foto']['tmp_name']);
                if ($imgInfo && isset($imgInfo['mime'])) {
                    $mime = $imgInfo['mime'];
                }
            }

            if (in_array($extensionArchivo, $allowedExts) && (empty($mime) || in_array($mime, $allowedMimes))) {
                $destDir = __DIR__ . '/../../assets/empleados-images';
                if (!is_dir($destDir)) {
                    @mkdir($destDir, 0777, true);
                }
                $file = "foto_user_" . $id . "_" . uniqid() . "." . $extensionArchivo;
                $ruta_img = $destDir . DIRECTORY_SEPARATOR . $file;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_img)) {
                    $sql = "UPDATE datos_personales SET foto = '$file' WHERE id_usuario = '$id'";
                    if (!empty($id_datos_personales)) {
                        $sql .= " OR id_datos_personales = '$id_datos_personales'";
                    }
                    $resFoto = mysqli_query($conn, $sql);
                    if ($resFoto) {
                        $res = true;
                    }
                } else {
                    error_log("Error al guardar foto en: " . $ruta_img);
                }
            } else {
                error_log("Foto rechazada por formato o MIME inválido. Ext: $extensionArchivo, MIME: $mime");
            }
        } else {
            error_log("Error en subida de archivo foto. Código error: " . $_FILES['foto']['error']);
        }
    }

    if ($res)
        echo "si";
    else
        echo "vacio";
}

closeConection($conn);
?>
