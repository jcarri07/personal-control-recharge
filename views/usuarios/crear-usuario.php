<?php
require_once '../database/conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

// Validación de permisos de administrador
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "<script>window.location='../home/dashboard.php';</script>";
    exit();
}
?>

<div class="container-fluid">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                
                <!-- Page-header start -->
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8" style="margin-bottom: 0px;">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Gestión de Usuarios</h4>
                                    <span>Creación y alta de nuevos usuarios en la plataforma</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="../home/dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="../home/form-edit-data.php?page=lista-usuarios">Gestión de Usuarios</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a class="activate">Crear Nuevo Usuario</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    
                                    <div class="box-title mb-4">
                                        <h3 style="margin-top: 10px; padding: 12px 24px; border-radius: 5px; background: #00A9AC; color: white; display: inline-block;">
                                            <i class="feather icon-user-plus mr-2"></i> Registro de Nuevo Usuario
                                        </h3>
                                    </div>

                                    <form id="form-crear-usuario" class="wizard-form" autocomplete="off">
                                        <input type="hidden" name="opc" value="add">

                                        <!-- Subtítulo Datos de Cuenta -->
                                        <div class="sub-title mb-3" style="border-bottom: 2px solid #00A9AC; padding-bottom: 5px;">
                                            <h5 style="color: #00A9AC; margin-bottom: 0;">
                                                <i class="feather icon-lock mr-2"></i> Datos de Acceso y Credenciales
                                            </h5>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="block"><b>Nombre de Usuario <span class="text-danger">*</span></b></label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-addon"><i class="feather icon-user"></i></span>
                                                    <input type="text" name="usuario" id="new_usuario" class="form-control" maxlength="50" required placeholder="Ej: alopez" pattern="[A-Za-z0-9_]{3,30}" title="De 3 a 30 caracteres, sin espacios ni caracteres especiales">
                                                </div>
                                                <small class="text-muted">Identificador único para iniciar sesión (3 a 30 caracteres)</small>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="block"><b>Contraseña <span class="text-danger">*</span></b></label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-addon"><i class="feather icon-lock"></i></span>
                                                    <input type="password" name="pass" id="new_pass" class="form-control" maxlength="50" required placeholder="Contraseña">
                                                </div>
                                                <small class="text-muted">Mínimo 4 caracteres</small>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="block"><b>Confirmar Contraseña <span class="text-danger">*</span></b></label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-addon"><i class="feather icon-check"></i></span>
                                                    <input type="password" name="confirm_pass" id="new_confirm_pass" class="form-control" maxlength="50" required placeholder="Repita la contraseña">
                                                </div>
                                                <small class="text-muted">Debe coincidir con la contraseña anterior</small>
                                            </div>
                                        </div>

                                        <!-- Subtítulo Datos Personales -->
                                        <div class="sub-title mb-3 mt-4" style="border-bottom: 2px solid #00A9AC; padding-bottom: 5px;">
                                            <h5 style="color: #00A9AC; margin-bottom: 0;">
                                                <i class="feather icon-info mr-2"></i> Información Personal y de Contacto
                                            </h5>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label class="block"><b>Cédula de Identidad <span class="text-danger">*</span></b></label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-addon"><i class="feather icon-credit-card"></i></span>
                                                    <input type="text" name="cedula" id="new_cedula" class="form-control" maxlength="20" required placeholder="Ej: 20123456" pattern="[0-9]{6,20}" title="Solo números, entre 6 y 20 dígitos">
                                                </div>
                                                <small class="text-muted">Cédula sin puntos ni letras</small>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="block"><b>Nombres <span class="text-danger">*</span></b></label>
                                                <input type="text" name="nombre" id="new_nombre" class="form-control" maxlength="50" required placeholder="Ej: Juan Carlos">
                                            </div>

                                            <div class="col-md-4">
                                                <label class="block"><b>Apellidos <span class="text-danger">*</span></b></label>
                                                <input type="text" name="apellido" id="new_apellido" class="form-control" maxlength="50" required placeholder="Ej: Pérez García">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="block"><b>Correo Electrónico</b></label>
                                                <div class="input-group mb-1">
                                                    <span class="input-group-addon"><i class="feather icon-mail"></i></span>
                                                    <input type="email" name="email" id="new_email" class="form-control" maxlength="200" placeholder="usuario@abae.gob.ve">
                                                </div>
                                                <small class="text-muted">Correo institucional o personal</small>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="block"><b>Rol / Nivel de Acceso <span class="text-danger">*</span></b></label>
                                                <select name="tipo_usuario" id="new_tipo_usuario" class="form-control form-control-primary" required>
                                                    <option value="empleado" selected>Empleado</option>
                                                    <option value="jefe">Jefe / Director</option>
                                                    <option value="admin">Administrador</option>
                                                </select>
                                                <small class="text-muted">Permisos en el sistema</small>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="block"><b>Estatus Inicial <span class="text-danger">*</span></b></label>
                                                <select name="estatus" id="new_estatus" class="form-control" required>
                                                    <option value="activo" selected>Activo</option>
                                                    <option value="inactivo">Inactivo</option>
                                                </select>
                                                <small class="text-muted">Estado de la cuenta</small>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="block"><b>Cargo Institucional</b></label>
                                                <input type="text" name="cargo" id="new_cargo" class="form-control" maxlength="50" placeholder="Ej: Operador, Analista, Especialista, Director">
                                                <small class="text-muted">Puesto o función en la institución</small>
                                            </div>
                                        </div>

                                        <!-- Loader spinner -->
                                        <div class="row">
                                            <div class="col-md-12 loaderParent text-center my-3" style="display:none;">
                                                <div class="loader" style="float:none !important; display:inline-block;"></div>
                                                <span class="ml-2 font-weight-bold" style="color: #00A9AC;">Creando nuevo usuario, por favor espere...</span>
                                            </div>
                                        </div>

                                        <!-- Botones de Acción -->
                                        <div class="text-center mt-4 pt-3" style="border-top: 1px solid #eee;">
                                            <button type="submit" class="btn btn-primary waves-effect px-4 py-2 mr-2" id="btn-crear-submit">
                                                <i class="feather icon-user-plus mr-1"></i> Registrar Usuario
                                            </button>
                                            <a href="../home/form-edit-data.php?page=lista-usuarios" class="btn btn-secondary waves-effect px-4 py-2 mr-2">
                                                <i class="feather icon-arrow-left mr-1"></i> Ver Lista de Usuarios
                                            </a>
                                            <button type="reset" class="btn btn-outline-secondary waves-effect px-3 py-2">
                                                <i class="feather icon-refresh-cw mr-1"></i> Limpiar
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../js/sweetalert2.js"></script>
<script>
    $("#form-crear-usuario").on("submit", function (e) {
        e.preventDefault();

        var pass = $("#new_pass").val();
        var confirm_pass = $("#new_confirm_pass").val();

        if (!pass || pass.trim() === "") {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseña requerida',
                text: 'Por favor complete el campo de contraseña',
                confirmButtonColor: '#00A9AC'
            });
            return;
        }

        if (pass.length < 4) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseña muy corta',
                text: 'La contraseña debe tener al menos 4 caracteres',
                confirmButtonColor: '#00A9AC'
            });
            return;
        }

        if (pass !== confirm_pass) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseñas no coinciden',
                text: 'La contraseña y la confirmación deben ser exactamente iguales',
                confirmButtonColor: '#00A9AC'
            });
            return;
        }

        var formData = new FormData(this);

        $('.loaderParent').show();
        $('#btn-crear-submit').prop('disabled', true);

        $.ajax({
            url: '../modules/update-data-user/usuario-process.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.loaderParent').hide();
                $('#btn-crear-submit').prop('disabled', false);

                var resp = response.trim();
                switch (resp) {
                    case 'si':
                        Swal.fire({
                            icon: 'success',
                            title: '¡Usuario Registrado!',
                            text: 'El nuevo usuario ha sido creado exitosamente en el sistema',
                            showCancelButton: true,
                            confirmButtonColor: '#00A9AC',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ver Lista de Usuarios',
                            cancelButtonText: 'Registrar Otro'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '../home/form-edit-data.php?page=lista-usuarios';
                            } else {
                                $("#form-crear-usuario")[0].reset();
                                $("#new_tipo_usuario").val("empleado");
                                $("#new_estatus").val("activo");
                            }
                        });
                        break;
                    case 'existe_cedula':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cédula ya registrada',
                            text: 'El número de cédula ingresado ya pertenece a otro usuario en el sistema',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'existe_usuario':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Nombre de usuario existente',
                            text: 'El nombre de usuario elegido ya está ocupado. Por favor elija otro.',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'pass_mismatch':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Contraseñas no coinciden',
                            text: 'La contraseña y su confirmación no son iguales',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'campos_vacios':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos Incompletos',
                            text: 'Por favor complete todos los campos obligatorios marcados con (*)',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'no_auth':
                        Swal.fire({
                            icon: 'error',
                            title: 'Acceso Denegado',
                            text: 'No tiene permisos de administrador para realizar esta operación',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Inesperado',
                            text: 'No se pudo registrar el usuario: ' + resp,
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                }
            },
            error: function () {
                $('.loaderParent').hide();
                $('#btn-crear-submit').prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'Ocurrió un error al comunicarse con el servidor',
                    confirmButtonColor: '#00A9AC'
                });
            }
        });
    });
</script>
