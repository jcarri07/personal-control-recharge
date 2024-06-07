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

    //closeConection($conn);

?>
<head>

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
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\new-style.css">

        <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
</head>

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
                                    <h4>Configuración de administrador</h4>
                                    <!--<span>Otros Datos</span>-->
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
                                        <!--<a href="#!" class="activate">Actualización de Datos / Otros Datos</a>-->
                                        <a href="#!" class="activate">Configuración de administrador</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
<?php
     if (empty($_GET['alert'])) {
        echo "";
    } elseif ($_GET['alert'] == 1) {
        echo " <div class='alert alert-success icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                     <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                     <p><strong>Actualización exitosa!</strong> Datos del administrador han sido modificados</p>
                                    </div>";
    } elseif ($_GET['alert'] == 2) {
        echo "<div class='alert alert-warning icons-alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <i class='icofont icofont-close-line-circled'></i>
                                    </button>
                                    <p><strong>Error!</strong> No se completó la solicitud</p>
                                   </div> ";
    }

?>
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="wizard">
                                                <section>
                                                <div id="form-edit" class="wizard-form">
                                                        <div class="box-title mb-1" style="display: flex; justify-content: center;">
                                                            <h4>Administrador Actual</h4>
                                                        </div>
                                                        <!--<fieldset>-->
                                                        <div class="form-group row align-items-center d-flex flex-column">
                                                            <div class="col-md-4">
                                                                <label class="block"><b>Usuario</b></label>
                                                                <input name="user" id="user" type="text" class="form-control" maxlength="50" value="<?php echo $datos_personales['user'];?>" readonly>
                                                            </div>
                                                            </br>
                                                            <div class="col-md-4">
                                                                <label class="block"><b>Nombres y Apellidos</b></label>
                                                                <input name="pass" id="pass" type="text" class="form-control" maxlength="50" value="<?php echo $datos_personales['nombres'] . ' ' . $datos_personales['apellidos']; ?>" readonly>
                                                            </div>
                                                        </div>
                                                        </br>
                                                        <div class="box-title mb-1" style="display: flex; justify-content: center;">
                                                            <h4>Nuevo administrador</h4>
                                                        </div>
                                                        <div class="form-group row align-items-center d-flex flex-column">
                                                            <div class="col-md-4">
                                                                <label class="block"><b>Usuario</b></label>
                                                                <select id="nuevo_adm" class="form-control form-control-primary" required>
                                                                    <option value="">Seleccione</option>
                                                                    <?php
                                                                        $query = mysqli_query($conn, "SELECT user FROM usuario WHERE cargo = 'jefe' OR cargo = 'director'")
                                                                            or die('error ' . mysqli_error($conn));

                                                                        while ($data = mysqli_fetch_assoc($query)) {
                                                                            echo "<option value=\"$data[user]\">$data[user]</option>";
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            </br>

                                                            <div class="col-md-4">
                                                                <label class="block"><b>Nombres y Apellidos</b></label>
                                                                <input id="nuevo_nom" type="text" class="form-control" maxlength="50" value="" readonly required>
                                                            </div>
                                                        </div>
                                                        <!--</fieldset-->
                                                        </br>
                                                        <div id="message"></div>

                                                        <div class="text-center mt-3">
                                                        <button id="updateButton" class="btn btn-primary" data-target="#myModal">Actualizar</button>
                                                        </div>
                                                       
                                                </div>


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

<!-- Ventana modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Administrador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Por favor, ingrese la contraseña para validar el cambio de administrador:</p>
                <input type="password" id="password" class="form-control" placeholder="Contraseña">

                <div id="error-message" style="font-size: 10px; color: red;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="checkPassword()">Validar</button>
            </div>
        </div>
    </div>
</div>


<script>

    document.getElementById('updateButton').addEventListener('click', function () {
              openModal();
             // console.log("funciona");
    });



    function openModal() {
    var input = document.getElementById('nuevo_nom');
    console.log(input.value);
    if (input.value.trim() !== "") {
        $("#myModal").modal("show");
    } else {
        var errorMessage = document.getElementById('message');
        errorMessage.textContent = 'Por favor, complete todos los campos requeridos.';
    }
}  


/*function checkPassword() {
        const passwordInput = document.getElementById('password');
        const password = passwordInput.value;

        // Aquí puedes agregar tu lógica de validación de contraseña.

        if (password === 'tu-contraseña') {
            alert('Contraseña válida. Acceso permitido.');
            document.getElementById('modal').style.display = 'none';
            passwordInput.value = '';
        } else {
            alert('Contraseña incorrecta. Intente de nuevo.');
            passwordInput.value = '';
        }
    }
*/    
var nombre_admin = document.getElementById("nuevo_adm");

    nombre_admin.addEventListener("change", function () {
        var valor = nombre_admin.value;

    $.ajax({
        url: "../php/nuevo_admin.php",
        type: "POST",
        data: { nombre: valor }, // Enviando el valor con una clave "nombre"
        success: function (response) {
            if (response != '0') {
            
                document.getElementById("nuevo_nom").value = response;
            }
        },
    });
});


function checkPassword() {
    // Obtiene la contraseña ingresada por el usuario
    var passwordInput = document.getElementById('password');
    var password = passwordInput.value;
    // Realiza la lógica de validación de contraseña aquí
    // Puedes comparar la contraseña ingresada con la contraseña almacenada en tu base de datos o cualquier otro método de validación que prefieras.
    if (password === '0000') {
        // La contraseña es válida, puedes realizar el cambio de administrador aquí
        var valor = document.getElementById('nuevo_adm').value;

        // Limpia el campo de contraseña
        passwordInput.value = '';
        
        // Realiza la actualización del administrador utilizando AJAX
        $.ajax({
            url: "../php/proces_actualizar_admin.php",
            type: "POST",
            data: { user: valor }, // Puedes enviar cualquier dato adicional necesario para la actualización
            success: function(response) {
                // Aquí puedes realizar cualquier acción adicional después de completar la actualización
                console.log('Se cambio la firma del usuario');
                window.location.href = "../home/select_admin.php?alert=1";

            },
            error: function(xhr, status, error) {
                // Aquí puedes manejar cualquier error que ocurra durante la consulta AJAX
                console.log(error);
                window.location.href = "../home/select_admin.php?alert=2";

            }
        });
        
        // Cierra la ventana modal
        $("#myModal").modal("hide");
    } else {
        // La contraseña es incorrecta, muestra un mensaje de error
        var errorMessage = document.getElementById('error-message');
        errorMessage.textContent = 'Contraseña incorrecta. Intente de nuevo.';
        // Limpia el campo de contraseña
        passwordInput.value = '';
    }
}

</script>




