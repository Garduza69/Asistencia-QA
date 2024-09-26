<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia localhost por el servidor de tu base de datos
$username = "u712195824_sistema2"; // Cambia tu_usuario por el nombre de usuario de tu base de datos
$password = "Cruzazul443"; // Cambia tu_contraseña por la contraseña de tu base de datos
$dbname = "u712195824_sistema2"; // Cambia login por el nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}

// Obtener el token del código QR escaneado (ajusta según cómo obtienes este valor)
$token_escaneado = isset($_GET["token"]) ? $_GET["token"] : '';

// Buscar el registro correspondiente al token en la tabla codigos_qr
$sql = "SELECT * FROM codigos_qr WHERE token = '$token_escaneado'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Obtener los datos del código QR
    $email = $row["correo"];
    $fecha_hora = $row["fecha_hora"];
    $materia = $row["materia"];

    // Verificar si la materia es "arquitectura de computadoras" y asignar el ID correspondiente
    if ($materia == "arquitectura de computadoras") {
        $id_materia = 1001;
    } else {
        // Si no es "arquitectura de computadoras", obtener el ID de la tabla materias
        $sql_materia = "SELECT id_materia FROM materias WHERE nombre_materia = '$materia'";
        $result_materia = $conn->query($sql_materia);
        if ($result_materia->num_rows > 0) {
            $row = $result_materia->fetch_assoc();
            $id_materia = $row["id_materia"];
        } else {
            echo "Error: La materia seleccionada no existe.<br>";
            exit();
        }
    }

    // Aquí deberías tener el ID del usuario desde algún lugar (por ejemplo, una variable de sesión)
    $id_usuario = 1; // Cambiar esto según la lógica de tu aplicación

    // Insertar la información de asistencia en la tabla asistencia
    $sql_asistencia = "INSERT INTO asistencia (Id_materia, Id_usuario, fecha_hora) VALUES ('$id_materia', '$id_usuario', '$fecha_hora')";

    if ($conn->query($sql_asistencia) === TRUE) {
        echo "Registro de asistencia creado correctamente.<br>";
    } else {
        echo "Error al crear el registro de asistencia: " . $conn->error . "<br>";
    }
} else {
    echo "Código QR no válido.<br>";
}

// Cerrar la conexión
$conn->close();
?>
