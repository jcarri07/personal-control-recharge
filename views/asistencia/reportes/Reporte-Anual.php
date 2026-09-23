<?php
session_start();
ob_start();
require_once '../../../database/conexion.php';
date_default_timezone_set("America/Caracas");
setlocale(LC_TIME, "spanish");

$a = isset($_GET["anio"]) ? intval($_GET["anio"]) : date('Y');

$res = mysqli_query($conn, "SELECT u.id_usuario, i.cargo as tipo_usuario, u.nombres as nombre_usuario, u.apellidos, a.condicion, a.descripcion, a.hora, a.fecha, un.nombre as nombre_unidad
FROM datos_abae i 
RIGHT JOIN usuario u ON i.id_usuario = u.id_usuario  
LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$a' AND a.estatus = 'activo'
LEFT JOIN unidad un ON i.id_unidad = un.id_unidad 
WHERE i.estatus = 'activo'  
ORDER BY un.nombre, u.tipo_usuario ASC, u.nombres DESC, a.fecha DESC, a.hora ASC;");

$num_r = mysqli_num_rows($res);

if ($num_r >= 1) {
?>

    <html>

<?php
        include_once 'style-pdf.php';
?>
    <body>
        <?php echo '<h2>Reporte de Asistencias del año '.$a.'</h2>'; ?>
        <br>
        <div id="watermark">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/user-profiles/Logo-Abae-sin-fondo2.png" height="45%" width="45%" />
        </div>

            <?php
            $unidad_actual = null;
            $usuario_actual_id = null;
            $i = 1;

            while ($fila = mysqli_fetch_assoc($res)) {

                // Si cambia la unidad
                if ($unidad_actual !== $fila['nombre_unidad']) {
                    // Cerrar tabla de usuario previo si estaba abierta
                    if ($usuario_actual_id !== null) {
                        echo '</tbody></table><br>';
                        $usuario_actual_id = null;
                    }
                    // Cerrar lista de unidad previa y agregar salto de página si no es la primera
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

                    echo '<li><p><b>' . htmlspecialchars($fila['tipo_usuario']) . $sel . '</b>: ' . htmlspecialchars($nombre_completo) . '</p></li>';
                    echo '<table class="table table-body">';
                    echo '<thead style="width:100%;background: #184072;color:#f5f5f5;">';
                    echo '<tr>';
                    echo '<th>N°</th>';
                    echo '<th>Condicion</th>';
                    echo '<th>Descripción</th>';
                    echo '<th>Fecha</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody style="width:100%">';
                }

                // Renderizar fila de reporte / actividad
                if (!empty($fila['hora']) && !empty($fila['fecha'])) {
                    $timestamp = strtotime($fila['fecha']);
                    $meses = [1 => 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                    $numMes = (int)date('n', $timestamp);
                    $fechaFormateada = date('d', $timestamp) . ' de ' . ($meses[$numMes] ?? '') . ' del ' . date('Y', $timestamp);
                    $horaFormateada = date("g:i a", strtotime($fila['hora']));
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($fila['condicion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['descripcion']); ?></td>
                        <td><?php echo $fechaFormateada . " a las " . $horaFormateada; ?></td>
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
                    </tr>
                    <?php
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

            //echo'</div>';
    ?>
    <div style="page-break-after:always;"></div>
    <br>
    <h3>Asistencias del Personal</h3>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-1-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
    </div>
    <br>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-2-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
    </div>
    <br>
    <div style="page-break-after:always;"></div>
    <h3>Cantidad de Reportes</h3>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-3-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
    </div>
    <br>
    <div style="display:flex; justify-content:center;">
        <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/temp/imagen-4-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
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

$dompdf->stream("Reporte-anual-".$a.".pdf", ["Attachment" => false]);

?>