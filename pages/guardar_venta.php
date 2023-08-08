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
            session_start();

            // Verificar si se ha enviado el formulario
            if (isset($_POST['guardarVenta'])) {
                // Obtener la lista de compras del formulario
                $listaCompra = unserialize($_POST['listaCompra']);

                // Conectar a la base de datos
                $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

                if ($conn) {
                    // Por ejemplo, puedes recorrer la lista de compras y guardar cada producto en la base de datos
                    // Iniciar una transacción
                    mysqli_begin_transaction($conn);
                    //try {
                    foreach ($listaCompra as $compra) {
                        $idProducto = $compra['idproducto'];
                        $nombreProducto = $compra['nombreproducto'];
                        $cantidadVendida = $compra['cantidad'];
                        $fechaVenta = $compra['fecha'];

                        // Verificar si la cantidad vendida es mayor a cero
                        if ($cantidadVendida > 0) {
                            // Obtener la cantidad disponible actual del producto
                            $sql = "SELECT cantidad FROM productos WHERE idproducto = ?";
                            $stmt = mysqli_prepare($conn, $sql);
                            mysqli_stmt_bind_param($stmt, 'i', $idProducto);
                            mysqli_stmt_execute($stmt);
                            $resultado = mysqli_stmt_get_result($stmt);
                            $producto = mysqli_fetch_assoc($resultado);

                            // Verificar si se encontró el producto
                            if ($producto) {
                                $cantidadDisponible = $producto['cantidad'];

                                // Verificar si hay suficiente cantidad disponible para la venta
                                if ($cantidadDisponible >= $cantidadVendida) {
                                    // Actualizar la cantidad disponible del producto
                                    $nuevaCantidad = $cantidadDisponible - $cantidadVendida;
                                    $sql = "UPDATE productos SET cantidad = ? WHERE idproducto = ?";
                                    $stmt = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($stmt, 'ii', $nuevaCantidad, $idProducto);
                                    mysqli_stmt_execute($stmt);

                                    // Registrar la transacción en el registro de ventas
                                    echo "La cantidad vendida para el producto con ID: $fechaVenta debe ser mayor a cero.<br>";
                                    $sql = "INSERT INTO ventas (idproducto, cantidad, fecha) VALUES (?, ?, ?)";
                                    $stmt = mysqli_prepare($conn, $sql);
                                    mysqli_stmt_bind_param($stmt, 'iii', $idProducto, $cantidadVendida, $fechaVenta);
                                    mysqli_stmt_execute($stmt);
                                    $venta = true;
                                } else {
                                    $venta = false;
                                    echo "No hay suficiente cantidad disponible para el producto con ID: $idProducto<br>";
                                    echo "<button onclick=\"window.location.href='realizar_venta.php'\">OK</button>";
                                }
                            } else {
                                $venta = false;
                                echo "El producto con ID: $idProducto no existe.<br>";
                                echo "<button onclick=\"window.location.href='realizar_venta.php'\">OK</button>";
                            }

                            // Liberar el resultado
                            mysqli_stmt_close($stmt);
                        } else {
                            $venta = false;
                            echo "La cantidad vendida para el producto con ID: $idProducto debe ser mayor a cero.<br>";
                            echo "<button onclick=\"window.location.href='realizar_venta.php'\">OK</button>";
                        }


                        // Confirmar la transacción
                        mysqli_commit($conn);

                    }

                    if ($venta) {
                        echo "Venta realizada correctamente.";
                        echo "<button onclick=\"window.location.href='realizar_venta.php'\">OK</button>";
                    }
                    /* } catch (Exception $e) {
                        // Revertir la transacción en caso de error
                        mysqli_rollback($conn);
                        echo "Error al realizar la venta.";
                    } */

                    // Después de guardar la venta, puedes realizar otras acciones necesarias, como limpiar la lista de compras en la sesión
                    $_SESSION['listaCompra'] = array();
                    // Cerrar la conexión a la base de datos
                    mysqli_close($conn);
                } else {
                    echo "Error al conectar a la base de datos.";
                    echo "<button onclick=\"window.location.href='realizar_venta.php'\">OK</button>";
                }
            }
            ?>

        </div>
    </div>
</body>

</html>