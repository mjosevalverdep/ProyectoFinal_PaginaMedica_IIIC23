<?php
include("config.php");

// Conexión a la base de datos
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

// Verifica conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Manejo del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitización y validación de datos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $correo = filter_var($_POST['correo-registro'], FILTER_SANITIZE_EMAIL);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario-registro']);
    $contrasena = $_POST['contrasena-registro']; // Aquí la contraseña no es sanada porque se usará password_hash

    // Verifica si la contraseña cumple con ciertos criterios (ejemplo: al menos 8 caracteres)
    if (strlen($contrasena) < 8) {
        echo '<script>alert("La contraseña debe tener al menos 8 caracteres.");</script>';
        echo '<script>window.location.href = "crear_cuenta.html";</script>';
        exit();
    }

    // Hashing de la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, apellido, correo, usuario, contraseña) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellido, $correo, $usuario, $contrasenaHash);

    if ($stmt->execute()) {
        // Registro exitoso
        echo '<script>alert("¡Registro exitoso!");</script>';
        // Redireccionamiento a login.html después de 3 segundos
        echo '<script>setTimeout(function(){ window.location.href = "loginUsuarios.html"; }, 3000);</script>';
    } else {
        // Error en el registro
        $mensaje = "Error en el registro: " . $stmt->error;
    }
    $stmt->close();
}
$conexion->close();
if (!empty($mensaje)) { ?>
    <p>
        <?php echo $mensaje; ?>
    </p>
<?php }
?>