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

  // Insertar usuario en la base de datos
  $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, correo = ?, usuario = ? WHERE id = ?");
  $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $usuario, $_POST['id']);

  if ($stmt->execute()) {
    // Registro exitoso
    $mensaje = "¡Registro exitoso!";
    // Redireccionamiento a adminUsuarios.php después de 0 segundos
    header("refresh:0;url=adminUsuarios.php");
  } else {
    // Error en el registro
    $mensaje = "Error en el registro: " . $stmt->error;
  }
  $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Editar Usuarios </title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>

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
    <?php
    $sql = "SELECT * FROM usuarios WHERE id = " . $_GET['fila_id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
        <form method="post" action="adminEditarUsuario.php">
          <input type="hidden" id="id" name="id" required value="<?php echo $row['id']; ?>">
          <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required value="<?php echo $row['nombre']; ?>">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required value="<?php echo $row['apellido']; ?>">
          </div>
          <div class="form-group">
            <label for="correo-registro">Correo Electrónico:</label>
            <input type="email" id="correo-registro" name="correo-registro" required value="<?php echo $row['correo']; ?>">
          </div>
          <div class="form-group">
            <label for="usuario-registro">Usuario:</label>
            <input type="text" id="usuario-registro" name="usuario-registro" required value="<?php echo $row['usuario']; ?>">
          </div>
          <input type="submit" value="Editar">
        </form>
    <?php }
    } ?>

  </div>
</body>                                        


</html>