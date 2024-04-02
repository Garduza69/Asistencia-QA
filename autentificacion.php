<?php
require_once 'configuracion.php';

// Imprimir el código de autorización para verificar si se recibe correctamente
var_dump($_GET['code']);

// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

    // Intercambia el código de autorización por un token de acceso
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Obtén la información del perfil del usuario
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $nombre = $google_account_info->name;

    // Guarda el correo electrónico y el nombre en variables de sesión
    session_start();
    $_SESSION['email'] = $email;
    $_SESSION['nombre'] = $nombre;

    // Redirige al usuario a verificar el correo en la base de datos
    header("Location: verificar_usuario.php");
    exit();
}
?>

