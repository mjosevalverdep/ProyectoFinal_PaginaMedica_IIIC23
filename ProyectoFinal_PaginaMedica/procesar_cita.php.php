<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos (modifica las credenciales según tu configuración)
    $servidor = "localhost";
    $usuario = "Proyecto"; 
    $contrasena = "Proyecto"; 
    $base_de_datos = "citas"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $correo_electronico = $_POST['correo_electronico'];
    $numero_telefono = $_POST['numero_telefono'];
    $especialidad_medica = $_POST['especialidad_medica'];
    $fecha_preferida = $_POST['fecha_preferida'];
    $hora_preferida = $_POST['hora_preferida'];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO citas_medicas (nombre_completo, correo_electronico, numero_telefono, especialidad_medica, fecha_preferida, hora_preferida) VALUES ('$nombre_completo', '$correo_electronico', '$numero_telefono', '$especialidad_medica', '$fecha_preferida', '$hora_preferida')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'La cita se ha reservado con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al reservar la cita: ' . $conn->error]);
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no es una solicitud POST, redirigir o manejar de acuerdo a tu necesidad
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido']);
}
?>
