<?php
require_once "clase_evento.php"; // Incluye tu clase Evento

function filtrar($dato) {
    return htmlspecialchars(trim($dato));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descripcion = filtrar($_POST["descripcion"] ?? '');
    $tipo = filtrar($_POST["tipo"] ?? '');
    $lugar = filtrar($_POST["lugar"] ?? '');
    $fecha = filtrar($_POST["fecha"] ?? '');
    $hora = filtrar($_POST["hora"] ?? '');

    if ($descripcion && $tipo && $lugar && $fecha && $hora) {
        $evento = new Evento($descripcion, $tipo, $lugar, $fecha, $hora);
        echo "<h2>Evento registrado exitosamente:</h2>";
        $evento->mostrar();
    } else {
        echo "<p style='color:red;'>Todos los campos son obligatorios.</p>";
    }
} else {
    echo "<p style='color:red;'>Acceso no válido.</p>";
}
?>
