<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Lista productos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/menu.css">
    <link rel="stylesheet" type="text/css" href="../css/tabla.css">
    <!-- Para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../css/dialog.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>

    <div style="margin-top: 20px;">

        <div style="margin-top: 20px; margin-right: 50px; margin-bottom: 50px; margin-left: 50px; " class="formulario">

            <center class="busqueda">
                <form action="realizar_venta.php" method="GET">
                    <input type="text" name="buscar" placeholder="Buscar por Código o Nombre de producto">
                    <button style="background-color: #ffac33; color: white;" type="submit">Buscar producto</button>
                </form>
            </center>

            <?php
            session_start();
            // Conectar a la base de datos
            $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

            // Verificar la conexión a la base de datos
            if ($conn) {
                // Obtener el valor de búsqueda del formulario
                if (isset($_GET['buscar'])) {
                    $buscar = $_GET['buscar'];
                } else {
                    $buscar = "";
                }

                // Mostrar productos solo si hay un valor de búsqueda
                if (!empty($buscar)) {
                    // Preparar la consulta SQL para obtener los productos
                    $sql = "SELECT * FROM productos WHERE idproducto = '$buscar' OR nombreproducto LIKE '%$buscar%'";

                    // Ejecutar la consulta SQL
                    $resultado = mysqli_query($conn, $sql);

                    // Verificar si se encontraron productos
                    if (mysqli_num_rows($resultado) > 0) {
                        echo "<div class='table-responsive'>";
                        echo "<table class='table'>";
                        echo "<tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Cantidad disponible</th>
                                    <th>Precio</th>
                                    <th>Imagen</th>
                                    <th>Acción</th>
                                    </tr>";

                        // Mostrar los productos en la tabla
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<tr>";
                            echo "<td>" . $row['idproducto'] . "</td>";
                            echo "<td>" . $row['nombreproducto'] . "</td>";
                            echo "<td>" . $row['descripcion'] . "</td>";
                            echo "<td>" . $row['cantidad'] . "</td>";
                            echo "<td>" . $row['precio'] . "</td>";
                            echo '<td>' . '<img title="Ver Imagen" class="imagen-producto" src="data:image/png;base64,' . base64_encode($row['imagen']) . '" width="50px" height="50px"/></td>';
                            echo "<td>";
                            echo "&nbsp;";
                            echo "<form action='realizar_venta.php' method='POST'>
                                    <input type='hidden' name='idproducto' value='" . $row['idproducto'] . "'>
                                    <input type='hidden' name='nombreproducto' value='" . $row['nombreproducto'] . "'>
                                    <input type='number' name='cantidad' min='1' placeholder='Ingrese la cantidad' required>
                                    <input type='hidden' id='fecha' name='fecha' min='1' placeholder='Fecha de venta' required>
                                    <button type='submit' name='agregarProducto' class='agregar' class='add-to-cart' title='Agregar a lista de compras'><i class='fas fa-cart-plus'></i></button>
                                 </form>";
                            echo "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";

                        echo "</div>";
                    } else {
                        // Mostrar mensaje si no se encontraron productos
                        echo "No se encontraron productos.";
                    }

                    // Liberar el resultado
                    mysqli_free_result($resultado);
                } else {
                    // Mostrar mensaje si no se encontró un valor de búsqueda
                    echo "Ingrese un código o nombre de producto.";
                }

                // Cerrar la conexión a la base de datos
                mysqli_close($conn);
            } else {
                // Mostrar mensaje de error si no se pudo conectar a la base de datos
                echo "Error al conectar a la base de datos.";
            }
            ?>
            <hr>
            <!-- lista de compras -->
            <hr>
            <h2>Lista de compras</h2>
            <div class='table-responsive'>
                <table class='table'>

                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Cantidad Vendida</th>
                        <th>Acción</th>
                    </tr>
                    <?php
                    if (isset($_POST['agregarProducto'])) {
                        $idProducto = $_POST['idproducto'];
                        $cantidadVendida = $_POST['cantidad'];
                        $nombreProducto = $_POST['nombreproducto'];
                        $fecha = $_POST['fecha'];

                        if (!empty($nombreProducto)) {
                            // Agregar el producto a la lista de compras en la sesión
                            $_SESSION['listaCompra'][] = array(
                                'idproducto' => $idProducto,
                                'nombreproducto' => $nombreProducto,
                                'cantidad' => $cantidadVendida,
                                'fecha' => $fecha
                            );
                        } else {
                            echo "El producto con ID: $idProducto no existe.<br>";
                        }
                    }
                    if (isset($_POST['eliminarProducto'])) {
                        $idProductoEliminar = $_POST['idproducto'];
                        $listaCompra = $_SESSION['listaCompra'];

                        // Buscar el producto en la lista de compras
                        foreach ($listaCompra as $key => $compra) {
                            if ($compra['idproducto'] == $idProductoEliminar) {
                                // Eliminar el producto de la lista de compras
                                unset($listaCompra[$key]);
                                break;
                            }
                        }

                        // Actualizar la lista de compras en la sesión
                        $_SESSION['listaCompra'] = $listaCompra;
                    }

                    if (isset($_SESSION['listaCompra']) && !empty($_SESSION['listaCompra'])) {

                        foreach ($_SESSION['listaCompra'] as $compra) {
                            echo "<tr>";
                            echo "<td>" . $compra['idproducto'] . "</td>";
                            echo "<td>" . $compra['nombreproducto'] . "</td>";
                            echo "<td>" . $compra['cantidad'] . "</td>";
                            echo "<td>";
                            echo "<form action='' method='POST'>
                                    <input type='hidden' name='idproducto' value='" . $compra['idproducto'] . "'>                                    
                                    <button type='submit' name='eliminarProducto' class='eliminar' title='Eliminar de la lista'><i class='fas fa-trash-alt'></i></button>
                                 </form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td colspan='4' style='text-align: right;'>
                            <form action='guardar_venta.php' method='POST'>
                                <input type='hidden' name='listaCompra' value='" . serialize($_SESSION['listaCompra']) . "'>
                                <button type='submit' name='guardarVenta' style='background-color: #0572d0; color: white;' class='btn-guardar'>Guardar Venta</button>
                            </form>
                          </td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='4'>No hay productos en la lista de compras.</td></tr>";
                    }
                    ?>
                </table>
            </div>

        </div>

        <!-- Diálogo para mostrar la imagen del producto -->
        <div id="dialog-overlay">
            <img id="dialog-image" src="" alt="Imagen del producto">
        </div>

        <script src="../js/dialog.js"></script>
        <script>
        // Obtener la fecha actual
        var fechaActual = new Date().toISOString().slice(0, 10);

        // Asignar la fecha actual a los campos de fecha del formulario
        document.getElementById("fecha").value = fechaActual;
    </script>
    </div>
</body>

</html>