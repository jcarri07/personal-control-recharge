<?php
    session_start();
    ob_start();
    require_once '../../../database/conexion.php';
    require_once 'image-service.php';
    $uni = $_GET['uni'];
    $tipo = $_GET['tipo'];
    $id_unidad = $_GET['unidad'];
    $fecha = $_GET['fecha'];
    $dia = $_GET['dia'];
    $d = new DateTime($fecha);
    $mes = $d->format('m');
    date_default_timezone_set("America/Caracas");
    setlocale(LC_TIME, "spanish");
    $au = DateTime::createFromFormat("Y-m-d", $fecha);
    $Y = date("Y");


    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrl = $protocol . $host . $scriptPath;
    $baseUrl = str_replace('php/reportes/modelos', '', $baseUrl);

    // Variables comunes para ambas consultas
    $selectFields = "u.id_usuario, i.cargo as tipo_usuario, u.nombres as nombre_usuario, u.apellidos, 
        a.condicion, a.descripcion, a.hora, a.fecha, 
        un.nombre as nombre_unidad, a.archivo as archivo";

    $joinConditions = "LEFT JOIN usuario u ON i.id_usuario = u.id_usuario 
        LEFT JOIN actividad a ON u.id_usuario = a.id_usuario
        LEFT JOIN unidad un ON i.id_unidad = un.id_unidad  
        AND MONTH(a.fecha) = '$mes' 
        AND DAY(a.fecha) = '$dia' 
        AND a.estatus = 'activo' 
        AND YEAR(a.fecha) = '$Y'";

    $orderBy = "ORDER BY i.nombre, u.tipo_usuario ASC, u.nombre DESC, a.hora ASC";

    if ($tipo == 'Director') {
        
        if ($uni == '0') {
            $query = "SELECT $selectFields
                     FROM datos_abae i 
                     $joinConditions
                     $orderBy";
        } else {
            
            $query = "SELECT $selectFields
                     FROM datos_abae i 
                     $joinConditions
                     WHERE i.id_unidad = '$uni' AND i.estatus = 'activo'
                     $orderBy";
        }
        
        $res = mysqli_query($conn, $query);
    }
    
    if ($tipo == 'jefe') {
        $query = "SELECT $selectFields
                 FROM datos_abae i
                 $joinConditions
                 WHERE u.tipo_usuario != 'Director' 
                 AND i.id_unidad = '$id_unidad'
                 ORDER BY u.tipo_usuario ASC, u.nombres DESC, a.hora ASC";
    
        $res = mysqli_query($conn, $query);
        
        // Consulta optimizada para obtener el nombre de la unidad
        $aux = mysqli_query($conn, "SELECT nombre FROM unidad WHERE id_unidad = '$id_unidad' LIMIT 1");
        $l = mysqli_fetch_assoc($aux);
    }
    
    $num_r = mysqli_num_rows($res);

// if ($tipo == 'Director') {

//     if ($uni == '0') {
//         $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha, i.nombre as nombre_unidad, a.archivo as archivo
//         FROM unidad i 
//         LEFT JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo' 
//         LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND DAY(a.fecha) = '$dia' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
//         ORDER BY i.nombre,u.tipo ASC, u.nombre DESC, a.hora ASC;");
//     } else {

//         $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha, i.nombre as nombre_unidad, a.archivo as archivo
//                               FROM unidad i 
//                               LEFT JOIN usuario u ON i.id_unidad = u.id_unidad AND u.estatus = 'A' AND NOT u.tipo = '$tipo'
//                               LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND DAY(a.fecha) = '$dia' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
//                               WHERE i.id_unidad = '$uni' AND i.estatus = 'A'
//                               ORDER BY u.tipo ASC,u.nombre DESC, a.hora ASC;");
//     }
// }

// if ($tipo == 'Jefe') {
//     $res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo, u.nombre as nombre_usuario, u.apellido, a.condicion, a.descripcion, a.hora, a.fecha, i.nombre as nombre_unidad, a.archivo as archivo
//                               FROM unidad i
//                               LEFT JOIN usuario u ON i.id_unidad = u.id_unidad 
//                               LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND MONTH(a.fecha) = '$mes' AND DAY(a.fecha) = '$dia' AND a.estatus = 'A' AND YEAR(a.fecha) = '$Y'
//                               WHERE u.estatus = 'A'  AND NOT u.tipo = 'Director' AND u.id_unidad = '$id_unidad'  AND i.estatus = 'A'
//                               ORDER BY u.tipo ASC,u.nombre DESC, a.hora ASC;");

//     $aux = mysqli_query($conn, "SELECT nombre FROM unidad WHERE id_unidad = '$id_unidad';");
//     $l = mysqli_fetch_assoc($aux);
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
?>


<?php
            $dias_semana_esp = [1 => 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            $meses_esp = [1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            if ($au) {
                $numDiaSemana = (int)$au->format('N');
                $numMes = (int)$au->format('n');
                $nombreDia = $dias_semana_esp[$numDiaSemana] ?? '';
                $nombreMes = $meses_esp[$numMes] ?? '';
                $a = $nombreDia . ', ' . $au->format('d') . ' de ' . $nombreMes . ' del ' . $au->format('Y');
            } else {
                $a = $fecha;
            }
            echo '<h2>Reporte de Asistencias del ' . htmlspecialchars($a) . '</h2>';
?>
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
                    echo '<thead style="width:100%; background: #184072; color:#f5f5f5;">';
                    echo '<tr>';
                    echo '<th>N°</th>';
                    echo '<th>Condicion</th>';
                    echo '<th>Descripción</th>';
                    echo '<th>Hora</th>';
                    echo '<th>Archivo</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody style="width:100%">';
                }

                // Renderizar fila de reporte / actividad
                if (!empty($fila['hora'])) {
                    $horaFormateada = date("g:i a", strtotime($fila['hora']));
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($fila['condicion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $horaFormateada; ?></td>
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
                        <td>#</td>
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
                        $horaTxt = !empty($fila['hora']) ? date("g:i a", strtotime($fila['hora'])) : '';
                        $array['description'] = $fila['nombre_usuario'] . ' ' . $fila['apellidos'] . ' - ' . $fila['condicion'] . ($horaTxt ? ' (' . $horaTxt . ')' : '');
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
        <h3>Asistencias del Personal</h3>
        <div style="display:flex; justify-content:center;">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-1-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
        </div>
        <br>
        <div style="page-break-after:always;"></div>
        <h3>Cantidad de Reportes</h3>
        <div style="display:flex; justify-content:center;">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-2-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
        </div>

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

    $dompdf->stream("Reporte-diario-" . $fecha . ".pdf", ["Attachment" => false]);

?>