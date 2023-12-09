<?php
$servername = "localhost";
$username = "Proyecto";
$password = "Proyecto";
$dbname = "usuarios";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"] ?? '';
    $correo = $_POST["correo"];
    $nueva_contrasena = $_POST["nueva_contrasena"];

    // Hash de la nueva contraseña
    $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

    // Actualiza la contraseña en la base de datos usando una consulta preparada
    $sql = "UPDATE usuarios SET contraseña = ? WHERE correo = ?";

    // Prepara la consulta
    $stmt = $conn->prepare($sql);

    // Vincula los parámetros y ejecuta la consulta
    $stmt->bind_param("ss", $hashed_password, $correo);

    if ($stmt->execute()) {
        // Contraseña actualizada con éxito
        echo '<script>alert("Contraseña actualizada correctamente");</script>';
        echo '<script>window.location.href = "loginUsuarios.html";</script>';
        exit();
    } else {
        // Error al actualizar la contraseña
        echo "Error al actualizar la contraseña: " . $conn->error;
    }
}
$conn->close();
?>
