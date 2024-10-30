<?php
include 'config.php'; // Asegúrate de que la ruta sea correcta

try {
    // Hashear las contraseñas
    $adminPassword = password_hash('ContraseñaSegura1!', PASSWORD_DEFAULT);
    $normalPassword = password_hash('ContraseñaSegura2!', PASSWORD_DEFAULT);
    
    // Agregar usuarios a la base de datos
    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role_id) VALUES (?, ?, ?, ?)");
    
    // Usuario administrador
    $stmt->execute(['adminUser', $adminPassword, 'admin@example.com', 1]);

    // Usuario normal
    $stmt->execute(['normalUser', $normalPassword, 'user@example.com', 2]);
    
    echo "Usuarios creados con éxito.";
} catch (PDOException $e) {
    echo "Error al crear usuarios: " . $e->getMessage();
}
?>
