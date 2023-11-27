<!DOCTYPE html>
<html lang="en">
<head>






        <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\pages\data-table\css\buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="..\files\bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">

        <script src="../files/bower_components/jquery/js/jquery.min.js"></script>
        <script src="../files/bower_components/datatables.net/js/jquery.dataTables.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\jszip.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\pdfmake.min.js" defer></script>
        <script src="..\files\assets\pages\data-table\js\vfs_fonts.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\buttons.print.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-buttons\js\buttons.html5.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js" defer></script>
        <script src="..\files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js" defer></script>


        <script>
            function iniciarTabla(id) {
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
$view = "../views/historial_notificacion.php";
include '../views/homebar.php'; 
?>
<style>
        table tr th{
        background: #01A9AC;
        color: white;
    }
    td::first-letter{
        text-transform: uppercase;
    }
</style>
    </head>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');

    document.addEventListener('DOMContentLoaded', function() {})
    </script>