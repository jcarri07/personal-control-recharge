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

    $sql = "SELECT * FROM otros_datos_usuario WHERE id_usuario = '$idUser' AND estatus = 'activo';";
    $query = mysqli_query($conn, $sql);

    closeConection($conn);

if($datos_personales['step'] > 8){
    $facebook = "";
    $twitter = "";
    $instagram = "";
    $otras_redes = "";
    $tiene_carnet_patria = "";
    $codigo_carnet_patria = "";
    $serial_carnet_patria = "";
    $beneficios_patria = "";
    $tiene_carnet_psuv = "";
    $codigo_carnet_psuv = "";
    $serial_carnet_psuv = "";
    $beneficios_psuv = "";
    $partido_politico = "";
    $movimiento_social = "";
    $comuna = "";
    $es_vocero_comuna = "";
    $recibe_clap = "";
    $vivienda = "";
    $tipo_vivienda = "";
    $posee_vehiculo = "";
    $tipo_vehiculo = "";
    $usa_transporte_publico = "";
    $tipo_transporte_publico = "";
    $ruta_trabajo = "";
    $deporte_actividad_cultural = "";

    if(mysqli_num_rows($query) > 0){
        $otros_datos = mysqli_fetch_array($query);

        $facebook = $otros_datos['facebook'];
        $twitter = $otros_datos['twitter'];
        $instagram = $otros_datos['instagram'];
        $otras_redes = $otros_datos['otras_redes'];
        $tiene_carnet_patria = $otros_datos['tiene_carnet_patria'];
        $codigo_carnet_patria = $otros_datos['codigo_carnet_patria'];
        $serial_carnet_patria = $otros_datos['serial_carnet_patria'];
        $beneficios_patria = $otros_datos['beneficios_patria'];
        $tiene_carnet_psuv = $otros_datos['tiene_carnet_psuv'];
        $codigo_carnet_psuv = $otros_datos['codigo_carnet_psuv'];
        $serial_carnet_psuv = $otros_datos['serial_carnet_psuv'];
        $beneficios_psuv = $otros_datos['beneficios_psuv'];
        $partido_politico = $otros_datos['partido_politico'];
        $movimiento_social = $otros_datos['movimiento_social'];
        $comuna = $otros_datos['comuna'];
        $es_vocero_comuna = $otros_datos['es_vocero_comuna'];
        $recibe_clap = $otros_datos['recibe_clap'];
        $vivienda = $otros_datos['vivienda'];
        $tipo_vivienda = $otros_datos['tipo_vivienda'];
        $posee_vehiculo = $otros_datos['posee_vehiculo'];
        $tipo_vehiculo = $otros_datos['tipo_vehiculo'];
        $usa_transporte_publico = $otros_datos['usa_transporte_publico'];
        $tipo_transporte_publico = $otros_datos['tipo_transporte_publico'];
        $ruta_trabajo = $otros_datos['ruta_trabajo'];
        $deporte_actividad_cultural = $otros_datos['deporte_actividad_cutural'];
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
                                    <span>Otros Datos del Empleado</span>
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
                                        <a class="activate">Actualización de Datos / Otros Datos</a>
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
                                                            <h3>Redes Sociales</h3>
                                                        </div>
                                                        <!--<fieldset>-->
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-6">
                                                                    <label class="block">Facebook</label>
                                                                    <input name="facebook" id="facebook" type="text" class="form-control" maxlength="100" value="<?php echo $facebook;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Twitter</label>
                                                                    <input name="twitter" id="twitter" type="text" class="form-control" maxlength="100" value="<?php echo $twitter;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Instagram</label>
                                                                    <input name="instagram" id="instagram" type="text" class="form-control" maxlength="100" value="<?php echo $instagram;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Otras Redes</label>
                                                                    <input name="otras_redes" id="otras_redes" type="text" class="form-control" maxlength="100" value="<?php echo $otras_redes;?>">
                                                                </div>
                                                            </div>

                                                            <div class="box-title mb-1">
                                                                <h3>Carnet de la Patria y del PSUV</h3>
                                                            </div>
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-6">
                                                                    <label for="posee_carnet_patria" class="block">Posee Carnet de la Patria?</label>
                                                                    <select class="form-control" name="posee_carnet_patria" id="posee_carnet_patria" onchange="changeCarnetPatria();">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Código del Carnet de la Patria</label>
                                                                    <input name="codigo_carnet_patria" id="codigo_carnet_patria" type="number" class="form-control" maxlength="100" value="<?php echo $codigo_carnet_patria;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Serial del Carnet de la Patria</label>
                                                                    <input name="serial_carnet_patria" id="serial_carnet_patria" type="number" class="form-control" maxlength="100" value="<?php echo $serial_carnet_patria;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Beneficios del Carnet de la Patria</label>
                                                                    <input name="beneficios_patria" id="beneficios_patria" type="text" class="form-control" maxlength="100" value="<?php echo $beneficios_patria;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="posee_carnet_psuv" class="block">Posee Carnet del PSUV?</label>
                                                                    <select class="form-control" name="posee_carnet_psuv" id="posee_carnet_psuv" onchange="changeCarnetPSUV();">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Código del Carnet del PSUV</label>
                                                                    <input name="codigo_carnet_psuv" id="codigo_carnet_psuv" type="number" class="form-control" maxlength="100" value="<?php echo $codigo_carnet_psuv;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Serial del Carnet del PSUV</label>
                                                                    <input name="serial_carnet_psuv" id="serial_carnet_psuv" type="number" class="form-control" maxlength="100" value="<?php echo $serial_carnet_psuv;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Beneficios del Carnet del PSUV</label>
                                                                    <input name="beneficios_psuv" id="beneficios_psuv" type="text" class="form-control" maxlength="100" value="<?php echo $beneficios_psuv;?>">
                                                                </div>
                                                            </div>

                                                            <div class="box-title mb-1">
                                                                <h3>Partidos Políticos y Comunas</h3>
                                                            </div>
                                                            <div class="form-group row justify-content-center" style="margin-bottom: 0px;">
                                                                <div class="col">
                                                                    <label for="pertenece_partido_politico_select" class="block">¿Pertenece a algún Partido Político?</label>
                                                                    <select class="form-control" name="pertenece_partido_politico_select" id="pertenece_partido_politico_select" onchange="changeComunasYPartidos(this.id);">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="pertenece_partido_politico" class="block">(Indique Partido Político)</label>
                                                                    <input name="pertenece_partido_politico" id="pertenece_partido_politico" type="text" class="form-control" maxlength="100" value="<?php echo $partido_politico;?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row justify-content-center" style="margin-bottom: 0px;">
                                                                <div class="col">
                                                                    <label for="pertenece_movimiento_social_select" class="block">¿Pertenece a algún Movimiento Social?</label>
                                                                    <select class="form-control" name="pertenece_movimiento_social_select" id="pertenece_movimiento_social_select" onchange="changeComunasYPartidos(this.id);">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="pertenece_movimiento_social" class="block">(Indique Movimiento Social)</label>
                                                                    <input name="pertenece_movimiento_social" id="pertenece_movimiento_social" type="text" class="form-control" maxlength="100" value="<?php echo $movimiento_social;?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row justify-content-center" style="margin-bottom: 0px;">
                                                                <div class="col">
                                                                    <label for="pertenece_comuna_select" class="block">¿Pertenece a alguna Comuna o Consejo Comunal?</label>
                                                                    <select class="form-control" name="pertenece_comuna_select" id="pertenece_comuna_select" onchange="changeComunasYPartidos(this.id);">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="pertenece_comuna" class="block">(Indique Comuna o Consejo Comunal)</label>
                                                                    <input name="pertenece_comuna" id="pertenece_comuna" type="text" class="form-control" maxlength="100" value="<?php echo $comuna;?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row justify-content-center" style="margin-bottom: 0px;">
                                                                <div class="col">
                                                                    <label for="es_vocero_comuna_select" class="block">¿Es Usted Vocero en Alguna Comuna o Consejo Comunal?</label>
                                                                    <select class="form-control" name="es_vocero_comuna_select" id="es_vocero_comuna_select" onchange="changeComunasYPartidos(this.id);">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label for="es_vocero_comuna" class="block">(Indique Comuna o Consejo Comunal)</label>
                                                                    <input name="es_vocero_comuna" id="es_vocero_comuna" type="text" class="form-control" maxlength="100" value="<?php echo $es_vocero_comuna;?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row justify-content-center" style="margin-bottom: 0px;">
                                                                <div class="col-md-6">
                                                                    <label for="recibe_clap" class="block">¿Recibe Beneficio de la Caja Clap?</label>
                                                                    <select class="form-control" name="recibe_clap" id="recibe_clap">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="box-title mb-1">
                                                                <h3>Vivienda, Vehículo, Transporte, Deporte</h3>
                                                            </div>
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-6">
                                                                    <label for="vivienda" class="block">¿Posee Vivienda Propia, Alquilada o Familiar?</label>
                                                                    <select class="form-control" name="vivienda" id="vivienda">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Alquilada">Alquilada</option>
                                                                        <option value="Propia">Propia</option>
                                                                        <option value="Familiar">Familiar</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="tipo_vivienda" class="block">Tipo de Vivienda</label>
                                                                    <select class="form-control" name="tipo_vivienda" id="tipo_vivienda">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Casa">Casa</option>
                                                                            <option value="Apartamento">Apartamento</option>
                                                                            <option value="Casa">Casa</option>
                                                                            <option value="Townhouse">Townhouse</option>
                                                                            <option value="Quinta">Quinta</option>
                                                                            <option value="Rancho">Rancho</option>
                                                                            <option value="Hacienda">Hacienda</option>
                                                                            <option value="Churuata">Churuata</option>
                                                                            <option value="Cabaña">Cabaña</option>
                                                                            <option value="Anexo">Anexo</option>
                                                                            <option value="Apartaestudio">Apartaestudio</option>
                                                                            <option value="Local comercial">Local Comercial</option>
                                                                            <option value="Oficina">Oficina</option>
                                                                            <option value="Terreno">Terreno</option>
                                                                            <option value="Galpón">Galpón</option>
                                                                            <option value="Edificio">Edificio</option>
                                                                            <option value="Otro">Otro</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="posee_vehiculo" class="block">¿Posee Vehiculo Propio?</label>
                                                                    <select class="form-control" name="posee_vehiculo" id="posee_vehiculo" onchange="changeVehiculo();">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="tipo_vehiculo" class="block">Tipo de Vehículo</label>
                                                                    <select class="form-control" name="tipo_vehiculo" id="tipo_vehiculo">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Automóvil">Automóvil</option>
                                                                        <option value="Camioneta">Camioneta</option>
                                                                        <option value="Motocicleta">Motocicleta</option>
                                                                        <option value="Bicicleta">Bicicleta</option>
                                                                        <option value="Autobús">Autobús</option>
                                                                        <option value="Camion">Camión</option>
                                                                        <option value="Otro">Otro</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label for="usa_transporte_publico" class="block">¿Utiliza Transporte Público?</label>
                                                                    <select class="form-control" name="usa_transporte_publico" id="usa_transporte_publico" onchange="changeTransportePublico();">
                                                                        <option value="">Seleccione</option>
                                                                        <option value="Si">Si</option>
                                                                        <option value="No">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">Indique Cual</label>
                                                                    <input name="tipo_transporte_publico" id="tipo_transporte_publico" type="text" class="form-control" maxlength="50" value="<?php echo $tipo_transporte_publico;?>">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label class="block">Describa Brevemente la Ruta que Utiliza Para Trasladarse al Lugar de Trabajo</label>
                                                                    <input name="ruta_trabajo" id="ruta_trabajo" type="text" class="form-control" maxlength="500" value="<?php echo $ruta_trabajo;?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="block">¿Practica Algún Deporte o Actividad Cultural? (Indique)</label>
                                                                    <input name="deporte_actividad_cultural" id="deporte_actividad_cultural" type="text" class="form-control" maxlength="200" value="<?php echo $deporte_actividad_cultural;?>">
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
        $("#posee_carnet_patria").val("<?php echo $tiene_carnet_patria;?>");
        changeCarnetPatria();

        $("#posee_carnet_psuv").val("<?php echo $tiene_carnet_psuv;?>");
        changeCarnetPSUV();

        /*$("#pertenece_partido_politico").val("<?php echo $partido_politico;?>");
        $("#pertenece_movimiento_social").val("<?php echo $movimiento_social;?>");
        $("#pertenece_comuna").val("<?php echo $comuna;?>");
        $("#es_vocero_comuna").val("<?php echo $es_vocero_comuna;?>");*/

        if("<?php echo $partido_politico;?>" == "")
            $("#pertenece_partido_politico_select").val("No");
        else
            $("#pertenece_partido_politico_select").val("Si");

        if("<?php echo $movimiento_social;?>" == "")
            $("#pertenece_movimiento_social_select").val("No");
        else
            $("#pertenece_movimiento_social_select").val("Si");

        if("<?php echo $comuna;?>" == "")
            $("#pertenece_comuna_select").val("No");
        else
            $("#pertenece_comuna_select").val("Si");

        if("<?php echo $es_vocero_comuna;?>" == "")
            $("#es_vocero_comuna_select").val("No");
        else
            $("#es_vocero_comuna_select").val("Si");

        changeComunasYPartidos("pertenece_partido_politico_select");
        changeComunasYPartidos("pertenece_movimiento_social_select");
        changeComunasYPartidos("pertenece_comuna_select");
        changeComunasYPartidos("es_vocero_comuna_select");
        $("#recibe_clap").val("<?php echo $recibe_clap;?>");
        $("#vivienda").val("<?php echo $vivienda;?>");
        $("#tipo_vivienda").val("<?php echo $tipo_vivienda;?>");

        $("#posee_vehiculo").val("<?php echo $posee_vehiculo;?>");
        $("#tipo_vehiculo").val("<?php echo $tipo_vehiculo;?>");
        changeVehiculo();

        $("#usa_transporte_publico").val("<?php echo $usa_transporte_publico;?>");
        changeTransportePublico();
    });

    function changeCarnetPatria(){
        if($("#posee_carnet_patria").val() == 'Si'){
            $("#codigo_carnet_patria").parent().show();
            $("#serial_carnet_patria").parent().show();
            $("#beneficios_patria").parent().show();
        }
        else{
            $("#codigo_carnet_patria").parent().hide();
            $("#serial_carnet_patria").parent().hide();
            $("#beneficios_patria").parent().hide();
            $("#codigo_carnet_patria").val("");
            $("#serial_carnet_patria").val("");
            $("#beneficios_patria").val("");
        }
    }

    function changeCarnetPSUV(){
        if($("#posee_carnet_psuv").val() == 'Si'){
            $("#codigo_carnet_psuv").parent().show();
            $("#serial_carnet_psuv").parent().show();
            $("#beneficios_psuv").parent().show();
        }
        else{
            $("#codigo_carnet_psuv").parent().hide();
            $("#serial_carnet_psuv").parent().hide();
            $("#beneficios_psuv").parent().hide();
            $("#codigo_carnet_psuv").val("");
            $("#serial_carnet_psuv").val("");
            $("#beneficios_psuv").val("");
        }
    }

    function changeVehiculo(){
        if($("#posee_vehiculo").val() == 'Si'){
            $("#tipo_vehiculo").parent().show();
        }
        else{
            $("#tipo_vehiculo").parent().hide();
            $("#tipo_vehiculo").val("");
        }
    }

    function changeTransportePublico(){
        if($("#usa_transporte_publico").val() == 'Si'){
            $("#tipo_transporte_publico").parent().show();
        }
        else{
            $("#tipo_transporte_publico").parent().hide();
            $("#tipo_transporte_publico").val("");
        } 
    }

    function changeComunasYPartidos(id){
        var id_campo = id.replace("_select", "");
        if($("#" + id).val() == "Si") {
            $("#" + id_campo).parent().show();
        }
        else {
            $("#" + id_campo).val("");
            $("#" + id_campo).parent().hide();
        }
    }


    $("#form-edit").on("submit",function(event){
    	event.preventDefault();

        var datos = new FormData();
        datos.append('id', '<?php echo $idUser;?>');
        datos.append('opc', 'edit');

        datos.append('facebook', this.facebook.value);
        datos.append('twitter', this.twitter.value);
        datos.append('instagram', this.instagram.value);
        datos.append('otras_redes', this.otras_redes.value);

        datos.append('posee_carnet_patria', this.posee_carnet_patria.value);
        datos.append('codigo_carnet_patria', this.codigo_carnet_patria.value);
        datos.append('serial_carnet_patria', this.serial_carnet_patria.value);
        datos.append('beneficios_patria', this.beneficios_patria.value);

        datos.append('posee_carnet_psuv', this.posee_carnet_psuv.value);
        datos.append('codigo_carnet_psuv', this.codigo_carnet_psuv.value);
        datos.append('serial_carnet_psuv', this.serial_carnet_psuv.value);
        datos.append('beneficios_psuv', this.beneficios_psuv.value);

        datos.append('pertenece_partido_politico', this.pertenece_partido_politico.value);
        datos.append('pertenece_movimiento_social', this.pertenece_movimiento_social.value);
        datos.append('pertenece_comuna', this.pertenece_comuna.value);
        datos.append('es_vocero_comuna', this.es_vocero_comuna.value);
        datos.append('recibe_clap', this.recibe_clap.value);

        datos.append('vivienda', this.vivienda.value);
        datos.append('tipo_vivienda', this.tipo_vivienda.value);
        datos.append('posee_vehiculo', this.posee_vehiculo.value);
        datos.append('tipo_vehiculo', this.tipo_vehiculo.value);

        datos.append('usa_transporte_publico', this.usa_transporte_publico.value);
        datos.append('tipo_transporte_publico', this.tipo_transporte_publico.value);
        datos.append('ruta_trabajo', this.ruta_trabajo.value);
        datos.append('deporte_actividad_cultural', this.deporte_actividad_cultural.value);
        

        $('.loaderParent').show();

        $.ajax({
            url: 			'../modules/update-data-user/otros-datos-process.php',
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
                                    <span>Otros Datos del Empleado</span>
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
                                        <a class="activate">Actualización de Datos / Otros Datos</a>
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
                                    <h2 class="text-center">Complete el registro de otros datos en <b>"Mis Datos"</b></h2>
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