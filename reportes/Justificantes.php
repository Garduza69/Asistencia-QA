<?php
session_start();
// Incluir el archivo de conexión a la base de datos
require('../conexion2.php');

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

        select, input[type="date"], input[type="text"] {
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

        .seleccionar-dia {
            margin-bottom: 20px;
        }

        .seleccionar-dia label {
            display: block;
            margin-bottom: 5px;
        }

        .seleccionar-dia input[type="date"] {
            width: 30%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .escribir-motivo input[type="date"] {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .seleccionar-turnos {
            margin-bottom: 10px;
            margin-top: -104px;
            margin-left: 400px;
        }

        .seleccionar-turnos label {
            display: block;
            margin-bottom: 5px;
        }

        .seleccionar-turnos select {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 1px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulario de Selección</h1>
        <form id="formulario-justificante" action="procesar_justificante.php" method="post">
            <label for="matricula">Matrícula del Alumno:</label>
            <input type="text" name="matricula" id="matricula" required>
            
            <label for="mes">Mes:</label>
            <select name="mes" id="mes">
                <?php
                // Obtener el mes actual
                $mes_actual = date('n');
                $meses = [
                    1 => 'Enero',
                    2 => 'Febrero',
                    3 => 'Marzo',
                    4 => 'Abril',
                    5 => 'Mayo',
                    6 => 'Junio',
                    7 => 'Julio',
                    8 => 'Agosto',
                    9 => 'Septiembre',
                    10 => 'Octubre',
                    11 => 'Noviembre',
                    12 => 'Diciembre'
                ];

                // Generar las opciones del combo de mes
                foreach ($meses as $mes_numero => $mes_nombre) {
                    $selected = ($mes_numero == $mes_actual) ? 'selected' : '';
                    echo "<option value='$mes_numero' $selected>$mes_nombre</option>";
                }
                ?>
            </select>

        <div class="seleccionar-dia">
            <label for="dia">Seleccionar día:</label>
            <div>
                <input type="date" name="dia" id="dia">
            </div>
        </div>
        <div class="seleccionar-dia">
            <label for="dia_seleccionado">Día seleccionado:</label>
            <input type="text" name="dia_seleccionado" id="dia_seleccionado" readonly  required>
        </div>
        <div class="escribir-motivo">
            <label for="motivo_seleccionado">Motivo de la Falta:</label>
            <input type="text" name="motivo_seleccionado" id="motivo_seleccionado" required>
        </div>            
            <button type="button" id="boton-generar-lista">Actualizar y Generar Justificante</button>
        </form>
    </div>

    <script>
    // Obtener el botón de generar lista
    const botonGenerarLista = document.getElementById('boton-generar-lista');

    // Agregar un event listener para el clic en el botón
    botonGenerarLista.addEventListener('click', function() {
        // Mostrar una confirmación al usuario
        const confirmacion = confirm("¿Están correctos los datos seleccionados? ¿Desea continuar?");
    
        // Si el usuario presiona Aceptar, validar campos requeridos y enviar el formulario
        if (confirmacion) {
            // Obtener todos los campos requeridos
            const camposRequeridos = document.querySelectorAll('[required]');

            // Variable para verificar si todos los campos están completos
            let camposCompletos = true;

            // Iterar sobre los campos requeridos para verificar si están completos
            camposRequeridos.forEach(function(campo) {
                if (!campo.value.trim()) { // Comprobar si el campo está vacío
                    alert('Completa este Campo: ' + campo.previousElementSibling.textContent);
                    camposCompletos = false; // Cambiar el estado de camposCompletos
                }
            });

            // Si todos los campos están completos, enviar el formulario
            if (camposCompletos) {
                document.getElementById('formulario-justificante').submit();
            }
        }
    });

    // Obtener el elemento del calendario
    const calendario = document.getElementById('dia');

    // Obtener la fecha actual
    const fechaActual = new Date();

    // Calcular la fecha límite (3 días hábiles atrás)
    const fechaLimite = new Date();
    fechaLimite.setDate(fechaActual.getDate() - 4);

    // Agregar un event listener para detectar cambios en el calendario
    calendario.addEventListener('change', () => {
        // Obtener la fecha seleccionada en el calendario (en formato local)
       const fechaSeleccionadaLocal = new Date(calendario.value);

        // Convertir la fecha seleccionada a formato UTC para evitar diferencias de zona horaria
        const fechaSeleccionadaUTC = new Date(Date.UTC(
            fechaSeleccionadaLocal.getUTCFullYear(),
            fechaSeleccionadaLocal.getUTCMonth(),
            fechaSeleccionadaLocal.getUTCDate()
        ));

        // Verificar si la fecha seleccionada está dentro del rango permitido
        if (fechaSeleccionadaUTC >= fechaLimite && fechaSeleccionadaUTC <= fechaActual) {
            // Extraer el día de la fecha seleccionada
            const diaSeleccionado = fechaSeleccionadaUTC.getUTCDate();

            // Actualizar el valor del campo de texto para mostrar solo el día
            document.getElementById('dia_seleccionado').value = diaSeleccionado;
        } else {
            // Mostrar un mensaje de error si la fecha seleccionada está fuera del rango permitido
            alert('Selecciona una fecha dentro de los 3 días hábiles.');
            // Restablecer el valor del calendario a la fecha actual
        calendario.valueAsDate = fechaActual;
        }
    });
    </script>
</body>
</html>