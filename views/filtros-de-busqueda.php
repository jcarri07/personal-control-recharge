<?php
    require_once '../database/conexion.php';
    //$idUser = $_SESSION["id_usuario"];

    // Verificar la conexión
    if (mysqli_connect_errno()) {
        echo "Error al conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }

    $sql = "SELECT * FROM direccion WHERE estatus = 'activo' AND nombre <> 'N/A';";
    $queryDireccion = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM unidad WHERE estatus = 'activo' AND nombre <> 'N/A';";
    $queryUnidades = mysqli_query($conn, $sql);

    /*$sql = "SELECT MAX(talla_pantalon) AS 'max_pantalon' from datos_personales;";
    $query = mysqli_query($conn, $sql);
    $max_pantalon_personal = mysqli_fetch_array($query)['max_pantalon'];*/

    $array_unidades = array();
    while($row = mysqli_fetch_array($queryUnidades)){
        $array_aux = array();
        $array_aux['id_unidad'] = $row['id_unidad'];
        $array_aux['nombre'] = $row['nombre'];
        $array_aux['id_direccion'] = $row['id_direccion'];        
        array_push($array_unidades, $array_aux);
    }


    //Permisología en caso de ser jefe de unidad o director
    $id_direccion = "";
    $id_unidad = "";

    if($_SESSION['tipo_usuario'] == "jefe" || $_SESSION['tipo_usuario'] == "Jefe"){
        $sql = "SELECT id_unidad, id_direccion
                FROM datos_abae
                WHERE id_usuario = '$_SESSION[id_usuario]';";
        $query = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($query);
        $id_direccion = $row['id_direccion'];
        $id_unidad = $row['id_unidad'];
    }

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
                                    <h4>Información de Personal</h4>
                                    <span>Búsqueda de Información</span>
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
                                        <a class="activate">Información de Personal</a>
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
                                                    <!--<form id="form-edit" class="wizard-form">-->
                                                        <div class="box-title mb-3">
                                                            <h3 id="title-section"> Personal </h3>
                                                        </div>
                                                        <!--<fieldset>-->
                                                        <div class="filtros">
                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-4">
                                                                    <label class="block">Dirección</label>
                                                                    <select name="direccion" id="direccion" class="form-control" onchange="changeDireccion();">
                                                                        <option value="">Todas</option>
<?php
                                                                    while($row = mysqli_fetch_array($queryDireccion)){
?>
                                                                        <option value="<?php echo $row['id_direccion'];?>"><?php echo $row['nombre'];?></option>
<?php
                                                                    }
?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Unidad</label>
                                                                    <select name="unidad" id="unidad" class="form-control">
                                                                        <option value="">Todas</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="block">Sexo</label>
                                                                    <select name="sexo" id="sexo" class="form-control">
                                                                        <option value="">Todos</option>
                                                                        <option value="Femenino">Femenino</option>
                                                                        <option value="Masculino">Masculino</option>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class="form-group row justify-content-center">
                                                                <div class="col">
                                                                    <label class="block">Filtro</label>
                                                                    <select name="filtro" id="filtro" class="form-control">
                                                                        <option value="empleados">Empleados</option>
                                                                        <option value="hijos">Hijos</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="block">SubFiltro</label>
                                                                    <select name="subfiltro" id="subfiltro" class="form-control">
                                                                        <option value="">Listado General</option>
                                                                        <option value="camisa">Camisa</option>
                                                                        <option value="pantalon">Pantalón</option>
                                                                        <option value="calzado">Calzado</option>
                                                                        <option value="estatura">Estatura</option>
                                                                        <option value="peso">Peso</option>
                                                                        <option value="edad">Edad</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col" style="display:none;">
                                                                    <label class="block">Valor</label>
                                                                    <select name="filtro_valor_select" id="filtro_valor_select" class="form-control">
                                                                        <option value="">Todos</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col row" id="multi-valor-filtro" style="margin-right: 5px; margin-left: 5px; display:none;">
                                                                    <label class="block col-12">Rango</label>
                                                                    <input type="number" name="desde" id="desde" class="col form-control" style="margin-right: 5px;">
                                                                    <input type="number" name="hasta" id="hasta" class="col form-control" style="margin-left: 5px;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="text-center">
                                                            <button class="btn btn-primary mt-5" style="font-size: 20px;" onclick="imprimir();">
                                                                Imprimir
                                                                <i class="feather icon-printer"></i>
                                                            </button>
                                                        </div>

                                                        
                                                        <div id="box-info">
                                                        </div>

                                                        
                                                        <!--</fieldset>-->
                                                        

                                                       <!-- <div class="row">
                                                            <div class="col-md-12 loaderParent">
                                                                <div class="loader">
                                                                </div>
                                                                Por favor, espere
                                                            </div>
                                                        </div>

                                                        <div class="text-center mt-3">
                                                            <button class="btn btn-primary">Actualizar</button>
                                                        </div>-->
                                                    <!--</form>-->
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


<script>
    var array_unidades = <?php echo json_encode($array_unidades);?>;

    $( document ).ready(function() {
        if("<?php echo $id_direccion?>" != "" && "<?php echo $id_direccion?>" != "0"){
            $("#direccion").val("<?php echo $id_direccion?>");
            $("#direccion").attr("disabled", true);
            changeDireccion();
        }

        if("<?php echo $id_unidad?>" != "" && "<?php echo $id_unidad?>" != "0"){
            $("#unidad").val("<?php echo $id_unidad?>");
            $("#unidad").attr("disabled", true);
            //$("#unidad").trigger("change");

            //Esto es el trigger pero con JavaScript sin JQuery
            var elemento = document.getElementById('unidad');
            var evento = new Event('change');
            elemento.dispatchEvent(evento);
        }
    });

    function changeDireccion(){
        $("#unidad").html("<option value=''>Todas</option>");
        if($("#direccion").val() != ""){
            for(var i = 0 ; i < array_unidades.length ; i++){
                if(array_unidades[i]['id_direccion'] == $("#direccion").val()){
                    $("#unidad").append("<option value='" + array_unidades[i]['id_unidad'] + "'>" + array_unidades[i]['nombre'] + "</option>");
                }
            }
        }
    }

    /*$("#subfiltro").on("change", function(){
        if(this.value == "peso" || this.value == "edad" || this.value == "estatura" || this.value == "calzado"){
            $("#multi-valor-filtro").show();
            $("#filtro_valor_select").closest(".col").hide();
        }
        else{
            $("#multi-valor-filtro").hide();
            $("#filtro_valor_select").closest(".col").show();
        }
    });*/

    $(".filtros select").on("change", function(){
        getTable(this);
    });

    $(".filtros input").on("keyup", function(){
        getTable(this);
    });

    $( document ).ready(function() {
        getTable("");
    });

    function getTable(element){
        if(element.id == "filtro"){
            if(element.value == "hijos")
                $("#title-section").text("Hijos");
            else
                $("#title-section").text("Personal");
        }

        if(element.id == "subfiltro" && (element.value == "estatura" || element.value == "peso")){
            $("#filtro").val("empleados");
            $("#filtro").attr("disabled", true);
        }
        else{
            $("#filtro").attr("disabled", false);
        }

        if(element.id == "filtro" || element.id == "subfiltro"){
            if($("#subfiltro").val() == ""){
                $("#multi-valor-filtro").hide();
                $("#filtro_valor_select").closest(".col").hide();

                $("#filtro_valor_select").val("");
                $("#multi-valor-filtro #desde").val("");
                $("#multi-valor-filtro #hasta").val("");
            }
            else{
                if( ($("#subfiltro").val() == "pantalon" && $("#filtro").val() == "empleados" ) || $("#subfiltro").val() == "peso" || $("#subfiltro").val() == "edad" || $("#subfiltro").val() == "estatura" || $("#subfiltro").val() == "calzado"){
                    $("#multi-valor-filtro").show();
                    $("#filtro_valor_select").closest(".col").hide();

                    $("#filtro_valor_select").val("");
                }
                else{
                    $("#multi-valor-filtro").hide();
                    $("#filtro_valor_select").closest(".col").show();

                    $("#multi-valor-filtro #desde").val("");
                    $("#multi-valor-filtro #hasta").val("");
                }
            }

            if($("#subfiltro").val() == "camisa" || ($("#subfiltro").val() == "pantalon" && $("#filtro").val() == "hijos")){
                var array = ["S", "M", "L", "XL", "XXL"];
                $("#filtro_valor_select").html("<option value=''>Todos</option>");
                for(var i = 0 ; i < array.length ; i++){
                    $("#filtro_valor_select").append("<option value='" + array[i] + "'>" + array[i] + "</option>");
                }
            }
        }

        


        $("#box-info").html("<h2 class='text-center'>Cargando...</h2>");

        var datos = new FormData();
        //datos.append('id', '<?php echo $idUser;?>');
        datos.append('direccion', $("#direccion").val());
        datos.append('unidad', $("#unidad").val());
        datos.append('sexo', $("#sexo").val());
        datos.append('filtro', $("#filtro").val());
        datos.append('subfiltro', $("#subfiltro").val());
        datos.append('filtro_valor_select', $("#filtro_valor_select").val());
        datos.append('desde', $("#desde").val());
        datos.append('hasta', $("#hasta").val());

        $.ajax({
            url: 			'../views/get-tabla-busqueda.php',
            type:			'POST',
            data:			datos,
            cache:          false,
            contentType:    false,
            processData:    false,
            success: function(response){ //console.log(response);
                //$('.loaderParent').hide();
                $("#box-info").html(response);
                iniciarTabla("row-select");
            }
            ,
            error: function(response){
            }
        });
    }

    function imprimir(){
        url = "../php/reportes/imprimir-pdf-personal.php";

        url += "?direccion=" + $("#direccion").val();
        url += "&unidad=" + $("#unidad").val();
        url += "&sexo=" + $("#sexo").val();
        url += "&filtro=" + $("#filtro").val();
        url += "&subfiltro=" + $("#subfiltro").val();
        url += "&filtro_valor_select=" + $("#filtro_valor_select").val();
        url += "&desde=" + $("#desde").val();
        url += "&hasta=" + $("#hasta").val();

        //console.log(url);


        window.open(url);
    }
</script>