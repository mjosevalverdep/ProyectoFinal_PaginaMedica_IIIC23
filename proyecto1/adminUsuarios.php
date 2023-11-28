<?php
include("config.php");


$conn = new mysqli($servidor, $usuario, $contrasena, $base_de_datos, $puerto);

if ($conn->connect_error) {
    die("Error de conexion");
}

function eliminarFila($id_fila)
{
    global $conn; // Variable global para acceder a la conexión a la base de datos

    // Realiza la consulta de eliminación
    $sql = "DELETE FROM usuarios WHERE id = $id_fila";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado exitosamente";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}
if (isset($_POST['borrar_btn'])) {
    eliminarFila($_POST['fila_id']);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Usuarios </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="adminUsuarios.css">

</head>

<body>
    <header>
        <h1>Citas Médicas</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="ReservaCitas.html">Citas Disponibles</a></li>
            <li><a href="loginUsuarios.html">Mi Cuenta</a></li>
            <li><a href="contactenos.html">Contacto</a></li>
        </ul>
    </nav>
    <div id="contenido">
        <div class="admin-usuarios">
            <h1>Administración de usuarios</h1>
            <div>
                <button onclick="location.href='adminCrearUsuario.php'">Agregar usuario </button>
            </div>
        </div>
        <table class="admin-table">
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Usuario</th>
                <th>Editar</th>
                <th>Borrar</th>
            </tr>

            <?php
            $sql = "SELECT * FROM usuarios";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>

                        <td><?php echo $row["nombre"] ?></td>
                        <td><?php echo $row["apellido"] ?></td>
                        <td><?php echo $row["correo"] ?></td>
                        <td><?php echo $row["usuario"] ?></td>
                        <td>
                            <button onclick="location.href='adminEditarUsuario.php?fila_id=<?php echo $row["id"] ?>'">Editar</button>
                        </td>
                        <td class="block">
                            <form method="post" action="adminUsuarios.php">
                                <input type="hidden" name="fila_id" required value="<?php echo $row["id"] ?>" />
                                <button type="submit" name="borrar_btn">Eliminar</button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
</body>


</html>