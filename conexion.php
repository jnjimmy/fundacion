<?php
$host = "localhost";      
$db = "ORGANIZACION";
$user = "root";           // 
$pass = "jnjimmy733****";              

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configurar errores como excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opcional: modo de retorno de resultados
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    // echo "Conexión exitosa"; // Descomenta para verificar
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
