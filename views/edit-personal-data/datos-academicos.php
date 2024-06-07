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

    $sql = "SELECT * FROM nivel_academico WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

if($datos_personales['step'] > 3){
    //$nivel_academico = mysqli_fetch_array($query);

    
    closeConection($conn);

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
                                    <span>Datos Académicos</span>
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
                                        <a class="activate">Actualización de Datos / Académicos</a>
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
                                                    <!--<form id="form-edit" class="wizard-form">
                                                        <div class="box-title mb-3">
                                                            <h3> Datos Académicos </h3>
                                                        </div>
                                                        <!--<fieldset>--
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-6">
                                                                    <label class="block">Grado de Instrucción</label>
                                                                    <select class="form-control" id="especializacion" name="especializacion" required>
                                                                        <option value="Seleccione">Seleccione</option>
                                                                        <option value="TSU">TSU</option>
                                                                        <option value="Licenciatura">Licenciatura</option>
                                                                        <option value="Especializacion">Especialización</option>
                                                                        <option value="Post-Grado">Post-Grado</option>
                                                                        <option value="Maestría">Maestría</option>
                                                                        <option value="Doctorado">Doctorado</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Título Obtenido</label>
                                                                    <input name="titulo" id="titulo" type="text" class="form-control" value="<?php echo $nivel_academico['titulo_obtenido'];?>" maxlength="100" required>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Año de Grado</label>
                                                                    <input name="anio" id="anio" type="text" class="form-control" value="<?php echo $nivel_academico['anio_egreso'];?>" maxlength="10" required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Institución Universitaria</label>
                                                                    <input name="institucion" id="institucion" type="text" class="form-control" value="<?php echo $nivel_academico['instituto_universitario'];?>" maxlength="100" required>
                                                                </div>
                                                                
                                                            </div>
                                                        <!--</fieldset>--
                                                        

                                                        <div class="row">
                                                            <div class="col-md-12 loaderParent">
                                                                <div class="loader">
                                                                </div>
                                                                Por favor, espere
                                                            </div>
                                                        </div>

                                                        <div class="text-center mt-3">
                                                            <button class="btn btn-primary">Actualizar</button>
                                                        </div>
                                                    </form>-->

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
                                                                    <th>Grado de Instrucción</th>
                                                                    <th>Título Obtenido</th>
                                                                    <th>Año de Grado</th>
                                                                    <th>Institución Universitaria</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php 
                                                    $i = 0;
                                                    while($row = mysqli_fetch_array($query)){
                                                        $id_nivel_academico = $row['id_nivel_academico'];
                                                        $especializacion = $row['especializacion'];
                                                        $titulo_obtenido = $row['titulo_obtenido'];
                                                        $anio_egreso = $row['anio_egreso'];
                                                        $instituto_universitario = $row['instituto_universitario'];
                                            ?>            
                                                                <tr>
                                                                    <td><?php echo ++$i;?></td>
                                                                    <td><?php echo $especializacion;?></td>
                                                                    <td><?php echo $titulo_obtenido;?></td>
                                                                    <td><?php echo $anio_egreso;?></td>
                                                                    <td><?php echo $instituto_universitario;?></td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-table" onclick="openModalEdit('<?php echo $id_nivel_academico;?>', '<?php echo $especializacion;?>', '<?php echo $titulo_obtenido;?>', '<?php echo $anio_egreso;?>', '<?php echo $instituto_universitario;?>');">
                                                                            <i class="feather icon-edit"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-table" onclick="deseaEliminar('<?php echo $id_nivel_academico;?>');">
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
                                                <h2 class="text-center mt-4">No hay niveles académicos registrados</h2>

                                                
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
    <div class="modal-dialog modal-lg">
        <div class="login-card card-block login-card-modal">
            <form class="md-float-material" id="form-edit"><!--form-->
                <div class="card m-t-15">
                    <div class="auth-box card-block">
                        <div class="row m-b-0">
                            
                            <div class="col-md-12 text-center" style="margin-bottom: 0px;">
                                <div class="box-title">
                                    <h3 class="modal-title text-center" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px;">Datos Académicos</h3>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-6">
                                        <label class="block">Grado de Instrucción</label>
                                        <select class="form-control" id="especializacion" name="especializacion" required>
                                            <option value="Seleccione">Seleccione</option>
                                            <option value="TSU">TSU</option>
                                            <option value="Licenciatura">Licenciatura</option>
                                            <option value="Especializacion">Especialización</option>
                                            <option value="Post-Grado">Post-Grado</option>
                                            <option value="Maestría">Maestría</option>
                                            <option value="Doctorado">Doctorado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Título Obtenido</label>
                                        <input name="titulo" id="titulo" type="text" class="form-control" maxlength="100" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Año de Grado</label>
                                        <input name="anio" id="anio" type="text" class="form-control" maxlength="10" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Institución Universitaria</label>
                                        <input name="institucion" id="institucion" type="text" class="form-control" maxlength="100" required>
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

    $(document).ready(function() {
        //$("#especializacion").val("<?php// echo $nivel_academico['especializacion'];?>");
    });

    iniciarTabla("row-select");

    function openModalAdd(){
        $("#aux_id").text("");
        $("#aux_opc").text("add");
        $("#aux_estatus").text("");
        $("#form-edit")[0].reset();
        $("#modal-form .modal-title").text("Añadir Datos Académicos");
        $("#modal-form form button[type=submit]").text("Añadir");
        $("#modal-form").modal("show");
    }

    function openModalEdit(id, especializacion, titulo_obtenido, anio_egreso, instituto_universitario){
        $("#aux_id").text(id);
        $("#aux_opc").text("edit");
        $("#aux_estatus").text("");

        $("#especializacion").val(especializacion);
        $("#titulo").val(titulo_obtenido);
        $("#anio").val(anio_egreso);
        $("#institucion").val(instituto_universitario);

        $("#modal-form .modal-title").text("Editar Datos Académicos");
        $("#modal-form form button[type=submit]").text("Editar");
        $("#modal-form").modal("show");
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('id_nivel_academico', $("#aux_id").text());
        datos.append('opc', $("#aux_opc").text());

        datos.append('especializacion', this.especializacion.value);
        datos.append('titulo', this.titulo.value);
        datos.append('anio', this.anio.value);
        datos.append('institucion', this.institucion.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/datos-academicos-process.php',
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

    function deseaEliminar(id_hijo) {
        $("#modal-actions .message").text("¿Desea eliminar?");
        $('#aux_id').text(id_hijo);
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
            url: 			'../modules/update-data-user/datos-academicos-process.php',
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
                                    <span>Datos Académicos</span>
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
                                        <a class="activate">Actualización de Datos / Académicos</a>
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
                                    <h2 class="text-center">Complete el registro de datos académicos en <b>"Mis Datos"</b></h2>
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