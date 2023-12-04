<?php
require_once '../database/conexion.php';

if (!isset($_SESSION)) {
    session_start();
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
} else {
    if (!isset($_SESSION["id_usuario"])) {

        print "<script>window.location='../index.php';</script>";
        //print "<script>alert(".$_SESSION["id_usuario"].");</script>";
    }
}
date_default_timezone_set("America/Caracas");

$idUser = $_SESSION["id_usuario"];

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Preparar la consulta SQL
$sql = "SELECT * FROM usuario WHERE id_usuario = '$idUser' LIMIT 1";
$data = "SELECT * FROM datos_personales WHERE id_usuario = '$idUser' LIMIT 1;";

// Ejecutar la consulta SQL
$resultado = mysqli_query($conn, $sql);
$resulData = mysqli_query($conn, $data);

$personal_data = mysqli_fetch_assoc($resulData);
$fila = mysqli_fetch_assoc($resultado);

?>


<head>
    <title>SGDP - ABAE</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
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
    <link rel="icon" href="..\files\assets\images\favicon.png" type="image/png">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\bootstrap\css\bootstrap.min.css">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\feather\css\feather.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\component.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\new-style.css">
</head>

<body id="homebar-container">

    <!-- Pre-loader start -->
    <div class="">
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
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">



            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu"></i>
                        </a>
                        <a href="dashboard.php">
                            <img class="img-fluid" src="..\files\assets\images\logo.png" alt="Theme-Logo">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <!--ul class="nav-left">
                            <li class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                                        <input type="text" class="form-control">
                                        <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">
                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>
                        </ul-->
                        <ul class="nav-right">
                            <!--INICIO DE NOTIFICACIONES-->
                            <li class="header-notification" style="padding: 0px">
                                <div class="dropdown-primary dropdown" style="width:50px;">
                                    <?php
                                    include '../php/notificacion/notificacion.php';
                                    ?>
                                    <!--<div class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-bell"></i>
                                        <span class="badge bg-c-pink">5</span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">John Doe</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">Joseph William</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="media">
                                                <img class="d-flex align-self-center img-radius" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="notification-user">Sara Soudein</h5>
                                                    <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                    <span class="notification-time">30 minutes ago</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>-->
                                </div>
                            </li>
                            <!--FIN DE NOTIFICACIONES-->
                            <!--
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                                        <i class="feather icon-message-square"></i>
                                        <span class="badge bg-c-green">3</span>
                                    </div>
                                </div>
                            </li>-->
                            <li style="padding:10px"></li>
                            <li class="user-profile header-notification" style="padding: 0px;">
                                <div class="dropdown-primary dropdown" style="text-align: center;">
                                    <div class="dropdown-toggle" data-toggle="dropdown" >
                                        <img src="../assets/empleados-images/<?php if($personal_data != null) { echo $personal_data['foto']; } else { echo "avatar_default.jpg"; } ?>" class="img-radius" alt="User-Profile-Image">
                                        <span><?php echo $fila['nombres']." ".$fila['apellidos'] ?></span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <!--<li>
                                            <a href="#!">
                                                <i class="feather icon-settings"></i> Settings
                                            </a>
                                        </li>-->
                                        <li>
                                            <a href="../home/form-edit-data.php?page=perfil">
                                                <i class="feather icon-user"></i> Perfil
                                            </a>
                                        </li>
                                        <!--<li>
                                            <a href="email-inbox.htm">
                                                <i class="feather icon-mail"></i> My Messages
                                            </a>
                                        </li>
                                        <li>
                                            <a href="auth-lock-screen.htm">
                                                <i class="feather icon-lock"></i> Lock Screen
                                            </a>
                                        </li>-->
                                        <li>
                                            <a href="../php/logout.php">
                                                <i class="feather icon-log-out"></i> Cerrar Sesión
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                            <li style="padding:5px"></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Sidebar chat start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="card card_main p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-inner-header">
                                <div class="back_chatBox">
                                    <div class="right-icon-control">
                                        <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image ">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe" data-toggle="tooltip" data-placement="left" title="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="..\files\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia" data-toggle="tooltip" data-placement="left" title="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen" data-toggle="tooltip" data-placement="left" title="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="..\files\assets\images\avatar-2.jpg" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat start-->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                        <i class="feather icon-chevron-left"></i> Josephin Doe
                    </a>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src="..\files\assets\images\avatar-3.jpg" alt="Generic placeholder image">
                    </a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media-right photo-table">
                        <a href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src="..\files\assets\images\avatar-4.jpg" alt="Generic placeholder image">
                        </a>
                    </div>
                </div>
                <div class="chat-reply-box p-b-20">
                    <div class="right-icon-control">
                        <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                        <div class="form-icon">
                            <i class="feather icon-navigation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="pcoded-navigatio-lavel"></div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="dashboard.php">
                                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                        <span class="pcoded-mtext">Inicio</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="pcoded-navigatio-lavel">Datos personales</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="../home/form-register.php">
                                        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                                        <span class="pcoded-mtext">Mis datos</span>
                                    </a>
                                </li>
                                <!--<li class=" ">
                                    <a href="../home/form-edit-data.php">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Actualización de datos</span>
                                    </a>
                                </li>-->





                                <li class="pcoded-hasmenu"><!-- pcoded-trigger -->
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-edit"></i></span>
                                        <span class="pcoded-mtext">Actualización de datos</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="pcoded-trigger"> <!--active-->
                                            <a href="../home/form-edit-data.php?page=datos-personales" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Personales</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class="pcoded-trigger">
                                            <a href="../home/form-edit-data.php?page=hijos" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Hijos</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=familiares" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Familiares</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=datos-academicos" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Académicos</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=formacion-exterior" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Formación exterior</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=experiencia-laboral-publica" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Experiencia laboral</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=datos-institucionales" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Institucionales</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=comision-servicio" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Comisión de servicio</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="../home/form-edit-data.php?page=otros-datos" data-i18n="nav.widget.main">
                                                <!--<span class="pcoded-micon"><i class="ti-view-grid"></i></span>-->
                                                <span class="pcoded-mtext">Otros datos</span>
                                                <!--<span class="pcoded-badge label label-danger">100+</span>
                                                <span class="pcoded-mcaret"></span>-->
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>






                            <div class="pcoded-navigatio-lavel">Solicitudes</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="../home/solicitudes.php">
                                        <span class="pcoded-micon"><i class="feather icon-file-text"></i></span>
                                        <span class="pcoded-mtext">Mis solicitudes</span>
                                    </a>
                                </li>
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-file"></i></span>
                                        <span class="pcoded-mtext">Formatos vacíos</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="../FPDF/Vacaciones_Vacio.php">
                                                <span class="pcoded-mtext">Vacaciones</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="../FPDF/Reposo_Vacio.php">
                                                <span class="pcoded-mtext">Reposo</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="../FPDF/Prueba_permiso.php">
                                                <span class="pcoded-mtext">Permisos</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
<?php
                    if($_SESSION['tipo_usuario'] == "admin" || $_SESSION['tipo_usuario'] == "jefe" || $_SESSION['tipo_usuario'] == "Jefe"){
?>
                            <div class="pcoded-navigatio-lavel">Búsqueda</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="../home/form-edit-data.php?page=filtros-de-busqueda">
                                        <span class="pcoded-micon"><i class="feather icon-list"></i></span>
                                        <span class="pcoded-mtext">Información de personal</span>
                                    </a>
                                </li>
                            </ul>
<?php
                    }
?>
                            <div class="pcoded-navigatio-lavel">Notificaciones</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="../home/notificaciones.php">
                                        <span class="pcoded-micon"><i class="feather icon-bell  "></i></span>
                                        <span class="pcoded-mtext">Mis notificaciones</span>
                                    </a>
                                </li>
                            </ul>
                            <br>            
                            <!-- ESTO NO BORRARLOOOOO -->
<?php
                    if($_SESSION['tipo_usuario'] == "admin"){
?>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="pcoded-hasmenu ">
                                    <a href="javascript:void(0)">
                                        <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                                        <span class="pcoded-mtext">Configuraciones</span>
                                    </a>
                                    <ul class="pcoded-submenu">
                                        <li class="">
                                            <a href="../home/config_feriados.php">
                                                <span class="pcoded-mtext">Feriados</span>
                                            </a>
                                        </li>
                                        <li class="">
                                            <a href="../home/select_admin.php">
                                                <span class="pcoded-mtext">Selec. Admin</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <?php
                    }
?>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class=" ">
                                    <a href="../php/logout.php">
                                        <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                                        <span class="pcoded-mtext">Salir</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">



                            <div class="main-body" id="main-body-container">
                                <?php
                                include $view;
                                ?>
                                <div id="styleSelector">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- <script data-cfasync="false" src="..\..\..\cdn-cgi\scripts\5c5dd728\cloudflare-static\email-decode.min.js"></script> -->
<script type="text/javascript" src="..\files\bower_components\jquery\js\jquery.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\popper.js\js\popper.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\bootstrap\js\bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="..\files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="..\files\bower_components\modernizr\js\modernizr.js"></script>
<!-- Chart js -->
<script type="text/javascript" src="..\files\bower_components\chart.js\js\Chart.js"></script>
<!-- amchart js -->
<script src="..\files\assets\pages\widget\amchart\amcharts.js"></script>
<script src="..\files\assets\pages\widget\amchart\serial.js"></script>
<script src="..\files\assets\pages\widget\amchart\light.js"></script>
<script src="..\files\assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
<!-- <script type="text/javascript" src="..\files\assets\js\SmoothScroll.js"></script> -->
<script src="..\files\assets\js\pcoded.min.js"></script>
<!-- custom js -->
<script src="..\files\assets\js\vartical-layout.min.js"></script>
<!-- <script type="text/javascript" src="..\files\assets\pages\dashboard\custom-dashboard.js"></script> -->
<script type="text/javascript" src="..\files\assets\js\script.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<!-- <script type="text/javascript" src="..\files\bower_components\popper.js\js\popper.min.js"></script> -->
<!-- <script type="text/javascript" src="../files/assets/js/SmoothScroll.js"></script>
<script type="text/javascript" src="../files/assets/pages/dashboard/custom-dashboard.js"></script>
<script src="../files/assets/js/vartical-layout.min.js"></script> -->