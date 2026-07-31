<?php

require_once '../../utils/general-utils.php';

function generarTemplateCorreo($datos, $incluir_version_texto = true) {
    
    // Valores por defecto
    $fecha = $datos['fecha'] ?? date('d/m/Y');
    $hora = $datos['hora'] ?? date('h:i A');
    $institucion = $datos['institucion'] ?? 'ABAE';
    $departamento = $datos['departamento'] ?? 'Control de Asistencia';
    $color_principal = $datos['color_principal'] ?? '#013f70';
    $color_acento = $datos['color_acento'] ?? '#fbae45';
    
    // Validar campos requeridos
    $campos_requeridos = ['condicion', 'descripcion', 'id_usuario', 'nombre_completo'];
    foreach ($campos_requeridos as $campo) {
        if (!isset($datos[$campo])) {
            throw new Exception("Campo requerido '$campo' no proporcionado para el template de correo");
        }
    }
    
    // Escapar contenido para evitar inyección HTML
    $condicion = htmlspecialchars($datos['condicion'], ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($datos['descripcion'], ENT_QUOTES, 'UTF-8');
    $descripcion_con_saltos = nl2br($descripcion);
    $id_usuario = htmlspecialchars($datos['id_usuario'], ENT_QUOTES, 'UTF-8');
    $nombre_completo = htmlspecialchars($datos['nombre_completo'], ENT_QUOTES, 'UTF-8');
    $archivo_nombre = isset($datos['archivo_nombre']) ? htmlspecialchars(basename($datos['archivo_nombre']), ENT_QUOTES, 'UTF-8') : null;
    
    // Determinar color del badge según condición
    $badge_color = '#E8F5E9'; // Verde claro por defecto
    $badge_text_color = '#2E7D32';
    
    if (strpos(strtolower($condicion), 'médica') !== false || strpos(strtolower($condicion), 'medica') !== false) {
        $badge_color = '#FFE5E5';
        $badge_text_color = '#D32F2F';
    } elseif (strpos(strtolower($condicion), 'personal') !== false) {
        $badge_color = '#E5F6FF';
        $badge_text_color = '#1976D2';
    }
    
    // Asunto del correo
    $asunto = "📋 Notificación: Nuevo Reporte de Personal - $condicion";
    
    // ========== VERSIÓN HTML ==========
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="margin:0; padding:0; font-family: \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; background-color:#f5f7fa; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f5f7fa; padding:30px 10px;">
            <tr>
                <td align="center">
                    <!-- Contenedor principal -->
                    <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.05); border:1px solid #e9ecef;">
                        
                        <!-- Encabezado con gradiente -->
                        <tr>
                            <td style="padding:30px 30px 20px 30px; background: ' . $color_principal . '; border-radius:12px 12px 0 0;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr style="text-align: center;">
                                        <td style="color:#ffffff; font-size:28px; letter-spacing:1px;">Reporte de Personal - ABAE</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height:5px; background-color:' . $color_acento . '; width:80px; margin-top:10px; border-radius:3px;"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Contenido principal -->
                        <tr>
                            <td style="padding:30px;">
                                
                                <!-- Título de la notificación -->
                                <h1 style="margin:0 0 15px 0; font-size:24px; font-weight:400; color:#2C3E50; border-left:5px solid ' . $color_acento . '; padding-left:20px;">
                                    Nuevo Reporte Registrado en el Sistema
                                </h1>
                                
                                <!-- Badge de condición -->
                                <table cellpadding="0" cellspacing="0" border="0" style="margin:25px 0;">
                                    <tr>
                                        <td style="background-color:' . $badge_color . '; border-radius:50px; padding:8px 25px;">
                                            <span style="font-size:16px; font-weight:500; color:' . $badge_text_color . ';">
                                                ⚡ ' . mb_strtoupper_spanish($condicion) . '
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Tarjeta de detalles -->
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F8FAFC; border-radius:10px; border:1px solid #E2E8F0; margin:20px 0;">
                                    <tr>
                                        <td style="padding:20px;">
                                            
                                            <!-- Fecha y hora -->
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
                                                <tr>
                                                    <td style="font-size:14px; color:#64748B; padding-bottom:5px;">📅 Fecha de registro</td>
                                                    <td style="font-size:14px; color:#64748B; padding-bottom:5px;">⏰ Hora</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:18px; font-weight:500; color:' . $color_principal . ';">' . $fecha . '</td>
                                                    <td style="font-size:18px; font-weight:500; color:' . $color_principal . ';">' . $hora . '</td>
                                                </tr>
                                            </table>
                                            
                                            <!-- Datos del reporte -->
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td width="120" style="font-size:14px; color:#64748B; padding:8px 0;">👤 Reporta:</td>
                                                    <td style="font-size:16px; color:#1E293B; font-weight:500; padding:8px 0;">' . $nombre_completo . '</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:14px; color:#64748B; padding:8px 0; vertical-align:top;">📝 Descripción:</td>
                                                    <td style="font-size:15px; color:#1E293B; padding:8px 0; line-height:1.5;">' . $descripcion_con_saltos . '</td>
                                                </tr>
                                            </table>';
    
    if ($archivo_nombre) {
        $html .= '
                                            <!-- Archivo adjunto -->
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:20px; background-color:#EDF2F7; border-radius:8px;">
                                                <tr>
                                                    <td style="padding:15px;">
                                                        <span style="font-size:14px; color:#475569;">📎 Archivo adjunto:</span>
                                                        <span style="font-size:14px; font-weight:500; color:' . $color_principal . '; margin-left:10px;">' . $archivo_nombre . '</span>
                                                    </td>
                                                </tr>
                                            </table>';
    }
    
    $html .= '
                                        </td>
                                    </tr>
                                </table>
                                
                                <!-- Mensaje de acción -->
                                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:25px 0 10px 0;">
                                    <tr>
                                        <td align="center" style="padding:15px; background-color:#F1F5F9; border-radius:8px;">
                                            <span style="font-size:15px; color:#334155;">
                                                🔔 Este reporte ha sido registrado exitosamente en el sistema de ' . $departamento . '.
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td style="padding:20px 30px; background-color:#F8FAFC; border-top:1px solid #E9ECEF; border-radius:0 0 12px 12px;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td style="font-size:13px; color:#64748B;">
                                            ' . $institucion . ' · ' . $departamento . '<br>
                                            <span style="color:' . $color_acento . ';">' . date('Y') . '</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="padding-top:15px; font-size:11px; color:#94A3B8; text-align:center;">
                                            Este es un mensaje automático del sistema. Por favor no responder a esta dirección.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';
    
    // ========== VERSIÓN TEXTO PLANO ==========
    $texto = "NUEVO REPORTE DE PERSONAL - $condicion\n";
    $texto .= str_repeat("=", 50) . "\n\n";
    $texto .= "Reporta: $nombre_completo\n";
    $texto .= "Fecha: $fecha - Hora: $hora\n";
    $texto .= "Descripción: $descripcion\n\n";
    $texto .= str_repeat("-", 50) . "\n";
    $texto .= "Este es un mensaje automático del Sistema de $departamento - $institucion.\n";
    $texto .= "Oficina de Recursos Humanos\n";
    $texto .= date('Y');
    
    return [
        'html' => $html,
        'texto' => $texto,
        'asunto' => $asunto
    ];
}
?>