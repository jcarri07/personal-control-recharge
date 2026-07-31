$(document).ready(function () {
    $('.button_fantasma').click(function (e) {
        e.preventDefault();
        $(this).prev().click();
    });
    $('.input_file_oculto').change(function () {
        var string_nombre = '';
        for (var i = 0; i < $(this)[0].files.length; i++) {
            string_nombre += $(this)[0].files[i].name;
            if (i + 1 != $(this)[0].files.length) string_nombre += ', ';
        }
        //$(this).next(".button_fantasma span").text(string_nombre);
        $(this).next('.button_fantasma').find('span').text(string_nombre);
    });
});
