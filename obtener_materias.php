<?php
require_once "conexion.php";

$stmt = $pdo->query("SELECT materia_id, nombre FROM materias"); // Incluir materia_id en la consulta
$options = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $options .= '<option value="' . $row['materia_id'] . '">' . $row['nombre'] . '</option>'; // Utilizar materia_id como valor del option
}
echo $options;
?>
