<?php
    require_once '../database/conexion.php';
    $idUser = $_SESSION["id_usuario"];

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }

    $sql = "SELECT * FROM usuario WHERE id_usuario = '$idUser' LIMIT 1;";
    $query = mysqli_query($conn, $sql);
    $datos_personales = mysqli_fetch_array($query);



    $sql = "SELECT * FROM experiencia_instituciones_publicas WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    /*$sql = "SELECT * FROM paises;";
    $queryPais = mysqli_query($conn, $sql);*/

    closeConection($conn);

if($datos_personales['step'] > 5){
    

?>


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
                                    <h4>Actualización de Datos</h4>
                                    <span>Datos de Experiencia Laboral</span>
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
                                        <a class="activate">Actualización de Datos / Experiencia Laboral</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="wizard">
                                                <section>
                                                    <div class="text-center">
                                                        <button class="btn btn-primary" onclick="openModalAdd();">Añadir</button>
                                                    </div>
                                            <?php 
                                                if(mysqli_num_rows($query) > 0){
                                            ?>
                                                    <div class="dt-responsive table-responsive mt-5">
                                                        <table id="row-select" class="table table-striped table-bordered nowrap">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Organismo</th>
                                                                    <th>Periodo</th>
                                                                    <th>Cargo</th>
                                                                    <th>Posee Antecedentes</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php 
                                                    $i = 0;
                                                    while($row = mysqli_fetch_array($query)){
                                                        $id_experiencia_instituciones_publicas = $row['id_experiencia_instituciones_publicas'];
                                                        $organismo = $row['organismo'];
                                                        $fecha_ingreso = $row['fecha_ingreso'];
                                                        $fecha_egreso = $row['fecha_egreso'];
                                                        $cargo = $row['cargo'];
                                                        $antecedentes_servicios = $row['antecedentes_servicios'];

                                                        setlocale(LC_TIME, "spanish");
                                                        $fecha_nueva = strftime("%B de %Y", strtotime($fecha_ingreso)) . " - " . strftime("%B de %Y", strtotime($fecha_egreso));
                                            ?>            
                                                                <tr>
                                                                    <td><?php echo ++$i;?></td>
                                                                    <td><?php echo $organismo;?></td>
                                                                    <td><?php echo $fecha_nueva;?></td>
                                                                    <td><?php echo $cargo;?></td>
                                                                    <td><?php echo $antecedentes_servicios;?></td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-table" onclick="openModalEdit('<?php echo $id_experiencia_instituciones_publicas;?>', '<?php echo $organismo;?>', '<?php echo $fecha_ingreso;?>', '<?php echo $fecha_egreso;?>', '<?php echo $cargo;?>', '<?php echo $antecedentes_servicios;?>');">
                                                                            <i class="feather icon-edit"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                            <?php 
                                                }
                                            ?>                    
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            <?php 
                                                }
                                                else{
                                            ?>
                                                <h2 class="text-center mt-4">No hay ninguna experiencia laboral registrada</h2>

                                                
                                            <?php 
                                                }
                                            ?>
                                                    
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="modal-form" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="login-card card-block login-card-modal">
            <form class="md-float-material" id="form-edit"><!--form-->
                <div class="card m-t-15">
                    <div class="auth-box card-block">
                        <div class="row m-b-0">
                            
                            <div class="col-md-12 text-center" style="margin-bottom: 0px;">
                                <div class="box-title">
                                    <h3 class="modal-title text-center" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px;"></h3>
                                </div>
                                <div class="form-group row justify-content-center">

                                    <div class="col-md-12">
                                        <label class="block">Organismo</label>
                                        <input id="organismo" name="organismo" type="text" class="form-control" maxlength="100" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Fecha de Ingreso</label>
                                        <input id="fecha_ingreso" name="fecha_ingreso" type="date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Fecha de Egreso</label>
                                        <input id="fecha_egreso" name="fecha_egreso" type="date" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Cargo</label>
                                        <input name="cargo" id="cargo" type="text" class="form-control" maxlength="50" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Posee Antecedentes de Servicios</label>
                                        <select class="form-control" id="antecedentes_servicios" name="antecedentes_servicios" required>
                                            <option value="Seleccione">Seleccione</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>

                                    
                                </div>

                                <div class="row">
                                    <div class="col-md-12 loaderParent">
                                        <div class="loader">
                                        </div>
                                        Por favor, espere
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center aceptar" style="margin-bottom: 0px;">
                                        <button type="button" class="btn btn-secondary waves-effect" data-toggle="modal" data-target="#modal-form">Cerrar</button>
                                        <button type="submit" class="btn btn-primary waves-effect">Añadir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../utils/functions-personal-data.js"></script>



<div id="aux_id" style="display:none;"></div>
<div id="aux_opc" style="display:none;"></div>

<script>
    //$("#row-select").DataTable();
    iniciarTabla("row-select");

    function openModalAdd(){
        $("#aux_id").text("");
        $("#aux_opc").text("add");
        $("#form-edit")[0].reset();
        $("#modal-form .modal-title").text("Añadir Antecedentes en la Administracion Pública");
        $("#modal-form").modal("show");
    }

    function openModalEdit(id, organismo, fecha_ingreso, fecha_egreso, cargo, antecedentes_servicios){
        $("#aux_id").text(id);
        $("#aux_opc").text("edit");

        $("#organismo").val(organismo);
        $("#fecha_ingreso").val(fecha_ingreso);
        $("#fecha_egreso").val(fecha_egreso);
        $("#cargo").val(cargo);
        $("#antecedentes_servicios").val(antecedentes_servicios);

        $("#modal-form .modal-title").text("Editar Antecedentes en la Administracion Pública");
        $("#modal-form").modal("show");
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('id_experiencia', $("#aux_id").text());
        datos.append('opc', $("#aux_opc").text());

        datos.append('organismo', this.organismo.value);
        datos.append('fecha_ingreso', this.fecha_ingreso.value);
        datos.append('fecha_egreso', this.fecha_egreso.value);
        datos.append('cargo', this.cargo.value);
        datos.append('antecedentes_servicios', this.antecedentes_servicios.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/experiencia-laboral-publica-process.php',
            type:			'POST',
            data:			datos,
            cache:          false,
            contentType:    false,
            processData:    false,
            success: function(response){ //console.log(response);
                $('.loaderParent').hide();
                if(response == 'si'){
                    //alertify.success("Bello."); 
                    $("#modal-generic .message").text("Actualización Exitosa");
                    $("#modal-generic .aceptar button").attr("onclick", "window.location.reload();");
                    $("#modal-generic").modal("show");
                }
                else{
                    $("#modal-generic .aceptar button").attr("onclick", "");
                    if(response == "vacio"){
                        //alertify.warning("Datos vacíos o sin modificación.");
                        $("#modal-generic .message").text("Datos vacíos o sin modificación");
                        $("#modal-generic").modal("show");
                        
                    }
                    else{
                        //alertify.error("Error al registrar.");
                        $("#modal-generic .message").text("Error al registrar");
                        $("#modal-generic").modal("show");
                    } 
                }
            }
            ,
            error: function(response){
                $('.loaderParent').hide();
                //alertify.error("Error al registrar."); 
                $("#modal-generic .message").text("Error al registrar");
                $("#modal-generic").modal("show");
            }
        });
    });
</script>



<div id="modal-generic" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="login-card card-block login-card-modal">
            <div class="md-float-material"><!--form-->
                <div class="card m-t-15">
                    <div class="auth-box card-block">
                        <div class="row m-b-0">
                            <div class="col-md-12 text-center" style="margin-bottom: 0px;">
                                <h2 class="message"></h2>

                                <div class="row mt-3">
                                    <div class="col-md-12 text-center aceptar" style="margin-bottom: 0px;">
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" data-target="#modal-generic">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php

}
else{
?>
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
                                    <h4>Actualización de Datos</h4>
                                    <span>Datos de Experiencia Laboral</span>
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
                                        <a class="activate">Actualización de Datos / Experiencia Laboral</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <h2 class="text-center">Complete el registro de experiencia laboral en instituciones públicas en <b>"Mis Datos"</b></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>