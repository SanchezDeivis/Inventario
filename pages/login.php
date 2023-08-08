<?php
session_start();
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DSMInventario";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar el formulario de inicio de sesión
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales de inicio de sesión
    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Credenciales válidas, inicio de sesión exitoso
        header("Location: inicio.php");
        exit();
        /*  echo "Inicio de sesión exitoso. Bienvenido, " . $username; */
    } else {
        // Credenciales inválidas, inicio de sesión fallido
        echo "Inicio de sesión fallido. Verifica tu nombre de usuario y contraseña.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Iniciar sesión</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
    <div class="container">
        <div>
            <center>
                <h1>DSM Tech Inventario</h1>
                <img src="../images/fondo.png" alt="Imagen 1">
            </center>

        </div>
        <div class=" formulario">

            <h2>Iniciar sesión</h2>
            <br>
            <form method="POST" action="">
                <label for="username">Nombre de usuario:</label>
                <input type="text" name="username" id="username" required><br><br>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" required><br><br>
                <input type="submit" name="submit" value="Iniciar sesión">
            </form>
            <a href="../index.php"><button>Cancelar</button></a>
        </div>
    </div>
</body>

</html>