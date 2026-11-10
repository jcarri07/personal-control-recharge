<?php
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $baseUrlHeaderPdf = $protocol . $host . $scriptPath . '../../../../';
?>

    <header>
        <div style="display: flex; width: 100%;">
            <img src="<?php echo $baseUrlHeaderPdf; ?>img/user-profiles/Superior_izquierdo.png" style="object-fit: contain; height: 40px; white-space: nowrap;" />
            <img src="<?php echo $baseUrlHeaderPdf; ?>img/user-profiles/Logo_Abae_Horizonta.png" style="object-fit: contain; height: 30px; white-space: nowrap; padding-left: 3.35cm;" />
        </div>
    </header>