<?php
require(__DIR__ . '/../vendor/autoload.php'); 

// Cargar variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

// Verificar si las variables de entorno están cargadas
//var_dump($_ENV); 

// Datos de conexión a la base de datos desde variables de entorno
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

// Intentar establecer la conexión
$db = new mysqli($servername, $username, $password, $dbname);

if ($db->connect_error) {
    die("La conexión ha fallado: " . $db->connect_error);
}
?>