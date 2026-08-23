<?php
session_start();
ob_start();
require_once '../../../database/conexion.php';
date_default_timezone_set("America/Caracas");
setlocale(LC_TIME, "spanish");
//$au = new DateTime();//aqui
$a = $_GET["anio"];


$res = mysqli_query($conn, "SELECT u.id_usuario, u.tipo_usuario, u.nombres as nombre_usuario, u.apellidos, a.condicion, a.descripcion, a.hora, a.fecha, un.nombre as nombre_unidad
FROM datos_abae i 
LEFT JOIN usuario u ON i.id_usuario = u.id_usuario  
LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND YEAR(a.fecha) = '$a' AND a.estatus = 'activo'
LEFT JOIN unidad un ON i.id_unidad = un.id_unidad 
WHERE i.estatus = 'activo'  
ORDER BY un.nombre,u.tipo_usuario ASC, u.nombres DESC, a.fecha DESC, a.hora ASC;");


$num_r = mysqli_num_rows($res);




if ($num_r >= 1) {
?>

    <html>

<?php
        include_once 'style-pdf.php';
?>
    <body>
<?php
        include_once 'style-pdf.php';
?>
        <?php echo '<h2>Reporte de Asistencias del año '.$a.'</h2>'; ?>
        <br>
        <div id="watermark">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/personal-control-recharge/img/user-profiles/Logo-Abae-sin-fondo2.png" height="45%" width="45%" />
        </div>

        <ul>
            <?php
            //echo'<div class="card card-body row">';

            $i = 1;
            while ($fila = mysqli_fetch_assoc($res)) {

                if (!isset($unidad_actual) || $unidad_actual != $fila['nombre_unidad']) {

                    $x='';
                    if(isset($unidad_actual)){ $x='<div style="page-break-after:always;"></div>'; }
                    $unidad_actual = $fila['nombre_unidad'];

                    echo '</ul>'.$x.'<li><h3>' . $fila['nombre_unidad'] . '</h3></li><ul>';
                }
                // Si es un usuario diferente al anterior, se inicia una nueva tabla
                if ($fila['nombre_usuario'] == NULL) {
                    echo '<p style= "">Sin Usuarios</p><br>';
                } else {
                    if (!isset($usuario_actual) || $usuario_actual != $fila['nombre_usuario']) {
                        if (isset($usuario_actual)) {
                            $i = 1;
            ?>
                            </table>
                            <br>
                        <?php
                        }
                        $usuario_actual = $fila['nombre_usuario'];
                        $sel;
                        if ($fila['tipo_usuario'] == "jefe" || $fila['tipo_usuario'] == "Director") {
                            $sel = "(E)";
                        }else{$sel = "";};
                        ?>
                        <?php echo ('<li><p style= ""><b>' . $fila['tipo_usuario'] . $sel . '</b>: ' . $usuario_actual . ' ' . $fila['apellidos'] . '</p></li>'); ?>
                        <table class="table table-body">
                            <thead style='width:100%;background: #184072;color:#f5f5f5;'>
                                <tr>
                                    <th>N°</th>
                                    <th>Condicion</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                        <?php
                    }
                        ?>
                        <tbody style='width:100%'>
                            <tr>
                                <?php if (isset($fila['hora']) || $fila['hora'] == true) { ?>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $fila['condicion']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php
                                        $al = strftime('%d de ', DateTime::createFromFormat("Y-m-d", $fila['fecha'])->getTimestamp()) . ' ' . ucwords(strftime('%b ', DateTime::createFromFormat("Y-m-d", $fila['fecha'])->getTimestamp())) . ' ' . strftime('del %Y', DateTime::createFromFormat("Y-m-d", $fila['fecha'])->getTimestamp());
                                        echo $al . " a las " . date("g:i a", strtotime($fila['hora'])); ?></td>
                                <?php $i++;
                                } else { ?>
                                    <td><?php echo '#'; ?></td>
                                    <td><?php echo 'Sin Reportes'; ?></td>
                                    <td ><?php echo '-------------------'; ?></td>
                                    <td ><?php echo '-------------------'; ?></td>
                                <?php
                                }
                                ?>
                            </tr>
                        </tbody>
                    <?php
                }
            };
            if (isset($usuario_actual)) {
                    ?>
                        </table>
        </ul>
        </ul>
    <?php

            };

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