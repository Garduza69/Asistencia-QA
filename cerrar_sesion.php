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



// Eliminar las variables de sesión específicas de las credenciales de Google
$_SESSION["loggedin"] = false;

unset($_SESSION['loggedin']);
unset($_SESSION['email']);
unset($_SESSION['nombre']);

session_unset();

session_destroy();

// Redirigir al usuario a la página de logout de Google y luego de regreso al índice de tu página web
$googleLogoutUrl = 'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=http://asistenciasus.site';
header('Location: ' . filter_var($googleLogoutUrl, FILTER_SANITIZE_URL));
exit;
?>
