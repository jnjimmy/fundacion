<?php
require_once "conexion.php";

// Consulta SQL compleja
$sql = "
    SELECT 
        p.id_proyecto,
        p.nombre AS proyecto,
        COUNT(d.id_donacion) AS total_donaciones,
        SUM(d.monto) AS monto_recaudado
    FROM 
        PROYECTO p
    LEFT JOIN 
        DONACION d ON p.id_proyecto = d.id_proyecto
    GROUP BY 
        p.id_proyecto
    HAVING 
        COUNT(d.id_donacion) > 2
    ORDER BY 
        monto_recaudado DESC
";

$resultado = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Proyectos Disponibles para Donar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-primary">🌟 Proyectos con Más de 2 Donaciones</h2>
        <table class="table table-striped">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Proyecto</th>
                    <th>Donaciones</th>
                    <th>Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultado as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['proyecto']) ?></td>
                    <td><?= $fila['total_donaciones'] ?></td>
                    <td>$<?= number_format($fila['monto_recaudado'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>












