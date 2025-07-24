<?php
require_once "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resumen de Donaciones por Proyecto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-primary">📊 Proyectos con más de 2 Donaciones</h2>

        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Proyecto</th>
                    <th>Cantidad de Donaciones</th>
                    <th>Total Recaudado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
          SELECT 
              p.nombre AS proyecto,
              COUNT(d.id_donacion) AS cantidad_donaciones,
              SUM(d.monto) AS total_recaudado
          FROM 
              DONACION d
          JOIN 
              PROYECTO p ON d.id_proyecto = p.id_proyecto
          GROUP BY 
              d.id_proyecto
          HAVING 
              COUNT(d.id_donacion) > 2
          ORDER BY 
              total_recaudado DESC
        ";

                $resultado = $pdo->query($sql)->fetchAll();

                foreach ($resultado as $fila) {
                    echo "<tr>
                  <td>{$fila['proyecto']}</td>
                  <td>{$fila['cantidad_donaciones']}</td>
                  <td>$" . number_format($fila['total_recaudado'], 0, ',', '.') . "</td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>