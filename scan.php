<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion2.php';

// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['email'])) {
    $email_usuario = $_SESSION['email'];

    // Consultar el idUsuario asociado al correo del usuario actual
    $sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = '$email_usuario'";
    $result_usuario = $db->query($sql_usuario);
    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
        $id_usuario = $row_usuario['idUsuario'];

        // Consultar el profesor_id asociado al idUsuario en la tabla profesores
        $sql_profesor = "SELECT profesor_id FROM profesores WHERE id_usuario = '$id_usuario'";
        $result_profesor = $db->query($sql_profesor);
        if ($result_profesor->num_rows > 0) {
            $row_profesor = $result_profesor->fetch_assoc();
            $profesor_id = $row_profesor['profesor_id'];

            // Consultar las materias que imparte el profesor en la tabla horarios
            $sql_materias = "SELECT materia_id FROM horarios WHERE profesor_id = '$profesor_id'";
            $result_materias = $db->query($sql_materias);
            $materias_imparte = [];
            while ($row_materia = $result_materias->fetch_assoc()) {
                $materias_imparte[] = $row_materia['materia_id'];
            }

            // Obtener el token del parámetro GET
            if (isset($_GET['token'])) {
                $token = $_GET['token'];

                // Consultar la materia asociada al token en la tabla codigos_qr
                $sql_select = "SELECT id_codigo, id_usuario, used FROM codigos_qr WHERE token = '$token'";
                $result_select = $db->query($sql_select);

                // Verificar si se encontró el token en la base de datos
                if ($result_select->num_rows > 0) {
                    // Obtener el id_usuario y used asociados al token
                    $row_select = $result_select->fetch_assoc();
                    $id_codigo = $row_select['id_codigo'];
                    $id_usuario = $row_select['id_usuario'];
                    $used = $row_select['used'];

                    $sql_selectmat = "SELECT materia_id FROM materia_qr WHERE id_codigo = '$id_codigo'";
                    $result_selectmat = $db->query($sql_selectmat);
                    // Obtener el materia_id
                    $row_selectmat = $result_selectmat->fetch_assoc();
                    $materia_id = $row_selectmat['materia_id'];

                    //verificar si el código ya fue usado
                    if($used == 0){

                        // Verificar si la materia del token coincide con alguna de las materias que imparte el profesor
                        if (in_array($materia_id, $materias_imparte)) {
                            // Consultar el alumno_id asociado al id_usuario en la tabla alumnos
                            $sql_alumno = "SELECT alumno_id FROM alumnos WHERE id_usuario = '$id_usuario'";
                            $result_alumno = $db->query($sql_alumno);

                            // Verificar si se encontró un alumno asociado al id_usuario
                            if ($result_alumno->num_rows > 0) {
                                // Obtener el alumno_id
                                $row_alumno = $result_alumno->fetch_assoc();
                                $alumno_id = $row_alumno['alumno_id'];

                                // Establecer la zona horaria a la Ciudad de México
                                date_default_timezone_set("America/Mexico_City");

                                // Obtener la fecha actual
                                $fecha_actual = date("Y-m-d");

                                // Verificar si la asistencia es NULL o 0
                                $sql_check_attendance = "SELECT asistencia FROM asistencia WHERE materia_id = '$materia_id' AND alumno_id = '$alumno_id' AND fecha_alta = '$fecha_actual'";
                                $result_check_attendance = $db->query($sql_check_attendance);
                                if ($result_check_attendance->num_rows > 0) {
                                    $row_attendance = $result_check_attendance->fetch_assoc();
                                    $attendance = $row_attendance['asistencia'];
                                    if ($attendance === null) {
                                        // Preparar la consulta para actualizar la tabla asistencia
                                        $sql_update = "UPDATE asistencia SET asistencia = 1, fecha_actualizacion = CONVERT_TZ(CURRENT_TIMESTAMP, '+00:00', '-06:00'), usuario_actualizacion = '$email_usuario'
                                        WHERE materia_id = '$materia_id' AND alumno_id = '$alumno_id' AND fecha_alta = '$fecha_actual' ";

                                        // Ejecutar la consulta de actualización
                                        if ($db->query($sql_update) === TRUE) {
                                            // Verificar si se actualizó algún registro
                                            if ($db->affected_rows > 0) {
                                                // Si se actualizó correctamente, muestra el mensaje de éxito
                                                // Después de procesar el registro de asistencia con éxito
                                                header("Location: send_email.php?token=$token&result=1");
                                                exit;
                                            }
                                            
                                        } else {
                                            // Si ocurrió un error al actualizar, devuelve el mensaje de error de MySQL
                                            // En caso de error al procesar el registro de asistencia
                                            header("Location: send_email.php?token=$token&result=6");
                                            exit;
                                        }
                                    } elseif($attendance == 1){
                                        // Si no se actualizó ningún registro (ya se había registrado la asistencia previamente), muestra un mensaje informativo
                                        // En caso de asistencia ya registrada manda la siguiente notificación
                                        header("Location: send_email.php?token=$token&result=2");
                                        exit;
                                    }
                                    else{
                                        // En caso de que la clase ya fue cerrada manda la siguiente notificación
                                        header("Location: send_email.php?token=$token&result=3");
                                        exit;
                                    }
                                } else {
                                    
                                    // En caso de error al procesar el registro de asistencia
                                    header("Location: send_email.php?token=$token&result=6");
                                    exit;
                                }
                            } else {
                                //"Error: No se encontró un alumno asociado al usuario.";
                                // En caso de error al procesar el registro de asistencia
                                header("Location: send_email.php?token=$token&result=6");
                                exit;
                            }
                        } else {
                            // En caso de asistencia ya registrada manda la siguiente notificación
                            header("Location: send_email.php?token=$token&result=4");
                            exit;
                        }
                        // Actualizar el campo 'used' a 1
                        $sql_update_used = "UPDATE codigos_qr SET used = 1 WHERE token = '$token'";
                        $db->query($sql_update_used);
                    }else{
                        if($used == 1){
                        // manda el mensaje si el código QR ya fue usado
                        // En caso de que el código ya ha sido usado manda la siguiente notificación
                            header("Location: send_email.php?token=$token&result=5");
                            exit;
                        }
                    }
                } else {
                    //"Error: No se encontró ningún token asociado.";
                    // En caso de error al procesar el registro de asistencia
                    header("Location: send_email.php?token=$token&result=6");
                    exit;
                }
            } else {
                // Si no se proporciona un token, se devuelve un error
                //"Error: No se proporcionó un token.";
                // En caso de error al procesar el registro de asistencia
                header("Location: send_email.php?token=$token&result=6");
                exit;
            }
        } else {
            // Si no se encontró un profesor asociado al idUsuario, muestra un mensaje de error
            $mensaje_respuesta = "Error: No se encontró un profesor asociado al usuario.";
        }
    } else {
        // Si no se encontró un usuario con el correo proporcionado, muestra un mensaje de error
        $mensaje_respuesta = "Error: No se encontró un usuario con el correo proporcionado.";
    }
} else {
    // Si el usuario no ha iniciado sesión, muestra un mensaje de error
    $mensaje_respuesta = "Error: El usuario no ha iniciado sesión.";
}

// Cerrar la conexión
$db->close();

?>

