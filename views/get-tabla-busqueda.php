<?php
require_once '../database/conexion.php';

// [CRIT-04 FIX] Todos los valores de $_POST se escapan con mysqli_real_escape_string
// antes de ser usados en la construcción dinámica del SQL

// [MED-02 FIX] No exponer detalles del error al usuario
if (mysqli_connect_errno()) {
    error_log("Error de conexión BD: " . mysqli_connect_error());
    echo "Error de conexión. Contacte al administrador.";
    exit();
}

$direccion    = mysqli_real_escape_string($conn, trim($_POST['direccion']           ?? ''));
$unidad       = mysqli_real_escape_string($conn, trim($_POST['unidad']              ?? ''));
$sexo         = mysqli_real_escape_string($conn, trim($_POST['sexo']                ?? ''));
$filtro       = mysqli_real_escape_string($conn, trim($_POST['filtro']              ?? ''));
$subfiltro    = mysqli_real_escape_string($conn, trim($_POST['subfiltro']           ?? ''));
$valor_filtro = mysqli_real_escape_string($conn, trim($_POST['filtro_valor_select'] ?? ''));
$desde        = mysqli_real_escape_string($conn, trim($_POST['desde']               ?? ''));
$hasta        = mysqli_real_escape_string($conn, trim($_POST['hasta']               ?? ''));

$add_select = "";
$add_tables = "";
$add_where = "";

if ($direccion != "") {
    $add_tables .= ", datos_abae da, unidad un, direccion d ";
    $add_where .= " AND u.id_usuario = da.id_usuario AND da.id_unidad = un.id_unidad AND un.id_direccion = d.id_direccion  ";
    if ($unidad == "") {
        $add_where .= " AND d.id_direccion = '$direccion' ";
    }
    if ($unidad != "") {
        $add_where .= " AND un.id_unidad = '$unidad' ";
    }
}


if ($filtro == "empleados") {

    if ($direccion == "" && $unidad == "") {
        //$add_select .= ", (SELECT IF(da.id_unidad <> '0', CONCAT(un.nombre, ' - ', d.nombre), '') FROM datos_abae da, unidad un, direccion d  WHERE da.id_usuario = u.id_usuario AND da.id_unidad = un.id_unidad AND un.id_direccion = d.id_direccion) AS 'unidad'";
    }

    if ($sexo != "" || $subfiltro != "") {
        $add_tables .= ", datos_personales dp";
        $add_where .= " AND u.id_usuario = dp.id_usuario ";
        $title = "";
        $name = "";

        if ($sexo != "") {
            $title = "Sexo";
            $name = "sexo";
            $add_select .= ", sexo";
            $add_where .= " AND sexo = '$sexo' ";
        }

        if ($subfiltro == "camisa") {
            $title = "Talla de Camisa";
            $name = "talla_camisa";
            $add_select .= ", talla_camisa";
            $add_where .= $valor_filtro != "" ? " AND talla_camisa = '$valor_filtro'" : '';
        }
        if ($subfiltro == "pantalon") {
            $title = "Talla de Pantalón";
            $name = "talla_pantalon";
            $add_select .= ", talla_pantalon";
            if ($desde != "")
                $add_where .= " AND talla_pantalon >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND talla_pantalon <= '$hasta'";
        }
        if ($subfiltro == "calzado") {
            $title = "Talla de Calzado";
            $name = "talla_calzado";
            $add_select .= ", talla_calzado";
            if ($desde != "")
                $add_where .= " AND talla_calzado >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND talla_calzado <= '$hasta'";
        }
        if ($subfiltro == "estatura") {
            $title = "Estatura (m)";
            $name = "estatura";
            $add_select .= ", estatura";
            if ($desde != "")
                $add_where .= " AND estatura >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND estatura <= '$hasta'";
        }
        if ($subfiltro == "peso") {
            $title = "Peso (Kg)";
            $name = "peso";
            $add_select .= ", peso";
            if ($desde != "")
                $add_where .= " AND peso >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND peso <= '$hasta'";
        }

        if ($subfiltro == "edad") {
            $title = "Edad";
            $name = "edad";
            $add_select .= ", ( YEAR(CURDATE())-YEAR(dp.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dp.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) AS 'edad'";
            if ($desde != "")
                $add_where .= " AND ( YEAR(CURDATE())-YEAR(dp.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dp.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND ( YEAR(CURDATE())-YEAR(dp.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dp.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) <= '$hasta'";
        }
    }
}


if ($filtro == "hijos") {
    $add_select .= ", dh.nombre AS 'nombre_hijo', dh.fecha_nacimiento AS 'fecha_nacimiento' ";
    $add_tables .= ", datos_hijos dh";
    $add_where .= " AND u.id_usuario = dh.id_usuario ";
    $title = "";
    $name = "";

    if ($sexo != "" || $subfiltro != "") {

        if ($sexo != "") {
            $title = "Sexo";
            $name = "sexo";
            $add_select .= ", dh.sexo AS 'sexo' ";
            $add_where .= " AND dh.sexo = '$sexo' ";
        }

        if ($subfiltro == "camisa") {
            $title = "Talla de Camisa";
            $name = "talla_camisa";
            $add_select .= ", talla_camisa";
            $add_where .= $valor_filtro != "" ? " AND talla_camisa = '$valor_filtro'" : '';
        }
        if ($subfiltro == "pantalon") {
            $title = "Talla de Pantalón";
            $name = "talla_pantalon";
            $add_select .= ", talla_pantalon";
            $add_where .= $valor_filtro != "" ? " AND talla_pantalon = '$valor_filtro'" : '';
            /*if($desde != "")
                    $add_where .= " AND talla_pantalon >= '$desde'";
                if($hasta != "")
                    $add_where .= " AND talla_pantalon <= '$hasta'";*/
        }
        if ($subfiltro == "calzado") {
            $title = "Talla de Calzado";
            $name = "talla_calzado";
            $add_select .= ", talla_calzado";
            if ($desde != "")
                $add_where .= " AND talla_calzado >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND talla_calzado <= '$hasta'";
        }
        if ($subfiltro == "edad") {
            $title = "Edad";
            $name = "edad";
            $add_select .= ", ( YEAR(CURDATE())-YEAR(dh.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dh.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) AS 'edad'";
            if ($desde != "")
                $add_where .= " AND ( YEAR(CURDATE())-YEAR(dh.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dh.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) >= '$desde'";
            if ($hasta != "")
                $add_where .= " AND ( YEAR(CURDATE())-YEAR(dh.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') >= DATE_FORMAT(dh.fecha_nacimiento,'%m-%d'), 0 , -1 ) ) <= '$hasta'";
        }
    }
}

$sql = "SELECT u.id_usuario, nombres, apellidos, u.cedula AS 'cedula', u.cargo AS 'cargo', tipo_usuario, correo, (SELECT IF(da.id_unidad <> '0', CONCAT(un.nombre, ' - ', d.nombre), '') FROM datos_abae da, unidad un, direccion d  WHERE da.id_usuario = u.id_usuario AND da.id_unidad = un.id_unidad AND un.id_direccion = d.id_direccion LIMIT 1) AS 'unidad' $add_select
            FROM usuario u $add_tables
            WHERE u.estatus = 'activo' $add_where
            GROUP BY u.id_usuario;";

$query = mysqli_query($conn, $sql);

closeConection($conn);

if (mysqli_num_rows($query) > 0) {
?>


    <script src="../files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="..\files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js"></script>
    <script src="..\files\assets\pages\data-table\js\jszip.min.js"></script>
    <script src="..\files\assets\pages\data-table\js\pdfmake.min.js"></script>
    <script src="..\files\assets\pages\data-table\js\vfs_fonts.js"></script>
    <script src="..\files\bower_components\datatables.net-buttons\js\buttons.print.min.js"></script>
    <script src="..\files\bower_components\datatables.net-buttons\js\buttons.html5.min.js"></script>
    <script src="..\files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
    <script src="..\files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
    <script src="..\files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>

    <style>
        tr th,
        tr td {
            word-break: break-word !important;
            white-space: normal !important;
        }

        tr th:first-letter,
        tr td:first-letter {
            text-transform: uppercase;
        }
    </style>


    <div class="dt-responsive table-responsive mt-5">
        <table id="row-select" class="table table-striped table-bordered nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo $filtro == "empleados" ? "Nombre" : "";
                        echo $filtro == "hijos" ? "Empleado" : ""; ?></th>
                    <th>Unidad / Dirección</th>
                    <th>Cargo</th>
                    <?php
                    if ($filtro == "hijos") {
                    ?>
                        <th>Hijo/a</th>
                    <?php
                    }
                    if ($sexo != "") {
                    ?>
                        <th>Sexo <?php echo $filtro == "hijos" ? "del Hijo/a" : ""; ?></th>
                    <?php
                    }
                    if ($subfiltro != "") {
                    ?>
                        <th><?php echo $title;
                            echo $filtro == "hijos" ? " del Hijo/a" : "" ?></th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($query)) {

                ?>
                    <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo htmlspecialchars($row['nombres'] . " " . $row['apellidos'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['unidad'] != "" ? $row['unidad'] : "-", ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($row['cargo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php
                        if ($filtro == "hijos") {
                        ?>
                            <td><?php echo htmlspecialchars($row['nombre_hijo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php
                        }
                        if ($sexo != "") {
                        ?>
                            <td><?php echo htmlspecialchars($row['sexo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php
                        }
                        if ($subfiltro != "") {
                        ?>
                            <td><?php echo htmlspecialchars($row[$name] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo "<h2 class='text-center mt-5'>No hay información registrada</h2>";
}
?>