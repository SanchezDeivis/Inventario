<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Generar Informe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <style>
        .container {
            margin-top: 40px;
        }

        .formulario {
            margin-top: 10px;
            margin-right: 50px;
            margin-bottom: 50px;
            margin-left: 50px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        textarea,
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #0572d0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0458a0;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 0px;
            color: #0572d0;
        }

        @media (max-width: 768px) {
            .formulario {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
<?php include '../includes/header.php'; ?>

<div style="margin-top: 40px;" class="container">
        <div style="margin-top: 10px; margin-right: 50px; margin-bottom: 50px; margin-left: 50px;" class="formulario">
    <h2>Generar Informe</h2>

    <form method="POST" action="generate_report.php">
        <label for="fecha_inicio">Fecha de inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" required>

        <label for="fecha_fin">Fecha de fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" required>

        <button type="submit">Generar Informe</button>
    </form>

    <script>
        // Obtener la fecha actual
        var fechaActual = new Date().toISOString().slice(0, 10);

        // Asignar la fecha actual a los campos de fecha del formulario
        document.getElementById("fecha_inicio").value = fechaActual;
        document.getElementById("fecha_fin").value = fechaActual;
    </script>
        </div>
</div>
</body>

</html>
