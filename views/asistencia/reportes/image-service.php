<?php
    function esImagen($rutaArchivo) {
        if (!file_exists($rutaArchivo)) {
            return false;
        }
        
        $infoArchivo = getimagesize($rutaArchivo);
        
        if ($infoArchivo === false) {
            return false;
        }
        
        $tiposMimeImagen = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/bmp',
            'image/webp',
            'image/svg+xml'
        ];

        echo $rutaArchivo;
        
        $mime = $infoArchivo['mime'];
        
        return in_array($mime, $tiposMimeImagen);
    }
?>