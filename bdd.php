<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion2.php';

// Verificar la conexión
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
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
if ($db->query($sql) === TRUE) {
    // Redirigir a success_alumno.php si se agregó correctamente
    header("Location: success_alumno.php");
    exit();
} else {
    echo "Error: " . $db->error;
}

// Cerrar la conexión
$db->close();
?>
