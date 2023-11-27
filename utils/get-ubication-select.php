<?php
require_once '../database/conexion.php';

$cat = $_POST['cat'];
$id = $_POST['id'];

$query;
$id_item_name = "";
$item_name = "";

if ($cat == 'estado') {
    $sql = "SELECT * FROM ciudades WHERE id_estado LIKE '$id' ORDER BY ciudad ASC;";
    $query = mysqli_query($conn, $sql);
    $id_item_name = "id_ciudad";
    $item_name = "ciudad";
}
if ($cat == 'ciudad') {
    $sql = "SELECT * FROM municipios WHERE id_estado LIKE '$id' ORDER BY municipio ASC;";
    $query = mysqli_query($conn, $sql);
    $id_item_name = "id_municipio";
    $item_name = "municipio";
}
/*if($cat == 'municipios'){
        $sql = "SELECT * FROM parroquias WHERE id_municipio LIKE '$id' ORDER BY parroquia ASC;";
        $query = mysqli_query($db, $sql);
        $id_item_name = "id_parroquia";
        $item_name = "parroquia";
    }*/

if (mysqli_num_rows($query) > 0) {
    echo "<option value=''>Seleccione</option>";
    while ($row = mysqli_fetch_array($query)) {
        $id_item = $row[$id_item_name];
        $item = $row[$item_name];
?>
        <option value='<?php echo $id_item; ?>'><?php echo utf8_encode($item); ?></option>
<?php
    }
}
?>