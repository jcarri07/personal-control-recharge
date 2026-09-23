<?php
    $sql = "SELECT da.cargo AS 'cargo_datos_abae', da.id_unidad AS 'id_unidad', u.cargo AS 'cargo_usuario', id_direccion
            FROM usuario u
            LEFT JOIN datos_abae da ON u.id_usuario = da.id_usuario
            WHERE u.id_usuario = '$idUser';";
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($query);
    $cargo = $user['cargo_datos_abae'] ?? $user['cargo_usuario'] ?? null;
    $idUnidad = $user['id_unidad'] ?? null;
    $idDireccion = $user['id_direccion'] ?? null;


    if ($cargo == 'Director') {
        $sql = "SELECT * 
                FROM unidad 
                WHERE id_direccion = '$idDireccion';";
        $queryUnidades = mysqli_query($conn, $sql);

        //si es director entonces carga las fechas de todos los trabajadores
        $sql = "SELECT a.fecha
                FROM actividad a
                INNER JOIN datos_abae da ON a.id_usuario = da.id_usuario
                INNER JOIN unidad u ON da.id_unidad = u.id_unidad
                WHERE a.estatus = 'A' AND u.id_direccion = '$idDireccion'
                GROUP BY a.fecha";
        $res = mysqli_query($conn, $sql);
    }

    if ($cargo == 'Jefe') {
        $sql = "SELECT a.fecha
                FROM actividad a
                INNER JOIN datos_abae da ON a.id_usuario = da.id_usuario
                WHERE a.estatus = 'A' AND da.id_unidad = '$idUnidad'
                GROUP BY a.fecha";
        $res = mysqli_query($conn, $sql);
    }

    closeConection($conn);
?>




<div class="container">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8" style="margin-bottom: 0px;">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Asistencia</h4>
                                    <span>Calendario</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="../home/dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        <a class="activate">Asistencia / Calendario</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <button type="button" onclick="PDF_unidad()" class="btn btn-primary w-100">Reporte Mensual</button>
                            </div>
                            <div class="col-sm-3">
                                <button type="button" onclick="semana()" class="btn  btn-primary w-100">Reporte Semanal</button>
                            </div>

<?php
                            if ($cargo == 'Director') { 
?>

                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3" style="padding: 0px;">
                                <select name="" id="unidad" class="form-control">
                                    <option value="0">Todas las Unidades</option>
<?php
                                    while ($row = mysqli_fetch_array($queryUnidades)) {
?>
                                        <option value="<?php echo $row['id_unidad']; ?>"><?php echo $row['nombre']; ?></option>
<?php
                                    }
?>
                                </select>
                            </div>
<?php
                            }
?>
                        </div>

                        <div class="col-12 calendario" id="calendario">
                        </div>

                        <br>
                        <div class="col-12 row" id="inf" style="padding-top: 30px;">
                            <div class="col-12 row m-auto">
                                <div class="" style="padding: 0px; border-radius: 50%; border: 1px solid; width: 30px; height: 30px; background-color: #ffffff;">
                                    <p style="text-align:center;color:#7267ef; margin-top: -2px !important; color:green;font-size:20px;" class="my-auto">•</p>
                                </div>
                                <div class="col-10 my-auto">
                                    <strong>Dias con Reportes</strong>
                                </div>
                            </div>
                            <div class="col-12 row m-auto" style="padding-top: 30px;">
                                <div class="" style="border-radius: 50%; border: 1px solid; width: 30px; height: 30px; background-color: #ffe71d;">
                                </div>
                                <div class="col-10 my-auto">
                                    <strong>Dia Actual</strong>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .calendario {
        min-height: 375px;
    }

    @media (min-width: 500px) {
        .calendario {
            min-height: 400px;
        }
    }

    @media (min-width: 700px) {
        .calendario {
            min-height: 450px;
        }
    }

    @media (min-width: 1200px) {
        .calendario {
            min-height: 600px;
        }
    }
</style>



<script>

    var date = new Date();
    var fecha = new Date();
    var url;
    var calendarEl = document.getElementById('calendario');

    /*---Metodo para crear el calendario---*/
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialDate: Date.now(),
        headerToolbar: {
            locale: 'es',
            left: 'title',
            right: 'today prevYear,prev,next,nextYear',
        },
        locale: 'es',
        editable: false,
        selectable: true,
        businessHours: true,
        dayMaxEvents: true, // allow "more" link when too many events
        aspectRatio: 3,
        fixedWeekCount: false,
        dayMaxEvents: 2,
        eventTextColor: 'green',
        events: [
<?php
            if(isset($res)) {
                while ($valor = mysqli_fetch_array($res)) { 
?> 
                    {
                        start: '<?php echo $valor["fecha"]; ?>',
                        end: '<?php echo $valor["fecha"]; ?>',
                        color: 'transparent',
                        title: '•',
                    },
<?php 
                }
            } 
?>

        ],

        dateClick: function(info) {
            fecha = info.date;
            date = info.date;

            var idUnidad = "<?php echo $idUnidad; ?>";
            if($("#unidad").length > 0)
                idUnidad = $("#unidad").val();

            var values = new FormData();
            values.append("unidad", idUnidad);
            values.append("fecha", info.dateStr);
            values.append("cargo", "<?php echo $cargo; ?>");
            values.append("id_unidad", "<?php echo $idUnidad; ?>");
            values.append("id_direccion", "<?php echo $idDireccion; ?>");
            values.append('current_user', "<?php echo $idUser; ?>")
            // console.log(idUnidad);
            $.ajax({
                url: '../views/asistencia/calendario/consulta_calendario.php',
                type: 'POST',
                data: values,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#mod-cont").html(response);
                }

                ,
                error: function(response) {

                alertify.error("Error inesperado." + response);

                }
            });

            $('#calendariomodal').modal('show');
            $('.modal-dialog').draggable({
                handle: ".modal-header"
            });
        },
    });
    calendar.render();


    function getAvtivitiesByUser(fecha, nombre, apellido, id_usuario) {
        //console.log('pasa algo');
        //console.log(fecha,id);

        $("#titulo-ind").html(nombre + ' ' + apellido);
        var values = new FormData();
        values.append("id_usuario", id_usuario);
        values.append("fecha", fecha);
        values.append("nombre", nombre);
        values.append("apellido", apellido);

        $.ajax({
            url: '../views/asistencia/calendario/actividades_por_usuario.php',
            type: 'POST',
            data: values,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                $("#modi-cont").html(response);
                
                var fecha = $("#fc-dom-86").text();
                array = fecha.split(" ");

                var string = "";
                for (var i = 0; i < array.length; i++) {
                if (i == 2)
                    string += array[2][0].toUpperCase() + array[2].substring(1);
                else
                    string += array[i];

                if (i < array.length - 1)
                    string += " ";
                }
                $("#fc-dom-86").text(string);
            },
            error: function(response) {
                alertify.error("Error inesperado.");
            }
        });
        $('#modd-cont').html('Seleccione un Reporte para Visualizar su Descripción.');
        $('#modalindividual').modal('show');
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
    }

    function modaldes(response) {
        $('#modd-cont').html(response);
    }

    /*-----------------REPORTES----------------*/
    function PDF_unidad() {

    const x = new Date();
    var url = "../views/asistencia/reportes/graficaMpdf.php?id_unidad=" + $("#unidad option:selected").val() + "&&unidad=<?php echo $_SESSION['unidad']; ?>&&tipo=<?php echo $_SESSION['cargo'] ?>&&mes=" + (date.getMonth() + 1) + "&&fecha=" + date.getFullYear() + "-0" + (date.getMonth() + 1) + "-" + x.getDate();
    window.open(url, "_blank");

  }
  /*--REPORTE SEMANAL--*/
  function PDF_semana() {
    val = $("#sell option:selected").val();
    const x = new Date();
    var url = "../views/asistencia/reportes/graficaSpdf.php?id_unidad=" + $("#unidad option:selected").val() + "&&unidad=<?php echo $_SESSION['unidad']; ?>&&tipo=<?php echo $_SESSION['cargo'] ?>&&mes=" + (date.getMonth() + 1) + "&&num="+val+"&&fecha=" + date.getFullYear() + "-0" + (date.getMonth() + 1) + "-" + x.getDate();
    window.open(url, "_blank");

  }
  /*--REPORTE DIARIO--*/
  function PDF_individual() {
    var url = "../views/asistencia/reportes/graficaDpdf.php?uni=" + $("#unidad option:selected").val() + "&&unidad=<?php echo $_SESSION['unidad'] ?>&&tipo=<?php echo $_SESSION['cargo'] ?>&&dia=" + (fecha.getDate()) + "&&fecha=" + fecha.getFullYear() + "-0" + (fecha.getMonth() + 1) + "-" + fecha.getDate();
    window.open(url, "_blank");
  }

  function semana(){
    numero = numeroSemanas(date);
    aux = 1;
    $('#modi-sem').html('');
    $('#modi-sem').append('<div class="col-sm-12" style="padding: 0px;"><select name="" id="sell" class="form-control"></select>');
    while(aux <= numero){
      $('#sell').append('<option value='+aux+'>'+aux+'</option>')
      aux++;
    }
    $('#modalsemana').modal('show');
  }
  
  function numeroSemanas(date) {
    
    //var year = year.getFullYear();
    console.log(date);
    var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    console.log(firstDay);console.log(lastDay);
    var daysInMonth = lastDay.getDate();
    var daysInFirstWeek = 7 - ((firstDay.getDay() == 0) ? 6 : firstDay.getDay() - 1);
    var daysLeft = daysInMonth - daysInFirstWeek;
    console.log((firstDay.getMonth() + 1).toString() + " " + daysInFirstWeek + " " + daysInMonth);
    return Math.ceil(daysLeft / 7) + 1;
  }


</script>


<div class="modal fade show bd-example-modal-lg" id="calendariomodal" tabindex="-1" aria-hidden="true" aria-labelledby="modal">
    <div class="modal-dialog modal-lg"><!-- style="left: -22%;"-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title col-md-8 text-right">
                <h2 id="titu" style="margin: 0;">Informes del Dia</h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
                </button>

            </div>
            <div class="modal-body">
                <div class="p-2" id="mod-cont">

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="PDF_individual()" class="btn  btn-primary">Descargar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show bd-example-modal-lg" id="modalindividual" tabindex="-1" aria-hidden="true" aria-labelledby="modal">
    <div class="modal-dialog modal-lg"><!-- style="left: 22%;"-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title col-md-8">
                    <h2 id="titulo-ind"></h2>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body p-3" id="modi-cont">
            </div>
            <div class="box-description-activity p-3">
                <h4 class="box-title">Descripción</h4>
                <div id="modd-cont">
                    Seleccione un Reporte para Visualizar su Descripción.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal de consulta semana -->
<div class="modal fade show bd-example-modal-sm" id="modalsemana" tabindex="-1" aria-hidden="true" aria-labelledby="modal">
  <div class="modal-dialog modal-sm"><!-- style="left: 22%;"-->
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title col-md-8">
          <h2 id="titulo-ind"></h2>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">X</span>
        </button>
      </div>
      <div class="modal-body" id="modi-sem">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" onclick="PDF_semana()" class="btn  btn-primary">Descargar</button>
      </div>
    </div>
  </div>
</div>