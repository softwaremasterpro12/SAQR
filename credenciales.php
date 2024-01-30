<?php
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
$nombre = $_POST["nombre"];
$apellidos = $_POST["apellidos"];
$cedula = $_POST["cedula"];
$correo = $_POST["correo"];
$contrasena = $_POST["contrasena"];
$repetir_contrasena = $_POST["repetir_contrasena"];

// Verificar si las contraseñas coinciden
if ($contrasena !== $repetir_contrasena) {
    die("Las contraseñas no coinciden");
}

// Encriptar la contraseña (puedes usar funciones más seguras)
$contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellidos, cedula, correo, contrasena) 
        VALUES ('$nombre', '$apellidos', '$cedula', '$correo', '$contrasena_encriptada')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario creado exitosamente";
    // Redirigir al usuario a la página después del inicio de sesión
    header("Location: pagina.html");
    exit(); // Importante: asegúrate de salir del script después de la redirección
} else {
    echo "Error al crear usuario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
