<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "u712195824_sotavento"; // Cambiar a tu usuario de MySQL
$password = "Cruzazul443"; // Cambiar a tu contraseña de MySQL (si la tienes)
$dbname = "u712195824_Sotaproyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recuperar datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$tipo_usuario = $_POST['tipo_usuario'];
$matricula = $_POST['matricula'];
$contrasena = $_POST['contrasena'];

// Preparar consulta SQL
$sql = "INSERT INTO registros (nombre, apellido_paterno, apellido_materno, tipo_usuario, matricula, contrasena)
VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$tipo_usuario', '$matricula', '$contrasena')";

// Ejecutar consulta
if ($conn->query($sql) === TRUE) {
    // Redireccionar al usuario a la página de registro exitoso
    header("Location:registro_exitoso.html");
    exit(); // Detener la ejecución del script
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
>
