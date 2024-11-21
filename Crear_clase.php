<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Clases</title>
    <style>
        /* CSS para un diseño moderno */
        body {
            background-color: white;
            font-family: Arial, sans-serif;
            color: black;
            margin: 0;
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            color: rgb(0, 47, 92);
            border-radius: 10px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: rgb(0, 47, 92);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #003366;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        select, input[type="date"] {
            background-color: #f9f9f9;
            color: rgb(0, 47, 92);
        }
    </style>
</head>
<body>
    <?php
    // Cambia 'nombre_base_datos' por el nombre real de tu base de datos.
    $host = 'localhost'; // Cambia si es necesario
    $username = 'root'; // Cambia si es necesario
    $password = ''; // Cambia si es necesario
    $database = 'u712195824_sistema2'; // Cambia por el nombre de tu base de datos

    // Crear conexión
    $conexion = new mysqli($host, $username, $password, $database);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Si el formulario ha sido enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoger los datos del formulario
        $clave_grupo = $_POST['grupo_id']; // Usamos clave_grupo
        $materia_id = $_POST['materia_id'];
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $dias_clase = $_POST['dias_clase']; // Array de días seleccionados

        // Obtener el grupo_id basado en el clave_grupo
        $grupo_result = $conexion->query("SELECT grupo_id FROM grupos WHERE clave_grupo = '$clave_grupo'");
        
        if ($grupo_result) {
            $grupo_data = $grupo_result->fetch_assoc();
            $grupo_id = $grupo_data['grupo_id']; // Obtener el grupo_id
            
            // Mostrar el grupo ID seleccionado para depuración
            echo "Grupo ID seleccionado: $grupo_id<br>";

            // Obtener los alumnos del grupo usando el grupo_id
            $alumnos = $conexion->query("SELECT alumno_id FROM alumnos WHERE grupo_id = '$clave_grupo'"); // Cambiamos a clave_grupo

            // Mostrar cuántos alumnos se han encontrado
            if ($alumnos) {
                $total_alumnos = $alumnos->num_rows;
                echo "Total de alumnos en el grupo $grupo_id: $total_alumnos<br>";
                
                // Mostrar los IDs de los alumnos encontrados
                if ($total_alumnos > 0) {
                    echo "Alumnos encontrados:<br>";
                    while ($alumno = $alumnos->fetch_assoc()) {
                        echo "Alumno ID: " . $alumno['alumno_id'] . "<br>";
                    }
                }
            } else {
                echo "Error al realizar la consulta: " . $conexion->error . "<br>";
            }

            // Lista para almacenar las fechas a insertar
            $fechas_a_insertar = [];
            
            // Generar fechas para las clases
            $start = new DateTime($fecha_inicio);
            $end = new DateTime($fecha_fin);
            $end = $end->modify('+1 day'); // Se incluye el último día
            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

            // Verificar cada fecha
            foreach ($period as $date) {
                if (in_array($date->format('l'), $dias_clase)) {
                    $fechas_a_insertar[] = $date->format('Y-m-d');
                }
            }

            // Insertar asistencia
            if ($total_alumnos > 0) { // Verificar si hay alumnos
                // Resetear el puntero del resultado de la consulta de alumnos
                $alumnos->data_seek(0); // Resetea el puntero del resultado para volver a recorrerlo
                
                while ($alumno = $alumnos->fetch_assoc()) {
                    $alumno_id = $alumno['alumno_id'];
                    
                    foreach ($fechas_a_insertar as $fecha_alta) {
                        $sql_asistencia = "INSERT INTO asistencia (asistencia, alumno_id, materia_id, usuario_alta, fecha_alta)
                                           VALUES (NULL, '$alumno_id', '$materia_id', 'ADMIN', '$fecha_alta')";
                        if (!$conexion->query($sql_asistencia)) {
                            echo "Error en la inserción de asistencia para Alumno ID: $alumno_id, Fecha: $fecha_alta - " . $conexion->error . "<br>"; // Muestra el error específico
                        } else {
                            echo "Insertado: Alumno ID: $alumno_id, Materia ID: $materia_id, Fecha Alta: $fecha_alta<br>"; // Muestra la inserción
                        }
                    }
                }
            } else {
                echo "No hay alumnos en el grupo seleccionado.";
            }
        } else {
            echo "Error al buscar el grupo: " . $conexion->error . "<br>";
        }

        echo "Proceso completado.";
    } else {
        // Obtener datos para las selecciones del formulario
        $grupos = $conexion->query("SELECT clave_grupo FROM grupos");
        $materias = $conexion->query("SELECT materia_id, nombre FROM materias");
        $dias = ['Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes'];
    ?>

    <form method="POST" action="">
        <label for="grupo_id">Seleccione el grupo:</label>
        <select name="grupo_id" id="grupo_id" required>
            <?php while ($grupo = $grupos->fetch_assoc()) : ?>
                <option value="<?php echo $grupo['clave_grupo']; ?>"><?php echo $grupo['clave_grupo']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="materia_id">Seleccione la materia:</label>
        <select name="materia_id" id="materia_id" required>
            <?php while ($materia = $materias->fetch_assoc()) : ?>
                <option value="<?php echo $materia['materia_id']; ?>"><?php echo $materia['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" name="fecha_inicio" required>

        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" name="fecha_fin" required>

        <label for="dias_clase">Días de clase:</label><br>
        <?php foreach ($dias as $key => $value) : ?>
            <input type="checkbox" name="dias_clase[]" value="<?php echo $key; ?>"> <?php echo $value; ?><br>
        <?php endforeach; ?>

        <input type="submit" value="Crear Clases">
    </form>

    <?php
    }
    ?>
</body>
</html>