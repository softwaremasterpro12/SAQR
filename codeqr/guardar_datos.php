<?php
$servername = "sql204.infinityfree.com";
$username = "if0_36093313";
$password = "6n0H5khH0GubEF";
$dbname = "if0_36093313_proyecto";

// Crear una conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir los datos del formulario en formato JSON
$data = json_decode(file_get_contents('php://input'), true);

$item = $data['item'];
$insumo = $data['insumo'];
$cantidad = $data['cantidad'];
$valorUnidad = $data['valorUnidad'];
$valorTotal = $data['valorTotal'];
$codigoQR = $data['codigoQR'];

// Paso 1: Verificar si el item o insumo ya existen en la base de datos
$verificar_existencia = "SELECT * FROM formulario WHERE item = '$item' OR insumo = '$insumo'";
$resultado = $conn->query($verificar_existencia);

if ($resultado->num_rows > 0) {
    // Si se encuentra un registro con el mismo item o insumo, mostrar mensaje de error y detener la ejecución
    echo "Error: El item o insumo ya existe en la base de datos.";
} else {
    // Continuar con la inserción de datos si no hay registros duplicados

    // Preparar la consulta SQL para insertar los datos en la tabla
    $sql = "INSERT INTO formulario (item, insumo, cantidad, valor_unidad, valor_total, codigo_QR) VALUES ('$item', '$insumo', $cantidad, $valorUnidad, $valorTotal, '$codigoQR')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conn->query($sql) === TRUE) {
        echo "Datos guardados exitosamente";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>


