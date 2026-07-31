<?php

    require_once '../../../database/conexion.php';
    date_default_timezone_set("America/Caracas");
    setlocale(LC_TIME,"spanish");

    $idUsuario = $_POST['id_usuario'];
    $fecha = $_POST['fecha'];

    $sql = "SELECT a.id_actividad, a.condicion, a.descripcion, a.hora, a.archivo 
            FROM actividad a 
            JOIN usuario u ON u.id_usuario = a.id_usuario AND u.id_usuario = '$idUsuario'                          
            WHERE a.fecha = '$fecha' AND a.estatus = 'A'
            ORDER BY a.hora DESC";

    $res = mysqli_query($conn, $sql);
    $copi = mysqli_query($conn, $sql);
    closeConection($conn);
?>

<script>
    var list = new Object();

<?php  
    while ($valor = mysqli_fetch_array($copi)){
        $descripcion = ($valor['descripcion'] == " ") ? "No hay descripción" : $valor['descripcion'];
        $archivo = $valor['archivo'] ? "<br><a href='{$valor['archivo']}' target='_blank'>Ver Archivo</a>" : "";
?>
        list["<?= $valor['hora'] ?>"] = "<?= $descripcion . $archivo ?>";
        list["0"] = "hola";
<?php 
    }
?>



    var calendarEl = document.getElementById('modi-cont');

    var calendari = new FullCalendar.Calendar(calendarEl, {
    initialDate: '<?php echo $fecha ?>',
    headerToolbar: {
        left: 'title',
        right: '',
    },
    locale: 'es',
    initialView: 'listDay',
    height: "auto",
    editable: false,
    selectable: true,
    navLinks: false, // can click day/week names to navigate views
    dayMaxEvents: true,
    events: [
<?php 
        while($valor = mysqli_fetch_array($res)){
            echo "{ 
                    title:  '".$valor["condicion"]."',
                    start:  '".$fecha.'T'.$valor["hora"]."'
                },";
        } 
?>
    ],
    eventTimeFormat: { // = '14:30:00'
        hour: 'numeric',
        minute: '2-digit',
        meridiem: 'short',
        hour12: true,
    },

    eventClick: function(info){
        let html = list[String(info.event.start.getHours()).padStart(2, '0')+":"+String(info.event.start.getMinutes()).padStart(2, '0')+":"+String(info.event.start.getSeconds()).padStart(2, '0')];
        modaldes(html);
    },

    });

    calendari.render();

</script>