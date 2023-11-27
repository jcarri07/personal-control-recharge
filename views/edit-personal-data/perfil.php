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
                                    <h4>Configuración de Perfil</h4>
                                    <!--<span>Otros Datos</span>-->
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="#"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <!--<a href="#!" class="activate">Actualización de Datos / Otros Datos</a>-->
                                        <a href="#!" class="activate">Configuración de Perfil</a>
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
                                                    <form id="form-edit" class="wizard-form">
                                                        <div class="box-title mb-1">
                                                            <h3>Perfil</h3>
                                                        </div>
                                                        <!--<fieldset>-->
                                                            <div class="form-group row align-items-center d-flex flex-column">
                                                                <div class="col-md-7">
                                                                    <label class="block">Usuario</label>
                                                                    <input name="user" id="user" type="text" class="form-control" maxlength="50" value="<?php echo $datos_personales['user'];?>">
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <label class="block">Contraseña</label>
                                                                    <input name="pass" id="pass" type="password" class="form-control" maxlength="50">
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <label class="block">Repetir Contraseña</label>
                                                                    <input name="pass_repeat" id="pass_repeat" type="password" class="form-control" maxlength="50">
                                                                </div>
                                                            </div>
                                                        <!--</fieldset>-->
                                                        

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
                                                    </form>
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

<!--<script src="../utils/functions-personal-data.js"></script>-->


<script>

   
    $(document).ready(function() {
    });

    

    
    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        if(this.pass.value != "" || this.pass_repeat.value != ""){
            if(this.pass.value != this.pass_repeat.value){
                $("#modal-generic .aceptar button").attr("onclick", "");
                $("#modal-generic .message").text("Las contraseñas no coinciden.");
                $("#modal-generic").modal("show");
                return false;
            }
        }

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('opc', 'edit');

        datos.append('user', this.user.value);
        datos.append('pass', this.pass.value);
        
        

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/perfil-process.php',
            type:			'POST',
            data:			datos,
            cache:          false,
            contentType:    false,
            processData:    false,
            success: function(response){ console.log(response);
                $('.loaderParent').hide();
                if(response == 'si'){
                    //alertify.success("Bello."); 
                    $("#modal-generic .message").text("Actualización exitosa");
                    $("#modal-generic .aceptar button").attr("onclick", "window.location.reload();");
                    $("#modal-generic").modal("show");
                }
                else{
                    $("#modal-generic .aceptar button").attr("onclick", "");
                    if(response == "vacio"){
                        //alertify.warning("Datos vacíos o sin modificación.");
                        $("#modal-generic .message").text("Datos Vacíos o sin Modificación");
                        $("#modal-generic").modal("show");
                        
                    }
                    else{
                        if(response == "existe"){
                            //alertify.warning("Datos vacíos o sin modificación.");
                            $("#modal-generic .message").text("Ya existe este nombre de usuario, intente con otro");
                            $("#modal-generic").modal("show");
                        }
                        else{
                            //alertify.error("Error al registrar.");
                            $("#modal-generic .message").text("Error al registrar.");
                            $("#modal-generic").modal("show");
                        }
                    } 
                }
            }
            ,
            error: function(response){
                $('.loaderParent').hide();
                //alertify.error("Error al registrar."); 
                $("#modal-generic .message").text("Error al registrar.");
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


