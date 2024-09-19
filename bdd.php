<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "u712195824_sistema2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar que se ha enviado el id_usuario
if (isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
} else {
    die("Error: No se seleccionó ningún usuario.");
}

// Recoger los datos del formulario
$nombre = $_POST['nombre'];
$primer_apellido = $_POST['primer_apellido'];
$segundo_apellido = $_POST['segundo_apellido'];
$matricula = $_POST['matricula'];
$curp = $_POST['curp'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$sexo = $_POST['sexo'];

// Consulta para insertar los datos
$sql = "INSERT INTO alumnos (nombre, primer_apellido, segundo_apellido, matricula, curp, fecha_nacimiento, sexo, id_usuario)
        VALUES ('$nombre', '$primer_apellido', '$segundo_apellido', '$matricula', '$curp', '$fecha_nacimiento', '$sexo', '$id_usuario')";

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    // Redirigir a success_alumno.php si se agregó correctamente
    header("Location: success_alumno.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
