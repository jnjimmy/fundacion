<?php session_start(); ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>


    </a>
</head>

<body>

    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Fundación Protege</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#proyectos">Proyectos</a></li>
                <li class="nav-item"><a class="nav-link" href="#donacion">Donar</a></li>
                <li class="nav-item"><a class="nav-link" href="#campanas">Campañas</a></li>
                <li class="nav-item"><a class="nav-link" href="form_proyecto.html">Agregar Proyecto</a></li>
                <li class="nav-item"><a class="nav-link" href="form_donante.html">Agregar Donante</a></li>
                <li class="nav-item"><a class="nav-link" href="ver_tablas.php">Ver Registros</a></li>

            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <!-- Carrito como botón para abrir modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCarrito">
                        🛒 Donaciones
                        <span class="badge badge-light"><?= count($_SESSION['carrito_donaciones'] ?? []) ?></span>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <?php if (!empty($_SESSION['carrito_donaciones'])): ?>
                            <?php foreach ($_SESSION['carrito_donaciones'] as $item): ?>
                                <span class="dropdown-item">
                                    <?= $item['campania'] ?>: $<?= number_format($item['monto'], 0, ',', '.') ?>
                                </span>
                            <?php endforeach; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#donacion">Ver más</a>
                        <?php else: ?>
                            <span class="dropdown-item text-muted">Carrito vacío</span>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>


    <div class="contenedor">

        <!-- Imagen tipo banner -->
        <div class="text-center my-4">
            <img src="image/logo_fundacion.jpg" alt="Fundación Comunidad Protege" style="width: 100%; max-height: 300px; object-fit: cover;">
        </div>

        <!-- Buscador de eventos -->
        <div class="buscador">
            <input type="text" id="campoBusqueda" placeholder="Buscar evento">
            <button onclick="filtrarEventos()">Buscar</button>
        </div>

        <!-- Resultados del filtro -->
        <div id="resultadosEventos"></div>

        <!-- Información de proyectos -->
        <section>
            <h2>Proyectos Actuales</h2>
            <div class="imagenes-flex">
                <img src="image/proyecto1.png" alt="Proyecto 1">
                <img src="image/proyecto2.jpg" alt="Proyecto 2">
            </div>
            <div id="zonaProyectos"></div>
        </section>

        <!-- Formulario para registrar nuevo evento -->
        <section>
            <h2>Registrar nuevo evento</h2>
            <form action="registrar_evento.php" method="POST" class="formulario-donacion">
                <label for="descripcion">Descripción del evento:</label>
                <input type="text" id="descripcion" name="descripcion" placeholder="Descripción del evento" required>

                <label for="tipo">Tipo de evento:</label>
                <input type="text" id="tipo" name="tipo" placeholder="Tipo de evento (ej. Taller, Feria)" required>

                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar" placeholder="Lugar del evento" required>

                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required>

                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" required>

                <input type="submit" value="Registrar Evento">
            </form>

        </section>

        <?php require_once "conexion.php"; ?>

        <section>
            <h2>Realizar una Donación</h2>
            <img src="image/donar.jpg" alt="Donar ahora" class="img-centrada">

            <form action="donar.php" method="POST" class="formulario-donacion">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="text" name="direccion" placeholder="Dirección" required>
                <input type="text" name="telefono" placeholder="Teléfono" required>
                <input type="number" name="montoDonacion" placeholder="Monto en pesos" required>

                <select name="id_proyecto" required>
                    <option value="">Selecciona proyecto</option>
                    <option value="1">🐶 Apoyo a animales</option>
                    <option value="2">🍲 Almuerzos solidarios</option>
                </select>

                <input type="submit" value="Donar">
            </form>


            <?php
            if (isset($_GET['mensaje'])) {
                echo "<p style='color:green; text-align:center;'>" . htmlspecialchars($_GET['mensaje']) . "</p>";
            }
            ?>
        </section>


        <section>
            <h2>Recaudación Actual</h2>
            <?php
            require_once "conexion.php";

            $sql = "
        SELECT 
            p.nombre AS proyecto,
            SUM(d.monto) AS total
        FROM 
            DONACION d
        JOIN 
            PROYECTO p ON d.id_proyecto = p.id_proyecto
        WHERE 
            p.id_proyecto IN (1, 2)
        GROUP BY 
            p.id_proyecto
    ";

            $stmt = $pdo->query($sql);
            $donaciones = $stmt->fetchAll();

            $recaudo = [
                'Apoyo a animales' => 0,
                'Almuerzos solidarios' => 0
            ];

            foreach ($donaciones as $fila) {
                $recaudo[$fila['proyecto']] = $fila['total'];
            }
            ?>

            <div style="text-align:center;">
                <p>🐶 <strong>Apoyo a animales:</strong> $<?= number_format($recaudo['Apoyo a animales'], 0, ',', '.') ?></p>
                <p>🍲 <strong>Almuerzos solidarios:</strong> $<?= number_format($recaudo['Almuerzos solidarios'], 0, ',', '.') ?></p>
            </div>
        </section>



        <!-- Notificaciones de campañas -->
        <section>
            <h2>Campañas y Logros</h2>

            <div class="imagenes-flex">
                <img src="image/campana1.jpg" alt="Campaña 1">
                <img src="image/campana2.jpg" alt="Campaña 2">
            </div>
            <ul id="listaAvisos"></ul>
        </section>

        <!-- Script embebido -->
        <script>
            class Proyecto {
                constructor(nombre, detalle) {
                    this.nombre = nombre;
                    this.detalle = detalle;
                }

                mostrar() {
                    const zona = document.getElementById("zonaProyectos");
                    const div = document.createElement("div");
                    div.innerHTML = `<strong>${this.nombre}</strong><p>${this.detalle}</p><hr>`;
                    zona.appendChild(div);
                }
            }

            class Evento {
                constructor(titulo, fecha, lugar) {
                    this.titulo = titulo;
                    this.fecha = fecha;
                    this.lugar = lugar;
                }

                coincide(busqueda) {
                    return this.titulo.toLowerCase().includes(busqueda.toLowerCase());
                }

                mostrar() {
                    const contenedor = document.getElementById("resultadosEventos");
                    const div = document.createElement("div");
                    div.innerHTML = `<strong>${this.titulo}</strong><br>Fecha: ${this.fecha}<br>Lugar: ${this.lugar}<hr>`;
                    contenedor.appendChild(div);
                }
            }

            const eventos = [
                new Evento("Junta Salud 2025", "2025-06-23", "Sede Vecinal"),
                new Evento("Cine Comunitario", "2025-06-06", "Plaza Sur"),
                new Evento("Fiesta del Libro", "2025-06-20", "Biblioteca local")
            ];

            const proyectos = [
                new Proyecto("Huertos Vecinal", "Fomentamos cultivos orgánicos para la comunidad."),
                new Proyecto("Protege Escolar", "Refuerzo para niños en situación vulnerable.")
            ];

            const avisos = [
                "¡Meta alcanzada: $4.500.000 para alimentación!",
                "Iniciamos campaña 'Abrígate 2025'",
                "Nuevo centro cultural en construcción"
            ];

            function mostrarProyectos() {
                proyectos.forEach(p => p.mostrar());
            }

            function mostrarAvisos() {
                const lista = document.getElementById("listaAvisos");
                lista.innerHTML = "";
                avisos.forEach(mensaje => {
                    const li = document.createElement("li");
                    li.textContent = mensaje;
                    lista.appendChild(li);
                });
            }

            function filtrarEventos() {
                const texto = document.getElementById("campoBusqueda").value.toLowerCase();
                const contenedor = document.getElementById("resultadosEventos");
                contenedor.innerHTML = "";

                const resultados = eventos.filter(e => e.coincide(texto));

                if (resultados.length === 0) {
                    contenedor.innerHTML = "<p>No se encontraron coincidencias.</p>";
                    return;
                }

                resultados.forEach(e => e.mostrar());
            }

            function agregarAviso(nuevoMensaje) {
                avisos.push(nuevoMensaje);
                mostrarAvisos();
                mostrarNotificacionInstantanea(nuevoMensaje);
            }

            function mostrarNotificacionInstantanea(mensaje) {
                const notificacion = document.createElement("div");
                notificacion.textContent = mensaje;
                notificacion.style.position = "fixed";
                notificacion.style.bottom = "20px";
                notificacion.style.right = "20px";
                notificacion.style.backgroundColor = "#4caf50";
                notificacion.style.color = "white";
                notificacion.style.padding = "10px";
                notificacion.style.borderRadius = "5px";
                notificacion.style.boxShadow = "0 2px 8px rgba(0,0,0,0.3)";
                notificacion.style.zIndex = 1000;
                document.body.appendChild(notificacion);

                setTimeout(() => {
                    document.body.removeChild(notificacion);
                }, 3000);
            }

            function actualizarProgresoDonacion(montoActual, meta) {
                const progreso = (montoActual / meta) * 100;
                const mensaje = `Progreso de donaciones: $${montoActual.toLocaleString()} (${progreso.toFixed(2)}% de la meta)`;
                agregarAviso(mensaje);

                if (montoActual >= meta) {
                    agregarAviso("¡Felicidades! Hemos alcanzado la meta de donaciones.");
                }
            }

            window.onload = () => {
                mostrarProyectos();
                mostrarAvisos();

                setTimeout(() => agregarAviso("Nueva campaña:'Abrígate 2025"), 5000);
                setTimeout(() => actualizarProgresoDonacion(2500000, 4500000), 8000);
                setTimeout(() => actualizarProgresoDonacion(4500000, 4500000), 12000);
            };
        </script>

    </div>

    <?php
    require_once "clase_evento.php"; // 

    // Función entradas del usuario
    function filtrar($dato)
    {
        return htmlspecialchars(trim($dato));
    }

    // Verificamos si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $descripcion = filtrar($_POST["descripcion"] ?? '');
        $tipo = filtrar($_POST["tipo"] ?? '');
        $lugar = filtrar($_POST["lugar"] ?? '');
        $fecha = filtrar($_POST["fecha"] ?? '');
        $hora = filtrar($_POST["hora"] ?? '');

        // Validamos los campos estén completos
        if ($descripcion && $tipo && $lugar && $fecha && $hora) {
            $evento = new Evento($descripcion, $tipo, $lugar, $fecha, $hora);

            echo "<h2>Evento registrado exitosamente:</h2>";
            $evento->mostrar(); // 
        } else {
            echo "<p style='color:red;'>Todos los campos son obligatorios.</p>";
        }
    } else {
        echo "<p style='color:red;'>Acceso no válido.</p>";
    }
    ?>


    <!-- Modal del Carrito -->
    <div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalCarritoLabel">Carrito de Donaciones</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <?php
                    if (isset($_SESSION['mensaje_modal'])) {
                        echo '<div class="alert alert-success" role="alert">'
                            . htmlspecialchars($_SESSION['mensaje_modal']) .
                            '</div>';
                        unset($_SESSION['mensaje_modal']);
                    }
                    ?>

                    <?php if (!empty($_SESSION['carrito_donaciones'])): ?>
                        <ul class="list-group">
                            <?php foreach ($_SESSION['carrito_donaciones'] as $index => $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= htmlspecialchars($item['campania']) ?></span>
                                    <div>
                                        <span class="badge badge-primary badge-pill mr-2">
                                            $<?= number_format($item['monto'], 0, ',', '.') ?>
                                        </span>
                                        <form action="eliminar_donacion.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" style="padding: 0 6px; font-size: 14px;">❌</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <hr>
                        <strong>Total: $<?= number_format(array_sum(array_column($_SESSION['carrito_donaciones'], 'monto')), 0, ',', '.') ?></strong>
                    <?php else: ?>
                        <p class="text-muted">El carrito está vacío.</p>
                    <?php endif; ?>

                </div>
                <div class="modal-footer">
                    <form action="vaciar_carrito.php" method="POST" style="display:inline-block; margin-right: 10px;">
                        <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
                    </form>
                    <form action="procesar_donacion.php" method="POST" style="display:inline-block;">
                        <button type="submit" class="btn btn-primary">Donar</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Abre el modal automáticamente si está el parámetro abrirModal=1 en la URL
        const params = new URLSearchParams(window.location.search);
        if (params.get("abrirModal") === "1") {
            $('#modalCarrito').modal('show');
        }
    </script>




</body>

</html>