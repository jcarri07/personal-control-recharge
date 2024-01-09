<?php
require_once('../database/conexion.php');
// session_start();

$id = $_SESSION['id_usuario'];

// consulto los dias feriados
$consulta = "SELECT days_actual, days_siguiente FROM feriados WHERE id = '1'";
$resultado = mysqli_query($conn, $consulta);
$fila = mysqli_fetch_assoc($resultado);

$año_actual = array();
$año_siguiente = array();

$año_actual = json_decode($fila['days_actual'], true, 512, JSON_UNESCAPED_UNICODE);
$año_siguiente = json_decode($fila['days_siguiente'], true, 512, JSON_UNESCAPED_UNICODE);

$años_combinados = array();

foreach ($año_actual as $days) {
    // $años_combinados[] = explode(" ", $days->date)[0];
    $años_combinados[] = $days;
}
foreach ($año_siguiente as $days) {
    // $años_combinados[] = explode(" ", $days->date)[0];
    $años_combinados[] = $days;
}
// print_r($años_combinados);
// foreach ($años_combinados as $days) {
//     print_r($days);
// }

$año_int = intval(date("Y"));

?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .feriados-container {
        margin: 50px;
    }

    .contenedor {
        display: grid;
        grid-template-columns:
            repeat(auto-fit,
                minmax(375px, 1fr));
        gap: 32px;
    }

    .feriados-guardar {
        display: flex;
        justify-content: center;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="page-wrapper">

<div class="container-fluid">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8" style="margin-bottom: 0px;">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Configuración de Feriados</h4>
                                    <!--<span>Otros Datos</span>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="../home/dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <!--<a href="#!" class="activate">Actualización de Datos / Otros Datos</a>-->
                                        <a class="activate">Configuraciones / Feriados</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- Page-body start -->
    <div class="page-body">
        <div class="card">

            <div class="feriados-container">
                <h3 class="mx-auto">Días Feriados</h3>
                <br>

                <div class="contenedor">
                    <div class="">
                        <h4>Año <?php echo $año_int; ?></h3>
                            <table>
                                <tr>
                                    <th>Día Feriado</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                                <?php

                                // Mostrar los resultados en una tabla
                                if ($resultado->num_rows > 0) {
                                    foreach ($año_actual as $row) {
                                        echo "<tr class='tr-actual-date'>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . explode(" ", $row["date"])[0] . "</td>";
                                        echo "<td><input type='checkbox' ";
                                        if ($row["status"] == "activo") {
                                            echo "checked";
                                        }
                                        echo "></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No hay días feriados registrados</td></tr>";
                                }

                                ?>
                            </table>
                    </div>

                    <div class="">
                        <h4>Año <?php echo ($año_int+1); ?></h3>
                            <table>
                                <tr>
                                    <th>Día Feriado</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                                <?php

                                // Mostrar los resultados en una tabla
                                if ($resultado->num_rows > 0) {
                                    foreach ($año_siguiente as $row) {
                                        echo "<tr class='tr-next-date'>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . explode(" ", $row["date"])[0] . "</td>";
                                        echo "<td><input type='checkbox' ";
                                        if ($row["status"] == "activo") {
                                            echo "checked";
                                        }
                                        echo "></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No hay días feriados registrados</td></tr>";
                                }

                                ?>
                            </table>
                    </div>
                </div>
                <br><br>
                <div class="feriados-guardar">
                    <button class="btn btn-primary" id="feriados-guardar">Guardar</button>
                    <button class="btn btn-primary ml-5" id="feriados-actualizar">Actualizar Feriados</button>
                </div>

            </div>

        </div>
    </div>
    <!-- Page-body end -->
</div>
</div>



<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    console.log("aaaaaa");

    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');
</script>