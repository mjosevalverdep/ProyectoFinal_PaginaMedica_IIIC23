<?php
include("config.php");
session_start();

if (!isset($_SESSION['usuario']) && !isset($_SESSION['correo'])) {
  header('Location: loginUsuarios.html');
  exit;
}

$correo_session = $_SESSION['correo'];
$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

if ($conn->connect_error) {
  die("Error de conexion");
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
// Filtros
$cardiology = isset($_GET['cardiology']) ? $_GET['cardiology'] : '';
$dermatology = isset($_GET['dermatology']) ? $_GET['dermatology'] : '';
$orthopedics = isset($_GET['orthopedics']) ? $_GET['orthopedics'] : '';
$neurology = isset($_GET['neurology']) ? $_GET['neurology'] : '';
$gastroenterology = isset($_GET['gastroenterology']) ? $_GET['gastroenterology'] : '';

function eliminarFila($id_fila)
{
  global $conn; // Variable global para acceder a la conexión a la base de datos

  // Realiza la consulta de eliminación
  $sql = "DELETE FROM citas WHERE id = $id_fila";

  if ($conn->query($sql) === TRUE) {
    echo "Cita eliminada exitosamente";
  } else {
    echo "Error al eliminar la cita: " . $conn->error;
  }
}
if (isset($_POST['borrar_btn'])) {
  eliminarFila($_POST['fila_id']);
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ClinicaASuAlcance</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand mt-2 mt-lg-0" href="index.html">
        <img src="images/logo.png" height="100" alt="Logo ClinicaASA" loading="lazy" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.html">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="citas.html">Agendar citas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ReservaCitas.php">Ver registro Citas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contactenos.html">Contacto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cerrar_sesion.php">Cerrar sesion</a>
          </li>
        </div>
      </div>
    </div>
  </nav>
  <div>
    <section>
      <!-- CRUD Roy -->
      <div class="container my-5">
        <div class="row">
          <div class="citas-usuarios">
            <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?>. Tus citas</h1>
            <div>
              <button onclick="location.href='citas.html'">Crear Cita </button>
            </div>
          </div>
          <div>
            <form class="row g-3 align-items-center" method="get" action="ReservaCitas.php">
              <div class="col-auto inline d-flex">
                <input value="<?php echo $searchTerm; ?>" type="text" id="search" name="search" class="form-control" aria-describedby="SearchInput" placeholder="Buscar">
                <button type="submit" class="mx-2 btn btn-primary" id="searchBtn">Buscar</button>
              </div>
              <div>
                <input type="checkbox" class="btn-check" id="cardiology" autocomplete="off" name="cardiology" <?php echo $cardiology == 'on' ? 'checked' : ''; ?>>
                <label class=" btn btn-outline-primary" for="cardiology">Cardiología</label>
                <input type="checkbox" class="btn-check" id="dermatology" autocomplete="off" name="dermatology" <?php echo $dermatology == 'on' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-primary" for="dermatology">Dermatologia</label>
                <input type="checkbox" class="btn-check" id="orthopedics" autocomplete="off" name="orthopedics" <?php echo $orthopedics == 'on' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-primary" for="orthopedics">Ortopedia</label>
                <input type="checkbox" class="btn-check" id="neurology" autocomplete="off" name="neurology" <?php echo $neurology == 'on' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-primary" for="neurology">Neurología</label>
                <input type="checkbox" class="btn-check" id="gastroenterology" autocomplete="off" name="gastroenterology" <?php echo $gastroenterology == 'on' ? 'checked' : ''; ?>>
                <label class="btn btn-outline-primary" for="gastroenterology">Gastroenterologia</label>
              </div>
              <script>
                document.addEventListener('DOMContentLoaded', function() {
                  var checkboxes = document.querySelectorAll('input[type="checkbox"]');

                  checkboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {

                      document.getElementById('searchBtn').click();
                    });
                  });
                });
              </script>
            </form>



          </div>

          <table class="admin-table my-5">
            <tr>
              <th>Nombre Completo</th>
              <th>Correo</th>
              <th>Número de Teléfono</th>
              <th>Especialidad</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Editar</th>
              <th>Borrar</th>
            </tr>

            <?php
            if ($searchTerm === '') {
              $sql = "SELECT * FROM citas WHERE correo_electronico = '$correo_session'";
            } else {
              $sql = "SELECT * FROM citas WHERE correo_electronico = '$correo_session'
            AND (nombre_completo LIKE '%" . $searchTerm . "%'
            OR numero_telefono LIKE '%" . $searchTerm . "%'
            OR fecha_preferida LIKE '%" . $searchTerm . "%'
            OR hora_preferida LIKE '%" . $searchTerm . "%')";
            }
            $selectedSpecialties = [];

            if ($cardiology == 'on') {
              $selectedSpecialties[] = "especialidad_medica = 'cardiology'";
            }
            if ($dermatology == 'on') {
              $selectedSpecialties[] = "especialidad_medica = 'dermatology'";
            }
            if ($orthopedics == 'on') {
              $selectedSpecialties[] = "especialidad_medica = 'orthopedics'";
            }
            if ($neurology == 'on') {
              $selectedSpecialties[] = "especialidad_medica = 'neurology'";
            }
            if ($gastroenterology == 'on') {
              $selectedSpecialties[] = "especialidad_medica = 'gastroenterology'";
            }

            // Build the WHERE clause for specialties
            if (!empty($selectedSpecialties)) {
              $sql .=  " AND ";
              $sql .= "(" . implode(" OR ", $selectedSpecialties) . ")";
            }


            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
            ?>
                <tr>

                  <td><?php echo $row["nombre_completo"] ?></td>
                  <td><?php echo $row["correo_electronico"] ?></td>
                  <td><?php echo $row["numero_telefono"] ?></td>
                  <td><?php echo $row["especialidad_medica"] ?></td>
                  <td><?php echo $row["fecha_preferida"] ?></td>
                  <td><?php echo $row["hora_preferida"] ?></td>
                  <td>
                    <button onclick="location.href='EditarCita.php?fila_id=<?php echo $row["id"] ?>'">Editar</button>
                  </td>
                  <td class="block">
                    <form method="post" action="ReservaCitas.php">
                      <input type="hidden" name="fila_id" required value="<?php echo $row["id"] ?>" />
                      <button type="submit" name="borrar_btn">Eliminar</button>
                    </form>
                  </td>
                </tr>
              <?php }
            } else {
              ?>
              <tr>
                <td colspan="8">No se encontraron resultados</td>
              </tr>
            <?php
            } ?>
          </table>
        </div>
      </div>

    </section>
  </div>
  <section id="redes-sociales" class="bg-dark p-4">
    <h2 class="text-center mb-4">Síganos en las Redes Sociales</h2>
    <div class="d-flex justify-content-center">
      <ul class="list-inline">
        <li class="list-inline-item mr-3">
          <a href="https://www.facebook.com/" class="text-dark" target="_blank">
            <img src="images\face.png" alt="Facebook" class="img-fluid">
          </a>
        </li>
        <li class="list-inline-item mr-3">
          <a href="https://twitter.com/" class="text-dark" target="_blank">
            <img src="images\twit.png" alt="Twitter" class="img-fluid">
          </a>
        </li>
        <li class="list-inline-item mr-3">
          <a href="https://www.instagram.com/" class="text-dark" target="_blank">
            <img src="images\insta.png" alt="Instagram" class="img-fluid">
          </a>
        </li>
        <li class="list-inline-item">
          <a href="https://web.whatsapp.com/" class="text-dark" target="_blank">
            <img src="images\whats.png" alt="WhatsApp" class="img-fluid">
          </a>
        </li>
      </ul>
    </div>
    <footer>
      <p>&copy; 2023 Citas Médicas</p>
    </footer>
  </section>
</body>

</html>