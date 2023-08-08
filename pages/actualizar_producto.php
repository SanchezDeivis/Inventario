<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Actualizar producto</title>
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
            <?php
            // Conectar a la base de datos
            $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

            // Verificar la conexión a la base de datos
            if ($conn) {
                // Verificar si se recibió el ID del producto
                if (isset($_GET['id'])) {
                    $id_producto = $_GET['id'];

                    // Verificar si se envió el formulario de actualización
                    if (isset($_POST['actualizar'])) {
                        // Obtener los datos del formulario
                        $nombre = $_POST['nombre'];
                        $descripcion = $_POST['descripcion'];
                        $cantidad = $_POST['cantidad'];
                        $_precio = $_POST['precio'];
                        // Obtener la imagen del formulario
                        $imagen_temp = $_FILES['imagen']['tmp_name'];
                        //$imagen = $_FILES['imagen'];
            
                        // Verificar si se seleccionó una nueva imagen
                        //if ($imagen['size'] > 0) {
                        if (!empty($imagen_temp)) {
                            // Obtener el contenido de la imagen                    
                            $imagen = addslashes(file_get_contents($imagen_temp));
                            // $imagen_contenido = file_get_contents($imagen['tmp_name']);
            
                            // Preparar la consulta SQL para actualizar el producto con la nueva imagen
                            $sql = "UPDATE productos SET nombreproducto = ?, descripcion = ?, cantidad = ?, precio = ?, imagen = ? WHERE idproducto = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, 'ssdbsi', $nombre, $descripcion, $cantidad, $_precio, $imagen, $id_producto);
                        } else {
                            // Preparar la consulta SQL para actualizar el producto sin cambiar la imagen
                            $sql = "UPDATE productos SET nombreproducto = ?, descripcion = ?, cantidad = ?, precio = ? WHERE idproducto = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, 'ssdsi', $nombre, $descripcion, $cantidad, $_precio, $id_producto);
                        }

                        // Ejecutar la consulta
                        $resultado = mysqli_stmt_execute($stmt);

                        // Verificar si la consulta se ejecutó correctamente
                        if ($resultado) {
                            echo "<p>El producto ha sido actualizado correctamente.</p>";
                            echo "<a href='productos.php'>Volver a la lista de productos</a>";
                        } else {
                            echo "Error al actualizar el producto.";
                        }
                    } else {
                        // Obtener los datos actuales del producto
                        $sql = "SELECT * FROM productos WHERE idproducto = ?";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, 'i', $id_producto);
                        mysqli_stmt_execute($stmt);
                        $resultado = mysqli_stmt_get_result($stmt);
                        $producto = mysqli_fetch_assoc($resultado);

                        // Verificar si se encontró el producto
                        if ($producto) {
                            ?>
                            <h1>Actualizar producto</h1>
                            <form method="POST" enctype="multipart/form-data">
                                <label for="nombre">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" value="<?php echo $producto['nombreproducto']; ?>"
                                    required>

                                <label for="descripcion">Descripción:</label>
                                <textarea id="descripcion" name="descripcion"
                                    required><?php echo $producto['descripcion']; ?></textarea>

                                <label for="cantidad">Cantidad inicial disponible:</label>
                                <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['cantidad']; ?>"
                                    required>

                                <label for="precio">Precio:</label>
                                <input type="number" id="precio" name="precio" value="<?php echo $producto['precio']; ?>" required>

                                <label for="imagen">Imagen:</label>
                                <input type="file" id="imagen" name="imagen" accept="image/*">

                                <button type="submit" name="actualizar">Actualizar</button>
                            </form>
                            <a href="productos.php"><button type="submit" name="cancelar" style="background-color: orange;">Cancelar</button> </a>
                            <?php
                        } else {
                            echo "No se encontró el producto.";
                        }

                        // Liberar el resultado
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    echo "No se especificó el ID del producto.";
                }

                // Cerrar la conexión a la base de datos
                mysqli_close($conn);
            } else {
                echo "Error al conectar a la base de datos.";
            }
            ?>
        </div>
    </div>
</body>

</html>