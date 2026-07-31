<?php
    $sql = "SELECT * 
            FROM usuario 
            WHERE id_usuario = '$idUser';";
    $query = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($query);

    $nowDate = date("Y-m-d");

    $nowSpanish = getDateSpanish();
    $nowTime = date("g:i a", time());

    // $sql = "SELECT * 
    //         FROM actividad 
    //         WHERE id_usuario = '$idUser' AND 
    //             fecha = '$nowDate' AND 
    //             estatus = 'A';";
    // $query = mysqli_query($conn, $sql);

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
                                    <span>Reportar Asistencia</span>
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
                                        <a class="activate">Asistencia / Reportar Asistencia</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <form id="form">
                            <div class="row">
                                <div class="col-sm-4 form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control" id="date" placeholder="Fecha" disabled>
                                </div>
                                <div class="col-sm-4 form-group">
                                    <label>Hora</label>
                                    <input type="text" class="form-control" id="time" placeholder="Hora" disabled>
                                </div>

                                <div class="col-sm-4 form-group">
                                    <label>Condición</label>
                                    <select id="condicion" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="Asistente">Asistente</option>
                                        <option value="Vacaciones">Vacaciones</option>
                                        <option value="Consulta Médica">Consulta Médica</option>
                                        <option value="Permiso Especial">Permiso Especial</option>
                                        <option value="Estudios">Estudios</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label for="file" class="col-form-label">Archivo (Opcional)</label>
                                    <input type="file" id="file" class="form-control input_file_oculto" oninvalid="setCustomValidity('Debe cargar un archivo')">
                                    <div class="form-control button_fantasma p-0 d-flex justify-content-between">
                                        <span class="w-100 p-2"></span>
                                        <button type="button" class="btn btn-primary btn-sm justify-content-right">Cargar Archivo</button>
                                    </div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Descripción</label>
                                    <textarea class="form-control" id="descripcion" rows="3" required></textarea>
                                </div>

                                <div class="form-group col-md-12 loaderParent">
                                    <div class="loader">
                                    </div>
                                    Por favor, espere
                                </div>


                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $("textarea").keyup(function(){  
        var height = $(this).prop("scrollHeight")+2+"px";
        $(this).css({"height":height});
    });

    $(document).ready(function() {
        $("#date").val("<?php echo $nowSpanish;?>");
        $("#time").val("<?php echo $nowTime;?>");
    });



    $(function(){
        $("#form").submit(function(e){	
            e.preventDefault();

            var datos = new FormData();
            datos.append("condicion", $("#condicion").val());
            datos.append('archivo', $('#file')[0].files[0]);
            datos.append("descripcion", $("#descripcion").val());
            datos.append("id_usuario", "<?php echo $idUser;?>");
            
            $('.loaderParent').show();

            $.ajax({
                url: 			'../php/asistencia/reportar-asistencia-process.php',
                type:			'POST',
                data:			datos,
                cache:          false,
                contentType:    false,
                processData:    false,
                success: function(response){
                    // console.log(response);
                    $('.loaderParent').hide();
                    if(response == 'si'){
                        $('#condicion').val('');
                        $('#descripcion').val('');
                        $('#file').val('');
                        $('#file + .button_fantasma span').text('');
                        $("#modal-generic .message").text('Registro Exitoso.');
                        $('#modal-generic').modal('show');
                    }
                    else{
                        $("#modal-generic .message").text("Error al registrar");
                        $("#modal-generic").modal("show");
                    }
                }
                ,
                error: function(response){
                    $('.loaderParent').hide();
                    $("#modal-generic .message").text("Error al registrar");
                    $("#modal-generic").modal("show");
                }
            });
        });
    });

</script>
