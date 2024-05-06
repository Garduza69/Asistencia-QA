<?php
$servidor= "localhost";
$usuario= "u712195824_sistema2";
$password = "Cruzazul443";
$nombreBD= "u712195824_sistema2";
$db = new mysqli($servidor, $usuario, $password, $nombreBD);
if ($db->connect_error) {
    die("la conexión ha fallado: " . $db->connect_error);
}
?>