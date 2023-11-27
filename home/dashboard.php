<!DOCTYPE html>
<html lang="en">

<?php 
$view = "../views/dashboard.php";
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

        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         document.getElementById("main-body-container").innerHTML = this.responseText;
        //     }
        // };
        // //CARGAR LA VISTA!
        // xhttp.open("GET", '../views/dashboard.php', true); //cambiar la ruta de la vista.
        // xhttp.send();
        //CARGAR LIBRERIAS (.js, .css) PERTENECIENTES A LAS VISTAS!
        var scriptElement = document.createElement("script");
        scriptElement.src = "../files/assets/pages/dashboard/custom-dashboard.js"; //Cambiar la ruta de la libreria.
        scriptElement.onload = function() {
            console.log("si")
        };
        scriptElement.onerror = function() {
            console.log("no")
        };

        document.head.appendChild(scriptElement);

    });
</script>

</html>