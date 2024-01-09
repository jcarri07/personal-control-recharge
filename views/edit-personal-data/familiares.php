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



    $sql = "SELECT * FROM nucleo_familiar WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    closeConection($conn);

if($datos_personales['step'] > 2){
    

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
                                    <span>Datos de Familiares</span>
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
                                        <a href="#!" class="activate">Actualización de Datos / Familiares</a>
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
                                                                    <th>Nombre</th>
                                                                    <th>Parentesco</th>
                                                                    <th>Fecha de Nacimiento</th>
                                                                    <th>Sexo</th>
                                                                    <th>Grado de Instrucción</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php 
                                                    $i = 0;
                                                    while($row = mysqli_fetch_array($query)){
                                                        $id_nucleo_familiar = $row['id_nucleo_familiar'];
                                                        $nombre = $row['nombre'];
                                                        $apellido = $row['apellido'];
                                                        $parentesco = $row['parentesco'];
                                                        $cedula = $row['cedula'];
                                                        $fecha_nacimiento = $row['fecha_nacimiento'];
                                                        $sexo = $row['sexo'];
                                                        $estado_civil = $row['estado_civil'];
                                                        $educacion = $row['grado_instruccion'];

                                                        setlocale(LC_TIME, "spanish");
                                                        $fecha_nueva = strftime("%d de %B de %Y", strtotime($fecha_nacimiento));
                                            ?>            
                                                                <tr>
                                                                    <td><?php echo ++$i;?></td>
                                                                    <td><?php echo $nombre . " " . $apellido;?></td>
                                                                    <td><?php echo $parentesco;?></td>
                                                                    <td><?php echo $fecha_nueva;?></td>
                                                                    <td><?php echo $sexo;?></td>
                                                                    <td><?php echo $educacion;?></td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-table" onclick="openModalEdit('<?php echo $id_nucleo_familiar;?>', '<?php echo $nombre;?>', '<?php echo $apellido;?>', '<?php echo $parentesco;?>', '<?php echo $cedula;?>', '<?php echo $fecha_nacimiento;?>', '<?php echo $sexo;?>', '<?php echo $estado_civil;?>', '<?php echo $educacion;?>');">
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
                                                <h2 class="text-center mt-4">No hay familiares registrados</h2>

                                                
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
                                    <h3 class="modal-title text-center" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px;">Datos Personales</h3>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-12">
                                        <label class="block">Parentesco</label>
                                        <select class="form-control" id="status_family" name="status_family" required>
                                        <option value="Seleccione">Seleccione</option>
                                            <option value="Conyugue">Conyugue</option>
                                            <option value="Esposo(a)">Esposo(a)</option>
                                            <option value="Hijo(a)">Hijo(a)</option>
                                            <option value="Madre">Madre</option>
                                            <option value="Padre">Padre</option>
                                            <option value="Hermano(a)">Hermano(a)</option>
                                            <option value="Tio(a)">Tio(a)</option>
                                            <option value="Sobrino(a)">Sobrino(a)</option>
                                            <option value="Abuelo(a)">Abuelo(a)</option>
                                            <option value="Nieto(a)">Nieto(a)</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Nombres</label>
                                        <input id="name" name="name" type="text" class="form-control" maxlength="50" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Apellidos</label>
                                        <input id="last_name" name="last_name" type="text" class="form-control" maxlength="50" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Cédula de Identidad</label>
                                        <input name="ci" id="ci" type="number" class="form-control" maxlength="30">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Fecha de Nacimiento</label>
                                        <input name="birthday" id="birthday" type="date" class="form-control" onchange="calculateAge('birthday','age')" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Edad</label>
                                        <input name="ageEmployeer" id="age" type="text" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Sexo</label>
                                        <select class="form-control" id="gender" name="gender" onchange="//womanInformation(this)" required>
                                            <option value="">Seleccione</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="block">Estado Civil</label>
                                        <select class="form-control" id="estado_civil" name="estado_civil" required>
                                            <option value="Seleccione">Seleccione</option>
                                            <option value="Soltero(a)">Soltero(a)</option>
                                            <option value="Conyugue">Concubinato</option>
                                            <option value="Casado(a)">Casado(a)</option>
                                            <option value="Anulado">Divorciado(a)</option>
                                            <option value="Viudo(a)">Viudo(a)</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="block">Grado de Instrucción</label>
                                        <select class="form-control" id="education" name="education" required>
                                            <option value="Seleccione">Seleccione</option>
                                            <option value="N/A">N/A</option>
                                            <option value="Primaria">Primaria</option>
                                            <option value="Secundaria">Secundaria</option>
                                            <option value="Universitario">Universitario</option>
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
        $("#modal-form .modal-title").text("Añadir Familiar");
        $("#modal-form").modal("show");
    }

    function openModalEdit(id, nombre, apellido, parentesco, cedula, fecha_nacimiento, sexo, estado_civil, educacion){
        $("#aux_id").text(id);
        $("#aux_opc").text("edit");

        $("#status_family").val(parentesco);
        $("#name").val(nombre);
        $("#last_name").val(apellido);
        $("#birthday").val(fecha_nacimiento);
        $("#ci").val(cedula);
        $("#gender").val(sexo);estado_civil
        $("#estado_civil").val(estado_civil);
        $("#education").val(educacion);

        $("#birthday").trigger("change");

        $("#modal-form .modal-title").text("Editar Familiar");
        $("#modal-form").modal("show");
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('id_familiar', $("#aux_id").text());
        datos.append('opc', $("#aux_opc").text());

        datos.append('parentesco', this.status_family.value);
        datos.append('nombre', this.name.value);
        datos.append('apellido', this.last_name.value);
        datos.append('cedula', this.ci.value);
        datos.append('fecha_nacimiento', this.birthday.value);
        datos.append('sexo', this.gender.value);
        datos.append('estado_civil', this.estado_civil.value);
        datos.append('educacion', this.education.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/datos-familiares-process.php',
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
                                    <span>Datos de Familiares</span>
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
                                        <a class="activate">Actualización de Datos / Familiares</a>
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
                                    <h2 class="text-center">Complete el registro de familiares en <b>"Mis Datos"</b></h2>
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