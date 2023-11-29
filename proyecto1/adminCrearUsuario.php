<?php
include("config.php");


$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

if ($conn->connect_error) {
  die("Error de conexion");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Sanitización y validación de datos
  $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
  $apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
  $correo = filter_var($_POST['correo-registro'], FILTER_SANITIZE_EMAIL);
  $usuario = mysqli_real_escape_string($conn, $_POST['usuario-registro']);
  $contrasena = $_POST['contrasena-registro']; // Aquí la contraseña no es sanada porque se usará password_hash

  // Verifica si la contraseña cumple con ciertos criterios (ejemplo: al menos 8 caracteres)
  if (strlen($contrasena) < 8) {
    die("La contraseña debe tener al menos 8 caracteres.");
  }

  // Hashing de la contraseña
  $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

  // Insertar usuario en la base de datos
  $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido, correo, usuario, contraseña) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $nombre, $apellido, $correo, $usuario, $contrasenaHash);

  if ($stmt->execute()) {
    // Registro exitoso
    $mensaje = "¡Registro exitoso!";
    // Redireccionamiento a adminUsuarios.php después de 3 segundos
    header("refresh:3;url=adminUsuarios.php");
  } else {
    // Error en el registro
    $mensaje = "Error en el registro: " . $stmt->error;
  }
  $stmt->close();
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Usuarios </title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/adminUsuarios.css">

</head>

<body>
<header>
    <nav>
      <div class="logo">
        <img src="images/logo.png" alt="ClinicaASA">
      </div>
      <ul class="menu">
        <nav>
          <li><a href="index.html">Inicio</a></li>
          <li><a href="citas.html">Agendar Citas</a></li>
          <li><a href="ReservaCitas.html">Ver registro Citas</a></li>
          <li><a href="loginUsuarios.html">Mi Cuenta</a></li>
          <li><a href="contactenos.html">Contacto</a></li>
        </nav>
      </ul>
    </nav>
  </header>
  <div id="contenido">
    <div class="admin-usuarios">
      <h1>Administración de usuarios</h1>
      <div>
        <button onclick="location.href='adminUsuarios.php'">Volver</button>
      </div>
    </div>
    <form method="post" action="adminCrearUsuario.php">
      <div class="form-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>
      <div class="form-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
      </div>
      <div class="form-group">
        <label for="correo-registro">Correo Electrónico:</label>
        <input type="email" id="correo-registro" name="correo-registro" required>
      </div>
      <div class="form-group">
        <label for="usuario-registro">Usuario:</label>
        <input type="text" id="usuario-registro" name="usuario-registro" required>
      </div>
      <div class="form-group">
        <label for="contrasena-registro">Contraseña:</label>
        <input type="password" id="contrasena-registro" name="contrasena-registro" required>
      </div>
      <input type="submit" value="Registrarse">
    </form>
  </div>
</body>

</html>