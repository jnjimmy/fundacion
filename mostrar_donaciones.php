<?php
require_once "conexion.php";

echo "<h2>📋 Últimas 10 Donaciones Registradas</h2>";
$donaciones = $pdo->query("SELECT * FROM DONACION ORDER BY fecha_donacion DESC LIMIT 10")->fetchAll();

echo "<table class='table table-bordered'>
    <thead class='thead-dark'>
        <tr>
            <th>ID Donación</th>
            <th>ID Donante</th>
            <th>ID Proyecto</th>
            <th>Monto</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>";

foreach ($donaciones as $d) {
    echo "<tr>
        <td>{$d['id_donacion']}</td>
        <td>{$d['id_donante']}</td>
        <td>{$d['id_proyecto']}</td>
        <td>$" . number_format($d['monto'], 0, ',', '.') . "</td>
        <td>{$d['fecha_donacion']}</td>
    </tr>";
}

echo "</tbody></table>";
?>