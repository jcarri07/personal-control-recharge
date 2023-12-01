$(document).on('change', "#estado, #ciudad, #parroquia", function() {
    console.log("Faro")
    console.log("id: "+this.id);
    if (this.id == "estado" || this.id == "ciudad") {
        var destino = "";
        var id = "";
        if (this.id == "estado") {
            destino = "ciudad";
            id = this.value;
            $('#ciudad').empty();
            $("#ciudad").append("<option value=''>Cargando...</option>");
            $('#municipio').empty();
            // $('#parroquia').empty();
            $("#municipio").append("<option value=''>Seleccione</option>");
            // $("#parroquia").append("<option value=''>Seleccionesss</option>");
        }
        if (this.id == "ciudad") {
            destino = "parroquia";
            id = this.value;

            // $('#municipio').empty();
            // $("#municipio").append("<option value=''>Cargando...</option>");
            $('#parroquia').empty();
            $("#parroquia").append("<option value=''>Seleccione</option>");
        }

        $.ajax({
            url: '../utils/get-ubication-select.php',
            type: 'POST',
            data: {
                cat: this.id,
                id: id
            },
            success: function(response) {
                console.log(response);
                $('select#' + destino).html(response).fadeIn();
            },
            error: function(response) {
                console.log(response.error);
            }
        });
    }
});
