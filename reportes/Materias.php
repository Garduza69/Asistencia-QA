<?php
session_start();
require('../conexion2.php');

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$email_usuario = $_SESSION['email'];

// Consultar el idUsuario asociado al correo del usuario actual
$sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = ?";
$stmt_usuario = $db->prepare($sql_usuario);
$stmt_usuario->bind_param("s", $email_usuario);
$stmt_usuario->execute();
$stmt_usuario->store_result();

if ($stmt_usuario->num_rows > 0) {
    $stmt_usuario->bind_result($id_usuario);
    $stmt_usuario->fetch();

    // Consultar el profesor_id asociado al idUsuario en la tabla profesores
    $sql_profesor = "SELECT profesor_id FROM profesores WHERE id_usuario = ?";
    $stmt_profesor = $db->prepare($sql_profesor);
    $stmt_profesor->bind_param("i", $id_usuario);
    $stmt_profesor->execute();
    $stmt_profesor->store_result();
	
    if ($stmt_profesor->num_rows > 0) {
        $stmt_profesor->bind_result($profesor_id);
        $stmt_profesor->fetch();

        // Consulta de facultades
        $queryFacultades = "SELECT f.nombre AS nombre_facultad
                            FROM matricula m
                            JOIN grupos g ON m.grupo_id = g.grupo_id
                            JOIN facultades f ON g.facultad_id = f.facultad_id
                            WHERE g.vigenciaSem = 1
                            GROUP BY f.nombre
                            ORDER BY f.nombre;";

        $facultades = $db->query($queryFacultades);

        // Consulta de grupos
        $queryGrupos = "SELECT g.clave_grupo AS nombre_grupo 
                        FROM horarios h 
                        JOIN materias m ON m.materia_id = h.materia_id
                        JOIN grupos g ON g.grupo_id = h.grupo_id
                        WHERE h.profesor_id = ? AND g.vigenciaSem = 1
                        GROUP BY g.clave_grupo;";

        if ($stmt_grupos = $db->prepare($queryGrupos)) {
            $stmt_grupos->bind_param('i', $profesor_id);
            $stmt_grupos->execute();
            $grupos_result = $stmt_grupos->get_result();
            // Si necesitas procesar $grupos_result, hazlo aquí
            $stmt_grupos->close();
        }

        $materias = [];
        if (isset($_POST['grupo']) && !empty($_POST['grupo'])) {
            $grupoSeleccionado = $_POST['grupo'];

            // Consulta de materias
            $queryMaterias = "SELECT m.nombre AS nombre_materia
                              FROM horarios h 
                              JOIN materias m ON m.materia_id = h.materia_id
                              JOIN grupos g ON g.grupo_id = h.grupo_id
                              WHERE h.profesor_id = ? 
                              AND g.vigenciaSem = 1 
                              AND g.clave_grupo = ?
                              GROUP BY m.nombre
                              ORDER BY m.nombre;";

            if ($stmt_materias = $db->prepare($queryMaterias)) {
                $stmt_materias->bind_param('is', $profesor_id, $grupoSeleccionado);
                $stmt_materias->execute();
                $result = $stmt_materias->get_result();

                while ($row = $result->fetch_assoc()) {
                    $materias[] = $row["nombre_materia"];
                }

                $stmt_materias->close();
            }

            // Respuesta AJAX
   if (isset($_POST['ajax']) && $_POST['ajax'] == 'true') {
        foreach ($materias as $materia) {
            echo '<option value="' . $materia . '">' . $materia . '</option>';
        }
                exit;
            }
        }
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
        <form action="lib/procesadores/procesar_datos.php" method="post">
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
				<option value="">Seleccione un grupo</option>
				
                <?php
                if ($grupos_result->num_rows > 0) {
                    while ($row = $grupos_result->fetch_assoc()) {
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