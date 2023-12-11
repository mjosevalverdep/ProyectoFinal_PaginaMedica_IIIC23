<?php
include "config.php";
// Conectar a la base de datos
$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Insertar datos en la base de datos
    $sql = "INSERT INTO Consultas (nombre, email, mensaje) VALUES ('$nombre', '$email', '$mensaje')";

    if ($conn->query($sql) === TRUE) {
        // Mensaje de éxito
        $mensaje_exito = "Consulta enviada correctamente. Pronto nos pondremos en contacto contigo por correo electrónico.";
        // Script de JavaScript para mostrar la alerta de confirmación
        echo '<script>alert("' . $mensaje_exito . '"); window.location.href = "index.html";</script>';
    } else {
        $mensaje_error = "Error al enviar la consulta: " . $conn->error;
        // Script de JavaScript para mostrar la alerta de error
        echo '<script>alert("' . $mensaje_error . '"); window.location.href = "index.html";</script>';
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
