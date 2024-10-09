<?php
require_once 'vendor/autoload.php';

$clientID = '836660401451-fjm2ab434pvjbbusp700udsd0srne8q1.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://asistenciasus.site/autentificacion.php';

// Crear el cliente de Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

?>
