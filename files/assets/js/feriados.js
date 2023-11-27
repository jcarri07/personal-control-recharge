var boton = document.getElementById("feriados-guardar");
var boton_act = document.getElementById("feriados-actualizar");

boton.addEventListener("click", function () {
    var filas_actual = document.getElementsByClassName("tr-actual-date");

    var año_actual = [];

    for (var i = 0; i < filas_actual.length; i++) {
        var celdas = filas_actual[i].getElementsByTagName("td");

        // var fecha = celdas[0].innerText;
        // var nombre = celdas[1].innerText;
        // var status = celdas[2].querySelector("input").checked
        //     ? "activo"
        //     : "inactivo";

        // var datos = [fecha, nombre, status];
        var datos = {
            name: celdas[0].innerText,
            date: celdas[1].innerText,
            status: celdas[2].querySelector("input").checked ? "activo" : "inactivo"
        }

        año_actual.push(datos);
    }

    var filas_next = document.getElementsByClassName("tr-next-date");

    var año_next = [];

    for (var i = 0; i < filas_next.length; i++) {
        var celdas = filas_next[i].getElementsByTagName("td");

        // var fecha = celdas[0].innerText;
        // var nombre = celdas[1].innerText;
        // var status = celdas[2].querySelector("input").checked
        //     ? "activo"
        //     : "inactivo";

        // var datos = [fecha, nombre, status];

        var datos = {
            name: celdas[0].innerText,
            date: celdas[1].innerText,
            status: celdas[2].querySelector("input").checked ? "activo" : "inactivo"
        }
        
        año_next.push(datos);
    }

    var json_actual = JSON.stringify(año_actual);
    var json_next = JSON.stringify(año_next);

    $.ajax({
        url: "../php/vacaciones/feriados.php",
        type: "POST",
        data: {
            año_actual: json_actual,
            año_siguiente: json_next
        },
        success: function (response) {
            if (response === '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Guardado con exito',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            console.log(response);
        },
    });
});

boton_act.addEventListener("click", function () {
    $.ajax({
        url: "../php/vacaciones/actualizar_feriados.php",
        type: "POST",
        success: function (response) {
            if (response === '1') {
                Swal.fire({
                    icon: 'success',
                    title: 'Actualizado con exito',
                    showConfirmButton: false,
                    timer: 1000
                }).then(function () {
                    location.reload(); // Recargar la página
                });
            }
            console.log(response);
        },
    });
});