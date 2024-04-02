<?php
require_once 'configuracion.php';

// Redireccionar al usuario a la página de inicio de sesión de Google
$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
?>
