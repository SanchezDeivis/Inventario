<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
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
        input[type="email"],
        input[type="date"], 
        textarea,
        select,
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

    <br>
    <div class="container">
        <div class=" formulario">
            <h1>Crear una cuenta</h1>
            <br>
            <form action="guardar_cuenta.php" method="POST">
                <div>
                    <label for="nombre">Nombre del usuario:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Pepito Perez" required>
                </div>
                <div>
                    <label for="correo">Correo electronico:</label>
                    <input type="email" id="correo" name="correo" placeholder="exple@gmail.com" required>
                </div>
                <div>
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" id="usuario" name="usuario" placeholder="PepitoPerez123" required>
                </div>        
                <div>
                    <label for="clave">Contraseña de usuario:</label>
                    <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
                </div>
                <div>
                    <label for="rol">Rol del usuario:</label>
                    <select name="rol" id="rol"></select>
                </div>
                <br>
                <div>
                    <label for="fecha">Fecha Ingreso:</label>
                    <input type="date" id="fecha" name="fecha">
                </div>
                <div>
                    <input type="submit" value="Crear nuevo usuario">
                </div>
            </form>
        </div>
</body>

</html>