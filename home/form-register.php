<!DOCTYPE html>
<html lang="en">

<?php
$view = "../views/register-personal-data.php";
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
        // xhttp.open("GET", '../views/solicitud-create.php', true); //cambiar la ruta de la vista.
        // xhttp.send();
        //CARGAR LIBRERIAS (.js, .css) PERTENECIENTES A LAS VISTAS!
        // Crea la función para agregar scripts dinámicamente
        function loadScript(url) {
            let scriptElement = document.createElement("script");
            scriptElement.src = url;
            document.head.appendChild(scriptElement);
        }

        // Crea la función para agregar estilos dinámicamente
        function loadStyle(url) {
            let styleElement = document.createElement("link");
            styleElement.href = url;
            styleElement.rel = "stylesheet";
            document.head.appendChild(styleElement);
        }

        // Agrega los scripts y estilos
        /* loadScript("../files/bower_components/jquery/js/jquery.min.js"); */
        loadScript("../files/bower_components/jquery-ui/js/jquery-ui.min.js");
        loadScript("../files/bower_components/popper.js/js/popper.min.js");
        loadScript("../files/bower_components/bootstrap/js/bootstrap.min.js");
        loadScript("../files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js");
        loadScript("../files/bower_components/modernizr/js/modernizr.js");
        loadScript("../files/bower_components/modernizr/js/css-scrollbars.js");
        loadScript("../files/bower_components/i18next/js/i18next.min.js");
        loadScript("../files/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js");
        loadScript("../files/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js");
        loadScript("../files/bower_components/jquery-i18next/js/jquery-i18next.min.js");
        loadScript("../files/bower_components/jquery.cookie/js/jquery.cookie.js");
        loadScript("../files/bower_components/jquery.steps/js/jquery.steps.js");
        loadScript("../files/bower_components/jquery-validation/js/jquery.validate.js");
        loadScript("https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js");
        loadScript("https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js");
        loadScript("../files/assets/pages/form-validation/validate.js");
        loadScript("../files/assets/pages/forms-wizard-validation/form-wizard.js");
        loadScript("../files/assets/js/pcoded.min.js");
        // loadScript("../files/assets/js/vartical-layout.min.js");
        loadScript("../files/assets/js/jquery.mCustomScrollbar.concat.min.js");
        loadScript("../files/assets/js/script.js");
        loadScript("https://www.googletagmanager.com/gtag/js?id=UA-23581568-13");

        loadStyle("../files/bower_components/jquery.steps/css/jquery.steps.css");
    });
</script>


</html>