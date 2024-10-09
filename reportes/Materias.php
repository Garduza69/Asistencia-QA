<?php
// Incluir el archivo de conexión a la base de datos
require('../conexion2.php');

// Obtener facultades y grupos
$queryFacultades = "SELECT 
                        f.nombre AS nombre_facultad
                    FROM matricula m
                    JOIN grupos g ON m.grupo_id = g.grupo_id
                    JOIN facultades f ON g.facultad_id = f.facultad_id
                    WHERE g.vigenciaSem = 1
                    GROUP BY f.nombre
                    ORDER BY f.nombre;";

$queryGrupos = "SELECT 
                        g.clave_grupo AS nombre_grupo
                    FROM matricula m
                    JOIN grupos g ON m.grupo_id = g.grupo_id
                    WHERE g.vigenciaSem = 1
                    GROUP BY g.clave_grupo
                    ORDER BY g.clave_grupo;";

$facultades = $db->query($queryFacultades);
$grupos = $db->query($queryGrupos);

// Consulta para obtener materias cuando se envíe una solicitud AJAX
$materias = [];
if (isset($_POST['grupo']) && !empty($_POST['grupo'])) {
    $grupoSeleccionado = $_POST['grupo'];
    
    // Consulta para obtener las materias relacionadas con el grupo seleccionado
    $queryMaterias = "SELECT 
                        ma.nombre AS nombre_materia 
                      FROM matricula m 
                      JOIN grupos g ON m.grupo_id = g.grupo_id 
                      JOIN materias ma ON m.materia_id = ma.materia_id 
                      WHERE g.clave_grupo = ? AND g.vigenciaSem = 1 
                      GROUP BY ma.nombre 
                      ORDER BY ma.nombre";

    // Preparar la consulta
    if ($stmt = $db->prepare($queryMaterias)) {
        $stmt->bind_param('s', $grupoSeleccionado);
        $stmt->execute();
        $result = $stmt->get_result();

        // Guardar las materias obtenidas en un array
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row["nombre_materia"];
        }

        $stmt->close();
    }

    // Si es una solicitud AJAX, devolver las materias en formato de opciones
    if (isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
        foreach ($materias as $materia) {
            echo '<option value="' . $materia . '">' . $materia . '</option>';
        }
        exit;
    }
}
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
        <form action="procesar_datos.php" method="post">
            <label for="facultad">Facultad:</label>
            <select name="facultad" id="facultad">
                <?php
                if ($facultades->num_rows > 0) {
                    while ($row = $facultades->fetch_assoc()) {
                        echo '<option value="' . $row["nombre_facultad"] . '">' . $row["nombre_facultad"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay facultades disponibles</option>';
                }
                ?>
            </select>
            
            <label for="grupo">Grupo:</label>
            <select name="grupo" id="grupo" onchange="cargarMaterias()" required>
                <?php
                if ($grupos->num_rows > 0) {
                    while ($row = $grupos->fetch_assoc()) {
                        echo '<option value="' . $row["nombre_grupo"] . '">' . $row["nombre_grupo"] . '</option>';
                    }
                } else {
                    echo '<option value="">No hay grupos disponibles</option>';
                }
                ?>
            </select>

            <label for="materia">Materia:</label>
            <select name="materia" id="materia" disabled required>
                <option value="">Seleccione un grupo</option>
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

    <script>
    function cargarMaterias() {
        var grupoSeleccionado = document.getElementById("grupo").value;
        var materiaSelect = document.getElementById("materia");

        // Deshabilitar el combo de materias mientras se cargan los datos
        materiaSelect.disabled = true;
        materiaSelect.innerHTML = '<option value="">Cargando materias...</option>';

        // Crear una solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true); // La solicitud se hace al mismo archivo PHP
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Definir qué hacer cuando recibimos una respuesta
        xhr.onload = function() {
            if (this.status == 200) {
                // Actualizar el combo de materias con la respuesta del servidor
                materiaSelect.innerHTML = this.responseText;
                // Desbloquear el combo de materias
                materiaSelect.disabled = false;
            } else {
                // Si hay un error, mostrar un mensaje
                materiaSelect.innerHTML = '<option value="">Error al cargar materias</option>';
            }
        };

        // Enviar la solicitud con el grupo seleccionado y un indicador AJAX
        xhr.send("grupo=" + grupoSeleccionado + "&ajax=true");
    }
    </script>
</body>
</html>