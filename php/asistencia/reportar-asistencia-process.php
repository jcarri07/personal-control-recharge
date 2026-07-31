<?php
    require_once '../../database/conexion.php';
    require '../../vendor/autoload.php';
    require_once 'email_template.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    date_default_timezone_set("America/Caracas");
    $condicion = $_POST['condicion'];
    $descripcion = $_POST['descripcion'];
    $id_usuario = $_POST['id_usuario'];
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    $nombreArchivo = null;

    $rutaCompleta = null;
    if(isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $directorio = 'files/activities/';
        $raiz = '../../' . $directorio;
        
        if(!file_exists($raiz)) {
            mkdir($raiz, 0777, true);
        }

        $file = $_FILES['archivo'];
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        
        $nombreArchivo = uniqid('act_', true) . '.' . $extension;
        $rutaCompleta = $raiz . $nombreArchivo;

        if(!move_uploaded_file($file['tmp_name'], $rutaCompleta)) {
            $nombreArchivo = null;
        }
        else{
            $nombreArchivo = $directorio . $nombreArchivo;
        }
    }


    $query = "INSERT INTO actividad (fecha, hora, condicion, descripcion, id_usuario, estatus, archivo) 
                VALUES (?, ?, ?, ?, ?, 'A', ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssis", $fecha, $hora, $condicion, $descripcion, $id_usuario, $nombreArchivo);
    $res = $stmt->execute();

    if($res) {
        echo 'si';

        if($condicion != "Asistente")
        {

            $sql = "SELECT da.id_unidad AS 'id_unidad', da.cargo AS 'cargo'
                    FROM usuario u
                    INNER JOIN datos_abae da ON u.id_usuario = da.id_usuario
                    WHERE u.id_usuario = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuarioReportante = $resultado->fetch_assoc();
            $idUnidad = $usuarioReportante['id_unidad'] ?? null;

            if($idUnidad) {
                $emails = [];

                // $sql = "SELECT * FROM usuario WHERE cargo = 'Director' AND estatus = 'A';";
                $sql = "SELECT u.correo
                        FROM usuario u
                        INNER JOIN datos_abae da ON u.id_usuario = da.id_usuario
                        WHERE da.cargo = 'Director' AND da.id_unidad = ? AND u.estatus = 'A';";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $idUnidad);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows > 0) {
                    $director = $res->fetch_assoc();
                    $emails[] = $director['correo'];
                }
                $director = $resultado->fetch_assoc();

                if($idUnidad && $idUnidad != '0' && $usuarioReportante['cargo'] != 'Jefe') {
                    // $sql = "SELECT * FROM usuario WHERE id_unidad = ? AND estatus = 'A' AND tipo = 'Jefe';";
                    $sql = "SELECT u.correo
                            FROM usuario u
                            INNER JOIN datos_abae da ON u.id_usuario = da.id_usuario
                            WHERE da.cargo = 'Jefe' AND da.id_unidad = ? AND u.estatus = 'A';";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $idUnidad);
                    $stmt->execute();
                    $jefes = $stmt->get_result();
                    while($jefe = $jefes->fetch_assoc()) {
                        $emails[] = $jefe['correo'];
                    }
                }

                $datos_correo = [
                    'condicion' => $condicion,
                    'descripcion' => $descripcion,
                    'id_usuario' => $id_usuario,
                    'nombre_completo' => $_SESSION['nombre'] . " " . $_SESSION['apellido'],
                    'fecha' => date('d/m/Y'),
                    'hora' => date('h:i A'),
                    'archivo_nombre' => $nombreArchivo,
                    'institucion' => 'Agencia Bolivariana Para Actividades Espaciales',
                    // 'departamento' => 'Control de Personal',
                    'color_principal' => '#013f70',
                    'color_acento' => '#fbae45',
                    'logo_base64' => imagenABase64(__DIR__ . '/../asistencia/abae.png')
                ];
                
                // Generar template
                $template = generarTemplateCorreo($datos_correo);


                // Integración de PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'DIIEBORBURATA@gmail.com';
                    $mail->Password   = 'oszj zijh xinp yadl';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;
                    $mail->CharSet    = 'UTF-8';

                    $mail->setFrom('DIIEBORBURATA@gmail.com', "Reporte de ".$_SESSION['nombre']." ".$_SESSION['apellido']);
                    // $mail->addAddress('nomina@abae.gob.ve');
                    // if(count($emails) > 0) {
                    //     foreach($emails as $email) {
                    //         $mail->addCC($email);
                    //     }
                    // }

                    // $mail->addAddress('alfredocalderon314@gmail.com');
                    // $mail->addAddress('migueldba@hotmail.com');
                    // $mail->addAddress('mdbencomo@gmail.com');
                    // $mail->addCC('mdbencomo@gmail.com');

                    $mail->isHTML(true);
                    $mail->Subject = "Nuevo reporte $condicion registrado";
                    // $mail->Body    = "Se ha registrado un nuevo reporte en el sistema.<br><br><b>Condición:</b> $condicion<br><b>Descripción:</b> $descripcion";
                    $mail->Body    = $template['html'];

                    if ($rutaCompleta && file_exists($rutaCompleta)) {
                        $mail->addAttachment($rutaCompleta);
                    }

                    $mail->send();
                } catch (Exception $e) {
                    // El correo falló silenciosamente, pero el registro fue exitoso
                }
            }
        }
    }
    else {
        echo 'error';
    }


    closeConection($conn);
?>