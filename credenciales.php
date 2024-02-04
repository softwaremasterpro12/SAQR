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

// Validar nombre
if (!preg_match("/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/", $nombre)) {
  echo "<p>El nombre solo puede contener letras y espacios.</p>";
  exit();
}

// Validar contraseña
if (!preg_match("/^(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*#?&])[A-Za-z0-9@$!%*#?&]{8,}$/", $contrasena)) {
  echo "<p>La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un caracter especial.</p>";
  exit();
}

// Validar cédula
if (!preg_match("/^[0-9]+$/", $cedula)) {
  echo "<p>La cédula solo puede contener números.</p>";
  exit();
}

// Validar correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
  echo "<p>El correo electrónico no es válido.</p>";
  exit();
}

// Verificar si las contraseñas coinciden
if ($contrasena !== $repetir_contrasena) {
  die("Las contraseñas no coinciden");
}

// Encriptar la contraseña
$contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar datos en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellidos, cedula, correo, contrasena) 
  VALUES ('$nombre', '$apellidos', '$cedula', '$correo', '$contrasena_encriptada')";

if ($conn->query($sql) === TRUE) {
  // Mostrar mensaje de éxito con el nombre
  echo '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <h1 style="font-size: 30px; color: green;">Usuario ' . $nombre . ' creado exitosamente. Vuelva a la página de inicio e ingrese con su usuario **' . $nombre . '** (que se ha guardado automáticamente) para acceder al sistema SAQR. ¡Gracias!</h1>
  </div>';
} else {
  echo "Error al crear usuario: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
