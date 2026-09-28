<?php
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrlWateraMark = $protocol . $host . $scriptPath . '../../../../';
?>
    <div id="watermark">
        <img src="<?php echo $baseUrlWateraMark; ?>/img/user-profiles/Logo-Abae-sin-fondo2.png" height="45%" width="45%" />
    </div>