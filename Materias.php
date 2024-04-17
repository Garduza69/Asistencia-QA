<?php
// Incluir el archivo de conexión a la base de datos
require('conexion.php');

// Query para obtener las materias desde la base de datos
$mat = "SELECT nombre FROM materias";
$materias = $db->query($mat);

// Query para obtener las facultades desde la base de datos
$fac = "SELECT nombre FROM facultades";
$facultad = $db->query($fac);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Selección</title>
</head>

<body>
    <div class="container">
        <h1>Formulario de Selección</h1>
        <form action="procesar_datos.php" method="post">
            <label for="facultad">Facultad:</label>
            <select name="facultad" id="facultad">
                <?php
                // Verificar si se obtuvieron resultados de la consulta
                if ($facultad->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $facultad->fetch_assoc()) {
                        echo '<option value="' . $row["nombre"] . '">' . $row["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay materias disponibles</option>';
                }

                // Cerrar la consulta
                $facultad->close();
                ?>
            </select>

            <label for="materia">Materia:</label>
            <select name="materia" id="materia">
                <?php
                // Verificar si se obtuvieron resultados de la consulta
                if ($materias->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $materias->fetch_assoc()) {
                        echo '<option value="' . $row["nombre"] . '">' . $row["nombre"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay materias disponibles</option>';
                }

                // Cerrar la consulta
                $materias->close();
                ?>
            </select>

            <label for="mes">Mes:</label>
            <select name="mes" id="mes">
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>

            <button type="submit">Generar Lista</button>
        </form>
    </div>
</body>
</html>
