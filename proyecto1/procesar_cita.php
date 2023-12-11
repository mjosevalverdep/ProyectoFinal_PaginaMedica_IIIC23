<?php

include "config.php";
// Verificar si se recibieron datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conectar a la base de datos (modifica las credenciales según tu configuración)

    $conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Obtener y validar los datos del formulario
    $nombre_completo = validarCampo($_POST['nombre_completo']);
    $correo_electronico = validarCampo($_POST['correo_electronico']);
    $numero_telefono = validarCampo($_POST['numero_telefono']);
    $especialidad_medica = validarCampo($_POST['especialidad_medica']);
    $fecha_preferida = validarCampo($_POST['fecha_preferida']);
    $hora_preferida = validarCampo($_POST['hora_preferida']);

    // Consulta preparada para prevenir la inyección de SQL
    $sql = $conn->prepare("INSERT INTO citas (nombre_completo, correo_electronico, numero_telefono, especialidad_medica, fecha_preferida, hora_preferida) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $nombre_completo, $correo_electronico, $numero_telefono, $especialidad_medica, $fecha_preferida, $hora_preferida);

    if ($sql->execute()) {
        // Operación exitosa, redirigir y mostrar mensaje emergente
        echo '<script>alert("La cita se ha reservado con éxito"); window.location.href = document.referrer;</script>';
    } else {
        // Log de errores y mensaje genérico al usuario
        error_log('Error al reservar la cita: ' . $sql->error);
        echo '<script>alert("Error al reservar la cita. Por favor, inténtalo de nuevo más tarde."); window.location.href = document.referrer;</script>';
    }

    // Cerrar la conexión y la consulta preparada
    $sql->close();
    $conn->close();
} else {
    // Si no es una solicitud POST
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido']);
}

// Función para validar y limpiar un campo
function validarCampo($campo)
{
   
    return htmlspecialchars(trim($campo));
}
