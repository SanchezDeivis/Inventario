<?php
// Verificar si se recibieron los datos del formulario
if (isset($_POST['idproducto']) && isset($_POST['nombreproducto']) && isset($_POST['descripcion']) && isset($_POST['cantidad']) && isset($_POST['precio']) && isset($_FILES['imagen']["tmp_name"]) && isset($_POST['fecha'])) {
  // Obtener los datos del formulario
  $idproducto = $_POST['idproducto'];
  $nombreproducto = $_POST['nombreproducto'];
  $descripcion = $_POST['descripcion'];
  $cantidad = $_POST['cantidad'];
  $precio = $_POST['precio'];
  $fecha = $_POST['fecha'];
  // Obtener información de la imagen 
  $imagen_nombre = $_FILES['imagen']['name'];
  $imagen_temp = $_FILES['imagen']['tmp_name'];
  $imagen_tipo = $_FILES['imagen']['type'];
  if (!empty($imagen_temp)) {
    $imgContent = addslashes(file_get_contents($imagen_temp));
  }else{
    $imgContent = null;
  }
 // Validar y filtrar los datos según tus requisitos

  // Conectar a la base de datos
  $conn = mysqli_connect('localhost', 'root', '', 'DSMInventario');

  // Verificar la conexión a la base de datos
  if ($conn) {
    // Verificar si el 'idproducto' ya existe en la tabla
    $sql_verificar = "SELECT * FROM productos WHERE idproducto = '$idproducto'";
    $resultado_verificar = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
      // Mostrar mensaje de error si el 'idproducto' ya existe
      echo "El código de producto ya existe. Por favor, elija otro código.";
    } else {
      // Preparar la consulta SQL para insertar el producto
      $sql = "INSERT INTO productos (idproducto, nombreproducto, descripcion, cantidad, precio, imagen, fecha) VALUES ('$idproducto', '$nombreproducto', '$descripcion', '$cantidad', '$precio', '$imgContent', '$fecha')";

      // Ejecutar la consulta
      $resultado = mysqli_query($conn, $sql);

      // Verificar si la consulta se ejecutó correctamente
      if ($resultado) {
        // Mover la imagen a la carpeta de imágenes
        move_uploaded_file($imagen_temp, 'images/' . $imagen_nombre);

        // Redirigir al usuario a la página de productos o mostrar un mensaje de éxito
        header('Location: productos.php');
        exit();
      } else {
        // Mostrar mensaje de error si la consulta falló
        echo "Error al guardar el producto en la base de datos.";
      }

    }
    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

  } else {
    // Mostrar mensaje de error si no se pudo conectar a la base de datos
    echo "Error al conectar a la base de datos.";
  }

} else {
  // Mostrar mensaje de error si no se recibieron los datos del formulario
  echo "Error al procesar el formulario.";
}
?>