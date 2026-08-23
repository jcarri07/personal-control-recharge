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
    $selectFields = "u.id_usuario, u.tipo_usuario, u.nombres as nombre_usuario, u.apellidos, 
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
        $whereConditions = "u.estatus = 'activo' AND u.tipo_usuario != 'Director'";
        
        if ($uni == '0') {
            $query = "SELECT $selectFields
                     FROM datos_abae i 
                     $joinConditions
                     WHERE $whereConditions
                     $orderBy";
        } else {
            $whereConditions .= " AND i.id_unidad = '$uni' AND i.estatus = 'activo'";
            $query = "SELECT $selectFields
                     FROM datos_abae i 
                     $joinConditions
                     WHERE $whereConditions
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
            $a = ucwords(strftime('%A,', $au->getTimestamp())) . ' ' . strftime('%d de', $au->getTimestamp()) . ' ' . ucwords(strftime('%B ', $au->getTimestamp())) . ' ' . strftime('del %Y', $au->getTimestamp());
            echo '<h2>Reporte de Asistencias del ' . utf8_encode($a) . '</h2>';
?>
        <br>

<?php
        include_once 'watermark-pdf.php';
?>

        <ul>
<?php

            $i = 1;
            $images = [];
            while ($fila = mysqli_fetch_assoc($res)) {

                if (!isset($unidad_actual) || $unidad_actual != $fila['nombre_unidad']) {
                    $x='';
                    if(isset($unidad_actual)){
                        $x='<div style="page-break-after:always;"></div>';
                    }
                    $unidad_actual = $fila['nombre_unidad'];

                    echo '</ul>'.$x.'<li><h3 class="m-0">' . $fila['nombre_unidad'] . '</h3></li><ul>';
                }
                // Si es un usuario diferente al anterior, se inicia una nueva tabla

                if ($fila['nombre_usuario'] == NULL) {
                    echo '<p style= "">Sin Usuarios</p><br>';
                    continue;
                }
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
                    if ($fila['tipo_usuario'] == "jefe" || $usuario_actual == "Director") {
                        $sel = "(E)";
                    }
                    else{
                        $sel = "";
                    }


?>
<?php 
                    echo ('<li><p class="mb-1"><b>' . $fila['tipo_usuario'] . $sel . '</b>: ' . $usuario_actual . ' ' . $fila['apellidos'] . '</p></li>');
                    if (isset($fila['hora']) || $fila['hora'] == true) {
                        echo '<table class="table table-body">
                            <thead style="width:100%; background: #184072; color:#f5f5f5;">
                                <tr>
                                    <th>N°</th>
                                    <th>Condicion</th>
                                    <th>Descripción</th>
                                    <th>Hora</th>
                                    <th>Archivo</th>
                                </tr>
                            </thead>';
                    } else {
                        echo '<p class="m-0 ml-1 f-italic">Sin Reportes</p>';
                        continue;
                    }
                }

                // Mostrar filas de reportes si existen
                if (isset($fila['hora']) && $fila['hora']) {
                    if($fila['archivo']){
                        if(esImagen('../../../' . $fila['archivo'])){
                            $array = [];
                            $array['url'] = $baseUrl . $fila['archivo'];
                            $array['description'] =  $usuario_actual . ' ' . $fila['apellido'] . ' - ' . $fila['condicion'] . ' (' . date("g:i a", strtotime($fila['hora'])) . ')';
                            $images[] = $array;
                        }
                    }
                    echo '<tbody style="width:100%">
                            <tr>
                                <td>' . $i . '</td>
                                <td>' . $fila['condicion'] . '</td>
                                <td>' . $fila['descripcion'] . '</td>
                                <td>' . date("g:i a", strtotime($fila['hora'])) . '</td>
                                <td>' . ($fila['archivo'] ? '<a href="' . $baseUrl . $fila['archivo'] . '">Ver Archivo</a>' : '-') . '</td>
                            </tr>
                        </tbody>';
                    $i++;
                }

                
            }
            if (isset($usuario_actual)) {
?>
                    </table>
                </ul>
                </ul>
        
<?php

            }

            //echo'</div>';
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
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Control_de_Personal/img/temp/imagen-1-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
        </div>
        <br>
        <div style="page-break-after:always;"></div>
        <h3>Cantidad de Reportes</h3>
        <div style="display:flex; justify-content:center;">
            <img src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/Control_de_Personal/img/temp/imagen-2-<?php echo $_SESSION['id_usuario']; ?>.png" style=" max-width:100%; height:auto;border:solid;border-color: #808080;">
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