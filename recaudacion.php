<?php
require_once "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Donaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Resumen de Recaudación por Proyecto</h2>

    <?php
    // Consulta total donado por proyecto
    $sql = "
        SELECT 
            p.nombre AS proyecto,
            SUM(d.monto) AS total_recaudado
        FROM 
            DONACION d
        JOIN 
            PROYECTO p ON d.id_proyecto = p.id_proyecto
        GROUP BY 
            d.id_proyecto
    ";

    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll();

    if (count($resultados) > 0): ?>
        <table>
            <tr>
                <th>Proyecto</th>
                <th>Total Recaudado</th>
            </tr>
            <?php 
            $granTotal = 0;
            foreach ($resultados as $fila): 
                $granTotal += $fila['total_recaudado'];
            ?>
                <tr>
                    <td><?= htmlspecialchars($fila['proyecto']) ?></td>
                    <td>$<?= number_format($fila['total_recaudado'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="total">
                <td>Total General</td>
                <td>$<?= number_format($granTotal, 0, ',', '.') ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No hay donaciones registradas aún.</p>
    <?php endif; ?>

</body>
</html>
