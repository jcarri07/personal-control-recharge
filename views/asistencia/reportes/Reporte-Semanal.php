<?php
    session_start();
    ob_start();
    require_once '../../../database/conexion.php';
    require_once 'image-service.php';
    $uni = $_GET['uni'];
    $tipo = $_GET['tipo'];
    $id_unidad = $_GET['unidad'];
    $fecha = $_GET['fecha'];
    $mes = $_GET['mes'];
    $numero_semana = $_GET['num'];
    $d = new DateTime($fecha);
    $me = $d->format('m'); //mes consulta
    $dias = $d->format('t');
    $anio = $d->format('Y'); // año consulta


    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $protocol . $host . $scriptPath;
    $baseUrl = str_replace('php/reportes/modelos', '', $baseUrl);


    function get_days_of_week($month_num, $week_num)
    {
        $year = date('Y');
        $first_day_of_month = date('N', strtotime("$year-$month_num-01"));
        $days_in_month = date('t', strtotime("$year-$month_num-01"));
        $days = array();
        for ($day = 1; $day <= $days_in_month; $day++) {
            $week_of_month = ceil(($day + $first_day_of_month - 1) / 7);
            if ($week_of_month == $week_num) {
                $days[] = $day;
            }
        }
        return $days;
    };

    $dias_semana = get_days_of_week($me, $numero_semana);
    $cantidad = count($dias_semana) - 1;

    // Último día del mes
    $ultimo_dia_mes = date("Y-m-t", strtotime("$anio-$me-01"));

    // Primer día de la semana
    $primer_dia_semana = date("Y-m-d", strtotime("$anio-$me-$dias_semana[0]"));

    // Último día de la semana
    $ultimo_dia_semana = date('Y-m-d', strtotime("{$primer_dia_semana} + " . $cantidad . " days"));
    $ultimo_dia_semana = ($ultimo_dia_semana > $ultimo_dia_mes) ? $ultimo_dia_mes : $ultimo_dia_semana;
    /*$data = str_replace('data:image/png;base64,', '', $data);

    $data = str_replace(' ', '+', $data);

    $data = base64_decode($data);

    $file = 'images/'.rand() . '.png';

    $success = file_put_contents($file, $data);

    $data = base64_decode($data); 

    $source_img = imagecreatefromstring($data);

    $rotated_img = imagerotate($source_img, 90, 0); 

    $file = 'images/'. rand(). '.png';

    $imageSave = imagejpeg($rotated_img, $file, 10);

    imagedestroy($source_img);*/


    // Decodificar la cadena base64 y guardar la imagen en un archivo


    date_default_timezone_set("America/Caracas");
    setlocale(LC_TIME, "Spanish");
    $au = DateTime::createFromFormat("Y-m-d", $fecha);
    $Y = date("Y");

    $selectFields = "u.id_usuario, d.cargo as tipo_usuario, u.nombres as nombre_usuario, u.apellidos, 
                a.condicion, a.descripcion, a.hora, a.fecha, 
                un.nombre as nombre_unidad, a.archivo as archivo";

    $baseJoin = "FROM datos_abae i 
                RIGHT JOIN usuario u ON i.id_usuario = u.id_usuario 
                LEFT JOIN actividad a ON u.id_usuario = a.id_usuario
                LEFT JOIN unidad un ON i.id_unidad = un.id_unidad 
                AND MONTH(a.fecha) = '$mes' 
                AND a.fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' 
                AND a.estatus = 'activo' 
                AND YEAR(a.fecha) = '$Y'";

    $baseConditions = "i.estatus = 'activo'";

    if ($tipo == 'Director') {
        
        
        if ($uni == '0') {
            $query = "SELECT $selectFields
                    $baseJoin
                    ORDER BY un.nombre, u.tipo_usuario ASC, u.nombres DESC, a.fecha DESC, a.hora ASC";
        } else {
            $query = "SELECT $selectFields
                    $baseJoin
                    WHERE  i.id_unidad = '$uni' 
                    ORDER BY u.nombres DESC, u.tipo_usuario ASC, a.fecha DESC, a.hora ASC";
        }
        
        $res = mysqli_query($conn, $query);
    }

    if ($tipo == 'jefe') {
        $query = "SELECT $selectFields
                $baseJoin
                WHERE  i.id_unidad = '$id_unidad' 
                AND u.estatus = 'activo' AND u.tipo_usuario != 'Director'
                ORDER BY u.tipo_usuario ASC, u.nombres DESC, a.fecha DESC, a.hora ASC";
        
        $res = mysqli_query($conn, $query);
    }

    $num_r = mysqli_num_rows($res);

    // if ($tipo == 'Director') {
    //     if ($uni == '0') {
    //         $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha, i.nombre as nombre_unidad, a.archivo as archivo
    //         FROM unidad i 
    //         LEFT JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo' 
    //         LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
    //         WHERE i.estatus = 'A'  
    //         ORDER BY i.nombre,u.tipo ASC, u.nombre DESC, a.fecha DESC, a.hora ASC;");
    //     } else {

    //         $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha, i.nombre as nombre_unidad, a.archivo as archivo
    //                             FROM unidad i 
    //                             LEFT JOIN usuario u ON i.id_unidad = u.id_unidad AND u.id_unidad = '$uni' AND u.estatus = 'A' AND NOT u.tipo = '$tipo'
    //                             LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
    //                             WHERE i.id_unidad = '$uni' AND i.estatus = 'A' 
    //                             ORDER BY u.nombre DESC,u.tipo ASC, a.fecha DESC, a.hora ASC;");
    //     }
    // }

    // if ($tipo == 'Jefe') {
    //     $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha,i.nombre as nombre_unidad, a.archivo as archivo
    //                                 FROM unidad i 
    //                                 LEFT JOIN usuario u ON i.id_unidad = u.id_unidad AND NOT u.tipo = 'Director' AND u.estatus = 'A'
    //                                 LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND fecha BETWEEN '$primer_dia_semana' AND '$ultimo_dia_semana' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
    //                                 WHERE i.estatus = 'A' AND u.id_unidad = '$id_unidad' 
    //                                 ORDER BY u.tipo ASC,u.nombre DESC, a.fecha DESC, a.hora ASC;");
    // }

    // $num_r = mysqli_num_rows($res);

if ($num_r >= 1) {
?>

    <html>

<?php
        include_once 'style-pdf.php';
?>

    <body>
<?php

        include_once 'header-pdf.php';


        $meses_full = [1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $a = ($meses_full[(int)$au->format('n')] ?? '') . ' del ' . $au->format('Y');
        $primer_dia_semana = date("d-m-Y", strtotime("$anio-$me-$dias_semana[0]"));

        // Último día de la semana
        $ultimo_dia_semana = date('d-m-Y', strtotime("{$primer_dia_semana} + " . $cantidad . " days"));
        $ultimo_dia_mes = date("t-m-Y", strtotime("$anio-$me-01"));
        $ultimo_dia_semana = ($ultimo_dia_semana > $ultimo_dia_mes) ? $ultimo_dia_mes : $ultimo_dia_semana;


        echo '<h2>Reporte de Asistencias de la semana entre las fechas '.$primer_dia_semana.' y '.$ultimo_dia_semana.'</h2>'; ?>
        <br>
<?php
        include_once 'watermark-pdf.php';
?>


            <?php
            $unidad_actual = null;
            $usuario_actual_id = null;
            $i = 1;
            $images = [];

            while ($fila = mysqli_fetch_assoc($res)) {

                // Si cambia la unidad
                if ($unidad_actual !== $fila['nombre_unidad']) {
                    if ($usuario_actual_id !== null) {
                        echo '</tbody></table><br>';
                        $usuario_actual_id = null;
                    }
                    if ($unidad_actual !== null) {
                        echo '</ul><div style="page-break-after:always;"></div>';
                    }

                    $unidad_actual = $fila['nombre_unidad'];
                    echo '<h3>' . htmlspecialchars($unidad_actual ?? 'Sin Unidad') . '</h3>';
                    echo '<ul style="list-style:none; padding-left:0;">';
                }

                // Si no hay usuario asociado a este registro
                if ($fila['id_usuario'] === null) {
                    echo '<li><p>Sin Usuarios</p></li><br>';
                    continue;
                }

                // Si cambia el usuario
                if ($usuario_actual_id !== $fila['id_usuario']) {
                    if ($usuario_actual_id !== null) {
                        echo '</tbody></table><br>';
                    }

                    $usuario_actual_id = $fila['id_usuario'];
                    $i = 1;

                    $sel = ($fila['tipo_usuario'] == "jefe" || $fila['tipo_usuario'] == "Director") ? "(E)" : "";
                    $nombre_completo = $fila['nombre_usuario'] . ' ' . $fila['apellidos'];

                    echo '<li><p class="mb-1"><b>' . htmlspecialchars($fila['tipo_usuario']) . $sel . '</b>: ' . htmlspecialchars($nombre_completo) . '</p></li>';
                    echo '<table class="table table-body">';
                    echo '<thead style="width:100%;background: #184072;color:#f5f5f5;">';
                    echo '<tr>';
                    echo '<th>N°</th>';
                    echo '<th>Condicion</th>';
                    echo '<th>Descripción</th>';
                    echo '<th>Fecha</th>';
                    echo '<th>Archivo</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody style="width:100%">';
                }

                $dateStr = '';
                // Renderizar fila de reporte / actividad
                if (!empty($fila['fecha']) && !empty($fila['hora'])) {
                    $timestamp = strtotime($fila['fecha']);
                    $meses = [1 => 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    $numMes = (int)date('n', $timestamp);
                    $fechaFormateada = date('d', $timestamp) . ' de ' . ($meses[$numMes] ?? '') . ' del ' . date('Y', $timestamp);
                    $horaFormateada = date("g:i a", strtotime($fila['hora']));
                    $dateStr = $fechaFormateada . " a las " . $horaFormateada;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($fila['condicion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $dateStr; ?></td>
                        <td>
                            <?php if (!empty($fila['archivo'])) { ?>
                                <a href="<?php echo htmlspecialchars($baseUrl . $fila['archivo']); ?>">Ver Archivo</a>
                            <?php } else { echo '-'; } ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                } else {
                    ?>
                    <tr>
                        <td style="width:50px">#</td>
                        <td>Sin Reportes</td>
                        <td>-------------------</td>
                        <td>-------------------</td>
                        <td>-------------------</td>
                    </tr>
                    <?php
                }

                if (!empty($fila['archivo'])) {
                    if (esImagen('../../../' . $fila['archivo'])) {
                        $array = [];
                        $array['url'] = $baseUrl . $fila['archivo'];
                        $array['description'] = $fila['nombre_usuario'] . ' ' . $fila['apellidos'] . ' - ' . $fila['condicion'] . ($dateStr ? ' (' . $dateStr . ')' : '');
                        $images[] = $array;
                    }
                }
            }

            // Cerrar tabla y lista pendientes al finalizar el bucle
            if ($usuario_actual_id !== null) {
                echo '</tbody></table>';
            }
            if ($unidad_actual !== null) {
                echo '</ul>';
            }
            ?>


        <div style="page-break-after:always;"></div>
        <br>
        <h3 class="m-0 mb-1">Anexos Fotográficos</h3>
<?php

        echo '<div style="">';
        foreach($images as $image){
            echo '<div style="text-align: center; margin-bottom: 0.5cm;">';
            echo '  <div style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden; display: inline-block;">';
            echo '      <img src="' . $image['url'] . '" style="width: auto; max-width: 100%; max-height: 250px; object-fit: cover;" alt="Imagen">';
            echo '      <div style="padding: 5px; background: white;">';
            echo '          <p style="margin: 0; font-size: 12px; text-align: center;">' . $image['description'] . '</p>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }
        echo '</div>';
?>


    <div style="page-break-after:always;"></div>
    <br>
    <div>
    <h3>Asistencias del Personal</h3>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-1-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
    </div>
    <h5 style="color:#f56a69">Los reportes que se visualizan en la gráfica de asistencia no incluyen aquellos realizados los días Sábado y Domingo</h5>
    <br>
    <div style="page-break-after:always;"></div>
    <h3>Cantidad de Reportes</h3>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-2-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
    </div>
    </div>
    <footer>
        <p></p>
    </footer>
    </body>

    </html>

<?php
}

closeConection($conn);

require_once '../../../php/reportes/dompdf/vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

$html_code = ob_get_clean(); //AQUI VA EL STRING CON EL CODIGO
// instantiate and use the dompdf class
// $dompdf = new Dompdf();
$options = new Options();
$options->set('isRemoteEnabled', true); // Activa imágenes remotas
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html_code);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("Reportes-mensual-".$mes."-".$Y.".pdf", ["Attachment" => false]);

?>