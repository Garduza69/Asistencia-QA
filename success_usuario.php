<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éxito al Agregar Usuario</title>
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
            width: 100px;
            height: auto;
            margin: 20px 0;
        }
        h2 {
            margin: 20px 0;
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
    </style>
</head>
<body>
    <img src="ruta/a/tu/icono.png" alt="Ícono de éxito" class="success-icon">
    <h2>¡Usuario agregado exitosamente!</h2>
    <button onclick="location.href='insertar_usuario.php'">Agregar otro usuario</button>
    <button onclick="location.href='interfaz_principal.php'">Menú</button>
</body>
</html>
