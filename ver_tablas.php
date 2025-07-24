<?php
include("conexion.php");

// Mostrar proyectos
echo "<h2>📦 Proyectos Registrados</h2>";
$proyectos = $pdo->query("SELECT * FROM PROYECTO")->fetchAll();
foreach ($proyectos as $p) {
    echo "<p>ID: {$p['id_proyecto']} | Nombre: {$p['nombre']} | Presupuesto: {$p['presupuesto']}</p>";
}

// Mostrar donantes
echo "<hr><h2>🧍 Donantes Registrados</h2>";
$donantes = $pdo->query("SELECT * FROM DONANTE")->fetchAll();
foreach ($donantes as $d) {
    echo "<p>ID: {$d['id_donante']} | Nombre: {$d['nombre']} | Correo: {$d['email']}</p>";
}
?>

<hr>
<h2 class="text-primary mt-5">💰 Donaciones Registradas</h2>
<table class="table table-bordered table-striped">
    <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Donante</th>
            <th>Proyecto</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $donaciones = $pdo->query("
            SELECT d.id_donacion, do.nombre AS donante, p.nombre AS proyecto, d.monto, d.fecha
            FROM DONACION d
            JOIN DONANTE do ON d.id_donante = do.id_donante
            JOIN PROYECTO p ON d.id_proyecto = p.id_proyecto
            ORDER BY d.id_donacion DESC
        ")->fetchAll();

        foreach ($donaciones as $don) {
            echo "<tr>
                <td>{$don['id_donacion']}</td>
                <td>{$don['donante']}</td>
                <td>{$don['proyecto']}</td>
                <td>$" . number_format($don['monto'], 0, ',', '.') . "</td>
                <td>" . date("d/m/Y", strtotime($don['fecha'])) . "</td>
              </tr>";
        }
        ?>
    </tbody>
</table>