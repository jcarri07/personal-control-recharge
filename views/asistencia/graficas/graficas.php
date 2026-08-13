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

    $unidades = [];
    $trabajadores = [];

    $addWhereTrabajadores = '';

    if ($cargo == 'Director') {
        $sql = "SELECT * 
                FROM unidad 
                WHERE id_direccion = '$idDireccion';";
        $queryUnidades = mysqli_query($conn, $sql);

        $addWhereTrabajadores .= " AND da.id_direccion = '$idDireccion' ";
    }
    else{
        if ($cargo == 'Jefe') {
            $sql = "SELECT * 
                    FROM unidad 
                    WHERE id_unidad = '$idUnidad';";
            $queryUnidades = mysqli_query($conn, $sql);

            $addWhereTrabajadores .= " AND da.id_unidad = '$idUnidad' ";

            
            // $sql = "SELECT a.fecha
            //         FROM actividad a
            //         INNER JOIN datos_abae da ON a.id_usuario = da.id_usuario
            //         WHERE a.estatus = 'A' AND da.id_unidad = '$idUnidad'
            //         GROUP BY a.fecha";
            // $res = mysqli_query($conn, $sql);
        }
    }

    while($row = mysqli_fetch_array($queryUnidades)) {
        $unidades[] = [
            'id' => $row['id_unidad'],
            'nombre' => $row['nombre'],
        ];
    }

    $sql = "SELECT u.id_usuario, nombres, apellidos, da.id_unidad, da.id_direccion, da.cargo
            FROM usuario u
            INNER JOIN datos_abae da ON u.id_usuario = da.id_usuario $addWhereTrabajadores
            WHERE u.estatus = 'activo' 
            ORDER BY nombres";
    $queryTrabajadores = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_array($queryTrabajadores)) {
        $trabajadores[] = [
            'id' => $row['id_usuario'],
            'nombres' => $row['nombres'],
            'apellidos' => $row['apellidos'],
            'id_unidad' => $row['id_unidad'],
            'id_direccion' => $row['id_direccion'],
            'cargo' => $row['cargo'],
        ];
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
                        <div class="row justify-content-end">

<?php
                            if ($cargo == 'Director') {
?>
                                <div class="col mb-3">
                                    <label class="form-label">Unidad</label>
                                    <select name=0 id="unidad" class="form-control" required>
                                        <option value="0">Todas las Unidades</option>
<?php
                                        foreach ($unidades as $unidad) {
?>
                                            <option value="<?php echo $unidad['id']; ?>"><?php echo  $unidad['nombre']; ?></option>
<?php
                                        }
?>
                                    </select>
                                </div>
<?php
                            }
?>
                                <div class="col-sm-3 mb-3">
                                    <label class="form-label">Cargo</label>
                                    <select id="cargo_search" class="form-control">
                                        <option value="0">Todos</option>
                                        <option value="Jefe">Jefes</option>
                                        <option Value="Personal de Investigacion">Personal de Investigacion</option>
                                    </select>
                                </div>

                                <div class="col-sm-3">
                                    <label class="form-label">Trabajador</label>
                                    <select id="trabajador_id" class="form-control">
                                        <option value="0">Todos</option>
<?php
                                        foreach ($trabajadores as $trabajador) {
?>
                                            <option value="<?php echo $trabajador['id'];  ?>"><?php echo $trabajador['nombres'] . " " . $trabajador['apellidos']; ?></option>
<?php
                                        }
?>
                                    </select>
                                </div>

<?php
                            // } 
                            // else {
?>
                                
<?php
                            // }
?>



                            <div id="pri" class="table-responsive" style="width:100%;">
                                <div class="" id="grafica">

                                </div>
                                <div id="cont">
                                </div>
                            </div>


                            <!-- <div id="" class="row"> -->
                                <div class="col-md-4">
                                    <select id="fe" class="form-control ">
                                        <option value="anio">Año</option>
                                        <option value="mes">Mes</option>
                                        <option Value="semana">Semana</option>
                                    </select>
                                </div>
                                <div id="formato" class="row col-md-8" style="padding: 0px; margin-left: 0px;">
                                </div>
                            <!-- </div> -->




                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    var trabajadores = <?php echo json_encode($trabajadores); ?>;

    $(document).ready(function() {
        ajax();
        $("#cargo_search, #unidad").change(function() {
            selectTrabajadores();
            ajax();
        });

        $("#trabajador_id").change(function() {
            ajax();
        });

        function selectTrabajadores() {
            const unidadId = $("#unidad").val();
            let filtered = unidadId !== "0" 
                ? trabajadores.filter(t => t.id_unidad == unidadId)
                : trabajadores;

            const cargoSearch = $("#cargo_search").val();
            filtered = cargoSearch !== "0" 
                ? trabajadores.filter(t => t.cargo == cargoSearch)
                : trabajadores;
            
            const $select = $("#trabajador_id").html("<option value='0'>Todos</option>");
            
            filtered.forEach(t => {
                $select.append(`<option value="${t.id}">${t.nombres} ${t.apellidos}</option>`);
            });
        }

        $("#trabajador").change(function() {
            ajax();
        });


        function changeFecha(input) {
            var fecha = new Date($("#" + input).val() + "-02");
            //fecha.setMonth(fecha.getMonth()+1);
            var options = {
                year: 'numeric',
                month: 'long'
            };
        }

        $("#fe").change(function() {
            switch ($("#fe").val()) {
                case "anio":
                    $("#formato").html("");
                    ajax();
                    break;
                case "mes":
                    var fechaActual = new Date();
                    //console.log(fechaActual);
                    $("#formato").html(`
                                    <div class="col-md-6">
                                        <input type="Month" id="mes" class="form-control" min="' + fechaActual.getFullYear().toString() + '-01" max="' + fechaActual.getFullYear().toString() + '-12" style="padding: 0px auto; margin-bottom:5px;">
                                    </div>`);

                    // Obtener el año y mes actual como cadenas de texto
                    var anioActual = fechaActual.getFullYear().toString();
                    var mesActual = (fechaActual.getMonth() + 1).toString().padStart(2, '0');

                    // Establecer el valor del input de tipo month
                    var valorMesActual = anioActual + '-' + mesActual;
                    $('#mes').val(valorMesActual);
                    ajax();
                    $("#mes").on('change', function() {
                        ajax();
                        changeFecha(this.id);
                    });

                    changeFecha("mes");
                    break;

                case "semana":
                    var fechaActual = new Date();
                    //console.log(fechaActual);
                    $("#formato").html('<div class="col-md-6"><input type="Month" id="mes" class="form-control" style="margin-bottom:5px;"></div> <div class="col-md-6" style=""><select id="semana" class="form-control" min="' + fechaActual.getFullYear().toString() + '-01" max="' + fechaActual.getFullYear().toString() + '-12" style="margin-bottom:5px;"></select></div>');

                    // Obtener el año y mes actual como cadenas de texto
                    var anioActual = fechaActual.getFullYear().toString();
                    var mesActual = String(fechaActual.getMonth() + 1).padStart(2, '0');
                    //console.log(mesActual);
                    // Establecer el valor del input de tipo month
                    var valorMesActual = anioActual + '-' + mesActual;
                    $('#mes').val(valorMesActual);

                    var numWeeks = numeroSemanas(mesActual, anioActual);

                    select = document.getElementById("semana");
                    // Agregar las opciones al select
                    select.innerHTML = "";
                    for (let i = 1; i <= numWeeks; i++) {
                        const option = document.createElement("option");
                        option.value = i;
                        option.text = `Semana ${i}`;
                        select.appendChild(option);
                    }
                    $("#mes").on('change', function() {
                        // Obtener valor del input tipo "month"
                        var valorInput = $("#mes").val();

                        // Formatear valor del input a "YYYY-MM-DD"
                        var fechaString = valorInput + "-01";
                        var fechaActual = new Date(fechaString);

                        var mesActual = (fechaActual.getMonth() + 2).toString().padStart(2, '0');
                        //console.log(mesActual);
                        var numWeeks = numeroSemanas(mesActual, fechaActual.getFullYear().toString());

                        select = document.getElementById("semana");
                        // Agregar las opciones al select
                        select.innerHTML = "";
                        for (let i = 1; i <= numWeeks; i++) {
                            const option = document.createElement("option");
                            option.value = i;
                            option.text = `Semana ${i}`;
                            select.appendChild(option);
                        }

                        if ($("#mes").val() == "") {
                            $('#semana').prop('disabled', true);
                        }
                        if (!($("#mes").val() == "")) {
                            $('#semana').prop('disabled', false);
                        }
                        ajax();
                        changeFecha(this.id);
                    });
                    $("#semana").on('change', function() {
                        ajax();
                    });
                    ajax();
                    changeFecha("mes");
                    break;
                default:
                    $("#formato").html("");
                    break;
            }
        });


        function ajax() {
            $("#grafica").html('');
            var values = new FormData();
            values.append("unidad", $("#unidad").val());
            values.append("cargo", "<?php echo $cargo; ?>");
            values.append("id_unidad", "<?php echo $idUnidad; ?>");
            values.append("id_direccion", "<?php echo $idDireccion; ?>");
            values.append("trabajador_id", $("#trabajador_id").val());
            values.append("cargo_search", $("#cargo_search").val());
            values.append("mes", $("#mes").val());
            values.append("semana", $("#semana").val());

            let grafica = $("#fe").val();
            values.append("grafica", grafica);

            $.ajax({
                url: '../views/asistencia/graficas/get-grafica.php',
                type: 'POST',
                data: values,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#cont").html(response);
                },
                error: function(response) {
                    alertify.error("Error inesperado.");
                }
            });
        };



        function numeroSemanas(month, year) {
            //var year = year.getFullYear();
            var firstDay = new Date(year, month - 1, 1);
            var lastDay = new Date(year, month, 0);
            var daysInMonth = lastDay.getDate();
            var daysInFirstWeek = 7 - ((firstDay.getDay() == 0) ? 6 : firstDay.getDay() - 1);
            var daysLeft = daysInMonth - daysInFirstWeek;
            // console.log((firstDay.getMonth() + 1).toString() + " " + daysInFirstWeek + " " + daysInMonth);
            return Math.ceil(daysLeft / 7) + 1;
        }
    });
</script>