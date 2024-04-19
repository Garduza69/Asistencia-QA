<?php
$servidor= "localhost";
$usuario= "root";
$password = "";
$nombreBD= "sota2";
$db = new mysqli($servidor, $usuario, $password, $nombreBD);
if ($db->connect_error) {
    die("la conexión ha fallado: " . $db->connect_error);
}
?>