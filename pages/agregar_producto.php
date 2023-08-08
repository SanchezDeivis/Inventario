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
    <br>
    <div class="container">
        <div class=" formulario">
            <h1>Agregar producto</h1>
            <br>
            <form action="guardar_producto.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="idproducto">Código:</label>
                    <input type="text" id="idproducto" name="idproducto" required>
                </div>
                <div>
                    <label for="nombreproducto">Nombre:</label>
                    <input type="text" id="nombreproducto" name="nombreproducto" required>
                </div>
                <div>
                    <label for="descripcion">Descripción:</label>
                    <input type="text" id="descripcion" name="descripcion">
                </div>
                <br>
                <div>
                    <label for="cantidad">Cantidad inicial disponible:</label>
                    <input type="number" id="cantidad" name="cantidad" required>
                </div>
                <br>
                <div>
                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" required>
                </div>
                <br>
                <div>
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*">
                </div>
                <br>
                <div>
                    <label for="fecha">Fecha Ingreso:</label>
                    <input type="date" id="fecha" name="fecha">
                </div>
                <div>
                    <input type="submit" value="Agregar Producto">
                </div>
            </form>
        </div>
</body>

</html>