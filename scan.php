<?php
// Configuración de la base de datos
$servername = "localhost"; // Cambia localhost por el servidor de tu base de datos
$username = "u712195824_sistema"; // Cambia tu_usuario por el nombre de usuario de tu base de datos
$password = "Cruzazul443"; // Cambia tu_contraseña por la contraseña de tu base de datos
$dbname = "u712195824_sistema"; // Cambia login por el nombre de tu base de datos

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

            // Obtener el token del parámetro GET
            if (isset($_GET['token'])) {
                $token = $_GET['token'];

                // Consultar la materia asociada al token en la tabla codigos_qr
                $sql_select = "SELECT materia_id, id_usuario FROM codigos_qr WHERE token = '$token'";
                $result_select = $conn->query($sql_select);

                // Verificar si se encontró el token en la base de datos
                if ($result_select->num_rows > 0) {
                    // Obtener el materia_id y el id_usuario asociados al token
                    $row_select = $result_select->fetch_assoc();
                    $materia_id = $row_select['materia_id'];
                    $id_usuario = $row_select['id_usuario'];

                    // Verificar si la materia del token coincide con alguna de las materias que imparte el profesor
                    if (in_array($materia_id, $materias_imparte)) {
                        // Consultar el alumno_id asociado al id_usuario en la tabla alumnos
                        $sql_alumno = "SELECT alumno_id FROM alumnos WHERE id_usuario = '$id_usuario'";
                        $result_alumno = $conn->query($sql_alumno);

                        // Verificar si se encontró un alumno asociado al id_usuario
                        if ($result_alumno->num_rows > 0) {
                            // Obtener el alumno_id
                            $row_alumno = $result_alumno->fetch_assoc();
                            $alumno_id = $row_alumno['alumno_id'];

                            // Obtener la fecha actual
                            $fecha_actual = date("Y-m-d");

                            // Preparar la consulta para actualizar la tabla asistencia
                            $sql_update = "UPDATE asistencia SET asistencia = 1 WHERE materia_id = '$materia_id' AND alumno_id = '$alumno_id' AND fecha_alta = '$fecha_actual'";

                            // Ejecutar la consulta de actualización
                            if ($conn->query($sql_update) === TRUE) {
                                // Verificar si se actualizó algún registro
                                if ($conn->affected_rows > 0) {
                                    // Si se actualizó correctamente, muestra el mensaje de éxito
                                    echo "Registro de asistencia exitoso.";
                                    
                                } else {
                                    // Si no se actualizó ningún registro (ya se había registrado la asistencia previamente), muestra un mensaje informativo
                                    echo "La asistencia ya ha sido registrada para este alumno y esta materia hoy.";
                                }
                            } else {
                                // Si ocurrió un error al actualizar, devuelve el mensaje de error de MySQL
                                echo "Error: " . $conn->error;
                            }
                        } else {
                            echo "Error: No se encontró un alumno asociado al usuario.";
                        }
                    } else {
                        echo "Error: La materia asociada al token no coincide con las materias que imparte el profesor.";
                    }
                } else {
                    echo "Error: No se encontró ningún token asociado.";
                }
            } else {
                // Si no se proporciona un token, se devuelve un error
                echo "Error: No se proporcionó un token.";
            }
        } else {
            // Si no se encontró un profesor asociado al idUsuario, muestra un mensaje de error
            echo "Error: No se encontró un profesor asociado al usuario.";
        }
    } else {
        // Si no se encontró un usuario con el correo proporcionado, muestra un mensaje de error
        echo "Error: No se encontró un usuario con el correo proporcionado.";
    }
} else {
    // Si el usuario no ha iniciado sesión, muestra un mensaje de error
    echo "Error: El usuario no ha iniciado sesión.";
}

// Cerrar la conexión
$conn->close();
?>



