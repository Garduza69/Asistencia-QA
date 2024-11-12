<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'u712195824_sistema2';

// Crear conexión
$conexion = new mysqli($host, $username, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Lógica para procesar la migración
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['semestre'])) {
    $semestre_actual = (int)$_POST['semestre'];

    // Mapear semestre a semestre_id
    $semestre_id_map = [
        1 => 5, // Primer semestre
        6 => 4, // Sexto semestre
        7 => 2, // Séptimo semestre
        8 => 1, // Octavo semestre
        9 => 3  // Noveno semestre
    ];

    // Obtener el semestre_id correspondiente
    if (array_key_exists($semestre_actual, $semestre_id_map)) {
        $semestre_id_actual = $semestre_id_map[$semestre_actual];
    } else {
        die("Semestre no válido.");
    }

    // Determinar el semestre siguiente
    $semestre_siguiente = null;
    if (array_key_exists($semestre_actual + 1, $semestre_id_map)) {
        $semestre_siguiente = $semestre_id_map[$semestre_actual + 1];
    }

    // Obtener los grupos del semestre actual
    $grupos = $conexion->query("SELECT grupo_id, clave_grupo FROM grupos WHERE semestre_id = '$semestre_id_actual'");

    if ($grupos && $grupos->num_rows > 0) {
        while ($grupo = $grupos->fetch_assoc()) {
            $grupo_clave = $grupo['clave_grupo'];

            // Buscar el grupo destino en el semestre siguiente
            $grupo_nuevo_clave = $grupo_clave + 1000;
            $grupo_nuevo_result = $conexion->query(
                "SELECT grupo_id FROM grupos WHERE clave_grupo = '$grupo_nuevo_clave' AND semestre_id = '$semestre_siguiente'"
            );

            if ($grupo_nuevo_result && $grupo_nuevo_result->num_rows > 0) {
                $grupo_nuevo = $grupo_nuevo_result->fetch_assoc();
                $grupo_nuevo_id = $grupo_nuevo['grupo_id'];

                $alumnos_migrados = $conexion->query("SELECT alumno_id, nombre FROM alumnos WHERE grupo_id = '$grupo_clave'");

                if ($alumnos_migrados && $alumnos_migrados->num_rows > 0) {
                    $sql_migracion = "UPDATE alumnos SET grupo_id = '$grupo_nuevo_clave' WHERE grupo_id = '$grupo_clave'";
                    
                    if ($conexion->query($sql_migracion)) {
                        echo "Alumnos del grupo {$grupo['clave_grupo']} migrados al grupo $grupo_nuevo_clave.<br>";

                        echo "<h3>Alumnos migrados:</h3><ul>";
                        while ($alumno = $alumnos_migrados->fetch_assoc()) {
                            echo "<li>Alumno ID: {$alumno['alumno_id']} - Nombre: {$alumno['nombre']}</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "Error migrando alumnos del grupo {$grupo['clave_grupo']}: " . $conexion->error . "<br>";
                    }
                } else {
                    echo "<p>No se encontraron alumnos para migrar del grupo {$grupo['clave_grupo']}.</p>";
                }

                echo "<h3>Asignaciones de materias y docentes para el nuevo grupo:</h3>";
                $materias_result = $conexion->query("SELECT id_materia, id_profesor FROM new_sem WHERE id_grupo = '$grupo_nuevo_id'");
                $insertados_count = 0;

                if ($materias_result && $materias_result->num_rows > 0) {
                    $alumnos_migrados->data_seek(0); 

                    while ($alumno = $alumnos_migrados->fetch_assoc()) {
                        $alumno_id = $alumno['alumno_id'];
                        $materias_result->data_seek(0);

                        while ($materia = $materias_result->fetch_assoc()) {
                            $materia_id = $materia['id_materia'];
                            $profesor_id = $materia['id_profesor'];
                            $fecha_actual = date('Y-m-d H:i:s');

                            $sql_matricula = "INSERT INTO matricula (alumno_id, grupo_id, materia_id, fecha_alta, fecha_actualizacion, usuario_alta, usuario_actualizacion, profesor_id) 
                                              VALUES ('$alumno_id', '$grupo_nuevo_id', '$materia_id', '$fecha_actual', '$fecha_actual', 'system', 'system', '$profesor_id')";

                            if ($conexion->query($sql_matricula)) {
                                $insertados_count++;
                            } else {
                                echo "Error al insertar en matrícula para alumno ID $alumno_id: " . $conexion->error . "<br>";
                            }
                        }
                    }

                    if ($insertados_count > 0) {
                        echo "<p>Se insertaron $insertados_count registros en la tabla matrícula.</p>";
                    } else {
                        echo "<p>No se insertó ningún registro en la tabla matrícula.</p>";
                    }
                } else {
                    echo "<p>No se encontraron materias asociadas al grupo nuevo {$grupo_nuevo_id}.</p>";
                }
            } else {
                echo "No se encontró un grupo equivalente en el semestre siguiente para la clave $grupo_nuevo_clave.<br>";
            }
        }
        echo "Migración completada.";
    } else {
        echo "No se encontraron grupos en el semestre actual.";
    }
} else {
    echo '<form method="POST" style="margin: 20px;">';
    echo '<label for="semestre">Selecciona el ciclo académico:</label>';
    echo '<select name="semestre" style="margin: 10px; padding: 5px;">';
    echo '<option value="">--Selecciona--</option>';
    echo '<option value="8">Octavo semestre</option>';
    echo '<option value="9">Noveno semestre</option>';
    echo '<option value="7">Séptimo semestre</option>';
    echo '<option value="6">Sexto semestre</option>';
    echo '<option value="1">Primer semestre</option>';
    echo '</select>';
    echo '<input type="submit" value="Migrar" style="padding: 10px 15px; background-color: rgb(0, 47, 92); color: white; border: none; cursor: pointer;">';
    echo '</form>';
}

$conexion->close();
?>

<!-- CSS -->
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    text-align: center;
}

header {
    background-color: rgb(0, 47, 92);
    color: white;
    padding: 20px;
}

h1 {
    margin: 0;
    font-size: 2.5em;
}

.menu-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: 50px 0;
}

.menu-item {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 20px;
    width: 150px;
    text-align: center;
    transition: transform 0.3s ease;
}

.menu-item:hover {
    transform: scale(1.1);
}

.menu-item img {
    width: 80px;
    height: 80px;
    margin-bottom: 15px;
}

.menu-item span {
    display: block;
    font-size: 1.2em;
    color: rgb(0, 47, 92);
    font-weight: bold;
}

.menu-item a {
    text-decoration: none;
    color: inherit;
}
</style>
