<?php

session_start();
require_once "conexion.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$email_usuario = $_SESSION['email'];

// Consultar el idUsuario asociado al correo del usuario actual 1
$sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = :email";
$stmt_usuario = $pdo->prepare($sql_usuario);
$stmt_usuario->bindParam(':email', $email_usuario, PDO::PARAM_STR);
$stmt_usuario->execute();
$row_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
$id_usuario = $row_usuario['idUsuario'];

// Consultar el alumno_id asociado al idUsuario en la tabla alumnos
$sql_alumno = "SELECT alumno_id FROM alumnos WHERE id_usuario = :id_usuario";
$stmt_alumno = $pdo->prepare($sql_alumno);
$stmt_alumno->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt_alumno->execute();
$row_alumno = $stmt_alumno->fetch(PDO::FETCH_ASSOC);
$alumno_id = $row_alumno['alumno_id'];

$sql_materias = "SELECT a.materia_id AS materia_id, m.nombre AS nombre
                    FROM matricula a 
                    join grupos g on a.grupo_id = g.grupo_id and g.vigenciaSem = 1
                    join materias m on a.materia_id = m.materia_id
                WHERE a.alumno_id = :alumno_id
                group by a.materia_id, m.nombre;";
$stmt_materias = $pdo->prepare($sql_materias);
$stmt_materias->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
$stmt_materias->execute();


$options  .='<option value>' . "Selecciona una opción". '</option>';
    while ($row = $stmt_materias->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row['materia_id'] . '">' . $row['nombre'] . '</option>';
    }

echo $options;

?>