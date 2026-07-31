<?php
    function getDateSpanish($date = null) {
        if($date == null) {
            $date = date("Y-m-d");
        }
        $months = [
            "01" => "Enero",
            "02" => "Febrero",
            "03" => "Marzo",
            "04" => "Abril",
            "05" => "Mayo",
            "06" => "Junio",
            "07" => "Julio",
            "08" => "Agosto",
            "09" => "Septiembre",
            "10" => "Octubre",
            "11" => "Noviembre",
            "12" => "Diciembre"
        ];

        $day = date("d", strtotime($date));
        $month = date("m", strtotime($date));
        $year = date("Y", strtotime($date));

        return $day . ' de ' . $months[$month] . ' de ' . $year;
    }

    function mb_strtoupper_spanish($string) {
        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        
        // Mapeo de caracteres con acentos y ñ
        $search = ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü'];
        $replace = ['Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ', 'Ü'];
        
        // Primero convertimos todo a mayúsculas (esto afectará los acentos)
        $string = mb_strtoupper($string, 'UTF-8');
        
        // Luego corregimos los caracteres que mb_strtoupper no maneja bien
        $string = str_replace($search, $replace, $string);
        
        return $string;
    }

    function imagenABase64($ruta_imagen) {
        if (file_exists($ruta_imagen)) {
            $imagen_data = file_get_contents($ruta_imagen);
            $tipo = pathinfo($ruta_imagen, PATHINFO_EXTENSION);
            $base64 = base64_encode($imagen_data);
            return "data:image/$tipo;base64,$base64";
        }
        return null;
    }
?>