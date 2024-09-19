<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito al Agregar Alumno</title>
    <link rel="stylesheet" href="bdd.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: rgb(0, 47, 92);
            color: white;
            text-align: center;
        }
        .success-icon {
            font-size: 50px;
            color: #28a745; /* Color verde para el check */
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }

        h2 {
            color: white;
        }
    </style>
</head>
<body>
<h2>¡Alumno agregado exitosamente!</h2>
    <div class="success-icon">✔️</div>
    <button onclick="location.href='insertar_alumno.php'">Agregar otro alumno</button>
    <button onclick="location.href='interfaz_principal.php'">Menú</button>
</body>
</html>
