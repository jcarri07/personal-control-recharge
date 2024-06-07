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



    $sql = "SELECT * FROM datos_hijos WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

if($datos_personales['step'] > 1){
    

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
                                    <span>Datos de Hijos</span>
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
                                        <a class="activate">Actualización de Datos / Hijos</a>
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
                                                                    <th>Fecha de Nacimiento</th>
                                                                    <th>Sexo</th>
                                                                    <th>Grado Escolar</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                            <?php 
                                                    $i = 0;
                                                    while($row = mysqli_fetch_array($query)){
                                                        $id_hijo = $row['id_datos_hijos'];
                                                        $nombre = $row['nombre'];
                                                        $fecha_nacimiento = $row['fecha_nacimiento'];
                                                        $cedula = $row['cedula'];
                                                        $sexo = $row['sexo'];
                                                        $educacion = $row['grado_escolar_semestre'];
                                                        $talla_camisa = $row['talla_camisa'];
                                                        $talla_pantalon = $row['talla_pantalon'];
                                                        $talla_calzado = $row['talla_calzado'];

                                                        setlocale(LC_TIME, "spanish");
                                                        $fecha_nueva = strftime("%d de %B de %Y", strtotime($fecha_nacimiento));
                                            ?>            
                                                                <tr>
                                                                    <td><?php echo ++$i;?></td>
                                                                    <td><?php echo $nombre;?></td>
                                                                    <td><?php echo $fecha_nueva;?></td>
                                                                    <td><?php echo $sexo;?></td>
                                                                    <td><?php echo $educacion != "" ? $educacion : "N/A";?></td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-table" onclick="openModalEdit('<?php echo $id_hijo;?>', '<?php echo $nombre;?>', '<?php echo $fecha_nacimiento;?>', '<?php echo $cedula;?>', '<?php echo $sexo;?>', '<?php echo $educacion;?>', '<?php echo $talla_camisa;?>', '<?php echo $talla_pantalon;?>', '<?php echo $talla_calzado;?>');">
                                                                            <i class="feather icon-edit"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger btn-table" onclick="deseaEliminar('<?php echo $id_hijo;?>');">
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
                                                <h2 class="text-center mt-4">No hay hijos registrados</h2>

                                                
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
                                    <h3 class="modal-title text-center" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px;">Datos Personales</h3>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-12">
                                        <label class="block">Nombres y Apellidos</label>
                                        <input id="name" name="name" type="text" class="required form-control" maxlength="100" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Cédula de Identidad</label>
                                        <input name="ci" id="ci" type="number" class="required form-control" maxlength="30">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Fecha de Nacimiento</label>
                                        <input name="birthday" id="birthday" type="date" class="form-control required" onchange="calculateAge('birthday','age')" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Edad</label>
                                        <input name="ageEmployeer" id="age" type="text" class="form-control required" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Sexo</label>
                                        <select class="form-control required" id="gender" name="gender" onchange="//womanInformation(this)" required>
                                            <option value="">Seleccione</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Masculino">Masculino</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="block">Grado Escolar</label>
                                        <select class="form-control required" id="education" name="education">
                                            <option value="Seleccione">Seleccione</option>
                                            <option value="N/A">N/A</option>
                                            <option value="Inicial">Inicial</option>
                                            <option value="Primaria">Primaria</option>
                                            <option value="Secundaria">Secundaria</option>
                                            <option value="Universitario">Universitario</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="block">Talla de Camisa</label>
                                        <select class="form-control" name="shirtSizes" id="shirtSizes">
                                        <option value="Seleccione">Seleccione</option>
                                            <option value="XS">XS</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="2XL">2XL</option>
                                            <option value="3XL">3XL</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jeansSizes" class="block">Talla de Pantalón</label>
                                        <input name="jeansSizes" id="jeansSizes" type="number" class="form-control" maxlength="10">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shoesSizes" class="block">Talla de Calzado</label>
                                        <input name="shoesSizes" id="shoesSizes" type="number" class="form-control" maxlength="10">
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
        $("#aux_estatus").text("");
        $("#form-edit")[0].reset();
        $("#modal-form .modal-title").text("Añadir Hijo");
        $("#modal-form").modal("show");
    }

    function openModalEdit(id, nombre, fecha_nacimiento, cedula, sexo, educacion, talla_camisa, talla_pantalon, talla_calzado){
        $("#aux_id").text(id);
        $("#aux_opc").text("edit");
        $("#aux_estatus").text("");

        $("#name").val(nombre);
        $("#birthday").val(fecha_nacimiento);
        $("#ci").val(cedula);
        $("#gender").val(sexo);
        $("#education").val(educacion);
        $("#shirtSizes").val(talla_camisa);
        $("#jeansSizes").val(talla_pantalon);
        $("#shoesSizes").val(talla_calzado);

        $("#birthday").trigger("change");

        $("#modal-form .modal-title").text("Editar Hijo");
        $("#modal-form").modal("show");
    }

    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('id_hijo', $("#aux_id").text());
        datos.append('opc', $("#aux_opc").text());

        datos.append('nombre', this.name.value);
        datos.append('fecha_nacimiento', this.birthday.value);
        datos.append('cedula', this.ci.value);
        datos.append('sexo', this.gender.value);
        datos.append('educacion', this.education.value);
        datos.append('talla_camisa', this.shirtSizes.value);
        datos.append('talla_pantalon', this.jeansSizes.value);
        datos.append('talla_calzado', this.shoesSizes.value);

       

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/datos-hijos-process.php',
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
            url: 			'../modules/update-data-user/datos-hijos-process.php',
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
                                    <span>Datos de Hijos</span>
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
                                        <a class="activate">Actualización de Datos / Hijos</a>
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
                                    <h2 class="text-center">Complete el Registro de Hijos en <b>"Mis Datos"</b></h2>
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