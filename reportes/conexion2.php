<?php
$servidor= "localhost";
$usuario= "u712195824_sistema";
$password = "Cruzazul1443";
$nombreBD= "u712195824_sistema";
$db = new mysqli($servidor, $usuario, $password, $nombreBD);
if ($db->connect_error) {
    die("la conexión ha fallado: " . $db->connect_error);
}
?>