<?php
include 'config.php';

// Crear Registro
if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    // Preparar la sentencia
    $stmt = $conn->prepare("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':age', $age);

    // Ejecutar la consulta
    $stmt->execute();
}

// Leer Registros
$users = $conn->query("SELECT * FROM users");

// Actualizar Registro
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    // Preparar la sentencia
    $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, age = :age WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':id', $id);

    // Ejecutar la consulta
    $stmt->execute();
}

// Eliminar Registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Preparar la sentencia
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);

    // Ejecutar la consulta
    $stmt->execute();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>CRUD con PHP y MariaDB</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <h2>Añadir Usuario</h2>
    <form action="" method="post">
        <input type="text" name="name" placeholder="Nombre" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="age" placeholder="Edad" required>
        <button type="submit" name="create">Añadir</button>
    </form>
    <h2>Lista de Usuarios</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['age']; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>">Editar</a>
                <a href="?delete=<?php echo $row['id']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])):
        $id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <h2>Editar Usuario</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
        <input type="number" name="age" value="<?php echo $row['age']; ?>" required>
        <button type="submit" name="update">Actualizar</button>
    </form>
    <?php endif; ?>
</body>
</html>
