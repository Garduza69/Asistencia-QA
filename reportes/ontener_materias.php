<?php
// Incluir la conexión a la base de datos
require('../conexion2.php');

if (isset($_POST['grupo'])) {
    $grupoSeleccionado = $_POST['grupo'];

    // Consulta para obtener las materias relacionadas con el grupo seleccionado
    $query = "SELECT 
                ma.nombre AS nombre_materia 
              FROM matricula m 
              JOIN grupos g ON m.grupo_id = g.grupo_id 
              JOIN materias ma ON m.materia_id = ma.materia_id 
              WHERE g.clave_grupo = ? AND g.vigenciaSem = 1 
              GROUP BY ma.nombre 
              ORDER BY ma.nombre";

    // Preparar la consulta
    if ($stmt = $db->prepare($query)) {
        $stmt->bind_param('s', $grupoSeleccionado);
        $stmt->execute();
        $result = $stmt->get_result();

        // Generar las opciones del combo de materias
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["nombre_materia"] . '">' . $row["nombre_materia"] . '</option>';
            }
        } else {
            echo '<option value="">No hay materias disponibles</option>';
        }

        $stmt->close();
    }
}
?>