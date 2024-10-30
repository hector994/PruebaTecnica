<?php
session_start();
include 'config.php'; // Incluye la configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Prepara la consulta para evitar inyección SQL
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        // Recupera el usuario
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica la contraseña
        if ($user && password_verify($password, $user['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id']; // Almacena el rol si es necesario

            // Redirigir a la página de inicio o dashboard
            header("Location: crud.html"); // Cambia esto a tu página de inicio
            exit();
        } else {
            echo "Nombre de usuario o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>
