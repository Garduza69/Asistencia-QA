<?php
// Incluye el archivo de conexión a la base de datos
include 'conexion2.php';

            // Obtener el token del parámetro GET
            if (isset($_GET['token'])) {
                $token = $_GET['token'];

                // Consultar el id_usuario asociada al token en la tabla codigos_qr
                $sql_select = "SELECT id_codigo, id_usuario, used FROM codigos_qr WHERE token = '$token'";
                $result_select = $db->query($sql_select);

                // Verificar si se encontró el token en la base de datos
                if ($result_select->num_rows > 0) {
                    // Obtener el id_usuario y used asociados al token
                    $row_select = $result_select->fetch_assoc();
                    $id_codigo = $row_select['id_codigo'];
                    $id_usuario = $row_select['id_usuario'];
                    $used = $row_select['used'];


                    //verificar si el código ya fue usado
                    if($used == 0){

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

                                echo "redirigiendo a las calificaciones|$alumno_id";
                                exit;
                            
    
                            } else {
                                //"Error: No se encontró un alumno asociado al usuario.";
                                // En caso de error al procesar el registro de asistencia
                                header("Location: send_email.php?token=$token&result=6");
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
                    echo "No se encontró ningún token asociado.";
                    exit;
                }
            } else {
                // Si no se proporciona un token, se devuelve un error
                //"Error: No se proporcionó un token.";
                // En caso de error al procesar el registro de asistencia
                    echo "No se encontró ningún token";
                    exit;
                }

// Cerrar la conexión
$db->close();

?>

