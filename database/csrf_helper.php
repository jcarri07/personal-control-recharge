<?php
/**
 * csrf_helper.php
 * [HIGH-04 FIX] Protección CSRF centralizada
 * 
 * Uso:
 *   require_once 'ruta/a/csrf_helper.php';
 *   // En formulario HTML:  echo csrf_field();
 *   // Al procesar POST:    csrf_validate();
 */

if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (!isset($_SESSION)) session_start();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        $token = csrf_token();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}

if (!function_exists('csrf_validate')) {
    function csrf_validate(): void {
        if (!isset($_SESSION)) session_start();
        $token_post    = $_POST['csrf_token']    ?? '';
        $token_session = $_SESSION['csrf_token'] ?? '';
        if (!hash_equals($token_session, $token_post)) {
            http_response_code(403);
            die('Error de seguridad: token CSRF inválido.');
        }
    }
}
?>

