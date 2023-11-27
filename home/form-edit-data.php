<!DOCTYPE html>
<html lang="en">

    <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\pages\data-table\css\buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css">
    
    
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

    <script>
        function iniciarTabla(id){
            $('#' + id).DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
        }
    </script>

<?php


$view = "";
switch ($_GET['page']) {
    case "datos-personales":
        $view = "../views/edit-personal-data/datos-personales.php";
        break;
    case "hijos":
        $view = "../views/edit-personal-data/hijos.php";
        break;
    case "familiares":
        $view = "../views/edit-personal-data/familiares.php";
        break;
    case "datos-academicos":
        $view = "../views/edit-personal-data/datos-academicos.php";
        break;
    case "formacion-exterior":
        $view = "../views/edit-personal-data/formacion-exterior.php";
        break;
    case "experiencia-laboral-publica":
        $view = "../views/edit-personal-data/experiencia-laboral-publica.php";
        break;
    case "datos-institucionales":
        $view = "../views/edit-personal-data/datos-institucionales.php";
        break;
    case "comision-servicio":
        $view = "../views/edit-personal-data/comision-de-servicio.php";
        break;
    case "otros-datos":
        $view = "../views/edit-personal-data/otros-datos.php";
        break;
    case "perfil":
        $view = "../views/edit-personal-data/perfil.php";
        break;
        
    case "filtros-de-busqueda":
        $view = "../views/filtros-de-busqueda.php";
        break;
    default:
        $view = "";
        break;
}

//$view = "../views/edit-personal-data.php";
include '../views/homebar.php';

?>


<style>
   /* .wizard .content{
        background: #FFF;
    }*/

    .box-title{
        text-align: center;
        margin-bottom: 15px;
    }

    .box-title h3{
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
    .row > div{
        margin-bottom: 15px;
    }

    label{
        margin-bottom: 3px;
    }

    .box-img img{
        width: 100%;
        max-width: 250px;
    }

    .box-img{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .loader{
        border: 3px solid #f3f3f3;
        border-top: 3px solid #00A9AC;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
        float:left !important;
        margin-right: 7px;


        position: initial !important;
        margin-top: 0px;
    }
    .loaderParent{
        display:none;
    }
    @keyframes spin{
        0%{ transform: rotate(0deg);}
        100%{ transform: rotate(360deg);}
    }

    table .btn-table{
        padding: 6px;
        padding-right: 2px;
        font-size: 15px;
    }

    table tr th, table tr{
        text-align: center !important;
    }

    table tr th{
        background: #01A9AC;
        color: white;
    }
</style>

<script>


    $(document).ready(function() {
        $(".pcoded-wrapper .pcoded-item > li").each(function(index) {
            if(!$(this).hasClass("pcoded-hasmenu")){
                $(this).find("a").each(function(index) {
                    if(this.href == window.location.href){
                        $(this).parent().addClass("active");
                        $(this).parent().addClass("pcoded-trigger");
                    }
                });
            }
            else{
                //console.log($(this).find(">a").text());
                $(this).find(".pcoded-submenu > li > a").each(function(index) {
                    if(this.href == window.location.href){
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




</html>