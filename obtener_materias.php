<?php

session_start();
require_once "conexion2.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$email_usuario = $_SESSION['email'];

// Consultar el idUsuario asociado al correo del usuario actual 1
$sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = '$email_usuario'";
$stmt_usuario = $db->query($sql_usuario);
$row_usuario = $stmt_usuario->fetch_assoc();
$id_usuario = $row_usuario['idUsuario'];

// Consultar el alumno_id asociado al idUsuario en la tabla alumnos
$sql_alumno = "SELECT alumno_id FROM alumnos WHERE id_usuario = '$id_usuario'";
$stmt_alumno = $db->query($sql_alumno);
$row_alumno = $stmt_alumno->fetch_assoc();
$alumno_id = $row_alumno['alumno_id'];

$sql_materias = "SELECT a.materia_id AS materia_id, m.nombre AS nombre
                    FROM matricula a 
                    join grupos g on a.grupo_id = g.grupo_id and g.vigenciaSem = 1
                    join materias m on a.materia_id = m.materia_id
                WHERE a.alumno_id = '$alumno_id'
                group by a.materia_id, m.nombre;";
$stmt_materias = $db->query($sql_materias);

$options  .='<option value>' . "Selecciona una opción". '</option>';
    while ($row = $stmt_materias->fetch_assoc()) {
        $options .= '<option value="' . $row['materia_id'] . '">' . $row['nombre'] . '</option>';
    }

echo $options;

?>