<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sistema2";
$password = "Cruzazul443";
$dbname = "u712195824_sistema2";

// Intentar establecer la conexión
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Verificar si hay errores de conexión
if (!$pdo) {
    die("Error al conectar a la base de datos: " . print_r($pdo->errorInfo(), true));
}
?>
