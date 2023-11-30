<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_SESSION)) {
    session_start();
    if (isset($_SESSION["id_usuario"])) {

        print "<script>window.location='home/dashboard.php';</script>";
    }
} else {
    if (isset($_SESSION["id_usuario"])) {

        print "<script>window.location='home/dashboard.php';</script>";
    }
}


date_default_timezone_set("America/Caracas");
?>

<head>
    <title>Login </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximun-scale=1, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="files\assets\images\small-logo.png" type="image/x-icon" style="object-fit: cover;">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="files\bower_components\bootstrap\css\bootstrap.min.css">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="files\assets\icon\themify-icons\themify-icons.css">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="files\assets\icon\icofont\css\icofont.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="files\assets\css\style.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\new-style.css">
    <link rel="stylesheet" type="text/css" href="files\assets\css\login.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="@sweetalert2/theme-bulma/bulma.css">
</head>

<body class="fix-menu" style="height: 100vh !important;margin:0;">
    <!--h2>Weekly Coding Challenge #1: Sign in/up Form</h2-->
    <div class="container" id="container" style="vertical-align:middle;">
        <div class="form-container sign-up-container">
            <form id="form2" enctype="multipart/form-data">
                <h2>Nuevo Usuario</h2>
                <input type="text" placeholder="Usuario" name="usuario" pattern="[A-Za-z0-9_]{1,15}" style="border-radius: 15px;" required />
                <input type="text" placeholder="Cedula" name="cedula" minlength="6" maxlength="8" style="border-radius: 15px;" required />
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="nombre" placeholder="Nombres" pattern="^[a-zA-Z\s\._-]*$" style="border-radius: 15px;" required />
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="apellido" placeholder="Apellidos" pattern="^[a-zA-Z\s\._-]*$" style="border-radius: 15px;" required />
                    </div>
                </div>
                <input type="email" name="email" placeholder="Ejemplo@abae.gob.ve" style="border-radius: 15px;" />
                <div class="row">
                    <div class="col-md-6">
                        <input type="password" placeholder="Contraseña" name="password" style="border-radius: 15px;" required />
                    </div>
                    <div class="col-md-6">
                        <input type="password" placeholder="Confirmar" name="confirm-password" style="border-radius: 15px;" required />
                    </div>
                </div>
                <button type="submit" style="margin-top:15px">Crear Cuenta</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="form" enctype="multipart/form-data">

                <div style="text-align:center;" class="row m-b-20">
                    <div class="col-md-12 text-center" style="text-align:center; margin-bottom:10px">
                        <img src="files\assets\images\logo.png" alt="logo.png" style="height:75px">
                    </div>
                    <h2 style="text-align:center;" class="text-center col-md-12">Iniciar Sesión</h2>
                </div>
                <input type="text" placeholder="Usuario" id="user" style="border-radius: 15px;" class="cont" />
                <input type="password" placeholder="Contraseña" id="password" style="border-radius: 15px;" class="cont" />
                <!--a href="#">Forgot your password?</a-->
                <button type="submit" style="margin-top:20px">Iniciar Sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Bienvenido!</h1>
                    <p>Ingresa los datos básicos para crear una nueva cuenta</p>
                    <button class="ghost" id="signIn">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>SIGH</h1>
                        <h5><b>Sistema de Información Gestión Humana</b></h5>
                    <p>Registrar Nuevo Personal</p>
                    <button class="ghost" id="signUp">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>
            Creado por la Direccion de Investigacion e Innovacion Espacial, USMI-UDLP; ABAE 2023.
        </p>
    </footer>

    <!-- Required Jquery -->
    <script type="text/javascript" src="files\bower_components\jquery\js\jquery.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
    <script type="text/javascript" src="files\bower_components\popper.js\js\popper.min.js"></script>
    <script type="text/javascript" src="files\bower_components\bootstrap\js\bootstrap.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="files\bower_components\modernizr\js\modernizr.js"></script>
    <script type="text/javascript" src="files\bower_components\modernizr\js\css-scrollbars.js"></script>
    <!-- notification js -->
    <script type="text/javascript" src="files\assets\js\bootstrap-growl.min.js"></script>
    <script type="text/javascript" src="files\assets\pages\notification\notification.js"></script>
    <!-- i18next.min.js -->
    <script type="text/javascript" src="files\bower_components\i18next\js\i18next.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-i18next\js\jquery-i18next.min.js"></script>
    <script type="text/javascript" src="files\assets\js\common-pages.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-23581568-13');
        $(document).ready(function() {

            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');

            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
            });

            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
            });

            $("#form").submit(function(e) {
                e.preventDefault();
                var values = new FormData();

                values.append("user", $("#user").val());
                values.append("password", $("#password").val());

                $.ajax({
                    url: 'php/login/login-pro.php',
                    type: 'POST',
                    data: values,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        switch (response) {
                            case "si":
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Sesión Iniciada',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });  //CUANDO INICIA SESION
                                setTimeout(function() {
                                    window.location = "home/dashboard.php";
                                }, 1500);
                                break;
                            case "no":
                                Swal.fire({
                                        icon: 'warning',
                                        title: 'Error en verificación',
                                        text: 'Nombre de usuario o contraseña incorrecto',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#01a9ac',
                                    }); //CONTRASEÑA O USUARIO INCORRECTOS
                                break;
                            default:
                                console.log(response);
                                break;
                        }

                    },
                    error: function(response) {

                    }
                });

            });

            $("#form2").submit(function(e) {
                e.preventDefault();

                if ($("[name='password']").prop("value") == $("[name='confirm-password']").prop("value")) {
                    var values = new FormData();

                    values.append("usuario", $("[name='usuario']").prop("value"));
                    values.append("apellido", $("[name='apellido']").prop("value"));
                    values.append("cedula", $("[name='cedula']").prop("value"));
                    values.append("pass", $("[name='password']").prop("value"));
                    values.append("nombre", $("[name='nombre']").prop("value"));
                    values.append("email", $("[name='email']").prop("value"));
                    $.ajax({
                        url: 'php/login/nuevo-usuario-pros.php',
                        type: 'POST',
                        data: values,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                            switch (response) {
                                case "si":
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Usuario Registrado',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });//CUANDO REGISTRA EXITOSAMENTE
                                    setTimeout(function() {
                                        window.location = "index.php";
                                    }, 2000);
                                    break;
                                case "no":
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Usuario no Registrado',
                                        text: 'Problema de comunicación con el servidor, intente más tarde',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#01a9ac',
                                    }); //ERROR AL REGISTRAR
                                    break;
                                case "existe_cedula":
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Usuario no Registrado',
                                        text: 'El número de cédula ya existe',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#01a9ac',
                                    }); //CEDULA EXISTENTE
                                    break;
                                case "existe_usuario":
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Usuario no Registrado',
                                        text: 'El nombre de usuario ya existe',
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#01a9ac',
                                    }); //NOMBRE DE USUARIO EXISTENTE
                                    break;
                                default:
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error Inesperado',
                                        text: toString(response),
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#01a9ac',
                                    });
                                    break;
                            }

                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error Inesperado',
                                text: toString(response),
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#01a9ac',
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Las contraseñas no coinciden',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#01a9ac',
                    });
                }
            });

            function promp(mensaje, tipo, from, align) {
                $.growl({
                    message: mensaje
                }, {
                    type: tipo,
                    allow_dismiss: false,
                    label: 'Cancel',
                    className: 'btn-xs btn-inverse',
                    placement: {
                        from: from,
                        align: align
                    },
                    delay: 2500,
                    animate: {
                        enter: 'animated fadeInRight',
                        exit: 'animated fadeOutRight'
                    },
                    offset: {
                        x: 30,
                        y: 30
                    }
                });
            }

        })
    </script>
</body>

</html>