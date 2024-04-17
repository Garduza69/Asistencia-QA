<?php
$servidor= "localhost";
$usuario= "root";
$password = "";
$nombreBD= "sotavento";
$db = new mysqli($servidor, $usuario, $password, $nombreBD);
if ($db->connect_error) {
    die("la conexión ha fallado: " . $db->connect_error);
}
?>