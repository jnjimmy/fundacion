<?php
session_start();

if (!empty($_SESSION['carrito_donaciones'])) {
    unset($_SESSION['carrito_donaciones']); // Limpia el carrito

    $_SESSION['mensaje_modal'] = "¡Gracias por tu aporte! Tu apoyo es muy valioso para nuestra fundación.";

    header("Location: index.php?abrirModal=1");
    exit();
} else {
    $_SESSION['mensaje_modal'] = "No tienes donaciones en el carrito para procesar.";
    header("Location: index.php?abrirModal=1");
    exit();
}
?>
