<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/fab64a8de4.js" crossorigin="anonymous"></script>
</head>
<body>
    <section id="comentarios">
        <div class="comentarios-header">
            <h2>Comentarios</h2>
                    </div>
        <div class="comentarios-container">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $conn = new mysqli('localhost', 'root', '', 'muñoz_travel');

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                $nombreyapellido = $_POST['nombreyapellido'];
                $usuario = $_POST['usuario'];
                $email = $_POST['email'];
                $nota = $_POST['nota'];
                $fechanota = $_POST['fechanota'];

                $sql = "INSERT INTO comentarios (nombreyapellido, usuario, email, nota, fechanota) VALUES ('$nombreyapellido', '$usuario', '$email', '$nota', '$fechanota')";

                if ($conn->query($sql) === TRUE) {
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $conn->close();
            }
            ?>
            <form action="" method="post" class="comentario-form">
                <div class="form-group">
                    <label for="nombre">Nombre y Apellido:</label>
                    <input type="text" id="nombre" name="nombreyapellido" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="nota">Nota:</label>
                    <textarea id="nota" name="nota" required></textarea>
                </div>
                <div class="form-group">
                    <label for="fechanota">Fecha de la Nota:</label>
                    <input type="date" id="fechanota" name="fechanota" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <button type="submit">Enviar</button>
            </form>
            <div id="lista-comentarios">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'muñoz_travel');

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                $sql = "SELECT nombreyapellido, usuario, email, nota, fechanota FROM comentarios ORDER BY fechanota DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='comentario'>";
                        echo "<i class='fa fa-user'></i>";
                        echo "<div class='comentario-texto'>";
                        echo "<h3>" . htmlspecialchars($row['nombreyapellido']) . " (" . htmlspecialchars($row['usuario']) . ")</h3>";
                        echo "<p>" . htmlspecialchars($row['nota']) . "</p>";
                        echo "<small>" . htmlspecialchars($row['fechanota']) . " - " . htmlspecialchars($row['email']) . "</small>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "No hay comentarios aún.";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </section>
</body>
</html>
