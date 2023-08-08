<?php




// Cerrar la sesión y destruir los datos de la sesión
session_destroy();

// Redirigir a otra página después de cerrar la sesión
header("Location: ../index.php");
//<li><a href="../index.php">Salir</a></li>
exit;
?>