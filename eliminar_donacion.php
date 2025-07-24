<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['index'])) {
    $index = (int)$_POST['index'];
    if (isset($_SESSION['carrito_donaciones'][$index])) {
        unset($_SESSION['carrito_donaciones'][$index]);
        $_SESSION['carrito_donaciones'] = array_values($_SESSION['carrito_donaciones']); // Reindexar
        header("Location: index.php?mensaje=" . urlencode("Donación eliminada correctamente.") . "&abrirModal=1");
        exit();
    }
}
header("Location: index.php?mensaje=" . urlencode("Error al eliminar donación."));
exit();
?>
