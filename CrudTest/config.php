<?php
$host = 'mariadb'; // Nombre del contenedor de Docker
$dbname = 'test_db'; // Nombre de la base de datos
$username = 'usuario'; // Usuario de la base de datos: usuario o root
$password = 'password'; // Contraseña del usuario root

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuración de errores de PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
