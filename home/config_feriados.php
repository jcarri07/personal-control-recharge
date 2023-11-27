<!DOCTYPE html>
<html lang="en">

<?php
$view = "../views/feriados.php";
include '../views/homebar.php';
?>

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-23581568-13');

    document.addEventListener('DOMContentLoaded', function() {

        var scriptElement = document.createElement("script");
        scriptElement.src = "../files/assets/pages/dashboard/custom-dashboard.js"; //Cambiar la ruta de la libreria.
        scriptElement.onload = function() {
            console.log("si")
        };
        scriptElement.onerror = function() {
            console.log("no")
        };

        var scriptElement2 = document.createElement("script");
        scriptElement2.src = "../files/assets/js/feriados.js"; //Cambiar la ruta de la libreria.

        scriptElement2.onload = function() {
            console.log("si")
        };
        scriptElement2.onerror = function() {
            console.log("no")
        };

        // document.head.appendChild(scriptElement2);
        document.head.appendChild(scriptElement2);

    });
</script>

</html>