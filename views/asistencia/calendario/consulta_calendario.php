
<?php

    require_once '../../../database/conexion.php';
    date_default_timezone_set("America/Caracas");
    setlocale(LC_TIME,"spanish");

    $unidad = $_POST['unidad'];
    $fecha = $_POST['fecha'];
    $cargo = $_POST['cargo'];
    $currentUser = $_POST['current_user'];
    $id_unidad =$_POST['id_unidad'];
    $idDireccion = $_POST['id_direccion'];


    $year = date("Y");
    $addWhere = "";
    $addWhereInUser = "";

    $unidades = [];

    if($cargo == 'Director'){

        if($unidad == '0'){
            $addWhere .= " i.id_direccion = '$idDireccion' ";
            $addWhereInUser .= " id_direccion = '$idDireccion' ";

            $sql = "SELECT * FROM unidad WHERE id_direccion = '$idDireccion';";
            $query = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_array($query)) {
                $unidades[] = [
                    'id' => $row['id_unidad'],
                    'nombre' => $row['nombre'],
                ];
            }
        }else{
            $addWhere .= " i.id_unidad = '$unidad' ";
            $addWhereInUser .= " id_unidad = '$unidad' ";
        }
    }
    if($cargo == 'Jefe') {
        $addWhere .= " i.id_unidad = '$id_unidad' ";
        $addWhereInUser .= " id_unidad = '$id_unidad' ";
    }

    $sql = "SELECT u.id_usuario, 
                    da.cargo, 
                    u.nombres as nombre_usuario, 
                    u.apellidos, 
                    a.condicion, 
                    a.descripcion, 
                    a.hora, 
                    a.fecha, 
                    /*i.nombre as nombre_unidad,*/
                    da.id_unidad
                FROM unidad i 
                JOIN usuario u ON u.estatus = 'activo' AND u.id_usuario IN (SELECT id_usuario FROM datos_abae WHERE $addWhereInUser)
                LEFT JOIN datos_abae da ON da.id_direccion = i.id_direccion AND da.id_usuario = u.id_usuario
                LEFT JOIN actividad a ON u.id_usuario = a.id_usuario AND a.fecha = '$fecha' AND a.estatus = 'A' AND YEAR(a.fecha) = '$year'
                WHERE $addWhere
                GROUP BY u.nombres
                ORDER BY i.nombre, da.cargo ASC, u.nombres DESC, a.fecha DESC, a.hora ASC;";
    $res = mysqli_query($conn, $sql);

    $num_r= mysqli_num_rows($res);
    closeConection($conn);

    if($num_r >=1){ 
?>
    <div class="table-responsive">
        <table class="table table-bordered col-md-12" id="">
            <thead>
                <tr role="row" class="odd">
<?php       
                    if($unidad == '0'){
?>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Cargo</th>
                        <th>Condicion</th>
                        <th>Hora</th>
                        <th>detalles</th>
<?php  
                    }
                    else{ 
?>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Condicion</th>
                        <th>Hora</th>
                        <th>detalles</th>
<?php  
                    }
?>
                </tr>
            </thead>
            <tbody>
<?php
                $i =1;
                while($valor = mysqli_fetch_array($res)) {

                    $unidadUser = null;
                    foreach ($unidades as $fila) {
                        if ($fila['id'] == $valor['id_unidad']) {
                            $unidadUser = $fila;
                            break; // Detiene la búsqueda al encontrar
                        }
                    }

                    if($unidad == '0'){
                        if($valor["condicion"] == "" || $valor["hora"] == "") {
                            $aux1 = "Sin Actividad Registrada"; 
                            $aux2 = "-";
?>
                            <tr role="row" class="odd">
                                <td ><?php echo $i;?></td>              
                                <td ><?php echo $valor["nombre_usuario"] . " " . $valor["apellidos"];?></td>
                                <td><?php echo $valor["cargo"] ?? '';?></td>
                                <td><?php echo $aux1;?></td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
<?php        
                        }
                        else {
                            $aux1 = $valor["condicion"];
                            $aux2 = date("g:i a",strtotime($valor["hora"])); 
?>
                            <tr role="row" class="odd">
                                <td><?php echo $i;?></td>              
                                <td ><?php echo $valor["nombre_usuario"] . " " . $valor["apellidos"];?></td>
                                <td><?php echo $valor["cargo"] ?? '';?></td>
                                <td><?php echo $aux1;?></td>
                                <td><?php echo $aux2;?></td>
                                <td>
                                    <a type='button' onclick="getAvtivitiesByUser('<?php echo $fecha?>','<?php echo $valor['nombre_usuario']?>','<?php echo $valor['apellidos'];?>','<?php echo $valor['id_usuario'];?>')"> 
                                        <i class='feather icon-file-text f-16 text-info'></i>
                                    </a>
                                </td>
                            </tr>
            
<?php
                        }
                    }
                    else {
                        if($valor["condicion"] == "" || $valor["hora"] == "") {
                            $aux1 = "Sin Actividad Registrada"; $aux2 = "-"; $aux3 = "disabled";
?>

                            <tr role="row" class="odd">
                                <td ><?php echo $i;?></td>              
                                <td ><?php echo $valor["nombre_usuario"] . " " . $valor["apellidos"];?></td>
                                <td><?php echo $aux1;?></td>
                                <td><?php echo $aux2;?></td>
                                <td>-</td>
                            </tr>
<?php        
                        }
                        else{
                            $aux1 = $valor["condicion"];
                            $aux2 = date("g:i a",strtotime($valor["hora"])); 
                            $aux3 = "";
?>
                            <tr role="row" class="odd">
                                <td><?php echo $i;?></td>              
                                <td ><?php echo $valor["nombre_usuario"] . " " . $valor["apellidos"];?></td>
                                <td><?php echo $aux1;?></td>
                                <td><?php echo $aux2;?></td>
                                <td>
                                    <a type='button' onclick="getAvtivitiesByUser('<?php echo $fecha?>','<?php echo $valor['nombre_usuario']?>','<?php echo $valor['apellidos'];?>','<?php echo $valor['id_usuario'];?>')" <?php echo$aux3;?>> 
                                        <i class='feather icon-file-text f-16 text-info'></i>
                                    </a>
                                </td>
                            </tr>

<?php
                        }
                    }

                $i++;  
                }
    }//verifico que no esta recibiendo resultados y ademas que si esta recibiendo el valor e la unidad

?>
            </tbody>
        </table>
    </div>