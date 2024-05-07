<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia localhost por el servidor de tu base de datos
$username = "u712195824_sistema2"; // Cambia tu_usuario por el nombre de usuario de tu base de datos
$password = "Cruzazul443"; // Cambia tu_contraseña por la contraseña de tu base de datos
$dbname = "u712195824_sistema2"; // Cambia login por el nombre de tu base de datos
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['email'])) {
    $email_usuario = $_SESSION['email'];

    // Crear conexión a la base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Consultar el idUsuario asociado al correo del usuario actual
    $sql_usuario = "SELECT idUsuario FROM usuario WHERE email = '$email_usuario'";
    $result_usuario = $conn->query($sql_usuario);
    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $id_usuario = $row_usuario['idUsuario'];

        // Consultar el profesor_id asociado al idUsuario en la tabla profesores
        $sql_profesor = "SELECT profesor_id FROM profesores WHERE id_usuario = '$id_usuario'";
        $result_profesor = $conn->query($sql_profesor);
        if ($result_profesor->num_rows > 0) {
            $row_profesor = $result_profesor->fetch_assoc();
            $profesor_id = $row_profesor['profesor_id'];

            // Consultar las materias que imparte el profesor en la tabla horarios
            $sql_materias = "SELECT materia_id FROM horarios WHERE profesor_id = '$profesor_id'";
            $result_materias = $conn->query($sql_materias);
            $materias_imparte = [];
            while ($row_materia = $result_materias->fetch_assoc()) {
                $materias_imparte[] = $row_materia['materia_id'];
            }

            // Obtener la fecha actual
            $fecha_actual = date("Y-m-d");

            // Iterar sobre las materias que imparte el profesor
            foreach ($materias_imparte as $materia_id) {
                // Preparar la consulta para actualizar la tabla asistencia
                $sql_update = "UPDATE asistencia SET asistencia = 0, fecha_actualizacion = CONVERT_TZ(CURRENT_TIMESTAMP, '+00:00', '-06:00'), usuario_actualizacion = '$email_usuario' WHERE materia_id = '$materia_id' AND fecha_alta = '$fecha_actual' AND asistencia IS NULL";

            }
            $conn->query($sql_update); 
        } 
    } 
} 

// Cerrar la conexión
$conn->close();
?>
