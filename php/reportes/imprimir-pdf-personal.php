


<?php
    require 'dompdf/vendor/autoload.php';

    use Dompdf\Dompdf;
    use Dompdf\Options;

    $options = new Options();
    $options->set('defaultFont', 'Arial');
    $options->set('isHtml5ParserEnabled', true); // Habilita el analizador HTML5
    $options->set('isPhpEnabled', true);
    //echo $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . "\n";

    $ruta = explode("php", $_SERVER['SCRIPT_NAME']);
    $url = $_SERVER['HTTP_HOST'] . $ruta[0] . "views/get-tabla-busqueda.php";

    $curl  = curl_init($url);


    $ruta_proyecto = $_SERVER['HTTP_HOST'] . explode("imprimir-pdf-personal.php", $_SERVER['SCRIPT_NAME'])[0];

    $data = array(
        'direccion' => $_GET['direccion'],
        'unidad' => $_GET['unidad'],
        'sexo' => $_GET['sexo'],
        'filtro' => $_GET['filtro'],
        'subfiltro' => $_GET['subfiltro'],
        'filtro_valor_select' => $_GET['filtro_valor_select'],
        'desde' => $_GET['desde'],
        'hasta' => $_GET['hasta']
    );

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    
    if ($response !== false) {
        // El contenido de la respuesta se encuentra en $response
        //echo $response;

        //Armando cabecera
        $ruta_img = 'mincyt.jpg';
        $contenido_imagen = file_get_contents($ruta_img);
        $mincyt_base64 = base64_encode($contenido_imagen);

        $ruta_img = 'abae.jpg';
        $contenido_imagen = file_get_contents($ruta_img);
        $abae_base64 = base64_encode($contenido_imagen);

        $gender = "o";
        if($_GET['sexo'] != ""){
            if($_GET['sexo'] == "Femenino")
                $gender = "a";
        }

        $title_aux = "";
        $detalles_reporte = "Listado General";

        if($_GET['subfiltro'] != ""){
            if($_GET['subfiltro'] == "camisa")
                $title_aux = "Talla de Camisa";

            if($_GET['subfiltro'] == "pantalon")
                $title_aux = "Talla de Pantalón";

            if($_GET['subfiltro'] == "calzado")
                $title_aux = "Talla de Calzado";

            if($_GET['subfiltro'] == "edad")
                $title_aux = "Edad";

            if($_GET['subfiltro'] == "estatura")
                $title_aux = "Estatura";

            if($_GET['subfiltro'] == "peso")
                $title_aux = "Peso";


            if($_GET['filtro_valor_select'] != "" || $_GET['desde'] != "" || $_GET['hasta'] != ""){
                $detalles_reporte = $title_aux;
                if($_GET['filtro_valor_select'] != "")
                    $detalles_reporte .= " ($_GET[filtro_valor_select])";
                else{
                    if($_GET['desde'] != "" || $_GET['hasta'] != ""){
                        if($_GET['desde'] != "" && $_GET['hasta'] == "")
                            $detalles_reporte .= " (a partir de $_GET[desde])";
                        elseif($_GET['desde'] == "" && $_GET['hasta'] != "")
                                $detalles_reporte .= " (hasta $_GET[hasta])";

                        elseif($_GET['desde'] != "" && $_GET['hasta'] != "")
                            $detalles_reporte .= " (a partir de $_GET[desde] hasta $_GET[hasta])";
                    }
                }
            }
        }

        $title = "Reporte";
        $title .= ($_GET['filtro'] == "hijos" ? (" de Hij" . $gender . "s de Empleados") : (" de Emplead" . $gender . "s") );
        $title .= ($title_aux != "" ? (" por " . $title_aux ) : "");
        


        //Consultando datos para los titulos
        /*require_once '../../database/conexion.php';

        // Verificar la conexión
        if (mysqli_connect_errno()) {
            echo "Error al conectar a la base de datos: " . mysqli_connect_error();
            exit();
        }

        $direccion = "";
        $unidad = "";

        if($_GET['direccion'] != ""){
            $add_select = "";
            $add_tables = "";
            $add_where = "";

            if($_GET['unidad'] != ""){
                $add_select = ", u.nombre AS 'unidad'";
                $add_tables = ", unidad u";
                $add_where = " AND u.nombre <> 'N/A' AND d.id_direccion = u.id_direccion AND u.id_unidad = '$_GET[unidad]'";
            }

            $sql = "SELECT d.nombre AS 'direccion' $add_select
                    FROM direccion d $add_tables
                    WHERE d.nombre <> 'N/A' AND d.id_direccion = '$_GET[direccion]' $add_where ;";
            $query = mysqli_query($conn, $sql);

            $row = mysqli_fetch_array($query);
            $direccion = $row['direccion'];
            if($_GET['unidad'] != "")
                $unidad = $row['unidad'];
        }
        

        closeConection($conn);*/

        

        $html = '
                <style>
                    @page {
                        margin-top: 120px;
                        font-family: Arial, sans-serif;
                    }
                    .header {
                        position: fixed;
                        top: -90px;
                        left: 0;
                        right: 0;
                        /*text-align: center;*/
                        font-size: 12px;
                        
                    }

                    table {
                        border-collapse: collapse;
                        font-family: Arial, sans-serif;
                    }

                    table.table {
                        width: 100%;
                    }
        
                    th, td {
                        border: 1px solid #dddddd;
                        text-align: left;
                        padding: 8px;
                        text-transform: none !important;
                        text-align: center;
                        font-size: 12px;
                    }
        
                    th {
                        background-color: #01A9AC;
                        color: white;
                    }
        
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }

                    .text-center{
                        text-align: center;
                    }
                </style>
            

                <div class="header">
                    <img src="data:image/jpeg;base64,' . $mincyt_base64 . '" height="auto" width="50%" alt="" />
                    <img src="data:image/jpeg;base64,' . $abae_base64 . '" height="auto" width="20%" alt="" style="float:right;" />
                </div>

                <div class="titulo">
                    <h2 class="text-center">' . $title . '</h2>
                </div>

                <table style="min-width: 40%; margin-bottom: 40px;">
                    <thead>
                        <tr>
                            <th>Detalles del Reporte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>' . $detalles_reporte . '</td>
                        </tr>
                    </tbody>
                </table>
            '.
                $response
            .'
            '; 

        // instantiate and use the dompdf class
        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        
        $name_file = $title . ".pdf";
        // Output the generated PDF to Browser
        $dompdf->stream($name_file, array('Attachment' => false));

    } else {
        // Ocurrió un error al realizar la solicitud
        echo "Error al hacer la petición: " . curl_error($curl);
    }
    
    curl_close($curl);

?>