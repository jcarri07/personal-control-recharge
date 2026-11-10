<?php
require_once '../database/conexion.php';
$idUser = $_SESSION["id_usuario"];

if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit();
}


$sql_usuarios = "SELECT step, tipo_usuario FROM usuario";
$res_usuarios = mysqli_query($conn, $sql_usuarios);

$total_usuarios = 0;
$completado_pendiente = 0;
$completado_principal = 0;
$completado_total = 0;

while ($row = mysqli_fetch_assoc($res_usuarios)) {
    if ($row['tipo_usuario'] == 'admin') {
        continue;
    }

    $total_usuarios++;
    $step = (int)$row['step'];

    if ($step < 8) {
        $completado_pendiente++;
    }

    if ($step == 8) {
        $completado_principal++;
    }

    if ($step >= 9) {
        $completado_total++;
    }
}

$sql_solicitudes = "SELECT ts.nombre AS tipo_solicitud, COUNT(s.id_solicitud) AS total_solicitudes 
FROM tipo_solicitud ts 
LEFT JOIN solicitud s ON ts.nombre = s.tipo_solicitud 
GROUP BY ts.id, ts.nombre";
$res_solicitudes = mysqli_query($conn, $sql_solicitudes);
?>

<style>
    .dashboard-header {
        background: linear-gradient(135deg, #00A9AC 0%, #00A9AC 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .custom-card {
        border: none;
        border-radius: 12px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        overflow: hidden;
    }

    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.15);
    }

    .icon-box-rounded {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 24px;
    }

    .section-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        color: #4e73df;
    }
</style>

<div class="page-wrapper">
    <div class="page-body container-fluid">

        <!-- Banner de Bienvenida superior -->
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="text-white font-weight-bold mb-1">¡Bienvenido, administrador!</h2>
                <p class="text-white-50 mb-0">Aquí tienes el resumen general de control de personal y solicitudes.</p>
            </div>
            <div>
                <i class="fas fa-chart-line fa-3x text-white-50"></i>
            </div>
        </div>

        <!-- SECCIÓN 1: ESTADÍSTICAS DE USUARIOS -->
        <div class="mb-1">
            <h4 class="section-title"><i class="fas fa-users-cog"></i> Métricas de Usuarios</h4>

            <div class="row">
                <!-- Card: Total de Usuarios -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card custom-card bg-white h-80 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-weight-bold text-uppercase ">Total de Usuarios</span>
                                <h2 class="font-weight-bold text-dark mt-2 mb-0"><?php echo $total_usuarios; ?></h2>
                            </div>
                            <div class="icon-box-rounded" style="background-color: #e8f0fe; color: #4e73df;">
                                <i class="feather icon-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Registro Pendiente / Incompleto (Paso < 8) -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card custom-card bg-white h-80 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-weight-bold text-uppercase">Registro Pendiente</span>
                                <h2 class="font-weight-bold text-danger mt-2 mb-0"><?php echo $completado_pendiente; ?></h2>
                            </div>
                            <div class="icon-box-rounded" style="background-color: #fdeede; color: #e63946;">
                                <i class="feather icon-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Registro Principal Completo (Paso >= 8) -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card custom-card bg-white h-80 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-weight-bold text-uppercase ">Registro Principal</span>
                                <h2 class="font-weight-bold text-success mt-2 mb-0"><?php echo $completado_principal; ?></h2>
                            </div>
                            <div class="icon-box-rounded" style="background-color: #e6f4ea; color: #137333;">
                                <i class="feather icon-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Registro Total Completo (Paso >= 9) -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card custom-card bg-white h-80 p-3">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-muted font-weight-bold text-uppercase ">Registro Total</span>
                                <h2 class="font-weight-bold text-info mt-2 mb-0"><?php echo $completado_total; ?></h2>
                            </div>
                            <div class="icon-box-rounded" style="background-color: #e8f4f8; color: #118ab2;">
                                <i class="feather icon-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 2: SOLICITUDES EMITIDAS POR TIPO -->
        <div class="mb-1">
            <h4 class="section-title"><i class="fas fa-clipboard-list"></i> Solicitudes Emitidas por Tipo</h4>

            <div class="row">
                <?php
                if (mysqli_num_rows($res_solicitudes) > 0) {
                    while ($row = mysqli_fetch_assoc($res_solicitudes)) {
                        $nombre_tipo = htmlspecialchars($row['tipo_solicitud']);
                        $cantidad = $row['total_solicitudes'];
                ?>
                        <!-- Card Dinámica por Tipo de Solicitud -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card custom-card bg-white h-80 p-3">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="text-muted font-weight-bold text-uppercase " style="font-size: 1rem; display: block; max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo $nombre_tipo; ?>">
                                            <?php echo $nombre_tipo; ?>
                                        </span>
                                        <h3 class="font-weight-bold text-dark mt-2 mb-0"><?php echo $cantidad; ?></h3>
                                    </div>
                                    <div class="icon-box-rounded" style="background-color: #fff8e1; color: #f59e0b;">
                                        <?php if ($nombre_tipo == 'Vacaciones') { ?>
                                            <i class="feather icon-sun"></i>
                                        <?php } else if ($nombre_tipo == 'Permisos') { ?>
                                            <i class="feather icon-check-square"></i>
                                        <?php } else if ($nombre_tipo == 'Reposo') { ?>
                                            <i class="feather icon-activity"></i>
                                        <?php } else if ($nombre_tipo == 'Constancia') { ?>
                                            <i class="feather icon-file-text"></i>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-12"><div class="alert alert-warning text-center border-0 shadow-sm py-3" style="border-radius: 10px;">No hay tipos de solicitudes registrados actualmente.</div></div>';
                }
                ?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript" src="..\files\bower_components\jquery\js\jquery.min.js"></script>
<!-- <script type="text/javascript" src="..\files\assets\pages\dashboard\custom-dashboard.js"></script> -->