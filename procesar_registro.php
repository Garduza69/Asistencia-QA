<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Cambiar a tu usuario de MySQL
$password = ""; // Cambiar a tu contraseña de MySQL (si la tienes)
$dbname = "sotavento";

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

// Mapear el tipo de usuario a su correspondiente número
$tipo_usuario = $_POST['tipo_usuario'];
switch ($tipo_usuario) {
    case 'docente':
        $tipo_usuario = 1;
        break;
    case 'alumno':
        $tipo_usuario = 2;
        break;
    case 'administrativo':
        $tipo_usuario = 3;
        break;
    case 'director_facultad':
        $tipo_usuario = 4;
        break;
    default:
        // En caso de que no se haya seleccionado un tipo válido, puedes manejarlo como desees, por ejemplo, lanzando un error o estableciendo un valor por defecto.
        break;
}

$matricula = $_POST['matricula'];
$contrasena = $_POST['contrasena'];
$email = $_POST['email'];

// Preparar consulta SQL
$sql = "INSERT INTO registros (nombre, apellido_paterno, apellido_materno, tipo_usuario, matricula, contrasena, email)
VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$tipo_usuario', '$matricula', '$contrasena', '$email')";

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
