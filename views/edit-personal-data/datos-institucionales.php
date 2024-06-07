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

    $sql = "SELECT * FROM sede;";
    $querySedes = mysqli_query($conn, $sql);

    $querySedes = mysqli_query($conn, "SELECT * FROM sede;");
    $queryDirecciones = mysqli_query($conn, "SELECT * FROM direccion;");
    $queryUnidades = mysqli_query($conn, "SELECT * FROM unidad;");
    /*$queryJefes = mysqli_query($conn, "SELECT u.id_usuario, u.nombres, u.apellidos, d.cargo
                                        FROM usuario u
                                        JOIN datos_abae d ON u.id_usuario = d.id_usuario
                                        WHERE d.cargo IN ('Jefe', 'Director', 'Vicepresidente', 'Presidente');");*/

    $sql = "SELECT d.id_jefe AS 'id_jefe', nombres, apellidos, u.cargo AS 'cargo', id_direccion
            FROM direccion d, usuario u
            WHERE d.id_jefe LIKE u.id_usuario;";
    $queryDirectores = mysqli_query($conn, $sql);

    $sql = "SELECT d.id_jefe AS 'id_jefe', nombres, apellidos, u.cargo AS 'cargo', id_unidad
            FROM unidad d, usuario u
            WHERE d.id_jefe LIKE u.id_usuario;";
    $queryJefes = mysqli_query($conn, $sql);

    $sql = "SELECT id_datos_abae, id_unidad, fecha_ingreso, cargo, correo_abae, nombres_familiares_abae, fecha_inicio_administracion, da.id_direccion AS 'id_direccion', tlf_oficina, id_sede FROM datos_abae da, direccion d WHERE da.id_direccion = d.id_direccion AND id_usuario = '$idUser' AND da.estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    closeConection($conn);

if($datos_personales['step'] > 6){
    $datos_abae = mysqli_fetch_array($query);

    
    $array_direcciones = array();
    while($row = mysqli_fetch_array($queryDirecciones)){
        $array_aux = array();
        $array_aux['id_direccion'] = $row['id_direccion'];
        $array_aux['nombre'] = $row['nombre'];
        $array_aux['id_sede'] = $row['id_sede'];
        array_push($array_direcciones, $array_aux);
    }

    $array_unidades = array();
    while($row = mysqli_fetch_array($queryUnidades)){
        $array_aux = array();
        $array_aux['id_unidad'] = $row['id_unidad'];
        $array_aux['nombre'] = $row['nombre'];
        $array_aux['id_direccion'] = $row['id_direccion'];        
        array_push($array_unidades, $array_aux);
    }


    $array_directores = array();
    while($row = mysqli_fetch_array($queryDirectores)){
        $array_aux = array();
        $array_aux['id_usuario'] = $row['id_jefe'];
        $array_aux['nombres'] = $row['nombres'];
        $array_aux['apellidos'] = $row['apellidos'];
        $array_aux['cargo'] = $row['cargo'];
        $array_aux['id_direccion'] = $row['id_direccion'];
        array_push($array_directores, $array_aux);
    }

    $array_jefes = array();
    while($row = mysqli_fetch_array($queryJefes)){
        $array_aux = array();
        $array_aux['id_usuario'] = $row['id_jefe'];
        $array_aux['nombres'] = $row['nombres'];
        $array_aux['apellidos'] = $row['apellidos'];
        $array_aux['cargo'] = $row['cargo'];
        $array_aux['id_unidad'] = $row['id_unidad'];        
        array_push($array_jefes, $array_aux);
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
                                    <span>Datos Institucionales</span>
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
                                        <a class="activate">Actualización de Datos / Institucionales</a>
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
                                                            <h3> Datos Institucionales </h3>
                                                        </div>
                                                        <!--<fieldset>-->
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-4">
                                                                    <label class="block">Ingreso en la ABAE</label>
                                                                    <input name="fecha_ingreso" id="fecha_ingreso" type="date" class="form-control" value="<?php echo $datos_abae['fecha_ingreso'];?>" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Años en la ABAE</label>
                                                                    <input name="age" id="age" type="number" class="form-control">
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="block">Cargo</label>
                                                                    <select class="form-control" id="cargo" name="cargo" required onchange="changeCargo();">
                                                                        <option value="">Seleccione</option>
                                                                        <!-- <option value="Presidente">Presidente</option> -->
                                                                        <!-- <option value="Vice-Presidente">Vice-Presidente</option> -->
                                                                        <option value="Director">Director</option>
                                                                        <option value="Jefe">Jefe</option>
                                                                        <option value="Personal de Investigacion">Personal de Investigacion</option>
                                                                        <option value="Empleado">Empleado</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Sede</label>
                                                                    <select class="form-control" id="sede" name="sede" required onchange="changeSede();">
                                                                        <option value="">Seleccione</option>
                                                            <?php
                                                                while ($row = mysqli_fetch_array($querySedes)) {
                                                            ?>
                                                                        <option value="<?php echo $row['id_sede']; ?>"><?php echo $row['nombre']; ?></option>
                                                            <?php
                                                                }
                                                            ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="block">Dirección de Adscripción</label>
                                                                    <select class="form-control" id="direccion" name="direccion" required onchange="changeDireccion();">
                                                                        <option value="">Seleccione</option>
                                                            
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Unidad de Adscripción</label>
                                                                    <select class="form-control" id="unidad" name="unidad" required onchange="changeUnidad();">
                                                                        <option value="">Seleccione</option>                                                            
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="block">Supervisor Inmediato</label>
                                                                    <select class="form-control" id="supervisor_inmediato" name="supervisor_inmediato">
                                                                        <option value="">Seleccione</option>
                                                                        <!--<option value='new'>Soy el Nuevo Supervisor de esta UNIDAD/DIRECCION</option>-->
                                                            <?php
                                                                /*while ($row = mysqli_fetch_array($queryJefes)) {
                                                            ?>
                                                                        <option value="<?php echo $row['id_jefe']; ?>"><?php echo $row['nombres'] . " " . $row['apellidos'] . ( ($row['cargo'] != "") ? (" (" . $row['cargo'] . ")") : "" ) ; ?></option>
                                                            <?php
                                                                }
                                                                while ($row = mysqli_fetch_array($queryDirectores)) {
                                                            ?>
                                                                        <option value="<?php echo $row['id_jefe']; ?>"><?php echo $row['nombres'] . " " . $row['apellidos'] . ( ($row['cargo'] != "") ? (" (" . $row['cargo'] . ")") : "" ) ; ?></option>
                                                            <?php
                                                                }*/
                                                            ?>                                                          
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Inicio en la Administración Pública</label>
                                                                    <input name="fecha_inicio_admin_publica" id="fecha_inicio_admin_publica" type="date" class="form-control" value="<?php echo $datos_abae['fecha_inicio_administracion'];?>" required>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="block">Correo Electrónico Institucional</label>
                                                                    <input name="correo" id="correo" type="text" class="form-control" value="<?php echo $datos_abae['correo_abae'];?>" maxlength="100" required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Teléfono Oficina / Ext.</label>
                                                                    <input name="telefono_oficina" id="telefono_oficina" type="text" class="form-control" value="<?php echo $datos_abae['tlf_oficina'];?>" maxlength="40">
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label class="block">Posee Familiares en la ABAE</label>
                                                                    <select class="form-control" id="posee_familiares_abae" name="posee_familiares_abae" required onchange="changeFamiliaresAbae();">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Nombre de Familiares</label>
                                                                    <input name="nombre_familiares" id="nombre_familiares" type="text" class="form-control" value="" maxlength="200">
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

<script src="../utils/functions-personal-data.js"></script>


<script>

    var array_direcciones = <?php echo json_encode($array_direcciones);?>;
    var array_unidades = <?php echo json_encode($array_unidades);?>;

    var array_directores = <?php echo json_encode($array_directores);?>;
    var array_jefes = <?php echo json_encode($array_jefes);?>;

    $(document).ready(function() {
        //$("#fecha_ingreso").trigger("change");
        calculateTime("fecha_ingreso", "age");

        $("#cargo").val("<?php echo $datos_abae['cargo'];?>");
        //$("#cargo").trigger("change");
        changeCargo();
        $("#sede").val("<?php echo $datos_abae['id_sede'];?>");
        //$("#sede").trigger("change");
        changeSede();
        if("<?php echo $datos_abae['cargo'];?>" != "Presidente" && "<?php echo $datos_abae['cargo'];?>" != "Vice-Presidente"){
            //$("#direccion").trigger("change");
            //changeDireccion();
            $("#direccion").val("<?php echo $datos_abae['id_direccion'];?>");

            if("<?php echo $datos_abae['cargo'];?>" != "Director"){
                //$("#unidad").trigger("change");
                changeDireccion();
                $("#unidad").val("<?php echo $datos_abae['id_unidad'];?>");

                changeUnidad();
            }
        }

        $("#supervisor_inmediato").val("<?php echo $datos_personales['id_jefe'];?>");

        if("<?php echo $datos_abae['nombres_familiares_abae'];?>" != "" && "<?php echo $datos_abae['nombres_familiares_abae'];?>" != "N/A"){
            $("#posee_familiares_abae").val("Si");
            //$("#posee_familiares_abae").trigger("change");
            changeFamiliaresAbae();
            $("#nombre_familiares").val("<?php echo $datos_abae['nombres_familiares_abae'];?>");
        }
        else{
            $("#posee_familiares_abae").val("No");
            changeFamiliaresAbae();
            //$("#posee_familiares_abae").trigger("change");
        }
        
    });

    $("#fecha_ingreso").on("change", function() {
        calculateTime(this.id, "age");
    });

    //$("#cargo").on("change", function() {
    function changeCargo(){    
        $("#direccion").html("<option value=''>Seleccione</option>");
        $("#unidad").html("<option value=''>Seleccione</option>");
        $("#supervisor_inmediato").html("<option value=''>Seleccione</option>");

        $("#direccion").parent().show();
        $("#unidad").parent().show();
        $("#direccion").attr("required", true);
        $("#unidad").attr("required", true);

        if($("#cargo").val() != ""){
            if($("#cargo").val() == "Presidente" || $("#cargo").val() == "Vice-Presidente"){
                $("#direccion").parent().hide();
                $("#unidad").parent().hide();
                $("#direccion").attr("required", false);
                $("#unidad").attr("required", false);
            }
            else{
                if($("#cargo").val() == "Director"){
                    $("#unidad").parent().hide();
                    $("#unidad").attr("required", false);
                }
                //else{
                    for(var i = 0 ; i < array_direcciones.length ; i++){
                        if(array_direcciones[i]['id_sede'] == $("#sede").val()){ 
                            $("#direccion").append("<option value='" + array_direcciones[i]['id_direccion'] + "'>" + array_direcciones[i]['nombre'] + "</option>");
                        }
                    }
                //}
            }
        }
    //});
    }

    //$("#sede").on("change", function() {
    function changeSede(){  
        $("#direccion").html("<option value=''>Seleccione</option>");
        $("#unidad").html("<option value=''>Seleccione</option>");

       /* $("#direccion").parent().show();
        $("#unidad").parent().show();
        $("#direccion").attr("required", true);
        $("#unidad").attr("required", true);*/

        if($("#sede").val() != ""){
            /*if(this.value == "Presidente" || this.value == "Vice-Presidente"){
                $("#direccion").parent().hide();
                $("#unidad").parent().hide();
                $("#direccion").attr("required", false);
                $("#unidad").attr("required", false);
            }
            else{
                if(this.value == "Director"){
                    $("#unidad").parent().hide();
                    $("#unidad").attr("required", false);
                }
                else{*/
                    for(var i = 0 ; i < array_direcciones.length ; i++){
                        if(array_direcciones[i]['id_sede'] == $("#sede").val()){
                            $("#direccion").append("<option value='" + array_direcciones[i]['id_direccion'] + "'>" + array_direcciones[i]['nombre'] + "</option>");
                        }
                    }
                /*}
            }*/
        }
    //});
    }

    //$("#direccion").on("change", function() {
    function changeDireccion(){
        $("#unidad").html("<option value=''>Seleccione</option>");
        if($("#direccion").val() != ""){
            
            for(var i = 0 ; i < array_unidades.length ; i++){
                if(array_unidades[i]['id_direccion'] == $("#direccion").val()){
                    $("#unidad").append("<option value='" + array_unidades[i]['id_unidad'] + "'>" + array_unidades[i]['nombre'] + "</option>");
                }
            }
        }

        $("#supervisor_inmediato").html("<option value=''>Seleccione</option>");
        if($("#direccion").val() != ""){

            if($("#cargo").val() != "Director") {
            
                for(var i = 0 ; i < array_directores.length ; i++){
                    if(array_directores[i]['id_direccion'] == $("#direccion").val()){
                        $("#supervisor_inmediato").append("<option value='" + array_directores[i]['id_usuario'] + "'>" + array_directores[i]['nombres'] + " " + array_directores[i]['apellidos'] + ( (array_directores[i]['cargo'] != "") ? (" (" + array_directores[i]['cargo'] + ")") : "" ) + "</option>");
                    }
                }
            }
        }
    }


    function changeUnidad(){
        $("#supervisor_inmediato").html("<option value=''>Seleccione</option>");
        for(var i = 0 ; i < array_directores.length ; i++){
            if(array_directores[i]['id_direccion'] == $("#direccion").val()){
                $("#supervisor_inmediato").append("<option value='" + array_directores[i]['id_usuario'] + "'>" + array_directores[i]['nombres'] + " " + array_directores[i]['apellidos'] + ( (array_directores[i]['cargo'] != "") ? (" (" + array_directores[i]['cargo'] + ")") : "" ) + "</option>");
            }
        }
        if($("#unidad").val() != "" && $("#cargo").val() != "Jefe"){
            for(var i = 0 ; i < array_jefes.length ; i++){
                if(array_jefes[i]['id_unidad'] == $("#unidad").val()){
                    $("#supervisor_inmediato").append("<option value='" + array_jefes[i]['id_usuario'] + "'>" + array_jefes[i]['nombres'] + " " + array_jefes[i]['apellidos'] + ( (array_jefes[i]['cargo'] != "") ? (" (" + array_jefes[i]['cargo'] + ")") : "" ) + "</option>");
                }
            }
        }
    }

    function changeFamiliaresAbae(){
        if($("#posee_familiares_abae").val() == "No"){
            $("#nombre_familiares").parent().hide();
            $("#nombre_familiares").val("");
        }
        else{
            $("#nombre_familiares").parent().show();
        }
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('opc', 'edit');

        datos.append('fecha_ingreso', this.fecha_ingreso.value);
        datos.append('cargo', this.cargo.value);
        //datos.append('sede', this.sede.value);
        datos.append('direccion', this.direccion.value);
        datos.append('unidad', this.unidad.value);
        datos.append('supervisor_inmediato', this.supervisor_inmediato.value);
        datos.append('fecha_inicio_admin_publica', this.fecha_inicio_admin_publica.value);
        datos.append('correo', this.correo.value);
        datos.append('telefono_oficina', this.telefono_oficina.value);
        datos.append('nombre_familiares', this.nombre_familiares.value);

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/datos-institucionales-process.php',
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
                                    <span>Datos Institucionales</span>
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
                                        <a class="activate">Actualización de Datos / Institucionales</a>
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
                                    <h2 class="text-center">Complete el registro de datos institucionales en <b>"Mis Datos"</b></h2>
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