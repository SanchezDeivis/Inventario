<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Eliminar producto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div style="margin-top: 40px;">
        <div style="margin-top: 10px; margin-right: 50px; margin-bottom: 50px; margin-left: 50px;" class="formulario">
            <?php
            // Conectar a la base de datos
            $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

            // Verificar la conexión a la base de datos
            if ($conn) {
                // Verificar si se recibió el ID del producto
                if (isset($_GET['id'])) {
                    $id_producto = $_GET['id'];

                    // Verificar si se envió el formulario de confirmación
                    if (isset($_POST['confirmar'])) {
                        $confirmar = $_POST['confirmar'];

                        // Si el usuario confirmó la eliminación
                        if ($confirmar == 'SI') {
                            // Preparar la consulta SQL para eliminar el producto
                            $sql = "DELETE FROM productos WHERE idproducto = '$id_producto'";

                            // Ejecutar la consulta
                            $resultado = mysqli_query($conn, $sql);

                            // Verificar si la consulta se ejecutó correctamente
                            if ($resultado) {
                                echo "El producto ha sido eliminado correctamente.";
                                echo "<button onclick=\"window.location.href='productos.php'\">OK</button>";
                            } else {
                                echo "Error al eliminar el producto.";
                            }
                        } else {
                            header('Location: productos.php'); // Redirigir al usuario a la lista de productos
                            exit();
                        }
                    } else {
                        // Mostrar formulario de confirmación
                        echo "<p>¿Estás seguro de que deseas eliminar este producto?</p>";
                        echo "<form action='' method='POST'>";
                        echo "<input type='hidden' name='id' value='$id_producto'>";
                        echo "<input type='submit' name='confirmar' value='SI'>";
                        echo "<input type='submit' name='confirmar' value='NO'>";
                        echo "</form>";
                    }
                } else {
                    echo "ID de producto no especificado.";
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