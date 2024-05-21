<?php
require_once 'configuracion.php';

session_start();

// Revocar el token de acceso de Google si está presente
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->revokeToken($_SESSION['access_token']);
}

// Destruir todas las variables de sesión de PHP
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();

// Eliminar caché del navegador
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirigir al usuario a la página principal de tu aplicación
header('Location: http://asistenciasus.site');
exit;
?>
