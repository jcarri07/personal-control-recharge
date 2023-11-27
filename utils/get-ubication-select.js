$(document).on('change', "#estado, #ciudad", function() {
    console.log("Faro")
    if (this.id == "estado" || this.id == "ciudad") {
        var destino = "";
        var id = "";
        if (this.id == "estado") {
            destino = "ciudad";
            id = this.value;
            $('#ciudad').empty();
            $("#ciudad").append("<option value=''>Cargando...</option>");
            $('#municipio').empty();
            //$('#parroquia').empty();
            $("#municipio").append("<option value=''>Seleccione</option>");
            //$("#parroquias").append("<option value=''>Seleccione</option>");
        }
        if (this.id == "ciudad") {
            destino = "municipio";
            id = $('#estado').prop('value');

            $('#municipio').empty();
            $("#municipio").append("<option value=''>Cargando...</option>");
            //$('#parroquias').empty();
            //$("#parroquias").append("<option value=''>Seleccione</option>");
        }
        /*if(this.id == "municipio"){
            destino = "parroquias";
            id = this.value;
        }*/

        $.ajax({
            url: '../utils/get-ubication-select.php',
            type: 'POST',
            data: {
                cat: this.id,
                id: id
            },
            success: function(response) {
                $('select#' + destino).html(response).fadeIn();
            },
            error: function(response) {

            }
        });
    }
});
