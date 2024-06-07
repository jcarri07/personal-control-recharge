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



    $sql = "SELECT * FROM formacion_exterior WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM paises;";
    $queryPais = mysqli_query($conn, $sql);

    closeConection($conn);

if($datos_personales['step'] > 4){
    

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
                                    <span>Datos de Formación Exterior</span>
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
                                        <a class="activate">Actualización de Datos / Formación Exterior</a>
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
                                                                    <th>Título Obtenido</th>
                                                                    <th>Año de Grado</th>
                                                                    <th>Institución Universitaria</th>
                                                                    <th>País</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php 
                                                    $i = 0;
                                                    while($row = mysqli_fetch_array($query)){
                                                        $id_formacion_exterior = $row['id_formacion_exterior'];
                                                        $titulo_obtenido = $row['titulo_obtenido'];
                                                        $anio_egreso = $row['anio_egreso'];
                                                        $instituto_universitario = $row['instituto_universitario'];
                                                        $pais = $row['pais'];

                                                        //setlocale(LC_TIME, "spanish");
                                                        //$fecha_nueva = strftime("%d de %B de %Y", strtotime($fecha_nacimiento));
                                            ?>            
                                                                <tr>
                                                                    <td><?php echo ++$i;?></td>
                                                                    <td><?php echo $titulo_obtenido;?></td>
                                                                    <td><?php echo $anio_egreso;?></td>
                                                                    <td><?php echo $instituto_universitario;?></td>
                                                                    <td><?php echo $pais;?></td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-table" onclick="openModalEdit('<?php echo $id_formacion_exterior;?>', '<?php echo $titulo_obtenido;?>', '<?php echo $anio_egreso;?>', '<?php echo $instituto_universitario;?>', '<?php echo $pais;?>');">
                                                                            <i class="feather icon-edit"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-table" onclick="deseaEliminar('<?php echo $id_formacion_exterior;?>');">
                                                                            <i class="feather icon-trash"></i>
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
                                                <h2 class="text-center mt-4">No hay ninguna formación en el exterior registrada</h2>

                                                
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

                                    <div class="col-md-6">
                                        <label class="block">Título Obtenido</label>
                                        <input id="titulo" name="titulo" type="text" class="form-control" maxlength="100" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Año de Grado</label>
                                        <input id="anio" name="anio" type="number" class="form-control" maxlength="10" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Institución Universitaria</label>
                                        <input name="instituto" id="instituto" type="text" class="form-control" maxlength="100" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">País</label>
                                        <select class="form-control" id="pais" name="pais" required>
                                            <option value="">Seleccione</option>
                                <?php
                                    while ($row = mysqli_fetch_array($queryPais)) {
                                ?>
                                            <option value="<?php echo $row['pais'];?>"><?php echo $row['pais'];?></option>
                                <?php
                                    }
                                ?>
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
<div id="aux_estatus" style="display:none;"></div>

<script>
    //$("#row-select").DataTable();
    iniciarTabla("row-select");

    function openModalAdd(){
        $("#aux_id").text("");
        $("#aux_opc").text("add");
        $("#form-edit")[0].reset();
        $("#modal-form .modal-title").text("Añadir Formación Exterior");
        $("#modal-form").modal("show");
    }

    function openModalEdit(id, titulo, anio, instituto, pais){
        $("#aux_id").text(id);
        $("#aux_opc").text("edit");

        $("#titulo").val(titulo);
        $("#anio").val(anio);
        $("#instituto").val(instituto);
        $("#pais").val(pais);

        $("#modal-form .modal-title").text("Editar Formación Exterior");
        $("#modal-form").modal("show");
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('id_formacion_exterior', $("#aux_id").text());
        datos.append('opc', $("#aux_opc").text());

        datos.append('titulo', this.titulo.value);
        datos.append('anio', this.anio.value);
        datos.append('instituto', this.instituto.value);
        datos.append('pais', this.pais.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/formacion-exterior-process.php',
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

    function deseaEliminar(id) {
        $("#modal-actions .message").text("¿Desea eliminar?");
        $('#aux_id').text(id);
        $('#aux_estatus').text("inactivo");
        $("#modal-actions").modal("show");
    }

    function modify_estatus() {
        $("#modal-actions").modal("hide");
        var datos = new FormData();
        datos.append('id', $("#aux_id").text());
        datos.append('opc', "estatus");
        datos.append('estatus', $("#aux_estatus").text());

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/formacion-exterior-process.php',
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
                    $("#modal-generic .message").text("Error al registrar");
                    $("#modal-generic").modal("show");
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
    }
</script>

<div id="modal-actions" class="modal fade" role="dialog">
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
                                        <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="modify_estatus();">Aceptar</button>
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
                                    <span>Datos de Formación Exterior</span>
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
                                        <a class="activate">Actualización de Datos / Formación Exterior</a>
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
                                    <h2 class="text-center">Complete el registro de formación en el exterior en <b>"Mis Datos"</b></h2>
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