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

    $sql = "SELECT * FROM datos_militar WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    closeConection($conn);

if($datos_personales['step'] > 7){
    $instituto = "";
    $rango = "";
    $fecha_inicio = "";
    $fecha_fin = "";
    if(mysqli_num_rows($query) > 0){
        $comision_servicio = mysqli_fetch_array($query);
        $instituto = $comision_servicio['instituto_militar'];
        $rango = $comision_servicio['rango'];
        $fecha_inicio = $comision_servicio['fecha_inicio'];
        $fecha_fin = $comision_servicio['fecha_fin'];
    }

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
                                    <span>Comisión de Servicio</span>
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
                                        <a href="#!" class="activate">Actualización de Datos / Comisión de Servicio</a>
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
                                                        <div class="box-title mb-3">
                                                            <h3>Comisión de Servicio</h3>
                                                        </div>
                                                        <!--<fieldset>-->
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-6">
                                                                    <label class="block">Instituto / Ente / Componente de Procedencia</label>
                                                                    <input name="instituto" id="instituto" type="text" class="form-control" maxlength="100" value="<?php echo $instituto;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Rango Militar</label>
                                                                    <input name="rango" id="rango" type="text" class="form-control" maxlength="50" value="<?php echo $rango;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Fecha de Inicio de la Comisión</label>
                                                                    <input name="fecha_inicio" id="fecha_inicio" type="date" class="form-control" value="<?php echo $fecha_inicio;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Fecha de Culminación de la Comisión de Servicio</label>
                                                                    <input name="fecha_fin" id="fecha_fin" type="date" class="form-control" value="<?php echo $fecha_fin;?>">
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

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('opc', 'edit');

        datos.append('instituto', this.instituto.value);
        datos.append('rango', this.rango.value);
        datos.append('fecha_inicio', this.fecha_inicio.value);
        datos.append('fecha_fin', this.fecha_fin.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/comision-de-servicio-process.php',
            type:			'POST',
            data:			datos,
            cache:          false,
            contentType:    false,
            processData:    false,
            success: function(response){ //console.log(response);
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
                        //alertify.error("Error al registrar.");
                        $("#modal-generic .message").text("Error al registrar.");
                        $("#modal-generic").modal("show");
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
                                    <span>Comisión de Servicio</span>
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
                                        <a href="#!" class="activate">Actualización de Datos / Comisión de Servicio</a>
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
                                    <h2 class="text-center">Complete el Registro de Comisión de Servicio en <b>"Mis Datos"</b>.</h2>
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