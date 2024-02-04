<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "clara1220";
$dbname = "CREDENCIALESSAQR";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre_usuario = $_POST["username"];  // Cambiado de 'nombre' a 'nombre_usuario'
$contrasena = $_POST["password"];

// Preparar la consulta SQL
$sql = "SELECT * FROM usuarios WHERE nombre = '$nombre_usuario'";


// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se encontró el usuario
if ($result === FALSE) {
    // Error en la consulta SQL
    echo "Error en la consulta: " . $conn->error;
} elseif ($result->num_rows > 0) {
    // Usuario encontrado, verificar la contraseña
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row["contrasena"])) {
        // Contraseña válida, redirigir a la página después del inicio de sesión
        header("Location: pagina.html");
        exit();
    } else {
        echo "Contraseña incorrecta";
    }
} else {
    echo "Usuario no encontrado. Nombre de usuario: $nombre_usuario";
}

// Cerrar la conexión
$conn->close();
?>

