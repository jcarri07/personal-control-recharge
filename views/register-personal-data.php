<?php
require_once '../database/conexion.php';
$step = 0;
$idUser = $_SESSION["id_usuario"];

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Preparar la consulta SQL
$sql = "SELECT * FROM usuario WHERE id_usuario = '$idUser' LIMIT 1";

// Ejecutar la consulta SQL
$resultado = mysqli_query($conn, $sql);
$fila = mysqli_fetch_assoc($resultado);
$step = $fila['step'];

$queryEstados = mysqli_query($conn, "SELECT * FROM estados;");
$queryPaises = mysqli_query($conn, "SELECT * FROM paises;");

$querySedes = mysqli_query($conn, "SELECT * FROM sede;");
$queryDirecciones = mysqli_query($conn, "SELECT * FROM direccion;");
$queryJefes = mysqli_query($conn, "SELECT u.id_usuario, u.nombres, u.apellidos, d.cargo
FROM usuario u
JOIN datos_abae d ON u.id_usuario = d.id_usuario
WHERE d.cargo IN ('Jefe', 'Director', 'Vicepresidente', 'Presidente');");

closeConection($conn);
?>
<!DOCTYPE html>

<head>
    <title></title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></scr>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\bootstrap\css\bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\themify-icons\themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\icofont\css\icofont.css">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\feather\css\feather.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\font-awesome\css\font-awesome.min.css">
    <!--forms-wizard css-->
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\jquery.steps\css\jquery.steps.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
    <link href="../assets/select2-4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="../assets/select2-4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- <link href="path/to/select2.min.css" rel="stylesheet" /> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="@sweetalert2/theme-bulma/bulma.css">
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->

    <div class="container-fluid">
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-header start -->
                    <div class="page-header">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <div class="d-inline">
                                        <h4>Mis Datos</h4>
                                        <span>Formulario de Registro</span>
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
                                            <a class="activate">Mis Datos</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-header end -->

                    <!-- Material tab card start -->
                    <div class="card">
                        <div class="card-block">
                            <!-- Row start -->
                            <div class="row m-b-30">
                                <div class="col-lg-12 col-xl-12">
                                    <!-- Row start -->
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs md-tabs tabs-left b-none" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home5" role="tab" style="text-align: left; margin-left: 10px; margin-right: 100px;" id="tab-personales">Personales</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#profile5" role="tab" style="text-align: left; margin-left: 10px;" id="tab-hijos">Hijos</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#messages5" role="tab" style="text-align: left; margin-left: 10px;" id="tab-familiares">Familiares</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings6" role="tab" style="text-align: left; margin-left: 10px;" id="tab-academicos">Académicos</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings7" role="tab" style="text-align: left; margin-left: 10px;" id="tab-exterior">Formación exterior</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings8" role="tab" style="text-align: left; margin-left: 10px;" id="tab-experiencia">Experiencia laboral</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings9" role="tab" style="text-align: left; margin-left: 10px;" id="tab-institucionales">Institucionales</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings10" role="tab" style="text-align: left; margin-left: 10px;" id="tab-comision">Comision de servicio</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings11" role="tab" style="text-align: left; margin-left: 10px;" id="tab-otros">Otros datos</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#settings12" role="tab" style="text-align: left; margin-left: 10px;" id="tab-finish">Registro Completado</a>
                                                    <div class="slide"></div>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content tabs-left-content container-fluid">
                                                <div class="tab-pane active" id="home5" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form id="example-advanced-form" class="wizard-form" method="POST" action="../modules/register-data-user/proses.php?act=insertPersonalData" enctype="multipart/form-data">
                                                                                            <h3> Datos Personales </h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Nombres y Apellidos</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input id="nameEmployeer" name="nameEmployeer" type="text" class="required form-control" value="<?php echo $fila['nombres'] . " " . $fila['apellidos'] ?>" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Cédula de Identidad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="ciEmployeer" type="number" class="required form-control" value="<?php echo $fila['cedula'] ?>" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">R.I.F</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="rifEmployeer" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Lugar de Nacimiento</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="birthPlace" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Fecha de Nacimiento</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="birthday" id="birthday" type="date" class="form-control required" onchange="calculateAge('birthday','age')" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Edad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="ageEmployeer" id="age" type="text" class="form-control required" value="" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Sexo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="gender" name="genderEmployeer" onchange="womanInformation()" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <option value="Femenino">Femenino</option>
                                                                                                            <option value="Masculino">Masculino</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Estado Civil</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="status" name="statusEmployeer" onchange="hideMarriedInformation()" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <option value="Soltero(a)">Soltero(a)</option>
                                                                                                            <option value="Conyugue">Concubinato</option>
                                                                                                            <option value="Casado(a)">Casado(a)</option>
                                                                                                            <option value="Anulado">Divorciado(a)</option>
                                                                                                            <option value="Viudo(a)">Viudo(a)</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" style="bottom: 150px" id="divSpouse">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="datejoin" class="block">Nombre del Conyugue</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="spouse" type="text" id="spouse" class="form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3> Dirección y Contacto </h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Estado</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="state" id="estado" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <?php
                                                                                                            while ($row = mysqli_fetch_array($queryEstados)) {
                                                                                                            ?>
                                                                                                                <option value="<?php echo $row['id_estado']; ?>"><?php echo $row['estado']; ?></option>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Municipio</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="municipality" id="ciudad" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Parroquia</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="parroquia" id="parroquia" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Dirección de Domicilio</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="address" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Teléfono de Habitación</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="phone" type="number" class="form-control ">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Teléfono Móvil</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="cellphone" type="number" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Teléfono de Emergencia</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="emergencyPhone" type="number" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Nombre de Emergencia</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="emergencyContact" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3> Datos Médicos </h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="University-2" class="block">Alergias</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="alergy" type="text" class="form-control ">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Grupo Sanguineo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="bloodType" required>
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
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Enfermedad Crónica</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="chronicDisease" id="chronicDisease" onchange="chronicFunction()">
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                            <option value="No">No</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="chronicDiv">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="datejoin" class="block">Tipo de Enfermedad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="chronic" id='chronicInput' type="text" class="form-control">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Perfil Dominante</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="perfilDominante" required>
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <option value="Diestro">Diestro</option>
                                                                                                            <option value="Zurdo">Zurdo</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <!-- <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="datejoin" class="block">Numero de Hijos</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="childrens" id="childrens" type="number" value="0" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div> -->
                                                                                                <div class="form-group row" id="divPregnant">
                                                                                                    <div class="col-md-4 col-lg-2">Estado de Embarazo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control" id="pregnant" name="pregnant" onchange="hideGestation()">
                                                                                                            <option value="N/A">Seleccione</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                            <option value="No">No</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="divGestation">
                                                                                                    <div class="col-md-4 col-lg-2">Meses de Gestación</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control" id="gestation" name="gestation">
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
                                                                                            <h3> Datos Finales</h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Talla de Camisa</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="shirtSizes" required>
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
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="surname-2" class="block">Talla de Pantalón</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="jeansSizes" type="number" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="phone-2" class="block">Talla de Calzado</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="shoesSizes" type="number" class="form-control required phone" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="date" class="block">Estatura (m)</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="stature" type="number" class="form-control required date-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="date" class="block">Peso (Kg)</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="weight" type="number" class="form-control required date-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="date" class="block">Firma Digital</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="firm" type="file" class="form-control required date-control" accept="image/jpeg, image/jpg, image/png" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="date" class="block">Foto del Empleado</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="photoEmployeer" type="file" class="form-control required date-control" accept="image/jpeg, image/jpg, image/png" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="profile5" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="form-children" method="POST" action="../modules/register-data-user/proses.php?act=insertChildrenData" enctype="multipart/form-data">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos de Hijos</p>
                                                                                            </div>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="userName-2" class="block">Nombres y Apellidos</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input id="employeerName-children" name="employeerName-children" type="text" class="required form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Cédula de Identidad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="ci-children" type="number" class=" form-control">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Fecha de Nacimiento</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="birthDate-children" id="birthDate-children" type="date" class="form-control required" onchange="calculateAge('birthDate-children', 'age-children')" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Edad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="age-children" id="age-children" type="text" class="form-control required" value="" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Sexo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="gender-children" name="gender-children" onchange="womanInformation()">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Femenino">Femenino</option>
                                                                                                            <option value="Masculino">Masculino</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Grado Escolar</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control" id="status-children" name="grade-children" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="N/A">N/A</option>
                                                                                                            <option value="Inicial">Inicial</option>
                                                                                                            <option value="Primaria">Primaria</option>
                                                                                                            <option value="Secundaria">Secundaria</option>
                                                                                                            <option value="Universitario">Universitario</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Talla de Camisa</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="shirt-children" name="shirt-children" required>
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
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <Label class="block">Talla de Pantalón</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="pants-children" type="number" class=" form-control required" required>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Talla de Calzado</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="shoes-children" type="number" class=" form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button class="btn btn-primary btn-outline-primary" id="omitir-children">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <input type="submit" id="save-children" class="btn btn-primary waves-effect waves-light" value="guardar"></input>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="messages5" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="form-family" method="POST" action="../modules/register-data-user/proses.php?act=insertFamilyData">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos de Familiares</p>
                                                                                            </div>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Parentesco</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="status-family" name="type-family" required>
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
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Nombres</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="names-family" id="names-family" type="text" class="form-control required" onchange="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Apellidos</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="lastnames-family" id="lastnames-family" type="text" class=" form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Cédula de Identidad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="ci-family" id="ci-family" type="number" class="form-control required" value="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Fecha de Nacimiento</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="birthDate-family" type="date" id="birthday-family" class=" form-control" onchange="calculateAge('birthday-family', 'age-family')" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Edad</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="age-family" id="age-family" type="number" class="form-control required" value="" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Sexo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="gender-family" name="gender-family" onchange="womanInformation()" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Femenino">Femenino</option>
                                                                                                            <option value="Masculino">Masculino</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Estado Civil</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="status-family" name="status-family" onchange="hideMarriedInformation()" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Soltero(a)">Soltero(a)</option>
                                                                                                            <option value="Conyugue">Concubinato</option>
                                                                                                            <option value="Casado(a)">Casado(a)</option>
                                                                                                            <option value="Anulado">Divorciado(a)</option>
                                                                                                            <option value="Viudo(a)">Viudo(a)</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Grado de Instrucción</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="grade-family" name="grade-family" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="N/A">N/A</option>
                                                                                                            <option value="Primaria">Primaria</option>
                                                                                                            <option value="Secundaria">Secundaria</option>
                                                                                                            <option value="Universitario">Universitario</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button class="btn btn-primary btn-outline-primary" id="omitir-family">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="save-family">Guardar</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings6" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" method="POST" action="../modules/register-data-user/proses.php?act=insertAcademicData">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos Académicos</p>
                                                                                            </div>
                                                                                            <fieldset style="height: 489px;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Grado de Instrucción</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="status-children" name="grade-academic" >
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="TSU">TSU</option>
                                                                                                            <option value="Licenciatura">Licenciatura</option>
                                                                                                            <option value="Especializacion">Especialización</option>
                                                                                                            <option value="Post-Grado">Post-Grado</option>
                                                                                                            <option value="Maestría">Maestría</option>
                                                                                                            <option value="Doctorado">Doctorado</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Título Obtenido</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="title-academic" id="dropper-default-children" type="text" class="form-control required" >
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Año de Grado</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="year-academic" id="year-academic" type="number" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Institución Universitaria</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="institute-academic" type="text" class=" form-control">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button id="omitir-academicos" class="btn btn-primary btn-outline-primary">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <input id="guardar-academicos" type="submit" class="btn btn-primary waves-effect waves-light" value="Guardar"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings7" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block" style=" height: 655px;">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="form-exterior" style="height: 564px;" method="POST" action="../modules/register-data-user/proses.php?act=insertAcademicExteriorData">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos de Formación Exterior</p>
                                                                                            </div>
                                                                                            <fieldset style="height: 489px;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Título Obtenido</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="title-exterior" id="dropper-default-children" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Año de Grado</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="anio-exterior" id="year-academic" type="number" class="form-control required" value="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Institución Universitaria</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="institute-exterior" type="text" class=" form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">País</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="status-children" name="country-exterior" required>
                                                                                                            <?php
                                                                                                            while ($row = mysqli_fetch_array($queryPaises)) {
                                                                                                            ?>
                                                                                                                <option value="<?php echo $row['pais']; ?>"><?php echo utf8_encode($row['pais']); ?></option>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button id="omitir-exterior" class="btn btn-primary btn-outline-primary">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <input type="submit" id="save-exterior" class="btn btn-primary waves-effect waves-light" value="Guardar"></input>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings8" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard" style=" height: 615px;">
                                                                                    <section>
                                                                                        <form class="wizard-form" style="height: 564px;" id="public-form" method="POST" action="../modules/register-data-user/proses.php?act=insertPublicData">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos de Experiencia Laboral</p>
                                                                                            </div>
                                                                                            <fieldset style="height: 489px;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Organismo</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="organismos-public" id="dropper-default-children" type="text" class="form-control required" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Fecha de Ingreso</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="fechaIngreso-public" id="year-in" type="date" class="form-control required" value="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Fecha de Egreso</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="fechaEgreso-public" id="year-out" type="date" class="form-control required" value="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Cargo</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="job-public" type="text" class=" form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Posee Antecedentes de Servicios</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="antecedentes-public" name="grade-academic" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                            <option value="No">No</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button class="btn btn-primary btn-outline-primary" id="omitir-publica">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="save-publica">Guardar</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings9" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="basic-forms" method="POST" action="../modules/register-data-user/proses.php?act=insertInstituteData">
                                                                                            <h3> Datos Institucionales </h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Ingreso en la ABAE</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="begin-institute" id="begin-institute" type="date" class="form-control required" onchange="calculateTime('begin-institute','calculate-time')" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Años en la ABAE</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="time-institute" id="calculate-time" type="number" class="form-control required" onchange="" readonly>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Cargo</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="cargo" name="job-institute" onchange="hideRole()" required>
                                                                                                            <option value="0">Seleccione</option>
                                                                                                            <!-- <option value="Presidente">Presidente</option> -->
                                                                                                            <!-- <option value="Vice-Presidente">Vice-Presidente</option> -->
                                                                                                            <option value="Director">Director</option>
                                                                                                            <option value="Jefe">Jefe</option>
                                                                                                            <option value="Personal de Investigacion">Personal Sustantivo</option>
                                                                                                            <option value="Empleado">Personal de Apoyo</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Sede</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="sede" name="sede-institute" onchange="changeSede()" required>
                                                                                                            <option value="0">Seleccione</option>
                                                                                                            <?php
                                                                                                            while ($row = mysqli_fetch_array($querySedes)) {
                                                                                                            ?>
                                                                                                                <option value="<?php echo $row['id_sede']; ?>"><?php echo $row['nombre']; ?></option>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="direccion-div">
                                                                                                    <div class="col-md-4 col-lg-2">Dirección de Adscripción</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="direccion" name="direction-institute" onchange="changeDireccion()">
                                                                                                            <option value="0">Seleccione</option>
                                                                                                            <?php
                                                                                                            while ($row = mysqli_fetch_array($queryDirecciones)) {
                                                                                                            ?>
                                                                                                                <option value="<?php echo $row['id_direccion']; ?>"><?php echo utf8_encode($row['nombre']); ?></option>
                                                                                                            <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="unidad-div">
                                                                                                    <div class="col-md-4 col-lg-2">Unidad de Adscripción</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="unidad" name="unity-institute" onchange="changeUnidad()">
                                                                                                            <option value="0">Seleccione</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Supervisor Inmediato</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="jefe" name="chief-institute" required>
                                                                                                            <option value="0">Seleccionar</option>
                                                                                                            <!-- <?php
                                                                                                                    while ($row = mysqli_fetch_array($queryJefes)) {
                                                                                                                    ?>
                                                                                                                <option value="<?php echo $row['id_usuario']; ?>"><?php echo utf8_encode($row['nombres'] . " " . $row['apellidos'] . " (" . $row['cargo'] . ")"); ?></option>
                                                                                                            <?php
                                                                                                                    }
                                                                                                            ?> -->
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3> Segunda Etapa </h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Inicio en la Administración Pública</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="begin-publicInstitute" id="default" type="date" class="form-control required" onchange="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Correo Electrónico Institucional</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="email-institute" id="dropper-default" type="email" class="form-control required" onchange="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Teléfono de Oficina / Ext.</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="tlf-institute" id="age" type="number" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Posee Familiares en la ABAE</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control " id="family-institute" onchange="hideFamilyInformation()">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                            <option value="No">No</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="family-info-container">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">Nombre del Familiar</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="familyName-institute" type="text" class="form-control ">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings10" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard" style=" height: 615px;">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="form-comision" style="height: 564px;" method="POST" action="../modules/register-data-user/proses.php?act=insertComisionData">
                                                                                            <div style="display: flex; justify-content: center; align-items: center; width: 250px; height: 55px; background-color: #00a9ac; border-radius: 5px; margin-bottom: 20px;">
                                                                                                <p style="color: white; margin-top: 15px; font-size: 16px">Datos de Comisión de Servicio</p>
                                                                                            </div>
                                                                                            <fieldset style="height: 488px;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Instituto de Procedencia</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="institute-comision" type="text" class=" form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="email-2" class="block">Rango Militar</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="range-comision" type="text" class=" form-control" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Inicio de Comisión</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="beginDate-comision" id="dropper-default" type="date" class="form-control required" onchange="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Culminacion de Comisión</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="finishDate-comision" id="dropper-default" type="date" class="form-control required" onchange="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <div style="display: flex; justify-content: flex-end; width: 100%; margin: 1px;">
                                                                                                <div style="margin:5px;">
                                                                                                    <button type="submit" class="btn btn-primary btn-outline-primary" id="omitir-comision">Omitir</button>
                                                                                                </div>
                                                                                                <div style="margin:5px;">
                                                                                                    <button type="submit" id="save-comision" class="btn btn-primary waves-effect waves-light">Guardar</inp>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings11" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="page-body">
                                                        <div class="row">
                                                            <div class=" col-sm-12">
                                                                <!-- Form wizard with validation card start -->
                                                                <div class="card">
                                                                    <div class="card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div id="wizard">
                                                                                    <section>
                                                                                        <form class="wizard-form" id="design-wizard" method="POST" action="../modules/register-data-user/proses.php?act=insertOthersData">
                                                                                            <h3></h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Facebook</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input id="facebook" name="facebook-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Twitter</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="twitter-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Instagram</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="instagram-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Otros</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="other-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Posee Carnet de la Patria</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="carnet-others" name="posee-carnetPatria" onchange="hideCarnetPatria()">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-codigo">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Código Carnet de la Patria</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="code-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-serial">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Serial Carnet de la Patria</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="serial-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-beneficios">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Beneficios del Carnet de la Patria</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="beneficios-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3></h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">Posee Carnet del PSUV</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="carnetPsuv-institute" name="posee-carnetPSUV" onchange="hideCarnetPSUV()">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-codigoPSUV">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Código Carnet del PSUV</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="codePsuv-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-serialPSUV">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Serial Carnet del PSUV</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="serialPsuv-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-beneficiosPSUV">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Beneficios del Carnet del PSUV</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="beneficiosPsuv-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Pertenece a Algún Partido Político? (Indique)</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input class="form-control required" name="partidoPolitico" placeholder="indique" id="partido-others">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Pertenece a Algún Movimiento Social? (Indique)</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="movimientoSocial" id="movimiento-others">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Pertenece a Alguna Comuna o Consejo Comunal? (Indique)</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="comuna" id="comuna-others">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3></h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Es Usted Vocero en Alguna Comuna o Consejo Comunal? (Indique)</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="vocero" id="vocero-others">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Recibe el Beneficio de la Caja Clap?</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="bolsa-others" name="bolsa">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Posee Vivienda Propia Alquilada o Familiar?</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="vivienda-others" name="vivienda-others" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Alquilada">Alquilada</option>
                                                                                                            <option value="Propia">Propia</option>
                                                                                                            <option value="Familiar">Familiar</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="tipoVivienda-others" class="block">Tipo de Vivienda</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select id='typeVivienda' name="tipoVivienda-others" class="form-control required" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Casa">Casa</option>
                                                                                                            <option value="Apartamento">Apartamento</option>
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
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Posee Vehículo Propio?</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" id="vehiculo-others" name="vehiculopropio" onchange="hideVehiculo()" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="No">No</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="tipoVehiculos">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Tipo de Vehículo</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="tipoVehiculo-others">
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Automóvil">Automóvil</option>
                                                                                                            <option value="Camioneta">Camioneta</option>
                                                                                                            <option value="Motocicleta">Motocicleta</option>
                                                                                                            <option value="Bicicleta">Bicicleta</option>
                                                                                                            <option value="Autobús">Autobús</option>
                                                                                                            <option value="Camion">Camión</option>
                                                                                                            <option value="Otro">Otro</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                            <h3></h3>
                                                                                            <fieldset style="overflow: auto;">
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">¿Utiliza Transporte Público?</div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <select class="form-control required" name="usaTrasporte" id="transportePublico-others" onchange="hideVehiculoPublic()" required>
                                                                                                            <option value="Seleccione">Seleccione</option>
                                                                                                            <option value="Si">Si</option>
                                                                                                            <option value="No">No</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row" id="div-vehiculo">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Indique Cual</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="tipoTrans-others" type="text" class="form-control required" value="">
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label for="confirm-2" class="block">Describa Brevemente la Ruta que Utiliza Para Trasladarse al Lugar de Trabajo</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="ruta-others" type="text" class="form-control required" value="" required>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group row">
                                                                                                    <div class="col-md-4 col-lg-2">
                                                                                                        <label class="block">¿Practica Algún Deporte o Actividad Cultural? (Indique)</label>
                                                                                                    </div>
                                                                                                    <div class="col-md-8 col-lg-10">
                                                                                                        <input name="deporte-others" type="text" class="form-control required">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </fieldset>
                                                                                        </form>
                                                                                    </section>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Form Basic Wizard card end -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Page body end -->
                                                </div>
                                                <div class="tab-pane" id="settings12" role="tabpanel">
                                                    <!-- Page body start -->
                                                    <div class="tab-pane" id="settings12" role="tabpanel">
                                                        <!-- Page body start -->
                                                        <div class="page-body" style="height: 100vh;">
                                                            <div class="row" style="height: 100%;">
                                                                <div class="col-sm-12" style="height: 100%;">
                                                                    <!-- Form wizard with validation card start -->
                                                                    <div class="card" style="height: 100%;">
                                                                        <div class="card-block" style="height: 80%;">
                                                                            <div class="row" style="height: 100%;">
                                                                                <div class="col-md-12" style="height: 100%;">
                                                                                    <div id="wizard" style="height: 100%;">
                                                                                        <section style="height: 100%;">
                                                                                            <div class="vh-100 d-flex justify-content-center align-items-center" style="height: 100%;">
                                                                                                <div class="card col-md-8 justify-content-center bg-white shadow-md p-5" style="height: 100%;">
                                                                                                    <div class="mb-4 text-center">
                                                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                                                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                                                                                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                                                                                                        </svg>
                                                                                                    </div>
                                                                                                    <div class="text-center">
                                                                                                        <h1>¡Registro Completado!</h1>
                                                                                                        <p>Para modificar sus datos, acceda al módulo de actualización de datos</p>
                                                                                                        <a class="btn btn-outline-success" href="../../personal-control-recharge/home/form-edit-data.php?page=datos-personales">Modificar</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Form Basic Wizard card end -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Page body end -->
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Row end -->
                                        </div>
                                    </div>
                                    <!-- Material tab card end -->
                                </div>
                            </div>
                            <!-- Main-body end -->

                            <div id="styleSelector">

                            </div>
                            <!-- Contenedor del modal -->
                            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <!-- <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Confirmar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div> -->
                                        <div class="modal-body">
                                            ¿Desea agregar otro Hijo?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="No">No</button>
                                            <button type="button" class="btn btn-primary" id="Si">Sí</button>
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
    <script src="../files/bower_components/jquery/js/jquery.min.js"></script>
    <script src="../utils/get-ubication-select.js"></script>
    <!-- <link href="path/to/select2.min.css" rel="stylesheet" />
    <script src="path/to/select2.min.js"></script> -->
    <script>
        //Agregar hijos
        $(document).ready(function() {
            $('#button-edit').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                header("Location: ../../home/solicitudes.php");
            });
        });

        function hideVehiculoPublic() {
            var selectedOption = $('#transportePublico-others').val();
            if (selectedOption === 'No') {
                $('#div-vehiculo').hide();
            } else {
                $('#div-vehiculo').show();
            }
        }


        function hideVehiculo() {
            var selectedOption = $('#vehiculo-others').val();
            if (selectedOption === 'No') {
                $('#tipoVehiculos').hide();
            } else {
                $('#tipoVehiculos').show();
            }
        }

        function hideCarnetPatria() {
            var selectedOption = $('#carnet-others').val();
            if (selectedOption === 'No') {
                $('#div-codigo').hide();
                $('#div-serial').hide();
                $('#div-beneficios').hide();
            } else {
                $('#div-codigo').show();
                $('#div-serial').show();
                $('#div-beneficios').show();
            }
        }

        function hideCarnetPSUV() {
            var selectedOption = $('#carnetPsuv-institute').val();
            if (selectedOption === 'No') {
                $('#div-codigoPSUV').hide();
                $('#div-serialPSUV').hide();
                $('#div-beneficiosPSUV').hide();
            } else {
                $('#div-codigoPSUV').show();
                $('#div-serialPSUV').show();
                $('#div-beneficiosPSUV').show();
            }
        }

        function hideFamilyInformation() {
            var selectedOption = $('#family-institute').val(); // Obtener el valor seleccionado del select

            if (selectedOption === 'No') { // Si se selecciona "No"
                // Ocultar el div contenedor de los campos
                $('#family-info-container').hide();
            } else {
                // Mostrar el div contenedor de los campos
                $('#family-info-container').show();
            }
        }


        function hideRole() {
            let cargo = $("#cargo").val();
            var sede = document.getElementById("sede");
            var direccion = document.getElementById("direccion");
            var unidad = document.getElementById("unidad");
            var jefe = document.getElementById("jefe");

            sede.selectedIndex = 0;
            direccion.selectedIndex = 0;
            unidad.selectedIndex = 0;
            jefe.selectedIndex = 0;

            if (cargo === "Presidente" || cargo === "Vice-Presidente") {
                $("#direccion-div, #unidad-div").hide();
                $("#direccion").val("N/A");
                $("#unidad").val("N/A");
            } else if (cargo === "Director") {
                $("#unidad-div").hide();
                $("#unidad").val("N/A");
                $("#direccion-div").show();
            } else {
                $("#direccion-div, #unidad-div").show();
            }
        }

        function changeSede() {
            console.log("Cambio el campo sede");
            var sedeId = $("#sede").val();
            console.log(sedeId)
            $.ajax({
                url: "../utils/get-direcciones.php",
                type: "POST",
                data: {
                    sedeId: sedeId
                },
                success: function(data, status) {
                    var options = "";
                    if (data != "") {
                        options = data;
                        console.log(data)
                    } else {
                        options = "<option value=''>No hay direcciones disponibles</option>";
                    }
                    $("#direccion").html(options);
                },
                error: function(error, status) {
                    console.log("Error en la solicitud AJAX: " + error + " Estatus: " + status);
                }
            });
        }

        function changeDireccion() {
            // Cargar unidades al seleccionar una dirección
            var direccionId = $("#direccion").val();
            var idUnidad = $("#unidad").val();
            var cargo = $("#cargo").val();


            console.log("valor unidad 1: " + idUnidad);
            console.log("valor direccion 1: " + direccionId);


            if (cargo === "Empleado" || cargo === "Personal de Investigacion" || cargo === "Jefe") {
                $.ajax({
                    url: "../utils/get-unidades.php",
                    type: "POST",
                    data: {
                        direccionId: direccionId
                    },
                    success: function(data) {

                        $("#unidad").html(data);
                        var jefeInmediato = $("#jefe-inmediato").val();
                        $("#jefe").val(jefeInmediato);
                    }
                });
            } else if (cargo === "Director") {
                $.ajax({
                    url: "../utils/get-directores.php",
                    type: "POST",
                    data: {
                        direccionId: direccionId,
                        idUnidad: idUnidad
                    },
                    success: function(data) {
                        $("#jefe").val("DATA: " + data);
                        $("#jefe").html(data);
                    }
                });
            }

            console.log("valor unidad: " + idUnidad);
            console.log("valor direccion: "+idDireccion)

            // Realizar una solicitud AJAX para obtener el nombre del jefe
            $.ajax({
                url: "../utils/get-jefe.php",
                type: "POST",
                data: {
                    idUnidad: idUnidad,
                    idDireccion: idDireccion,
                    cargo: cargo
                },
                success: function(data) {
                    $("#jefe").val("DATA: " + data);
                    $("#jefe").html(data);
                    console.log(data);
                },
                error: function(error) {
                    console.log("Error en la solicitud AJAX: " + error);
                }
            });
        }

        function changeUnidad() {
            var idUnidad = $("#unidad").val();
            var direccionId = $("#direccion").val();
            console.log("valor unidad 2: " + idUnidad);
            console.log("valor direccion 2: " + direccionId);


            var cargo = $("#cargo").val();

            // Realizar una solicitud AJAX para obtener el nombre del jefe
            if (cargo === "Jefe") {
                $.ajax({
                    url: "../utils/get-directores.php",
                    type: "POST",
                    data: {
                        direccionId: direccionId,
                        idUnidad: idUnidad
                    },
                    success: function(data) {
                        $("#jefe").val("DATA: " + data);
                        $("#jefe").html(data);
                    }
                });
            } else {
                $.ajax({
                    url: "../utils/get-jefe.php",
                    type: "POST",
                    data: {
                        idUnidad: idUnidad,
                        cargo: cargo
                    },
                    success: function(data) {
                        $("#jefe").val("DATA: " + data);
                        $("#jefe").html(data);
                        console.log(data);
                    },
                    error: function(error) {
                        console.log("Error en la solicitud AJAX: " + error);
                    }
                });
            }
        }

        function confirmModal() {
            return new Promise(function(resolve) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                Swal.fire({
                    title: 'Confirmar',
                    text: '¿Desea agregar otro?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí',
                    cancelButtonText: 'No',
                    confirmButtonColor: '#01a9ac',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        resolve(true);
                    } else {
                        resolve(false);
                    }
                });
            });
        }

        let step = <?php echo $step; ?>;
        let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
        //Pestañas completadas                                                                                                        
        $(document).ready(function() {
            if (step >= 1) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-personales').append(icono);
                $('#tab-personales').addClass('disabled');
                $('#tab-hijos').tab('show');
            } else {
                $('#tab-hijos').prop('disabled', true);
            }

            if (step >= 2) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-hijos').append(icono);
                $('#tab-hijos').addClass('disabled');
                $('#tab-familiares').tab('show');
            } else {
                $('#tab-familiares').prop('disabled', true);
            }

            if (step >= 3) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-familiares').append(icono);
                $('#tab-familiares').addClass('disabled');
                $('#tab-academicos').tab('show');
            } else {
                $('#tab-academicos').prop('disabled', true);
            }

            if (step >= 4) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-academicos').append(icono);
                $('#tab-academicos').addClass('disabled');
                $('#tab-exterior').tab('show');
            } else {
                $('#tab-exterior').prop('disabled', true);
            }

            if (step >= 5) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-exterior').append(icono);
                $('#tab-exterior').addClass('disabled');
                $('#tab-experiencia').tab('show');
            } else {
                $('#tab-experiencia').prop('disabled', true);
            }

            if (step >= 6) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-experiencia').append(icono);
                $('#tab-experiencia').addClass('disabled');
                $('#tab-institucionales').tab('show');
            } else {
                $('#tab-institucionales').prop('disabled', true);
            }

            if (step >= 7) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-institucionales').append(icono);
                $('#tab-institucionales').addClass('disabled');
                $('#tab-comision').tab('show');
            } else {
                $('#tab-comision').prop('disabled', true);
            }

            if (step >= 8) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-comision').append(icono);
                $('#tab-comision').addClass('disabled');
                $('#tab-otros').tab('show');
            } else {
                $('#tab-otros').prop('disabled', true);
            }

            if (step >= 9) {
                let icono = $('<i>').addClass('fa fa-check-circle').css('margin-left', '5px');
                $('#tab-otros').append(icono);
                $('#tab-otros').addClass('disabled');
                $('#tab-finish').tab('show');
            } else {
                $('#tab-finish').prop('disabled', true);
            }
        });


        //Agregar hijos
        $(document).ready(function() {
            $('#save-children').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                confirmModal().then(function(result) {
                    if (result) {
                        $("#form-children").trigger("submit");
                    } else {
                        $("#form-children").trigger("submit");
                        $("#omitir-children").trigger("click");
                    }
                });
            });
        });


        //Omitir hijos
        $(document).ready(function() {
            $('#omitir-children').click(function(e) {
                e.preventDefault();
                $('#tab-familiares').tab('show');
                $('#tab-hijos').append(icono);
                $("#tab-hijos").addClass("disabled");
                step = 2;
                accion = "children";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        });

        //Agregar Familiares
        $(document).ready(function() {
            $('#save-family').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                confirmModal().then(function(result) {
                    if (result) {
                        $("#form-family").trigger("submit");
                    } else {
                        $("#form-family").trigger("submit");
                        $("#omitir-family").trigger("click");
                    }
                });
            });
        });

        //Omitir Familiares
        $(document).ready(function() {
            $('#omitir-family').click(function(e) {
                e.preventDefault();
                $('#tab-academicos').tab('show');
                $('#tab-familiares').append(icono);
                $("#tab-familiares").addClass("disabled");
                step = 3;
                accion = "family";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        });

        //Agregar Familiares
        $(document).ready(function() {
            $('#save-exterior').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                confirmModal().then(function(result) {
                    if (result) {
                        $("#form-exterior").trigger("submit");
                    } else {
                        $("#form-exterior").trigger("submit");
                        $("#omitir-exterior").trigger("click");
                    }
                });
            });
        });

        //Omitir Formacion en el exterior
        $(document).ready(function(e) {
            $('#omitir-academicos').click(function(e) {
                e.preventDefault();
                $('#tab-exterior').tab('show');
                $('#tab-academicos').append(icono);
                $("#tab-academicos").addClass("disabled");
                step = 4;
                accion = "academicos";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        }); 


        //Omitir Formacion en el exterior
        $(document).ready(function(e) {
            $('#omitir-exterior').click(function(e) {
                e.preventDefault();
                $('#tab-experiencia').tab('show');
                $('#tab-exterior').append(icono);
                $("#tab-exterior").addClass("disabled");
                step = 5;
                accion = "exterior";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        });

        //Agregar Experiencia en administracion publica
        $(document).ready(function() {
            $('#save-publica').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                confirmModal().then(function(result) {
                    if (result) {
                        $("#public-form").trigger("submit");
                    } else {
                        $("#public-form").trigger("submit");
                        $("#omitir-publica").trigger("click");
                    }
                });
            });
        });

        //Agregar comision
        $(document).ready(function() {
            $('#save-comision').click(function(e) {
                e.preventDefault(); // Evitar el comportamiento predeterminado del botón
                $("#form-comision").trigger("submit");
            });
        });

        //Omitir experiencia en la administracion publica
        $(document).ready(function(e) {
            $('#omitir-comision').click(function(e) {
                e.preventDefault();
                $('#tab-otros').tab('show');
                $('#tab-comision').append(icono);
                $("#tab-comision").addClass("disabled");
                step = 8;
                accion = "comision";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        });

        //Omitir experiencia en la administracion publica
        $(document).ready(function(e) {
            $('#omitir-publica').click(function(e) {
                e.preventDefault();
                $('#tab-institucionales').tab('show');
                $('#tab-experiencia').append(icono);
                $("#tab-experiencia").addClass("disabled");
                step = 6;
                accion = "publica";
                // Aquí puedes agregar la función que deseas ejecutar al hacer clic en el botón
                console.log('Se hizo clic en el botón "Omitir"');
                $.ajax({
                    url: '../utils/step.php',
                    method: 'POST',
                    data: {
                        parametro1: step,
                        parametro2: accion,
                        // Agrega aquí los demás parámetros y valores que necesites enviar
                    },
                    success: function(response) {
                        // Maneja la respuesta del servidor después de la inserción
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Maneja cualquier error que ocurra durante la solicitud
                        console.error(error);
                    }
                });
            });
        });

        // id="tab-personales"
        // id="tab-hijos"
        // id="tab-familiares"
        // id="tab-academicos"
        // id="tab-exterior"
        // id="tab-experiencia"
        // id="tab-institucionales"
        // id="tab-comision"
        // id="tab-otros"  
    </script>
</body>

</html>