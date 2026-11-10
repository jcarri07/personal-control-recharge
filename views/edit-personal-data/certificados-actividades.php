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

$sql = "SELECT * FROM certificados_actividades WHERE id_usuario = '$idUser' AND estatus = 'activo';";
$query = mysqli_query($conn, $sql);

if ($datos_personales['step'] > 3) {
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
                                        <h4>Actualización de Datos</h4>
                                        <span>Certificados de Actividades Realizadas en la Institución</span>
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
                                            <a class="activate">Actualización de Datos / Certificados de Actividades</a>
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
                                                        <div class="text-center">
                                                            <button class="btn btn-primary" onclick="openModalAdd();">Añadir</button>
                                                        </div>
                                                        <?php
                                                        if (mysqli_num_rows($query) > 0) {
                                                            ?>
                                                            <div class="dt-responsive table-responsive mt-5">
                                                                <table id="row-select" class="table table-striped table-bordered nowrap">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Nombre del Curso</th>
                                                                            <th>Duración</th>
                                                                            <th>Año del Curso</th>
                                                                            <th>Instituto / Universidad</th>
                                                                            <th>Observaciones</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $i = 0;
                                                                        while ($row = mysqli_fetch_array($query)) {
                                                                            $id_certificado_actividad = $row['id_certificado_actividad'];
                                                                            $nombre_curso = $row['nombre_curso'];
                                                                            $duracion = $row['duracion'];
                                                                            $anio_curso = $row['anio_curso'];
                                                                            $instituto_universidad = $row['instituto_universidad'];
                                                                            $observaciones = $row['observaciones'];
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo ++$i; ?></td>
                                                                                <td><?php echo htmlspecialchars($nombre_curso); ?></td>
                                                                                <td><?php echo htmlspecialchars($duracion); ?></td>
                                                                                <td><?php echo htmlspecialchars($anio_curso); ?></td>
                                                                                <td><?php echo htmlspecialchars($instituto_universidad); ?></td>
                                                                                <td><?php echo htmlspecialchars($observaciones); ?></td>
                                                                                <td>
                                                                                    <button class="btn btn-primary btn-table"
                                                                                        onclick="openModalEdit('<?php echo $id_certificado_actividad; ?>', '<?php echo addslashes(htmlspecialchars($nombre_curso)); ?>', '<?php echo addslashes(htmlspecialchars($duracion)); ?>', '<?php echo addslashes(htmlspecialchars($anio_curso)); ?>', '<?php echo addslashes(htmlspecialchars($instituto_universidad)); ?>', '<?php echo addslashes(htmlspecialchars($observaciones)); ?>');">
                                                                                        <i class="feather icon-edit"></i>
                                                                                    </button>
                                                                                    <button class="btn btn-danger btn-table"
                                                                                        onclick="deseaEliminar('<?php echo $id_certificado_actividad; ?>');">
                                                                                        <i class="feather icon-trash"></i>
                                                                                    </button>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <h2 class="text-center mt-4">No hay certificados de actividades registrados</h2>
                                                            <?php
                                                        }
                                                        ?>
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

    <div id="modal-form" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="login-card card-block login-card-modal">
                <form class="md-float-material" id="form-edit">
                    <div class="card m-t-15">
                        <div class="auth-box card-block">
                            <div class="row m-b-0">
                                <div class="col-md-12 text-center" style="margin-bottom: 0px;">
                                    <div class="box-title">
                                        <h3 class="modal-title text-center" style="margin-top: 0px; padding-top: 5px; padding-bottom: 5px;">Certificados de Actividades Realizadas en la Institución</h3>
                                    </div>
                                    <div class="form-group row justify-content-center">
                                        <div class="col-md-6">
                                            <label class="block text-left" style="text-align: left; display: block;">Nombre del Curso</label>
                                            <input name="nombre_curso" id="nombre_curso" type="text" class="form-control" maxlength="200" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="block text-left" style="text-align: left; display: block;">Duración</label>
                                            <input name="duracion" id="duracion" type="text" class="form-control" maxlength="100" placeholder="Ej: 40 horas, 3 meses" required>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="block text-left" style="text-align: left; display: block;">Año del Curso</label>
                                            <input name="anio_curso" id="anio_curso" type="text" class="form-control" maxlength="10" required>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label class="block text-left" style="text-align: left; display: block;">Instituto / Universidad</label>
                                            <input name="instituto_universidad" id="instituto_universidad" type="text" class="form-control" maxlength="200" required>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <label class="block text-left" style="text-align: left; display: block;">Observaciones</label>
                                            <textarea name="observaciones" id="observaciones" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 loaderParent">
                                            <div class="loader"></div>
                                            Por favor, espere
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center aceptar" style="margin-bottom: 0px;">
                                            <button type="button" class="btn btn-secondary waves-effect" data-toggle="modal" data-target="#modal-form">Cerrar</button>
                                            <button type="submit" class="btn btn-primary waves-effect">Añadir</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../utils/functions-personal-data.js"></script>

    <div id="aux_id" style="display:none;"></div>
    <div id="aux_opc" style="display:none;"></div>
    <div id="aux_estatus" style="display:none;"></div>

    <script>
        iniciarTabla("row-select");

        function openModalAdd() {
            $("#aux_id").text("");
            $("#aux_opc").text("add");
            $("#aux_estatus").text("");
            $("#form-edit")[0].reset();
            $("#modal-form .modal-title").text("Añadir Certificado de Actividad");
            $("#modal-form form button[type=submit]").text("Añadir");
            $("#modal-form").modal("show");
        }

        function openModalEdit(id, nombre_curso, duracion, anio_curso, instituto_universidad, observaciones) {
            $("#aux_id").text(id);
            $("#aux_opc").text("edit");
            $("#aux_estatus").text("");

            $("#nombre_curso").val(nombre_curso);
            $("#duracion").val(duracion);
            $("#anio_curso").val(anio_curso);
            $("#instituto_universidad").val(instituto_universidad);
            $("#observaciones").val(observaciones);

            $("#modal-form .modal-title").text("Editar Certificado de Actividad");
            $("#modal-form form button[type=submit]").text("Editar");
            $("#modal-form").modal("show");
        }

        $("#form-edit").on("submit", function (event) {
            event.preventDefault();

            var datos = new FormData();
            datos.append('id', '<?php echo $idUser; ?>');
            datos.append('id_certificado_actividad', $("#aux_id").text());
            datos.append('opc', $("#aux_opc").text());

            datos.append('nombre_curso', this.nombre_curso.value);
            datos.append('duracion', this.duracion.value);
            datos.append('anio_curso', this.anio_curso.value);
            datos.append('instituto_universidad', this.instituto_universidad.value);
            datos.append('observaciones', this.observaciones.value);

            $('.loaderParent').show();

            $.ajax({
                url: '../modules/update-data-user/certificados-actividades-process.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('.loaderParent').hide();
                    if (response == 'si') {
                        $("#modal-generic .message").text("Actualización Exitosa");
                        $("#modal-generic .aceptar button").attr("onclick", "window.location.reload();");
                        $("#modal-generic").modal("show");
                    } else {
                        $("#modal-generic .aceptar button").attr("onclick", "");
                        if (response == "vacio") {
                            $("#modal-generic .message").text("Datos vacíos o sin modificación");
                            $("#modal-generic").modal("show");
                        } else {
                            $("#modal-generic .message").text("Error al registrar");
                            $("#modal-generic").modal("show");
                        }
                    }
                },
                error: function (response) {
                    $('.loaderParent').hide();
                    $("#modal-generic .message").text("Error al registrar");
                    $("#modal-generic").modal("show");
                }
            });
        });

        function deseaEliminar(id) {
            $("#modal-actions .message").text("¿Desea eliminar?");
            $('#aux_id').text(id);
            $('#aux_estatus').text("inactivo");
            $("#modal-actions").modal("show");
        }

        function modify_estatus() {
            $("#modal-actions").modal("hide");
            var datos = new FormData();
            datos.append('id', $("#aux_id").text());
            datos.append('opc', "estatus");
            datos.append('estatus', $("#aux_estatus").text());

            $('.loaderParent').show();

            $.ajax({
                url: '../modules/update-data-user/certificados-actividades-process.php',
                type: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    $('.loaderParent').hide();
                    if (response == 'si') {
                        $("#modal-generic .message").text("Actualización Exitosa");
                        $("#modal-generic .aceptar button").attr("onclick", "window.location.reload();");
                        $("#modal-generic").modal("show");
                    } else {
                        $("#modal-generic .aceptar button").attr("onclick", "");
                        $("#modal-generic .message").text("Error al registrar");
                        $("#modal-generic").modal("show");
                    }
                },
                error: function (response) {
                    $('.loaderParent').hide();
                    $("#modal-generic .message").text("Error al registrar");
                    $("#modal-generic").modal("show");
                }
            });
        }
    </script>

    <div id="modal-actions" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="login-card card-block login-card-modal">
                <div class="md-float-material">
                    <div class="card m-t-15">
                        <div class="auth-box card-block">
                            <div class="row m-b-0">
                                <div class="col-md-12 text-center" style="margin-bottom: 0px;">
                                    <h2 class="message"></h2>
                                    <div class="row mt-3">
                                        <div class="col-md-12 text-center aceptar" style="margin-bottom: 0px;">
                                            <button type="button" class="btn btn-primary waves-effect" data-toggle="modal" onclick="modify_estatus();">Aceptar</button>
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

    <div id="modal-generic" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="login-card card-block login-card-modal">
                <div class="md-float-material">
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
                                        <span>Certificados de Actividades Realizadas en la Institución</span>
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
                                            <a class="activate">Actualización de Datos / Certificados de Actividades</a>
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
                                        <h2 class="text-center">Complete el registro de datos en <b>"Mis Datos"</b></h2>
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
