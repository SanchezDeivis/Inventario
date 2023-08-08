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

  <div style="margin-top: 40px;">

    <div style="margin-top: 10px; margin-right: 50px; margin-bottom: 50px; margin-left: 50px; " class=" formulario">

      <h1>Productos</h1>
      <center class="busqueda">
        <form action="productos.php" method="GET">
          <input type="text" name="buscar_id" placeholder="Buscar por Código de producto">
          <button type="submit">Buscar</button>
          <button style=" background-color:  #ffac33; color: white;  " type="submit">Cancelar</button>
        </form>
        <br>
      </center>
      <?php
      // Conectar a la base de datos
      $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');


      // Verificar la conexión a la base de datos
      if ($conn) {
        // Obtener el valor de búsqueda del formulario
        if (isset($_GET['buscar_id'])) {
          $buscar_id = $_GET['buscar_id'];
        } else {
          $buscar_id = "";
        }

        // Preparar la consulta SQL para obtener los productos
        $sql = "SELECT * FROM productos";

        // Agregar la cláusula WHERE si se ingresó un ID de producto en la búsqueda
        if (!empty($buscar_id)) {
          $sql .= " WHERE idproducto = '$buscar_id'";
        }

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
                            <th></th>
                            </tr>";

          // Mostrar los productos en la tabla
          while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . $row['idproducto'] . "</td>";
            echo "<td>" . $row['nombreproducto'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>" . $row['cantidad'] . "</td>";
            echo "<td>" . $row['precio'] . "</td>";
            echo '<td>' . '<img title="Ver Imagen" class="imagen-producto" src = "data:image/png;base64,' . base64_encode($row['imagen']) . '" width = "80px" height = "80px"/>' . '</td>';
            echo "<td>";
            echo "<a href='actualizar_producto.php?id=" . $row['idproducto'] . "'><i class='fas fa-edit' title='Editar'></i></a>";
            echo "&nbsp;"; // Agregar espacio en blanco
            echo "&nbsp;"; // Agregar espacio en blanco
            echo "<a href='eliminar_producto.php?id=" . $row['idproducto'] . "' class='eliminar''><i class='fas fa-trash' title='Eliminar'></i></a>";
            echo "</td>";
            echo "</tr>";
          }

          echo "</table>";
          echo "</div>";
        } else {
          // Mostrar mensaje si no se encontraron productos
          echo "No se encontraron productos.";
        }

        // Liberar el resultado y cerrar la conexión a la base de datos
        mysqli_free_result($resultado);
        mysqli_close($conn);
      } else {
        // Mostrar mensaje de error si no se pudo conectar a la base de datos
        echo "Error al conectar a la base de datos.";
      }
      ?>
    </div>
    <!-- Diálogo para mostrar la imagen del producto -->
    <div id="dialog-overlay">
      <img id="dialog-image" src="" alt="Imagen del producto">
    </div>

    <script src="../js/dialog.js"></script>
</body>

</html>