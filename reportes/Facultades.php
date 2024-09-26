<?php
// Incluir el archivo de conexión a la base de datos
require('conexion2.php');

// Query para obtener las materias desde la base de datos
$queryFacultades = "SELECT 
                        f.nombre AS nombre_facultad
                    FROM matricula m
                    JOIN grupos g ON m.grupo_id = g.grupo_id
                    JOIN facultades f ON g.facultad_id = f.facultad_id
                    WHERE g.vigenciaSem = 1
                    GROUP BY f.nombre
                    ORDER BY f.nombre;";

$queryGrupos = "SELECT 
						g.clave_grupo AS cve_grupo
					FROM matricula m
					JOIN grupos g ON m.grupo_id = g.grupo_id
					JOIN facultades f ON g.facultad_id = f.facultad_id
					WHERE g.vigenciaSem = 1
					GROUP BY g.clave_grupo
					ORDER BY g.clave_grupo;";
$facultades = $db->query($queryFacultades);
$grupos = $db->query($queryGrupos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Selección</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Formulario de Selección</h1>
        <form action="procesar_facultad.php" method="post">
            <label for="facultad">Facultad:</label>
            <select name="facultad" id="facultad">
                <?php
                // Verificar si se obtuvieron resultados de facultades
                if ($facultades->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $facultades->fetch_assoc()) {
                        echo '<option value="' . $row["nombre_facultad"] . '">' . $row["nombre_facultad"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay facultades disponibles</option>';
                }
                ?>
            </select>

            <label for="grupo">Grupo:</label>
            <select name="grupo" id="grupo">
                <?php
                // Verificar si se obtuvieron resultados de la consulta
                if ($grupos->num_rows > 0) {
                    // Iterar sobre los resultados y generar las opciones del combo box
                    while ($row = $grupos->fetch_assoc()) {
                        echo '<option value="' . $row["cve_grupo"] . '">' . $row["cve_grupo"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay grupos disponibles</option>';
                }

                // Cerrar la consulta
                $grupos->close();
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