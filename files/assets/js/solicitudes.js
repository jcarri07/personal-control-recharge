// console.log("prueba");
window.dataLayer = window.dataLayer || [];

function gtag() {
    dataLayer.push(arguments);
}
console.log("solicitudes");
gtag("js", new Date());
const tiposol = document.getElementById("tipo_sol");
const reposo = document.getElementById("form_reposo");
const vacaciones = document.getElementById("form_vacaciones");
const motivo = document.getElementById("subject");
const motivo_per = document.getElementById("subject_per");
const permisos = document.getElementById("form_permisos");
const horario = document.getElementById("horario");


const f_ini = document.getElementById("fechain");
const f_fin = document.getElementById("fechafin");
const f_ini_per = document.getElementById("fechainper");
const f_fin_per = document.getElementById("fechafinper");
const f_ini_vaca = document.getElementById("fecha_ini");
const peri_disfrute = document.getElementById("peri_disfrute");

var today = new Date();
today.setDate(today.getDate() - 1);
var formattedDate = today.toISOString().split("T")[0];

if(typeof f_ini !== 'undefined' && f_ini !== null)
    f_ini.setAttribute("min", formattedDate);
if (typeof f_fin !== 'undefined' && f_fin !== null)
    f_fin.setAttribute("min", formattedDate);
if (typeof f_ini_vaca !== 'undefined' && f_ini_vaca !== null)
f_ini_vaca.setAttribute("min", formattedDate);

//console.log("pruebita");
gtag("config", "UA-23581568-13");

tiposol.addEventListener("change", (event) => {
    var cod = document.getElementById("tipo_sol").value;

    if (cod == "Reposo") {
        ocultSolicitud(vacaciones);
        showSolicitud(reposo);
        ocultSolicitud(permisos);
        showSolicitud(motivo);
        f_ini.setAttribute("required", "required");
        f_fin.setAttribute("required", "required");
        f_ini_vaca.removeAttribute("required");
        motivo_per.removeAttribute("required");
        horario.removeAttribute("required");
        f_ini_per.removeAttribute("required");
        f_fin_per.removeAttribute("required");

        //    alert(cod);
    } else if (cod == "Constancia") {
        ocultSolicitud(reposo);
        ocultSolicitud(vacaciones);
        ocultSolicitud(permisos);
        showSolicitud(motivo);
        f_ini.removeAttribute("required");
        f_fin.removeAttribute("required");
        f_ini_vaca.removeAttribute("required");
        motivo_per.removeAttribute("required");
        horario.removeAttribute("required");
        f_ini_per.removeAttribute("required");
        f_fin_per.removeAttribute("required");

    } 
    else if (cod == "Permisos") {
       // console.log("prueba permisos");
        ocultSolicitud(reposo);
        ocultSolicitud(vacaciones);
        showSolicitud(permisos);
        ocultSolicitud(motivo);
        f_ini_vaca.removeAttribute("required");  
        f_ini.removeAttribute("required");
        f_fin.removeAttribute("required");
        f_ini_per.setAttribute("required", "required");
        f_fin_per.setAttribute("required", "required");
        horario.setAttribute("required", "required");
        motivo_per.setAttribute("required", "required");

    } else if (cod == "Vacaciones") {
        ocultSolicitud(reposo);
        showSolicitud(vacaciones);
        ocultSolicitud(permisos);
        showSolicitud(motivo);

        f_ini_vaca.setAttribute("required", "required");
        f_ini.removeAttribute("required");
        f_fin.removeAttribute("required");
        motivo_per.removeAttribute("required");
        horario.removeAttribute("required");
        f_ini_per.removeAttribute("required");
        f_fin_per.removeAttribute("required");

        $('#fecha_ini').keydown( () => {
            return false;
        });

        var selectedValue = this.value;
        $.ajax({
            url: '../php/vacaciones/validate_vacaciones.php',
            method: 'POST',
            data: { 
                valorSeleccionado: cod,
                validacion: "pendientes",
            },
            success: function(response) {
            if (response === '1') {
                $('#myModal').modal('show');
                console.log("retorno 1 ", tiposol.value, response)
                tiposol.value = "";
                ocultSolicitud(reposo);
                ocultSolicitud(vacaciones);
                f_ini.removeAttribute('required');
                f_fin.removeAttribute('required');
                f_ini_vaca.removeAttribute('required');
            }else {
                console.log(response)
            }
            },
            error: function() {
            console.error('Error en la petición AJAX');
            }
        });
    } else {
        ocultSolicitud(reposo);
        ocultSolicitud(vacaciones);
        f_ini.removeAttribute("required");
        f_fin.removeAttribute("required");
        f_ini_vaca.removeAttribute("required");
    }
});

function showSolicitud(solicitud) {
    solicitud.style.display = "";
    solicitud.setAttribute("required", "required");
    motivo.value = "";
}

function ocultSolicitud(solicitud) {
    solicitud.style.display = "none";
    solicitud.removeAttribute("required");
    motivo.value = "";
}

f_ini_vaca.addEventListener("change", (event) => {
    var selectedDate = new Date(f_ini_vaca.value);
    //Comparacion de si es fin de semana
    var dayOfWeek = selectedDate.getDay();
    if (dayOfWeek === 5 || dayOfWeek === 6) {
        f_ini_vaca.value = "";
        $("#fechaModal").modal("show");
    } else {
        //INICIO DE COMPARACION DE FERIADOS
        //feriados
        $.ajax({
            url: "../php/vacaciones/validate_vacaciones.php",
            method: "POST",
            data: {
                fecha_ini_vaca: f_ini_vaca.value,
                peri_disfrute: peri_disfrute.value,
                validacion: "feriados",
                peri_disfrute: peri_disfrute.value
            },
            success: function (response) {
                if (response === "1") {
                    f_ini_vaca.value = "";
                    $("#fechaModal").modal("show");
                } else {console.log(response)
                    // INICIO DE COMPARACION DE OCUPADOS
                    $.ajax({
                        url: "../php/vacaciones/validate_vacaciones.php",
                        method: "POST",
                        data: {
                            fecha_ini_vaca: f_ini_vaca.value,
                            validacion: "ocupados",
                            peri_disfrute: peri_disfrute.value
                        },
                        success: function (response) {
                            if (response != "1") {
                                console.log(response);
                                // response = JSON.parse(response);
                                // document.getElementById("modal_fecha_ini").value =
                                //     response[0].fecha_inicio.split(" ")[0];
                                // document.getElementById("modal_fecha_fin").value =
                                //     response[0].fecha_fin.split(" ")[0];
                                // $("#ocupateModal").modal("show");
                                // f_ini_vaca.value = "";
                            } else {
                            }
                        },
                        error: function () {
                            console.error("Error en la petición AJAX");
                        },
                    });
                    // FIN DE COMPARACION DE OCUPADOS
                }
            },
            error: function () {
                console.error("Error en la petición AJAX");
            },
        });
        //FIN DE COMPARACION DE FERIADOS
    }
});

peri_disfrute.addEventListener("change", (event) => {
    f_ini_vaca.value = "";
});