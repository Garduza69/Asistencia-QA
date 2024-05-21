<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sistema";
$password = "Cruzazul443";
$dbname = "u712195824_sistema";


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

if ($result) {
    $row = $result->fetch_assoc();
    $registros = $row['registros'];

    // Si no hay registros, actualizar los campos asistencia a 3 donde es NULL
    if ($registros == 0) {
        $sql_actualizar = "UPDATE asistencia SET asistencia = 3 WHERE asistencia IS NULL AND DATE(fecha_alta) = '$fecha_actual'";
        if ($conn->query($sql_actualizar) === TRUE) {
            echo "Registro actualizado correctamente";
        } else {
            echo "Error actualizando registro: " . $conn->error;
        }
    } else {
        echo "Ya existen registros para el día de hoy.";
    }
} else {
    echo "Error consultando registros: " . $conn->error;
}

$conn->close();
?>