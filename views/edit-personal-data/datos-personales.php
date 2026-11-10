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

$sql = "SELECT * FROM datos_personales WHERE id_usuario = '$idUser' LIMIT 1;";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
    $datos_personales_detalles = mysqli_fetch_array($query);

    $sql = "SELECT id_datos_hijos FROM datos_hijos WHERE id_usuario = '$idUser';";
    $queryHijos = mysqli_query($conn, $sql);
    $numero_hijos = mysqli_num_rows($queryHijos);

    $sql = "SELECT * FROM estados;";
    $queryEstados = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM municipios;";
    $queryMunicipios = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM parroquias;";
    $queryParroquias = mysqli_query($conn, $sql);

    closeConection($conn);

    $array_municipios = array();
    while ($row = mysqli_fetch_array($queryMunicipios)) {
        $array_aux = array();
        $array_aux['id_municipio'] = $row['id_municipio'];
        $array_aux['municipio'] = $row['municipio'];
        $array_aux['id_estado'] = $row['id_estado'];
        array_push($array_municipios, $array_aux);
    }

    $array_parroquias = array();
    while ($row = mysqli_fetch_array($queryParroquias)) {
        $array_aux = array();
        $array_aux['id_parroquia'] = $row['id_parroquia'];
        $array_aux['id_municipio'] = $row['id_municipio'];
        $array_aux['parroquia'] = $row['parroquia'];
        array_push($array_parroquias, $array_aux);
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
                                        <span>Datos Personales</span>
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
                                            <a class="activate">Actualización de Datos / Personales</a>
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
                                                        <form id="form-edit" class="wizard-form" method="POST" action=""
                                                            enctype="multipart/form-data">
                                                            <div class="row m-b-30">
                                                                <div class="col-lg-12 col-xl-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-xl-12">
                                                                            <!-- Nav tabs internos -->
                                                                            <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link active" data-toggle="tab" href="#dp-personales" role="tab" style="text-align: left; margin-left: 10px; margin-right: 100px;">Datos Personales</a>
                                                                                    <div class="slide"></div>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#dp-direccion" role="tab" style="text-align: left; margin-left: 10px;">Dirección y Contacto</a>
                                                                                    <div class="slide"></div>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#dp-medicos" role="tab" style="text-align: left; margin-left: 10px;">Datos Médicos</a>
                                                                                    <div class="slide"></div>
                                                                                </li>
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link" data-toggle="tab" href="#dp-finales" role="tab" style="text-align: left; margin-left: 10px;">Datos Finales</a>
                                                                                    <div class="slide"></div>
                                                                                </li>
                                                                            </ul>

                                                                            <!-- Tab panes -->
                                                                            <div class="tab-content tabs-left-content container-fluid" style="height: 520px; overflow-y: auto; overflow-x: hidden;">

                                                                                <!-- ==================== TAB 1: DATOS PERSONALES ==================== -->
                                                                                <div class="tab-pane active" id="dp-personales" role="tabpanel">
                                                                                    <div style="display: flex; justify-content: flex-start; padding-left: 20px; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px; margin-top: 20px;">
                                                                                        <p style="color: white; margin-top: 15px; font-size: 16px; font-weight: bold;">Datos Personales</p>
                                                                                    </div>
                                                                                    <div class="form-group row justify-content-center">
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Nombres</label>
                                                                                            <input id="nameEmployeer" name="nameEmployeer"
                                                                                                type="text" class="required form-control"
                                                                                                value="<?php echo $fila['nombres']; ?>" required
                                                                                                maxlength="50">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Apellidos</label>
                                                                                            <input id="lastNameEmployeer" name="lastNameEmployeer"
                                                                                                type="text" class="required form-control"
                                                                                                value="<?php echo $fila['apellidos']; ?>" required
                                                                                                maxlength="50">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Cédula de Identidad</label>
                                                                                            <input name="ciEmployeer" type="number"
                                                                                                class="required form-control"
                                                                                                value="<?php echo $fila['cedula'] ?>" required
                                                                                                maxlength="20">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Correo</label>
                                                                                            <input name="email" type="email"
                                                                                                class="required form-control"
                                                                                                value="<?php echo $fila['correo'] ?>" required
                                                                                                maxlength="200">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">R.I.F</label>
                                                                                            <input name="rifEmployeer" type="text"
                                                                                                class="form-control required"
                                                                                                value="<?php echo $datos_personales_detalles['rif']; ?>"
                                                                                                maxlength="20">
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Lugar de Nacimiento</label>
                                                                                            <input name="birthPlace" type="text"
                                                                                                class="form-control required"
                                                                                                value="<?php echo $datos_personales_detalles['lugar_nacimiento']; ?>"
                                                                                                maxlength="100" required>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Fecha de Nacimiento</label>
                                                                                            <input name="birthday" id="birthday" type="date"
                                                                                                class="form-control required"
                                                                                                onchange="calculateAge('birthday','age')"
                                                                                                value="<?php echo $datos_personales_detalles['fecha_nacimiento']; ?>"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Edad</label>
                                                                                            <input name="ageEmployeer" id="age" type="text"
                                                                                                class="form-control required" value="" readonly>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Sexo</label>
                                                                                            <select class="form-control required" id="gender"
                                                                                                name="gender" onchange="womanInformation(this)">
                                                                                                <option value="N/A">Seleccione</option>
                                                                                                <option value="Femenino">Femenino</option>
                                                                                                <option value="Masculino">Masculino</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <label class="block">Estado Civil</label>
                                                                                            <select class="form-control required" id="status"
                                                                                                name="status" onchange="hideMarriedInformation()">
                                                                                                <option value="N/A">Seleccione</option>
                                                                                                <option value="Soltero(a)">Soltero(a)</option>
                                                                                                <option value="Conyugue">Concubinato</option>
                                                                                                <option value="Casado(a)">Casado(a)</option>
                                                                                                <option value="Anulado">Divorciado(a)</option>
                                                                                                <option value="Viudo(a)">Viudo(a)</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-4" id="divSpouse">
                                                                                            <label for="datejoin" class="block">Nombre del Cónyuge</label>
                                                                                            <input name="spouse" type="text" id="spouse"
                                                                                                class="form-control"
                                                                                                value="<?php echo $datos_personales_detalles['nombre_conyugue']; ?>"
                                                                                                maxlength="200">
                                                                                        </div>
                                                                                        <div class="col-md-4 mb-3">
                                                                                            <label for="datejoin" class="block">Número de Hijos</label>
                                                                                            <input name="childrens" id="childrens" type="number"
                                                                                                class="form-control required" readonly
                                                                                                value="<?php echo $datos_personales_detalles['cantidad_hijos']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- ==================== TAB 2: DIRECCIÓN Y CONTACTO ==================== -->
                                                                                <div class="tab-pane" id="dp-direccion" role="tabpanel">
                                                                                    <div style="display: flex; justify-content: flex-start; padding-left: 20px; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px; margin-top: 20px;">
                                                                                        <p style="color: white; margin-top: 15px; font-size: 16px; font-weight: bold;">Dirección y Contacto</p>
                                                                                    </div>
                                                                                    <fieldset>
                                                                                        <div class="form-group row justify-content-center">
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Estado</label>
                                                                                                <select class="form-control required" name="state"
                                                                                                    id="estado" onchange="changeEstado();">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <?php
                                                                                                    while ($row = mysqli_fetch_array($queryEstados)) {
                                                                                                        ?>
                                                                                                        <option
                                                                                                            value="<?php echo $row['id_estado']; ?>">
                                                                                                            <?php echo $row['estado']; ?>
                                                                                                        </option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Municipio</label>
                                                                                                <select class="form-control required"
                                                                                                    name="municipality" id="ciudad"
                                                                                                    onchange="changeCiudad();">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Parroquia</label>
                                                                                                <select class="form-control required"
                                                                                                    name="parroquia" id="parroquia">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Dirección de Domicilio</label>
                                                                                                <input name="address" type="text"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['domicilio']; ?>"
                                                                                                    maxlength="100">
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Teléfono de Habitación</label>
                                                                                                <input name="phone" type="number"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['telefono_habitacion']; ?>"
                                                                                                    maxlength="20">
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <label class="block">Teléfono Móvil</label>
                                                                                                <input name="cellphone" type="number"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['telefono_movil']; ?>"
                                                                                                    maxlength="20">
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label class="block">Teléfono de Emergencia</label>
                                                                                                <input name="emergencyPhone" type="number"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['telefono_emergencia']; ?>"
                                                                                                    maxlength="50">
                                                                                            </div>
                                                                                            <div class="col-md-6">
                                                                                                <label class="block">Nombre de Emergencia</label>
                                                                                                <input name="emergencyContact" type="text"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['contacto_emergencia']; ?>"
                                                                                                    maxlength="50">
                                                                                            </div>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>

                                                                                <!-- ==================== TAB 3: DATOS MÉDICOS ==================== -->
                                                                                <div class="tab-pane" id="dp-medicos" role="tabpanel">
                                                                                    <div style="display: flex; justify-content: flex-start; padding-left: 20px; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px; margin-top: 20px;">
                                                                                        <p style="color: white; margin-top: 15px; font-size: 16px; font-weight: bold;">Datos Médicos</p>
                                                                                    </div>
                                                                                    <fieldset>
                                                                                        <div class="form-group row justify-content-center">
                                                                                            <div class="col-md-12 mb-3">
                                                                                                <label for="University-2" class="block">Alergias</label>
                                                                                                <input name="alergy" type="text"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['alergias']; ?>"
                                                                                                    maxlength="200">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="" class="block">Grupo Sanguíneo</label>
                                                                                                <select class="form-control required"
                                                                                                    name="bloodType" id="bloodType">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <option value="O-">O-</option>
                                                                                                    <option value="O+">O+</option>
                                                                                                    <option value="A-">A-</option>
                                                                                                    <option value="A+">A+</option>
                                                                                                    <option value="B-">B-</option>
                                                                                                    <option value="B+">B+</option>
                                                                                                    <option value="AB-">AB-</option>
                                                                                                    <option value="AB+">AB+</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="perfilDominante" class="block">Perfil Dominante</label>
                                                                                                <select class="form-control required"
                                                                                                    name="perfilDominante" id="perfilDominante">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <option value="Diestro">Diestro</option>
                                                                                                    <option value="Zurdo">Zurdo</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="" class="block">Enfermedad Crónica</label>
                                                                                                <select class="form-control required"
                                                                                                    name="chronicDisease" id="chronicDisease"
                                                                                                    onchange="chronicFunction(this);">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <option value="Si">Si</option>
                                                                                                    <option value="No">No</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-12 mb-3">
                                                                                                <label for="datejoin" class="block">Tipo de Enfermedad</label>
                                                                                                <input name="chronic" id='chronicInput' type="text"
                                                                                                    class="form-control" maxlength="200" placeholder="Especifique la enfermedad crónica">
                                                                                            </div>
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="" class="block" value="0">Estado de Embarazo</label>
                                                                                                <select class="form-control" id="pregnant"
                                                                                                    name="pregnant" onchange="hideGestation(this)">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <option value="Si">Si</option>
                                                                                                    <option value="No">No</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="" class="block">Meses de Gestación</label>
                                                                                                <select class="form-control" id="gestation"
                                                                                                    name="gestation">
                                                                                                    <option value="0">Seleccione</option>
                                                                                                    <option value="1">1</option>
                                                                                                    <option value="2">2</option>
                                                                                                    <option value="3">3</option>
                                                                                                    <option value="4">4</option>
                                                                                                    <option value="5">5</option>
                                                                                                    <option value="6">6</option>
                                                                                                    <option value="7">7</option>
                                                                                                    <option value="8">8</option>
                                                                                                    <option value="9">9</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </div>

                                                                                <!-- ==================== TAB 4: DATOS FINALES ==================== -->
                                                                                <div class="tab-pane" id="dp-finales" role="tabpanel">
                                                                                    <div style="display: flex; justify-content: flex-start; padding-left: 20px; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px; margin-top: 20px;">
                                                                                        <p style="color: white; margin-top: 15px; font-size: 16px; font-weight: bold;">Datos Finales</p>
                                                                                    </div>
                                                                                    <fieldset>
                                                                                        <div class="form-group row justify-content-center">
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="" class="block">Talla de Camisa</label>
                                                                                                <select class="form-control required"
                                                                                                    name="shirtSizes" id="shirtSizes">
                                                                                                    <option value="N/A">Seleccione</option>
                                                                                                    <option value="XS">XS</option>
                                                                                                    <option value="S">S</option>
                                                                                                    <option value="M">M</option>
                                                                                                    <option value="L">L</option>
                                                                                                    <option value="XL">XL</option>
                                                                                                    <option value="2XL">2XL</option>
                                                                                                    <option value="3XL">3XL</option>
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="surname-2" class="block">Talla de Pantalón</label>
                                                                                                <input name="jeansSizes" type="number"
                                                                                                    class="form-control required"
                                                                                                    value="<?php echo $datos_personales_detalles['talla_pantalon']; ?>"
                                                                                                    maxlength="10">
                                                                                            </div>
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="phone-2" class="block">Talla de Calzado</label>
                                                                                                <input name="shoesSizes" type="number"
                                                                                                    class="form-control required phone"
                                                                                                    value="<?php echo $datos_personales_detalles['talla_calzado']; ?>"
                                                                                                    maxlength="10">
                                                                                            </div>
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="date" class="block">Estatura (m)</label>
                                                                                                <input name="stature" type="number"
                                                                                                    class="form-control required date-control"
                                                                                                    value="<?php echo $datos_personales_detalles['estatura']; ?>"
                                                                                                    step="0.01" maxlength="10">
                                                                                            </div>
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="date" class="block">Peso (Kg)</label>
                                                                                                <input name="weight" type="number"
                                                                                                    class="form-control required date-control"
                                                                                                    value="<?php echo $datos_personales_detalles['peso']; ?>"
                                                                                                    maxlength="10">
                                                                                            </div>
                                                                                            
                                                                                            <!-- Imágenes Modernas -->
                                                                                            <div class="col-md-6 mb-4 d-flex flex-column align-items-center mt-3">
                                                                                                <label class="block font-weight-bold mb-3 text-uppercase text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">Firma Digital</label>
                                                                                                
                                                                                                <div class="box-img firma d-flex align-items-center justify-content-center" style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 12px; width: 100%; max-width: 260px; height: 120px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                                                                                    <img src="../assets/firmas-images/<?php echo $datos_personales_detalles['firma']; ?>" style="max-width: 90%; max-height: 90px; object-fit: contain;">
                                                                                                </div>
                                                                                                
                                                                                                <div class="box-img preview firma align-items-center justify-content-center" style="display: none; background-color: #f8f9fa; border: 2px dashed #00a9ac; border-radius: 12px; width: 100%; max-width: 260px; height: 120px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);"></div>
                                                                                                
                                                                                                <div class="mt-3 w-100 text-center" style="max-width: 260px;">
                                                                                                    <label for="firm" class="btn btn-outline-info btn-sm waves-effect" style="cursor: pointer; border-radius: 20px; font-weight: bold; padding: 5px 15px; border: 2px solid #00a9ac; color: #00a9ac;">
                                                                                                        <i class="feather icon-upload"></i> Cargar Firma
                                                                                                    </label>
                                                                                                    <input name="firm" id="firm" type="file" style="display: none;" accept="image/jpeg, image/jpg, image/png">
                                                                                                    <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">Formatos: JPG, PNG. Ideal: 300x150</small>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            <div class="col-md-6 mb-4 d-flex flex-column align-items-center">
                                                                                                <label class="block font-weight-bold mb-3 text-uppercase text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">Foto de Perfil</label>
                                                                                                
                                                                                                <div class="box-img foto">
                                                                                                    <img src="../assets/empleados-images/<?php echo $datos_personales_detalles['foto']; ?>" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 6px 15px rgba(0,169,172,0.3);">
                                                                                                </div>
                                                                                                
                                                                                                <div class="box-img preview foto" style="display: none;"></div>
                                                                                                
                                                                                                <div class="mt-4 w-100 text-center" style="max-width: 260px;">
                                                                                                    <label for="photoEmployeer" class="btn btn-outline-info btn-sm waves-effect" style="cursor: pointer; border-radius: 20px; font-weight: bold; padding: 5px 15px; border: 2px solid #00a9ac; color: #00a9ac;">
                                                                                                        <i class="feather icon-camera"></i> Cargar Foto
                                                                                                    </label>
                                                                                                    <input name="photoEmployeer" id="photoEmployeer" type="file" style="display: none;" accept="image/jpeg, image/jpg, image/png">
                                                                                                    <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">Formatos: JPG, PNG. Foto frontal</small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                </div>
                                                                                <!-- fin tab-pane finales -->

                                                                            </div>
                                                                            
                                                                            <!-- Submit Button and Loader Outside Tabs -->
                                                                            <div class="mt-4 pt-3" style="border-top: 1px solid #eee;">
                                                                                <div class="row">
                                                                                    <div class="col-md-12 loaderParent text-center" style="display: none;">
                                                                                        <div class="loader" style="margin: 0 auto;"></div>
                                                                                        <p class="mt-2">Por favor, espere...</p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-center mt-2 mb-4">
                                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Actualizar Datos</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
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
    </div>


    <script src="../utils/functions-personal-data.js"></script>


    <script>
        var array_municipios = <?php echo json_encode($array_municipios); ?>;
        var array_parroquias = <?php echo json_encode($array_parroquias); ?>;

        $(document).ready(function () {
            $("#birthday").trigger("change");

            $("#gender").val("<?php echo $datos_personales_detalles['sexo']; ?>");
            $("#status").val("<?php echo $datos_personales_detalles['estado_civil']; ?>");
            $("#status").trigger("change");
            if ("<?php echo $datos_personales_detalles['estado_civil']; ?>" == "N/A" ||
                "<?php echo $datos_personales_detalles['estado_civil']; ?>" == "Soltero(a)" ||
                "<?php echo $datos_personales_detalles['estado_civil']; ?>" == "Anulado" ||
                "<?php echo $datos_personales_detalles['estado_civil']; ?>" == "Viudo(a)"
            ) {
                $("#spouse").parent().hide();
            }

            var id_estado;
            for (var i = 0; i < array_municipios.length; i++) {
                if (array_municipios[i]['id_municipio'] == '<?php echo $datos_personales_detalles['id_municipio']; ?>') {
                    id_estado = array_municipios[i]['id_estado'];
                    break;
                }
            }
            $("#estado").val(id_estado);
            //$("#estado").trigger("change");
            changeEstado();
            /*for(var i = 0 ; i < array_municipios.length ; i++){
                if(array_municipios[i]['id_estado'] == id_estado){
                    $("#ciudad").append("<option value='" + array_municipios[i]['id_municipio'] + "'>" + array_municipios[i]['municipio'] + "</option>");
                }
            }*/
            $("#ciudad").val('<?php echo $datos_personales_detalles['id_municipio']; ?>');
            changeCiudad();
            $("#parroquia").val('<?php echo $datos_personales_detalles['parroquia']; ?>');

            $("#bloodType").val('<?php echo $datos_personales_detalles['tipo_sangre']; ?>');
            $("#chronicDisease").val('<?php echo $datos_personales_detalles['padece_enfermedad_cronica']; ?>');

            if ('<?php echo $datos_personales_detalles['padece_enfermedad_cronica']; ?>' == "Si")
                $("#chronicInput").val('<?php echo $datos_personales_detalles['enfermedad_cronica']; ?>');

            $("#perfilDominante").val("<?php echo $datos_personales_detalles['perfil_dominante']; ?>");
            $("#childrens").val('<?php echo $numero_hijos; ?>');
            $("#pregnant").val("<?php echo $datos_personales_detalles['esta_embarazada']; ?>");
            $("#gestation").val("<?php echo $datos_personales_detalles['meses_gestacion']; ?>");
            $("#shirtSizes").val("<?php echo $datos_personales_detalles['talla_camisa']; ?>");

            $("#gender").trigger("change");

            if ($("#gender").val() == "Femenino")
                $("#pregnant").trigger("change");

            $("#chronicDisease").trigger("change");
        });

        $("#status").on("change", function () {
            console.log(this.value);
            if (this.value == "N/A" ||
                this.value == "Soltero(a)" ||
                this.value == "Anulado" ||
                this.value == "Viudo(a)"
            ) {
                $("#spouse").parent().hide();
            }
            else {
                $("#spouse").parent().show();
            }
        });


        //$("#estado").on("change", function() {
        function changeEstado() {
            if ($("#estado").val() == "N/A") {
                $("#ciudad").html("<option value=''>Seleccione</option>");
                $("#parroquia").html("<option value=''>Seleccione</option>");
            }
            else {
                $("#ciudad").html("<option value=''>Seleccione</option>");
                for (var i = 0; i < array_municipios.length; i++) {
                    if (array_municipios[i]['id_estado'] == $("#estado").val()) {
                        $("#ciudad").append("<option value='" + array_municipios[i]['id_municipio'] + "'>" + array_municipios[i]['municipio'] + "</option>");
                    }
                }
                $("#parroquia").html("<option value=''>Seleccione</option>");
            }
            //});
        }

        function changeCiudad() {
            if ($("#ciudad").val() == "N/A")
                $("#parroquia").html("<option value=''>Seleccione</option>");
            else {
                $("#parroquia").html("<option value=''>Seleccione</option>");
                for (var i = 0; i < array_parroquias.length; i++) {
                    if (array_parroquias[i]['id_municipio'] == $("#ciudad").val()) {
                        $("#parroquia").append("<option value='" + array_parroquias[i]['id_parroquia'] + "'>" + array_parroquias[i]['parroquia'] + "</option>");
                    }
                }
            }
        }

        //Ocultar informacion femenina
        function womanInformation(select) {
            if (select.value == "Masculino") {
                $("#pregnant").parent().hide();
                $("#gestation").parent().hide();
            } else {
                $("#pregnant").parent().show();
                $("#gestation").parent().show();
            }
        }

        function hideGestation(select) {
            if (select.value == "No" || select.value == "N/A") {
                $("#gestation").val("0");
                $("#gestation").parent().hide();
            }
            else {
                $("#gestation").parent().show();
            }
        }

        function chronicFunction(select) {
            if (select.value == "No") {
                $("#chronicInput").val("");
                $("#chronicInput").parent().hide();
            } else {
                //$("#chronicInput").val("");
                $("#chronicInput").parent().show();
            }
        }

        $(document).on('change', "#photoEmployeer, #firm", function () {
            if (this.files && this.files[0]) {

                array_img = [];

                //Funcion dentro del archivo reducir_imagen.js
                //reduce_image(this.files[0], 0, 0, false, array_img);

                var div = "";
                if (this.id == "firm") {
                    div = ".preview.firma";
                }
                if (this.id == "photoEmployeer") {
                    div = ".preview.foto";
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    $(div).empty();
                    
                    if (div === '.preview.foto') {
                        $(div).append($('<img>', {
                            src: e.target.result,
                            style: 'width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0 6px 15px rgba(0,169,172,0.3);'
                        }));
                    } else {
                        $(div).append($('<img>', {
                            src: e.target.result,
                            style: 'max-width: 90%; max-height: 90px; object-fit: contain;'
                        }));
                    }
                    
                    $(div).css('display', 'flex');
                    if (div === '.preview.firma') {
                        $('.box-img.firma').not('.preview').hide();
                    } else if (div === '.preview.foto') {
                        $('.box-img.foto').not('.preview').hide();
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        $("#form-edit").on("submit", function (event) {
            event.preventDefault();

            var datos = new FormData();
            datos.append('id', '<?php echo $idUser; ?>');
            datos.append('opc', 'edit');

            datos.append('nombre', this.nameEmployeer.value);
            datos.append('apellido', this.lastNameEmployeer.value);
            datos.append('cedula', this.ciEmployeer.value);
            datos.append('correo', this.email.value);

            datos.append('rif', this.rifEmployeer.value);
            datos.append('lugar_nacimiento', this.birthPlace.value);
            datos.append('fecha_nacimiento', this.birthday.value);
            datos.append('sexo', this.gender.value);
            datos.append('estado_civil', this.status.value);

            datos.append('municipio', this.municipality.value);
            datos.append('direccion_domicilio', this.address.value);
            datos.append('telefono', this.phone.value);
            datos.append('celular', this.cellphone.value);
            datos.append('telefono_emergencia', this.emergencyPhone.value);
            datos.append('nombre_contacto_emergencia', this.emergencyContact.value);

            datos.append('alergias', this.alergy.value);
            datos.append('tipo_sangre', this.bloodType.value);
            datos.append('padece_enfermedad_cronica', this.chronicDisease.value);
            datos.append('describa_enfermedad_cronica', this.chronicInput.value);
            datos.append('nombre_conyugue', $("#spouse").val());
            datos.append('perfil_dominante', this.perfilDominante.value);
            datos.append('esta_embarazada', this.pregnant.value);
            datos.append('meses_gestacion', this.gestation.value);

            datos.append('talla_camisa', this.shirtSizes.value);
            datos.append('talla_pantalon', this.jeansSizes.value);
            datos.append('talla_calzado', this.shoesSizes.value);
            datos.append('estatura', this.stature.value);
            datos.append('peso', this.weight.value);

            datos.append('firma', $(this.firm)[0].files[0]);
            datos.append('foto', $(this.photoEmployeer)[0].files[0]);

            $('.loaderParent').show();

            $.ajax({
                url: '../modules/update-data-user/datos-personales-process.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) { //console.log(response);
                    $('.loaderParent').hide();
                    if (response == 'si') {
                        //alertify.success("Bello."); 
                        $("#modal-generic .message").text("Actualización Exitosa");
                        $("#modal-generic .aceptar button").attr("onclick", "window.location.reload();");
                        $("#modal-generic").modal("show");
                    }
                    else {
                        $("#modal-generic .aceptar button").attr("onclick", "");
                        if (response == "vacio") {
                            //alertify.warning("Datos vacíos o sin modificación.");
                            $("#modal-generic .message").text("Datos vacíos o sin modificación");
                            $("#modal-generic").modal("show");

                        }
                        else {
                            //alertify.error("Error al registrar.");
                            $("#modal-generic .message").text("Error al registrar");
                            $("#modal-generic").modal("show");
                        }
                    }
                }
                ,
                error: function (response) {
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
                                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal"
                                                data-target="#modal-generic">Aceptar</button>
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
} else {
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
                                        <span>Datos Personales</span>
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
                                            <a class="activate">Actualización de Datos / Personales</a>
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
                                        <h2 class="text-center">Complete el Registro de Datos Personales en <b>"Mis
                                                Datos"</b></h2>
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
