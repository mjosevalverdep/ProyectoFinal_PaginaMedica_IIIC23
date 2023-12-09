<?php
$servername = "localhost";
$username = "Proyecto";
$password = "Proyecto";
$dbname = "usuarios";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];

    // Consulta para verificar si el correo existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: cambiar_contrasena.php?correo=" . urlencode($correo));
        exit();
    } else {
        // El correo no existe en la base de datos
        echo '<script>alert("Correo no existente");</script>';
        echo '<script>window.location.href = "olvido_contrasena.html";</script>';
        exit();
    }
}

$conn->close();
?>
