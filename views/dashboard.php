
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
<div class="page-wrapper">

                                <div class="page-body">
                                    <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-blue">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                        <h4 class="text-white">Mis datos</h4>
                                                            <h6 class="text-white m-b-0">Agregar datos personales</h6>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <?php if($_SESSION['tipo_usuario'] != "admin"){ ?> 
                                                <a href="../home/form-register.php" class="download-icon"><i class="feather icon-user-plus"></i></a>
                                                <?php }else { ?>
                                                    <a class="download-icon"><i class="feather icon-user-plus"></i></a>
                                                <?php } ?>

                                                <div class="card-footer">
                                                    <!--<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i></p>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-pink">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                        <h4 class="text-white">Actualización de datos</h4>
                                                            <h6 class="text-white m-b-0">Modificar datos personales</h6>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <?php if($_SESSION['tipo_usuario'] != "admin"){ ?> 
                                                    <a href="../home/form-edit-data.php?page=datos-personales" class="download-icon"><i class="feather icon-user-check"></i></a>
                                                <?php }else { ?>
                                                    <a class="download-icon"><i class="feather icon-user-check"></i></a>
                                                <?php } ?>

                                                <div class="card-footer">
                                                    <!--<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i></p>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-blue">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                        <h4 class="text-white">Mis solicitudes</h4>
                                                            <h6 class="text-white m-b-0">Crear y/o aprobar solicitudes</h6>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <a href="../home/solicitudes.php" class="download-icon" ><i class="feather icon-file-plus"></i></a>
                                                <div class="card-footer">
                                                    <!--<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i></p>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-green">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                        <h4 class="text-white">Formatos vacíos</h4>
                                                            <h6 class="text-white m-b-0">Descargar formatos</h6>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <a class="download-icon"><i class="feather icon-file"></i></a>
                                                <div class="card-footer">
                                                    <!--<p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i></p>-->
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- task, page, download counter  start 
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card bg-c-yellow update-card">
                                                <div class="card-block">
                                                    <div class="row align-items-end">
                                                        <div class="col-8">
                                                            <h4 class="text-white">Mis datos</h4>
                                                            <h6 class="text-white m-b-0">Agregar datos personales</h6>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <canvas id="update-chart-1" height="50"></canvas>
                                                            <a href="https://es-la.facebook.com/AbaeVzla/" class="download-icon" target="_blank"><i class="feather icon-arrow-up"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 col-md-6">
                                            <div class="card bg-c-green update-card">
                                                <div class="card-block">
                                                    <div class="row align-items-end">
                                                        <div class="col-8">
                                                            <h4 class="text-white">290+</h4>
                                                            <h6 class="text-white m-b-0">Page Views</h6>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <canvas id="update-chart-2" height="50"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card bg-c-pink update-card">
                                                <div class="card-block">
                                                    <div class="row align-items-end">
                                                        <div class="col-8">
                                                            <h4 class="text-white">145</h4>
                                                            <h6 class="text-white m-b-0">Task Completed</h6>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <canvas id="update-chart-3" height="50"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card bg-c-lite-green update-card">
                                                <div class="card-block">
                                                    <div class="row align-items-end">
                                                        <div class="col-8">
                                                            <h4 class="text-white">500</h4>
                                                            <h6 class="text-white m-b-0">Downloads</h6>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <canvas id="update-chart-4" height="50"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>update : 2:15 am</p>
                                                </div>
                                            </div>
                                        </div>-->
                                        <!-- task, page, download counter  end -->

                                        <!--  sale analytics start -->
                                        <!-- <div class="col-xl-9 col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5>Sales Analytics</h5>
                                                    <span class="text-muted">For more details about usage, please refer <a href="https://www.amcharts.com/online-store/" target="_blank">amCharts</a> licences.</span>
                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
                                                            <li><i class="feather icon-maximize full-card"></i></li>
                                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div id="sales-analytics" style="height: 265px;"></div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-xl-3 col-md-12">
                                            <div class="card user-card2">
                                                <div class="card-block text-center">
                                                    <h6 class="m-b-15">Project Risk</h6>
                                                    <div class="risk-rate">
                                                        <span><b>5</b></span>
                                                    </div>
                                                    <h6 class="m-b-10 m-t-10">Balanced</h6>
                                                    <a href="#!" class="text-c-yellow b-b-warning">Change Your Risk</a>
                                                    <div class="row justify-content-center m-t-10 b-t-default m-l-0 m-r-0">
                                                        <div class="col m-t-15 b-r-default">
                                                            <h6 class="text-muted">Nr</h6>
                                                            <h6>AWS 2455</h6>
                                                        </div>
                                                        <div class="col m-t-15">
                                                            <h6 class="text-muted">Created</h6>
                                                            <h6>30th Sep</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning btn-block p-t-15 p-b-15">Download Overall Report</button>
                                            </div>
                                        </div> -->
                                        <!--  sale analytics end -->

                                        <!-- <div class="col-xl-8 col-md-12">
                                            <div class="card table-card">
                                                <div class="card-header">
                                                    <h5>Application Sales</h5>
                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
                                                            <li><i class="feather icon-maximize full-card"></i></li>
                                                            <li><i class="feather icon-minus minimize-card"></i></li>
                                                            <li><i class="feather icon-trash-2 close-card"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover  table-borderless">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <div class="chk-option">
                                                                            <div class="checkbox-fade fade-in-primary">
                                                                                <label class="check-task">
                                                                                    <input type="checkbox" value="">
                                                                                    <span class="cr">
                                                                                        <i class="cr-icon feather icon-check txt-default"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        Application
                                                                    </th>
                                                                    <th>Sales</th>
                                                                    <th>Change</th>
                                                                    <th>Avg Price</th>
                                                                    <th>Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div class="chk-option">
                                                                            <div class="checkbox-fade fade-in-primary">
                                                                                <label class="check-task">
                                                                                    <input type="checkbox" value="">
                                                                                    <span class="cr">
                                                                                        <i class="cr-icon feather icon-check txt-default"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-inline-block align-middle">
                                                                            <h6>Able Pro</h6>
                                                                            <p class="text-muted m-b-0">Powerful Admin Theme</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>16,300</td>
                                                                    <td><canvas id="app-sale1" height="50" width="100"></canvas></td>
                                                                    <td>$53</td>
                                                                    <td class="text-c-blue">$15,652</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="chk-option">
                                                                            <div class="checkbox-fade fade-in-primary">
                                                                                <label class="check-task">
                                                                                    <input type="checkbox" value="">
                                                                                    <span class="cr">
                                                                                        <i class="cr-icon feather icon-check txt-default"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-inline-block align-middle">
                                                                            <h6>Photoshop</h6>
                                                                            <p class="text-muted m-b-0">Design Software</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>26,421</td>
                                                                    <td><canvas id="app-sale2" height="50" width="100"></canvas></td>
                                                                    <td>$35</td>
                                                                    <td class="text-c-blue">$18,785</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="chk-option">
                                                                            <div class="checkbox-fade fade-in-primary">
                                                                                <label class="check-task">
                                                                                    <input type="checkbox" value="">
                                                                                    <span class="cr">
                                                                                        <i class="cr-icon feather icon-check txt-default"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-inline-block align-middle">
                                                                            <h6>Guruable</h6>
                                                                            <p class="text-muted m-b-0">Best Admin Template</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>8,265</td>
                                                                    <td><canvas id="app-sale3" height="50" width="100"></canvas></td>
                                                                    <td>$98</td>
                                                                    <td class="text-c-blue">$9,652</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="chk-option">
                                                                            <div class="checkbox-fade fade-in-primary">
                                                                                <label class="check-task">
                                                                                    <input type="checkbox" value="">
                                                                                    <span class="cr">
                                                                                        <i class="cr-icon feather icon-check txt-default"></i>
                                                                                    </span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-inline-block align-middle">
                                                                            <h6>Flatable</h6>
                                                                            <p class="text-muted m-b-0">Admin App</p>
                                                                        </div>
                                                                    </td>
                                                                    <td>10,652</td>
                                                                    <td><canvas id="app-sale4" height="50" width="100"></canvas></td>
                                                                    <td>$20</td>
                                                                    <td class="text-c-blue">$7,856</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="text-center">
                                                            <a href="#!" class=" b-b-primary text-primary">View all Projects</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-xl-4 col-md-12">
                                            <div class="card user-activity-card">
                                                <div class="card-header">
                                                    <h5>User Activity</h5>
                                                </div>
                                                <div class="card-block">
                                                    <div class="row m-b-25">
                                                        <div class="col-auto p-r-0">
                                                            <div class="u-img">
                                                                <img src="..\files\assets\images\breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                                <img src="..\files\assets\images\avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-5">John Deo</h6>
                                                            <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                                        </div>
                                                    </div>
                                                    <div class="row m-b-25">
                                                        <div class="col-auto p-r-0">
                                                            <div class="u-img">
                                                                <img src="..\files\assets\images\breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                                <img src="..\files\assets\images\avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-5">John Deo</h6>
                                                            <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                                        </div>
                                                    </div>
                                                    <div class="row m-b-25">
                                                        <div class="col-auto p-r-0">
                                                            <div class="u-img">
                                                                <img src="..\files\assets\images\breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                                <img src="..\files\assets\images\avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-5">John Deo</h6>
                                                            <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                                        </div>
                                                    </div>
                                                    <div class="row m-b-5">
                                                        <div class="col-auto p-r-0">
                                                            <div class="u-img">
                                                                <img src="..\files\assets\images\breadcrumb-bg.jpg" alt="user image" class="img-radius cover-img">
                                                                <img src="..\files\assets\images\avatar-2.jpg" alt="user image" class="img-radius profile-img">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-5">John Deo</h6>
                                                            <p class="text-muted m-b-0">Lorem Ipsum is simply dummy text.</p>
                                                            <p class="text-muted m-b-0"><i class="feather icon-clock m-r-10"></i>2 min ago</p>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <a href="#!" class="b-b-primary text-primary">View all Projects</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- wather user -->
                                        <div class="col-xl-6 col-md-12">
                                            <div class="card latest-update-card">
                                                <div class="card-header">
                                                    <h5>Funciones Principales</h5>
                                                    <div class="card-header-right">
                                                        <ul class="list-unstyled card-option">
                                                            <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                            <li><i class="fa fa-window-maximize full-card"></i></li>
                                                            <li><i class="fa fa-minus minimize-card"></i></li>
                                                            <li><i class="fa fa-refresh reload-card"></i></li>
                                                            <li><i class="fa fa-trash close-card"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-block">
                                                    <div class="latest-update-box" style="text-align: justify;">
                                                        <div class="row p-b-15">
                                                            <div class="col-auto text-right update-meta">
                                                                <p class="text-muted m-b-0 d-inline">1</p>
                                                                <i class="feather icon-folder bg-simple-c-blue update-icon"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Carga de datos</h6>
                                                                <p class="text-muted m-b-0">Datos personales, hijos, familiares, datos académicos, formación en el exterior, experiencia laboral, datos institucionales, comisión de servicio, otros datos.</p>
                                                            </div>
                                                        </div>
                                                        <div class="row p-b-15">
                                                            <div class="col-auto text-right update-meta">
                                                                <p class="text-muted m-b-0 d-inline">2</p>
                                                                <i class="feather icon-edit bg-simple-c-pink  update-icon"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Actualización de datos</h6>
                                                                <p class="text-muted m-b-0">Datos personales, hijos, familiares, datos académicos, formación en el exterior, experiencia laboral, datos institucionales, comisión de servicio, otros datos.</p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row p-b-0">
                                                            <div class="col-auto text-right update-meta">
                                                                <p class="text-muted m-b-0 d-inline">3</p>
                                                                <i class="feather icon-file-text bg-simple-c-blue update-icon"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Solicitudes</h6>
                                                                <p class="text-muted m-b-10">Vacaciones, permisos, reposos y constancia de trabajo.</p>
                                                                <!--<div class="table-responsive">
                                                                    <table class="table table-hover m-b-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td class="b-none">
                                                                                    <a href="#!" class="align-middle">
                                                                                        <img src="..\files\assets\images\avatar-2.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                                        <div class="d-inline-block">
                                                                                            <h6>Jeny William</h6>
                                                                                            <p class="text-muted m-b-0">Graphic Designer</p>
                                                                                        </div>
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>-->
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row p-b-15">
                                                            <div class="col-auto text-right update-meta">
                                                                <p class="text-muted m-b-0 d-inline">4</p>
                                                                <i class="feather icon-download bg-simple-c-green update-icon"></i>
                                                            </div>
                                                            <div class="col">
                                                                <h6>Descarga de formatos</h6>
                                                                <p class="text-muted m-b-0">Vacaciones, permisos y reposos.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="text-center">
                                                        <a href="#!" class="b-b-primary text-primary">View all Projects</a>
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-md-12">
                                            <div class="card user-card-full">
                                                <div class="row m-l-0 m-r-0">
                                                    <div class="col-sm-4 bg-c-lite-green user-profile">
                                                        <div class="card-block text-center text-white">
                                                            <div class="m-b-25">
                                                                <img src="../files\assets\images\small-logo.png" style="width: 100%" class="img-radius" alt="User-Profile-Image">
                                                            </div>
                                                            <h4>ABAE</h4>
                                                            <br>
                                                            <h5 class="f-w-600">Agencia Bolivariana para Actividades Espaciales</h5>
                                                            <!--<i class="feather icon-edit m-t-10 f-16"></i>-->
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="card-block">
                                                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Acerca de:</h6>
                                                            <div class="row">
                                                                <div class="col-sm-12" style="text-align: justify;">
                                                                    <p class="m-b-10">La Agencia Bolivariana para Actividades Espaciales es un organismo autónomo adscrito el Ministerio del Poder Popular para Ciencia y Tecnología (MppCyT), creado en Enero de 2008 con la finalidad de regir todo lo relativo al desarrollo de políticas espaciales y uso pacífico del espacio ultra-terrestre.</p>

                                                                    <p>Nuestra misión es  planificar, organizar y coordinar con enfoque socialista, el uso y desarrollo de la ciencia y tecnología espacial para concertar planes, proyectos y programas que favorezcan la inclusión social, a través del desarrollo del talento humano y el fortalecimiento del Sistema Nacional de Ciencia,Tecnología e Innovación en materia espacial, impulsando el desarrollo económico, político, social y cultural del país y de la región.</p>
                                                                    <h6 class="text-muted f-w-400"><a href="..\..\..\cdn-cgi\l\email-protection.htm" class="__cf_email__" data-cfemail="3a505f54437a5d575b535614595557"></a></h6>
                                                                </div>
                                                               <!-- <div class="col-sm-6">
                                                                    <p class="m-b-10 f-w-600">Agencia Bolivariana para Actividades Espaciales</p>
                                                                    <h6 class="text-muted f-w-400"></h6>
                                                                </div>
                                                            </div>
                                                            <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Projects</h6>
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <p class="m-b-10 f-w-600">Recent</p>
                                                                    <h6 class="text-muted f-w-400">Guruable Admin</h6>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <p class="m-b-10 f-w-600">Most Viewed</p>
                                                                    <h6 class="text-muted f-w-400">Able Pro Admin</h6>
                                                                </div>-->
                                                            </div>
                                                            <!--<ul class="social-link list-unstyled m-t-40 m-b-10">
                                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="facebook"><i class="feather icon-facebook facebook" aria-hidden="true"></i></a></li>
                                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="twitter"><i class="feather icon-twitter twitter" aria-hidden="true"></i></a></li>
                                                                <li><a href="#!" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="instagram"><i class="feather icon-instagram instagram" aria-hidden="true"></i></a></li>
                                                            </ul>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- wather user -->

                                        <!-- social download  start -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-blue">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <i class="feather icon-mail f-34 text-c-blue social-icon"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-0">Correo Institucional</h6>
                                                            </br></br>
                                                            <p class="m-b-0">Acceso directo al correo de la ABAE</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="https://correo.abae.gob.ve/SOGo/so/" class="download-icon" target="_blank"><i class="feather icon-at-sign"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-pink">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <i class="feather icon-twitter f-34 text-c-pink social-icon"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-0">Twitter</h6>
                                                            </br></br>
                                                            <p class="m-b-0">Acceso directo a la cuenta de la ABAE</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="https://twitter.com/AbaeVzla" class="download-icon" target="_blank"><i class="feather icon-twitter"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-blue">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <i class="feather icon-facebook f-34 text-c-blue social-icon"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-0">Facebook</h6>
                                                            </br></br>
                                                            <p class="m-b-0">Acceso directo a la cuenta de la ABAE</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="https://es-la.facebook.com/AbaeVzla/" class="download-icon" target="_blank"><i class="feather icon-facebook"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card social-card bg-simple-c-green">
                                                <div class="card-block">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <i class="feather icon-instagram f-34 text-c-green social-icon"></i>
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="m-b-0">Instagram</h6>
                                                            </br></br>
                                                            <p class="m-b-0">Acceso directo a la cuenta de la ABAE</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="https://www.instagram.com/abaevzla/" class="download-icon" target="_blank"><i class="feather icon-instagram"></i></a>
                                            </div>
                                        </div>
                                        <!-- social download  end -->

                                    </div>
                                </div>
                            </div>

<script type="text/javascript" src="..\files\bower_components\jquery\js\jquery.min.js"></script>
<!-- <script type="text/javascript" src="..\files\assets\pages\dashboard\custom-dashboard.js"></script> -->
