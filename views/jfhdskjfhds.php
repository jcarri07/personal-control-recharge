<!DOCTYPE html>
<html lang="en" id="homebar-container">
    <!-- AQUI DENTRO VA LA VISTA HOMEBAR -->
</html>

<script>
    // Utiliza AJAX para cargar el contenido del archivo sidebar.html y agregarlo al contenedor deseado
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("homebar-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", '../views/homebar.php', true);
    xhttp.send();
</script>


<!-- Required Jquery -->
<!-- <script data-cfasync="false" src="..\..\..\cdn-cgi\scripts\5c5dd728\cloudflare-static\email-decode.min.js"></script> -->
<script type="text/javascript" src="..\files\bower_components\jquery\js\jquery.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\popper.js\js\popper.min.js"></script>
<script type="text/javascript" src="..\files\bower_components\bootstrap\js\bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="..\files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="..\files\bower_components\modernizr\js\modernizr.js"></script>
<!-- Chart js -->
<script type="text/javascript" src="..\files\bower_components\chart.js\js\Chart.js"></script>
<!-- amchart js -->
<script src="..\files\assets\pages\widget\amchart\amcharts.js"></script>
<script src="..\files\assets\pages\widget\amchart\serial.js"></script>
<script src="..\files\assets\pages\widget\amchart\light.js"></script>
<script src="..\files\assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
<!-- <script type="text/javascript" src="..\files\assets\js\SmoothScroll.js"></script> -->
<script src="..\files\assets\js\pcoded.min.js"></script>
<!-- custom js -->
<!-- <script src="..\files\assets\js\vartical-layout.min.js"></script> -->
<!-- <script type="text/javascript" src="..\files\assets\pages\dashboard\custom-dashboard.js"></script> -->
<script type="text/javascript" src="..\files\assets\js\script.min.js"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>



<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="..\files\assets\images\favicon.ico" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="..\files\bower_components\bootstrap\css\bootstrap.min.css">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\icon\feather\css\feather.css">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\style.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="..\files\assets\css\new-style.css">