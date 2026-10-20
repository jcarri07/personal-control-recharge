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

if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

// Consultar todos los usuarios
$sqlUsuarios = "SELECT id_usuario, nombres, apellidos, cedula, cargo, user, tipo_usuario, estatus, correo 
                FROM usuario 
                ORDER BY id_usuario DESC;";
$queryUsuarios = mysqli_query($conn, $sqlUsuarios);

// Métricas de conteo
$totalUsuarios = 0;
$totalActivos = 0;
$totalInactivos = 0;
$totalAdmins = 0;
$totalJefes = 0;
$totalEmpleados = 0;

$usuariosData = [];
if ($queryUsuarios) {
    while ($u = mysqli_fetch_assoc($queryUsuarios)) {
        $usuariosData[] = $u;
        $totalUsuarios++;
        if ($u['estatus'] === 'activo') {
            $totalActivos++;
        } else {
            $totalInactivos++;
        }

        if ($u['tipo_usuario'] === 'admin') {
            $totalAdmins++;
        } elseif ($u['tipo_usuario'] === 'jefe' || $u['tipo_usuario'] === 'Jefe') {
            $totalJefes++;
        } else {
            $totalEmpleados++;
        }
    }
}

closeConection($conn);
?>

<style>
    table .btn-table {
        padding: 6px 9px !important;
        font-size: 14px !important;
        margin: 1px !important;
        border-radius: 4px;
        display: inline-block;
    }
    .bt {
    background-color: #ffc107;
    border-color: #ffc107;
    color: #fff;
    cursor: pointer;
    -webkit-transition: all ease-in 0.3s;
    transition: all ease-in 0.3s;
    }
</style>

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
                                    <span>Lista general de usuarios registrados en el sistema</span>
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
                                        <a href="#!">Gestión de Usuarios</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a class="activate">Lista de Usuarios</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-header end -->

                <!-- Summary Cards start -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-blue text-white update-card" style="margin-bottom: 20px;">
                            <div class="card-block">
                                <div class="row align-items-end">
                                    <div class="col-8">
                                        <h4 class="text-white"><?php echo $totalUsuarios; ?></h4>
                                        <h6 class="text-white m-b-0">Total Usuarios</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-users f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-green text-white update-card" style="margin-bottom: 20px;">
                            <div class="card-block">
                                <div class="row align-items-end">
                                    <div class="col-8">
                                        <h4 class="text-white"><?php echo $totalActivos; ?></h4>
                                        <h6 class="text-white m-b-0">Usuarios Activos</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-check-circle f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card text-white update-card" style="margin-bottom: 20px; background: linear-gradient(to right, #f6d369ff, #f9d976);">
                            <div class="card-block">
                                <div class="row align-items-end">
                                    <div class="col-8">
                                        <h4 class="text-white"><?php echo $totalJefes; ?></h4>
                                        <h6 class="text-white m-b-0">Jefes / Directores</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-briefcase f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-c-pink text-white update-card" style="margin-bottom: 20px;">
                            <div class="card-block">
                                <div class="row align-items-end">
                                    <div class="col-8">
                                        <h4 class="text-white"><?php echo $totalAdmins; ?></h4>
                                        <h6 class="text-white m-b-0">Administradores</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="feather icon-shield f-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Summary Cards end -->

                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-block">
                                    
                                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                                        <div class="box-title mb-0">
                                            <h3 style="margin-top: 0; padding: 10px 18px; border-radius: 5px; background: #00A9AC; color: white; display: inline-block;">
                                                <i class="feather icon-list mr-2"></i> Usuarios Registrados
                                            </h3>
                                        </div>
                                        <div class="mt-2 mt-sm-0">
                                            <a href="../home/form-edit-data.php?page=crear-usuario" class="btn btn-primary waves-effect">
                                                <i class="feather icon-user-plus mr-1"></i> Crear Nuevo Usuario
                                            </a>
                                            <button type="button" class="btn btn-outline-primary waves-effect ml-1" onclick="openModalAdd();">
                                                <i class="feather icon-plus mr-1"></i> Añadir Rápido
                                            </button>
                                        </div>
                                    </div>

                                    <?php if (count($usuariosData) > 0) { ?>
                                        <div class="dt-responsive table-responsive mt-3">
                                            <table id="tabla-usuarios" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Usuario</th>
                                                        <th>Cédula</th>
                                                        <th>Nombres y Apellidos</th>
                                                        <th>Correo</th>
                                                        <th>Rol</th>
                                                        <th>Cargo</th>
                                                        <th>Estatus</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($usuariosData as $row) {
                                                        $id_u        = $row['id_usuario'];
                                                        $nombres     = htmlspecialchars($row['nombres'], ENT_QUOTES, 'UTF-8');
                                                        $apellidos   = htmlspecialchars($row['apellidos'], ENT_QUOTES, 'UTF-8');
                                                        $cedula      = htmlspecialchars($row['cedula'], ENT_QUOTES, 'UTF-8');
                                                        $cargo       = htmlspecialchars($row['cargo'], ENT_QUOTES, 'UTF-8');
                                                        $user        = htmlspecialchars($row['user'], ENT_QUOTES, 'UTF-8');
                                                        $tipo        = htmlspecialchars($row['tipo_usuario'], ENT_QUOTES, 'UTF-8');
                                                        $estatus     = htmlspecialchars($row['estatus'], ENT_QUOTES, 'UTF-8');
                                                        $correo      = htmlspecialchars($row['correo'], ENT_QUOTES, 'UTF-8');
                                                        
                                                        $nombreCompleto = trim($nombres . " " . $apellidos);
                                                        
                                                        // Rol
                                                        if ($tipo === 'admin') {
                                                            $rolTexto = 'Administrador';
                                                        } elseif ($tipo === 'jefe' || $tipo === 'Jefe') {
                                                            $rolTexto = 'Jefe / Director';
                                                        } else {
                                                            $rolTexto = 'Empleado';
                                                        }

                                                        // Estatus badge
                                                        if ($estatus === 'activo') {
                                                            $badgeEstatus = '<span class="badge badge-success" style="font-size: 13px;">Activo</span>';
                                                        } else {
                                                            $badgeEstatus = '<span class="badge badge-secondary" style="font-size: 13px;">Inactivo</span>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td><?php echo ++$i; ?></td>
                                                            <td>
                                                                <span><?php echo $user; ?></span>
                                                                <?php if ($id_u == $_SESSION['id_usuario']) { ?>
                                                                    <span class="badge badge-light text-primary" style="font-size: 10px;">(Tú)</span>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?php echo $cedula; ?></td>
                                                            <td><?php echo $nombreCompleto; ?></td>
                                                            <td><?php echo !empty($correo) ? $correo : '<span class="text-muted">N/A</span>'; ?></td>
                                                            <td><?php echo $rolTexto; ?></td>
                                                            <td><?php echo !empty($cargo) ? $cargo : '<span class="text-muted">Sin asignar</span>'; ?></td>
                                                            <td><?php echo $badgeEstatus; ?></td>
                                                            <td>
                                                                <!-- Botón Editar -->
                                                                <button class="btn btn-primary btn-table" title="Editar Usuario"
                                                                    onclick="openModalEdit('<?php echo $id_u; ?>', '<?php echo addslashes($user); ?>', '<?php echo addslashes($cedula); ?>', '<?php echo addslashes($nombres); ?>', '<?php echo addslashes($apellidos); ?>', '<?php echo addslashes($correo); ?>', '<?php echo addslashes($tipo); ?>', '<?php echo addslashes($cargo); ?>', '<?php echo addslashes($estatus); ?>');">
                                                                    <i class="feather icon-edit"></i>
                                                                </button>

                                                                <!-- Botón Desactivar / Activar Usuario -->
                                                                <?php if ($id_u == $_SESSION['id_usuario']) { ?>
                                                                    <button class="btn bt btn-table text-white" disabled title="No puedes desactivar tu propia cuenta activa" style="opacity: 0.45; cursor: not-allowed;">
                                                                        <i class="feather icon-user-x"></i>
                                                                    </button>
                                                                    <button class="btn btn-danger btn-table" disabled title="No puedes eliminar tu propia cuenta" style="opacity: 0.45; cursor: not-allowed;">
                                                                        <i class="feather icon-trash-2"></i>
                                                                    </button>
                                                                <?php } else { ?>
                                                                    <?php if (strtolower(trim($estatus)) === 'activo') { ?>
                                                                        <button class="btn bt btn-table text-white" title="Desactivar Usuario"
                                                                            onclick="confirmarEstatus('<?php echo $id_u; ?>', 'inactivo', '<?php echo addslashes($user); ?>');">
                                                                            <i class="feather icon-user-x"></i>
                                                                        </button>
                                                                    <?php } else { ?>
                                                                        <button class="btn btn-success btn-table text-white" title="Activar Usuario"
                                                                            onclick="confirmarEstatus('<?php echo $id_u; ?>', 'activo', '<?php echo addslashes($user); ?>');">
                                                                            <i class="feather icon-user-check"></i>
                                                                        </button>
                                                                    <?php } ?>

                                                                    <!-- Botón Eliminar -->
                                                                    <button class="btn btn-danger btn-table" title="Eliminar Usuario"
                                                                        onclick="confirmarEliminar('<?php echo $id_u; ?>', '<?php echo addslashes($user); ?>');">
                                                                        <i class="feather icon-trash-2"></i>
                                                                    </button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center py-5">
                                            <i class="feather icon-user-x f-60 text-muted"></i>
                                            <h4 class="mt-3 text-muted">No se encontraron usuarios registrados</h4>
                                            <a href="../home/form-edit-data.php?page=crear-usuario" class="btn btn-primary mt-3">
                                                <i class="feather icon-plus mr-1"></i> Crear Primer Usuario
                                            </a>
                                        </div>
                                    <?php } ?>

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

<!-- Modal Formulario (Crear / Editar) -->
<div id="modal-form" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00A9AC; color: white;">
                <h5 class="modal-title" id="modal-title-user">Añadir Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-usuario-modal">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="block"><b>Nombre de Usuario *</b></label>
                            <input type="text" name="usuario" id="modal_usuario" class="form-control" maxlength="50" required placeholder="Ej: jdoe">
                            <small class="text-muted">Sin espacios, letras y números</small>
                        </div>
                        <div class="col-md-6">
                            <label class="block"><b>Cédula de Identidad *</b></label>
                            <input type="text" name="cedula" id="modal_cedula" class="form-control" maxlength="20" required placeholder="Ej: 12345678">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="block"><b>Nombres *</b></label>
                            <input type="text" name="nombre" id="modal_nombre" class="form-control" maxlength="50" required placeholder="Nombres">
                        </div>
                        <div class="col-md-6">
                            <label class="block"><b>Apellidos *</b></label>
                            <input type="text" name="apellido" id="modal_apellido" class="form-control" maxlength="50" required placeholder="Apellidos">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="block"><b>Correo Electrónico</b></label>
                            <input type="email" name="email" id="modal_email" class="form-control" maxlength="200" placeholder="usuario@abae.gob.ve">
                        </div>
                        <div class="col-md-6">
                            <label class="block"><b>Rol / Tipo de Usuario *</b></label>
                            <select name="tipo_usuario" id="modal_tipo_usuario" class="form-control" required>
                                <option value="empleado">Empleado</option>
                                <option value="jefe">Jefe / Director</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="block"><b>Cargo</b></label>
                            <input type="text" name="cargo" id="modal_cargo" class="form-control" maxlength="50" placeholder="Ej: Operador, Analista, Jefe, Director">
                        </div>
                        <div class="col-md-6">
                            <label class="block"><b>Estatus</b></label>
                            <select name="estatus" id="modal_estatus" class="form-control" required>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row" id="pass-section">
                        <div class="col-md-6">
                            <label class="block"><b id="lbl-pass">Contraseña *</b></label>
                            <input type="password" name="pass" id="modal_pass" class="form-control" maxlength="50" placeholder="Contraseña">
                            <small class="text-muted" id="help-pass"></small>
                        </div>
                        <div class="col-md-6">
                            <label class="block"><b id="lbl-confirm-pass">Confirmar Contraseña *</b></label>
                            <input type="password" name="confirm_pass" id="modal_confirm_pass" class="form-control" maxlength="50" placeholder="Confirmar contraseña">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 loaderParent text-center" style="display:none;">
                            <div class="loader" style="float:none !important; display:inline-block;"></div>
                            <span class="ml-2">Procesando solicitud, por favor espere...</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <div>
                        <button type="button" class="btn bt waves-effect text-white" id="btn-modal-toggle-estatus" style="display:none;" onclick="toggleEstatusDesdeModal();">
                            <i class="feather icon-user-x mr-1"></i> <span id="lbl-modal-toggle-estatus">Desactivar Usuario</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect" id="btn-save-modal">
                            <i class="feather icon-check mr-1"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal confirmación de acción -->
<div id="modal-actions" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #00A9AC; color: white;">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="feather icon-alert-circle text-warning f-50 mb-3" style="display:block;"></i>
                <h5 class="message mb-2 font-weight-normal"></h5>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary waves-effect" id="btn-confirm-action">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Elementos auxiliares para estado -->
<div id="aux_user_id" style="display:none;"></div>
<div id="aux_user_opc" style="display:none;"></div>
<div id="aux_user_estatus" style="display:none;"></div>

<script type="text/javascript" src="../js/sweetalert2.js"></script>
<script>
    $(document).ready(function () {
        if (typeof iniciarTabla === "function") {
            iniciarTabla("tabla-usuarios");
        } else {
            $('#tabla-usuarios').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                }
            });
        }
    });

    function openModalAdd() {
        $("#aux_user_id").text("");
        $("#aux_user_opc").text("add");
        $("#form-usuario-modal")[0].reset();
        
        $("#modal-title-user").text("Añadir Nuevo Usuario");
        $("#lbl-pass").text("Contraseña *");
        $("#lbl-confirm-pass").text("Confirmar Contraseña *");
        $("#modal_pass").prop("required", true);
        $("#modal_confirm_pass").prop("required", true);
        $("#help-pass").text("Mínimo 4 caracteres");
        
        $("#modal_usuario").prop("readonly", false);
        $("#modal_estatus").val("activo");
        $("#modal_tipo_usuario").val("empleado");
        $("#btn-modal-toggle-estatus").hide();

        $("#modal-form").modal("show");
    }

    function openModalEdit(id, user, cedula, nombre, apellido, email, tipo, cargo, estatus) {
        $("#aux_user_id").text(id);
        $("#aux_user_opc").text("edit");
        $("#form-usuario-modal")[0].reset();

        $("#modal-title-user").text("Editar Usuario: " + user);
        $("#modal_usuario").val(user);
        $("#modal_cedula").val(cedula);
        $("#modal_nombre").val(nombre);
        $("#modal_apellido").val(apellido);
        $("#modal_email").val(email);
        $("#modal_tipo_usuario").val(tipo);
        $("#modal_cargo").val(cargo);
        $("#modal_estatus").val(estatus);

        $("#lbl-pass").text("Nueva Contraseña (Opcional)");
        $("#lbl-confirm-pass").text("Confirmar Nueva Contraseña");
        $("#modal_pass").prop("required", false);
        $("#modal_confirm_pass").prop("required", false);
        $("#help-pass").text("Dejar en blanco si no desea modificar la contraseña actual");

        // Configurar botón Desactivar / Activar en el modal
        if (id == '<?php echo $_SESSION['id_usuario']; ?>') {
            $("#btn-modal-toggle-estatus").hide();
        } else {
            var estatusNorm = (estatus || '').trim().toLowerCase();
            if (estatusNorm === 'activo') {
                $("#btn-modal-toggle-estatus")
                    .removeClass("btn-success")
                    .addClass("bt")
                    .html('<i class="feather icon-user-x mr-1"></i> Desactivar Usuario')
                    .show();
            } else {
                $("#btn-modal-toggle-estatus")
                    .removeClass("bt")
                    .addClass("btn-success")
                    .html('<i class="feather icon-user-check mr-1"></i> Activar Usuario')
                    .show();
            }
        }

        $("#modal-form").modal("show");
    }

    function toggleEstatusDesdeModal() {
        var id = $("#aux_user_id").text();
        var username = $("#modal_usuario").val();
        var estatusActual = ($("#modal_estatus").val() || '').trim().toLowerCase();
        var nuevoEstatus = estatusActual === 'activo' ? 'inactivo' : 'activo';

        $("#modal-form").modal("hide");
        confirmarEstatus(id, nuevoEstatus, username);
    }

    $("#form-usuario-modal").on("submit", function (e) {
        e.preventDefault();

        var opc = $("#aux_user_opc").text();
        var id  = $("#aux_user_id").text();

        var pass = $("#modal_pass").val();
        var confirm_pass = $("#modal_confirm_pass").val();

        if (opc === "add" && (!pass || pass.trim() === "")) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseña requerida',
                text: 'Por favor ingrese una contraseña para el usuario',
                confirmButtonColor: '#00A9AC'
            });
            return;
        }

        if (pass !== confirm_pass) {
            Swal.fire({
                icon: 'warning',
                title: 'Contraseñas no coinciden',
                text: 'La contraseña y su confirmación deben ser iguales',
                confirmButtonColor: '#00A9AC'
            });
            return;
        }

        var formData = new FormData();
        formData.append('opc', opc);
        formData.append('id_usuario', id);
        formData.append('usuario', $("#modal_usuario").val());
        formData.append('cedula', $("#modal_cedula").val());
        formData.append('nombre', $("#modal_nombre").val());
        formData.append('apellido', $("#modal_apellido").val());
        formData.append('email', $("#modal_email").val());
        formData.append('tipo_usuario', $("#modal_tipo_usuario").val());
        formData.append('cargo', $("#modal_cargo").val());
        formData.append('estatus', $("#modal_estatus").val());
        formData.append('pass', pass);
        formData.append('confirm_pass', confirm_pass);

        $('.loaderParent').show();
        $('#btn-save-modal').prop('disabled', true);

        $.ajax({
            url: '../modules/update-data-user/usuario-process.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('.loaderParent').hide();
                $('#btn-save-modal').prop('disabled', false);

                var resp = response.trim();
                switch (resp) {
                    case 'si':
                        $("#modal-form").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: opc === 'add' ? 'Usuario Creado' : 'Usuario Actualizado',
                            text: opc === 'add' ? 'El nuevo usuario fue registrado con éxito' : 'Los datos del usuario han sido actualizados',
                            showConfirmButton: false,
                            timer: 1800
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 1800);
                        break;
                    case 'existe_cedula':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Cédula Existente',
                            text: 'El número de cédula ingresado ya está asignado a otro usuario',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'existe_usuario':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Usuario Existente',
                            text: 'El nombre de usuario ya se encuentra registrado. Elija otro nombre.',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'pass_mismatch':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Contraseñas no coinciden',
                            text: 'La contraseña y la confirmación no son iguales',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'campos_vacios':
                        Swal.fire({
                            icon: 'warning',
                            title: 'Campos Incompletos',
                            text: 'Por favor complete todos los campos obligatorios (*)',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    case 'no_auth':
                        Swal.fire({
                            icon: 'error',
                            title: 'No Autorizado',
                            text: 'No tiene permisos de administrador para realizar esta acción',
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                    default:
                        Swal.fire({
                            icon: 'error',
                            title: 'Error Inesperado',
                            text: 'Ocurrió un error en el servidor: ' + resp,
                            confirmButtonColor: '#00A9AC'
                        });
                        break;
                }
            },
            error: function () {
                $('.loaderParent').hide();
                $('#btn-save-modal').prop('disabled', false);
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'No se pudo conectar con el servidor',
                    confirmButtonColor: '#00A9AC'
                });
            }
        });
    });

    function confirmarEstatus(id, nuevoEstatus, username) {
        var textoAccion = nuevoEstatus === 'activo' ? 'activar' : 'desactivar';
        Swal.fire({
            title: '¿Desea ' + textoAccion + ' a "' + username + '"?',
            text: 'El usuario ' + (nuevoEstatus === 'activo' ? 'podrá iniciar sesión normalmente' : 'no podrá ingresar al sistema mientras esté inactivo'),
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: nuevoEstatus === 'activo' ? '#2ed8b6' : '#ffb64d',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, ' + textoAccion,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarCambioEstatus(id, nuevoEstatus);
            }
        });
    }

    function ejecutarCambioEstatus(id, estatus) {
        var formData = new FormData();
        formData.append('opc', 'estatus');
        formData.append('id_usuario', id);
        formData.append('estatus', estatus);

        $.ajax({
            url: '../modules/update-data-user/usuario-process.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                var resp = response.trim();
                if (resp === 'si') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Estatus Actualizado',
                        showConfirmButton: false,
                        timer: 1400
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1400);
                } else if (resp === 'auto_desactivar') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Acción No Permitida',
                        text: 'No puedes desactivar tu propia cuenta activa de administrador',
                        confirmButtonColor: '#00A9AC'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el estatus: ' + resp,
                        confirmButtonColor: '#00A9AC'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'No se pudo conectar con el servidor',
                    confirmButtonColor: '#00A9AC'
                });
            }
        });
    }

    function confirmarEliminar(id, username) {
        Swal.fire({
            title: '¿Eliminar usuario "' + username + '"?',
            text: 'Esta acción no se puede deshacer. Se eliminarán las credenciales de acceso.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff5370',
            cancelButtonColor: '#999',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarEliminar(id);
            }
        });
    }

    function ejecutarEliminar(id) {
        var formData = new FormData();
        formData.append('opc', 'delete');
        formData.append('id_usuario', id);

        $.ajax({
            url: '../modules/update-data-user/usuario-process.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                var resp = response.trim();
                if (resp === 'si') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario Eliminado',
                        showConfirmButton: false,
                        timer: 1400
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1400);
                } else if (resp === 'auto_eliminar') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Acción No Permitida',
                        text: 'No puedes eliminar tu propia cuenta de administrador',
                        confirmButtonColor: '#00A9AC'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Eliminar',
                        text: 'Ocurrió un error: ' + resp,
                        confirmButtonColor: '#00A9AC'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Red',
                    text: 'No se pudo conectar con el servidor',
                    confirmButtonColor: '#00A9AC'
                });
            }
        });
    }
</script>
