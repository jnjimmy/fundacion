<?php
session_start();
unset($_SESSION['carrito_donaciones']); // Borra solo el carrito
header("Location: index.php?mensaje=" . urlencode("Carrito vaciado correctamente."));
exit();
?>
