<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u712195824_sistema2";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Nombre único de la migración
$nombre_migracion = '20240926_crear_tabla_pruebas';
$lote = 1;

// Verificar si la migración ya fue aplicada
$verificar_sql = "SELECT * FROM migraciones WHERE nombre_migracion = '$nombre_migracion'";
$resultado = $conn->query($verificar_sql);

if ($resultado->num_rows == 0) {
    // Si no ha sido aplicada, crear la tabla 'pruebas'
    $sql_migraciones = "CREATE TABLE IF NOT EXISTS pruebas (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        prueba_1 VARCHAR(100) NOT NULL,
        descripcion TEXT,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql_migraciones) === TRUE) {
        echo "Migración aplicada exitosamente: tabla 'pruebas' creada.<br>";

        // Registrar la migración en la tabla 'migraciones'
        $sql_registrar_migracion = "INSERT INTO migraciones (nombre_migracion, lote) VALUES ('$nombre_migracion', $lote)";
        
        if ($conn->query($sql_registrar_migracion) === TRUE) {
            echo "Migración registrada en la tabla 'migraciones'.<br>";
        } else {
            echo "Error al registrar la migración: " . $conn->error . "<br>";
        }
    } else {
        echo "Error al aplicar la migración: " . $conn->error . "<br>";
    }
} else {
    echo "La migración '$nombre_migracion' ya ha sido aplicada anteriormente.<br>";
}

// Verificación de registro
$consulta_verificar = "SELECT * FROM migraciones WHERE nombre_migracion = '$nombre_migracion'";
$resultado_verificacion = $conn->query($consulta_verificar);

if ($resultado_verificacion->num_rows > 0) {
    echo "La migración '$nombre_migracion' ha sido registrada correctamente.<br>";
} else {
    echo "La migración '$nombre_migracion' no ha sido registrada.<br>";
}

// Cerrar la conexión
$conn->close();
?>
