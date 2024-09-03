<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sistema2";
$password = "Cruzazul443";
$dbname = "u712195824_sistema2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha actual
$fecha_actual = date('Y-m-d');

// Contar el número de registros para el día actual
$sql_contar = "SELECT COUNT(*) AS registros FROM asistencia WHERE DATE(fecha) = '$fecha_actual'";
$result = $conn->query($sql_contar);
$row = $result->fetch_assoc();
$registros = $row['registros'];

// Ruta del archivo de log
$log_file = '/home/u712195824/public_html/cron_log.txt';

// Registrar en el log el inicio de la ejecución
file_put_contents($log_file, "Script ejecutado el: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// Si no hay registros, actualizar los campos asistencia a 3 donde es NULL
if ($registros == 0) {
    $sql_actualizar = "UPDATE asistencia SET asistencia = 3 WHERE asistencia IS NULL AND DATE(fecha_alta) = '$fecha_actual'";
    if ($conn->query($sql_actualizar) === TRUE) {
        file_put_contents($log_file, "Registros actualizados correctamente.\n", FILE_APPEND);
    } else {
        file_put_contents($log_file, "Error actualizando registros: " . $conn->error . "\n", FILE_APPEND);
    }
} else {
    file_put_contents($log_file, "No hay registros para actualizar.\n", FILE_APPEND);
}

$conn->close();
?>
