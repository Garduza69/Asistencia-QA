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

        // Si se envía una solicitud AJAX para actualizar las materias según el grupo
        if (isset($_POST['grupo']) && isset($_POST['ajax'])) {
            $grupoSeleccionado = $_POST['grupo'];

            // Consulta para obtener las materias según el grupo seleccionado
            $sql_materias_grupo = "SELECT m.nombre AS nombre
                                   FROM horarios h
                                   JOIN materias m ON m.materia_id = h.materia_id
                                   JOIN grupos g ON g.grupo_id = h.grupo_id
                                   WHERE h.profesor_id = ? AND g.clave_grupo = ? AND g.vigenciaSem = 1
                                   GROUP BY m.nombre";
            $stmt_materias_grupo = $db->prepare($sql_materias_grupo);
            $stmt_materias_grupo->bind_param("is", $profesor_id, $grupoSeleccionado);
            $stmt_materias_grupo->execute();
            $result_materias_grupo = $stmt_materias_grupo->get_result();

            // Devolver las opciones de materias en formato HTML
            $options_materias = '';
            while ($row = $result_materias_grupo->fetch_assoc()) {
                $options_materias .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
            }
            echo $options_materias;
            exit; // Terminar aquí para no continuar con el resto de la página
        }

        // Consultar las materias que imparte el profesor en la tabla horarios
        $options_materias = '';
        $options_grupos = '';
        $sql_materias = "SELECT m.nombre AS nombre, g.clave_grupo AS Grupos 
                FROM horarios h 
                JOIN materias m ON m.materia_id = h.materia_id
                JOIN grupos g ON g.grupo_id = h.grupo_id
                WHERE h.profesor_id = ? AND g.vigenciaSem = 1
                GROUP BY m.nombre, g.clave_grupo;";
        $stmt_materias = $db->prepare($sql_materias);
        $stmt_materias->bind_param("i", $profesor_id);
        $stmt_materias->execute();
        $result_materias = $stmt_materias->get_result();
        
        while ($row = $result_materias->fetch_assoc()) {
            $options_grupos .= '<option value="' . $row['Grupos'] . '">' . $row['Grupos'] . '</option>';
            $options_materias .= '<option value="' . $row['nombre'] . '">' . $row['nombre'] . '</option>';
        }
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores seleccionados
    $selected_materia = isset($_POST['materia']) ? $_POST['materia'] : '';
    $selected_grupo = isset($_POST['grupos']) ? $_POST['grupos'] : '';

    // Consulta para obtener las calificaciones
    $sql_calificaciones = "SELECT 
                          alu.alumno_id,  -- Añadir alumno_id
                              alu.matricula,
                              CONCAT(alu.primer_apellido, ' ', alu.segundo_apellido, ' ', alu.nombre) AS nombre_completo,
                              g.clave_grupo,
							  ma.nombre AS materia_nombre,
                              ma.materia_id,
							  h.profesor_id AS nombre_docente
                          FROM 
                              matricula mat
                          JOIN 
                              alumnos alu ON mat.alumno_id = alu.alumno_id
                          JOIN 
                              grupos g ON mat.grupo_id = g.grupo_id
                          JOIN 
                              materias ma ON mat.materia_id = ma.materia_id
						  JOIN 
                              horarios h ON h.materia_id = ma.materia_id AND h.grupo_id = g.grupo_id
                          WHERE 
                              ma.nombre = ? AND g.clave_grupo = ?
                          GROUP BY 
                              alu.alumno_id,
                              alu.matricula,
                              nombre_completo,
                              g.clave_grupo,
                              ma.materia_id,
							  ma.nombre,
							  h.profesor_id
                          ORDER BY 
                              nombre_completo;";
                                
    $stmt_calificaciones = $db->prepare($sql_calificaciones);
    $stmt_calificaciones->bind_param("ss", $selected_materia, $selected_grupo);
    $stmt_calificaciones->execute();
    $result_calificaciones = $stmt_calificaciones->get_result();

    // Guardar los resultados en un array
    $calificaciones = [];
    while ($row = $result_calificaciones->fetch_assoc()) {
        $calificaciones[] = $row;
		$alumno_ids[] = $row['alumno_id'];
    }

    $stmt_calificaciones->close();
}
$fac = "SELECT nombre FROM facultades";
$facultad = $db->query($fac);

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
            max-width: 1500px;
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

        .section {
            margin-bottom: 20px;
        }

        .section label {
            display: block;
            margin-bottom: 8px;
        }

        .section select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .grades-table th, .grades-table td {
            border: 5px solid #ccc;
            padding: 5px;
            text-align: left;
        }


		.grades-table th:nth-child(1), .grades-table td:nth-child(1) {
    		width: 2%;
		}

		.grades-table th:nth-child(2), .grades-table td:nth-child(2) {
   			 width: 6%; 
		}

		.grades-table th:nth-child(3), .grades-table td:nth-child(3) {
   		 width: 20%; 
		}
	
		.grades-table th:nth-child(4), .grades-table td:nth-child(4),
		.grades-table th:nth-child(5), .grades-table td:nth-child(5),
		.grades-table th:nth-child(6), .grades-table td:nth-child(6) {
  		  width: 5%; /* Ancho para las columnas de parciales */
		}

		.grades-table th {
  		  background-color: #f4f4f4;
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
    <script>
    // Función para cargar materias basadas en el grupo seleccionado
    function cargarMaterias() {
        var grupoSelect = document.getElementById('grupos');
        var materiaSelect = document.getElementById('materia');
        var grupoSeleccionado = grupoSelect.value;
		
		materiaSelect.disabled = true;
        materiaSelect.innerHTML = '<option value="">Cargando materias...</option>';

        // Crear un objeto XMLHttpRequest
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        // Definir qué hacer cuando la solicitud sea exitosa
        xhr.onload = function() {
            if (this.status === 200) {
                // Actualizar las opciones del combo de materias con la respuesta del servidor
                materiaSelect.innerHTML = this.responseText;
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
</head>

<body>
    <div class="container">
        <h1>Nombre del Docente</h1>
        <form action="" method="post">
            <!-- Sección de Facultad -->
            <div class="section">
                <label for="facultad">Facultad:</label>
                <select name="facultad" id="facultad">
                <?php
                if ($facultad->num_rows > 0) {
                    while ($row = $facultad->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row["nombre"]) . '">' . htmlspecialchars($row["nombre"]) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay facultades disponibles</option>';
                }
                $facultad->close();
                ?>
                </select>
            </div>

            <!-- Sección de Grupo -->
            <div class="section">
                <label for="grupos">Grupo:</label>
                <select name="grupos" id="grupos" onchange="cargarMaterias()">
					<option value="">Seleccione un grupo</option>
                <?php echo $options_grupos; ?>
                </select>
            </div>
            
            <!-- Sección de Materia -->
            <div class="section">
                <label for="materia">Materia:</label>
                <select name="materia" id="materia" disabled required>
					<option value="">Seleccione una materia</option>
                <?php echo $options_materias; ?>
                </select>
            </div>
            
            <button type="submit" name="buscar">Buscar</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
            if (count($calificaciones) > 0): ?>
                <form method="post">
                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Matrícula</th>
                                <th>Alumno</th>
                                <th>Parcial 1</th>
                                <th>Parcial 2</th>
                                <th>Parcial 3</th>
                                <th>Promedio</th>
                                <th>Ordinario</th>
                                <th>Ordinario 2</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $valoresCiclo = [];
                            for ($i = 0; $i < count($calificaciones); $i++): 
                                $valoresCiclo[] = [
                                    'indice' => $i + 1,
                                    'matricula' => $calificaciones[$i]['matricula'],
                                    'nombre_completo' => $calificaciones[$i]['nombre_completo'],
                                    'materia_nombre' => $calificaciones[$i]['materia_nombre'],
                                    'alumno_id' => $calificaciones[$i]['alumno_id'],
                                    'materia_id' => $calificaciones[$i]['materia_id'],
                                    'nombre_docente' => $calificaciones[$i]['nombre_docente']
                                ];
                            ?>
                                <tr>
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($calificaciones[$i]['matricula']); ?></td>
                                    <td><?php echo htmlspecialchars($calificaciones[$i]['nombre_completo']); ?></td>
                                    <td><input type="text" name="parcial_1_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" /></td>
                                    <td><input type="text" name="parcial_2_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" /></td>
                                    <td><input type="text" name="parcial_3_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" /></td>
                                    <td><input type="text" name="promedio_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" readonly /></td>
                                    <td><input type="text" name="ordinario_1_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" /></td>
                                    <td><input type="text" name="ordinario_2_<?php echo htmlspecialchars($calificaciones[$i]['alumno_id']); ?>" value="0" /></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <input type="hidden" name="valores_ciclo" value='<?php echo htmlspecialchars(json_encode($valoresCiclo)); ?>'>
                    <button type="submit" name="registrar">Registrar</button>
                </form>
            <?php else: ?>
                <p>No hay datos disponibles para la selección actual.</p>
            <?php endif;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
            $valoresCiclo = json_decode($_POST['valores_ciclo'], true);
            $sql = "INSERT INTO calificaciones 
                    (profesor_id, alumno_id, materia_id, parcial_1, parcial_2, parcial_3, ordinario_1, ordinario_2, promedio, usuario_alta, usuario_actualizacion) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";        
            $stmt = $db->prepare($sql);

            foreach ($valoresCiclo as $valor) {
                $profesor_id = $valor['nombre_docente']; // Ajustar según el ID real del profesor
                $alumno_id = $valor['alumno_id'];
                $materia_id = $valor['materia_id'];
                $parcial_1 = isset($_POST['parcial_1_' . $alumno_id]) ? floatval($_POST['parcial_1_' . $alumno_id]) : 0.00;
                $parcial_2 = isset($_POST['parcial_2_' . $alumno_id]) ? floatval($_POST['parcial_2_' . $alumno_id]) : 0.00;
                $parcial_3 = isset($_POST['parcial_3_' . $alumno_id]) ? floatval($_POST['parcial_3_' . $alumno_id]) : 0.00;
                $ordinario_1 = isset($_POST['ordinario_1_' . $alumno_id]) ? floatval($_POST['ordinario_1_' . $alumno_id]) : 0.00;
                $ordinario_2 = isset($_POST['ordinario_2_' . $alumno_id]) ? floatval($_POST['ordinario_2_' . $alumno_id]) : 0.00;
                $promedio = ($parcial_1 + $parcial_2 + $parcial_3) / 3;
                $usuario_alta = 'admin';
                $usuario_actualizacion = 'admin';

                // Asignación de los valores a los parámetros
                $stmt->bind_param("iiidddddsss", $profesor_id, $alumno_id, $materia_id, $parcial_1, $parcial_2, $parcial_3, $ordinario_1, $ordinario_2, $promedio, $usuario_alta, $usuario_actualizacion);

                // Ejecución de la consulta

            }
			if ($stmt->execute()) {
            echo "Calificacion Guardada Correctamente";
            } else {
             echo "Error al Subir las Calificaciones, Verifique Nuevamente". "<br>";
            }

            // Cerrar la sentencia después de que se haya usado
            $stmt->close();
        }
        ?>
    </div>
</body>
</html>