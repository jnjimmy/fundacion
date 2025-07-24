<?php
require_once "conexion.php"; // conexión con PDO
session_start();

function filtrar($dato)
{
    return htmlspecialchars(trim($dato));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = filtrar($_POST["nombre"] ?? '');
    $email = filtrar($_POST["email"] ?? '');
    $direccion = filtrar($_POST["direccion"] ?? '');
    $telefono = filtrar($_POST["telefono"] ?? '');
    $monto = (int) ($_POST["montoDonacion"] ?? 0);
    $id_proyecto = (int) ($_POST["id_proyecto"] ?? 0);

    if ($nombre && $email && $monto > 0 && $id_proyecto > 0) {
        try {
            // Verificamos si el donante ya existe
            $stmt = $pdo->prepare("SELECT id_donante FROM DONANTE WHERE email = ?");
            $stmt->execute([$email]);
            $donante = $stmt->fetch();

            if ($donante) {
                $id_donante = $donante['id_donante'];
            } else {
                // Insertar nuevo donante
                $stmt = $pdo->prepare("INSERT INTO DONANTE (nombre, email, direccion, telefono) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nombre, $email, $direccion, $telefono]);
                $id_donante = $pdo->lastInsertId();
            }

            // Insertar donación
            $stmt = $pdo->prepare("INSERT INTO DONACION (monto, fecha, id_proyecto, id_donante)
                                   VALUES (?, CURDATE(), ?, ?)");
            $stmt->execute([$monto, $id_proyecto, $id_donante]);

            $mensaje = "Gracias, $nombre. Donaste $" . number_format($monto, 0, ',', '.');
            header("Location: index.php?mensaje=" . urlencode($mensaje));
            exit();
        } catch (PDOException $e) {
            die("Error al insertar la donación: " . $e->getMessage());
        }
    } else {
        header("Location: index.php?mensaje=" . urlencode("Por favor, completa todos los campos correctamente."));
        exit();
    }
}
