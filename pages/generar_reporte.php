<?php
// Verificar si se recibieron las fechas del formulario
if (isset($_POST['fecha_inicio']) && isset($_POST['fecha_fin'])) {
    $fechaInicio = $_POST['fecha_inicio'];
    $fechaFin = $_POST['fecha_fin'];

    // Validar las fechas (puedes agregar validaciones adicionales según tus necesidades)
    if ($fechaInicio && $fechaFin) {
        // Conectar a la base de datos
        $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

        // Verificar la conexión a la base de datos
        if ($conn) {
            // Obtener los datos del informe según las fechas proporcionadas
            $sql = "SELECT * FROM productos WHERE fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
            $result = mysqli_query($conn, $sql);

            // Verificar si se encontraron resultados
            if (mysqli_num_rows($result) > 0) {
                // Generar el informe
                echo "<h2>Informe de productos</h2>";
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Precio</th><th>Fecha</th></tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['idproducto'] . "</td>";
                    echo "<td>" . $row['nombreproducto'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td>" . $row['cantidad'] . "</td>";
                    echo "<td>" . $row['precio'] . "</td>";
                    echo "<td>" . $row['fecha'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No se encontraron resultados para las fechas seleccionadas.";
            }

            // Cerrar la conexión a la base de datos
            mysqli_close($conn);
        } else {
            echo "Error al conectar a la base de datos.";
        }
    } else {
        echo "Las fechas proporcionadas no son válidas.";
    }
} else {
    echo "No se recibieron las fechas del formulario.";
}
?>
