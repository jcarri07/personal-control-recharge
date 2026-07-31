<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" type="text/css"
    href="..\files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="..\files\assets\pages\data-table\css\buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css"
    href="..\files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css">


<script src="../files/bower_components/jquery/js/jquery.min.js"></script>
<script src="../files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="..\files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js"></script>
<script src="..\files\assets\pages\data-table\js\jszip.min.js"></script>
<script src="..\files\assets\pages\data-table\js\pdfmake.min.js"></script>
<script src="..\files\assets\pages\data-table\js\vfs_fonts.js"></script>
<script src="..\files\bower_components\datatables.net-buttons\js\buttons.print.min.js"></script>
<script src="..\files\bower_components\datatables.net-buttons\js\buttons.html5.min.js"></script>
<script src="..\files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
<script src="..\files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
<script src="..\files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>
<script src="..\assets\js\main.js"></script>

<script src='../assets/fullcalendar-6.1.4/dist/index.global.min.js'></script>
<script src='../assets/fullcalendar-6.1.4/packages/core/locales-all.global.min.js'></script>
<link rel="stylesheet" href="../assets/alertifyjs/css/alertify.min.css">
<script src="../assets/alertifyjs/alertify.js"></script>

<script>
    // function iniciarTabla(id) {
    //     $('#' + id).DataTable({
    //         language: {
    //             "decimal": "",
    //             "emptyTable": "No hay información",
    //             "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    //             "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
    //             "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    //             "infoPostFix": "",
    //             "thousands": ",",
    //             "lengthMenu": "Mostrar _MENU_ Entradas",
    //             "loadingRecords": "Cargando...",
    //             "processing": "Procesando...",
    //             "search": "Buscar:",
    //             "zeroRecords": "Sin resultados encontrados",
    //             "paginate": {
    //                 "first": "Primero",
    //                 "last": "Ultimo",
    //                 "next": "Siguiente",
    //                 "previous": "Anterior"
    //             }
    //         },
    //     });
    // }
</script>

<?php
require_once '../database/conexion.php';
require_once '../utils/general-utils.php';
date_default_timezone_set("America/Caracas");

session_start();
$idUser = $_SESSION["id_usuario"];

// Verificar la conexión
if (mysqli_connect_errno()) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
    exit();
}

$view = "";
switch ($_GET['page']) {
    case "reportar":
        $view = "../views/asistencia/reportar/reportar.php";
        break;
    case "calendario":
        $view = "../views/asistencia/calendario/calendario.php";
        break;
    case "graficas":
        $view = "../views/asistencia/graficas.php";
        break;
    default:
        $view = "";
        break;
}

include '../views/homebar.php';

?>


<style>
    /* .wizard .content{
        background: #FFF;
    }*/

    .box-title {
        text-align: center;
        margin-bottom: 15px;
    }

    .box-title h3 {
        text-align: center;
        /*padding-bottom: 10px;
        padding-top: 20px;*/
        padding: 12px;
        border-radius: 5px;

        background: #00A9AC;
        color: white;
        display: inline-block;
        margin-top: 30px;
    }

    .row>div {
        margin-bottom: 15px;
    }

    label {
        margin-bottom: 3px;
    }

    .box-img img {
        width: 100%;
        max-width: 250px;
    }

    .box-img {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .loader {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #00A9AC;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        float: left !important;
        margin-right: 7px;


        position: initial !important;
        margin-top: 0px;
    }

    .loaderParent {
        display: none;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    table .btn-table {
        padding: 6px;
        padding-right: 2px;
        font-size: 15px;
    }

    table tr th,
    table tr {
        text-align: center !important;
    }

    table tr th {
        background: #01A9AC;
        color: white;
    }
</style>

<script>


    $(document).ready(function () {
        $(".pcoded-wrapper .pcoded-item > li").each(function (index) {
            if (!$(this).hasClass("pcoded-hasmenu")) {
                $(this).find("a").each(function (index) {
                    if (this.href == window.location.href) {
                        $(this).parent().addClass("active");
                        $(this).parent().addClass("pcoded-trigger");
                    }
                });
            }
            else {
                //console.log($(this).find(">a").text());
                $(this).find(".pcoded-submenu > li > a").each(function (index) {
                    if (this.href == window.location.href) {
                        $(this).parent().addClass("active");
                        $(this).closest(".pcoded-hasmenu").addClass("pcoded-trigger");
                    }
                });
            }

        });
    });




    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');


</script>


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

</html>