<?php
class Evento
{
    private $descripcion;
    private $tipo;
    private $lugar;
    private $fecha;
    private $hora;

    public function __construct($descripcion, $tipo, $lugar, $fecha, $hora)
    {
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->lugar = $lugar;
        $this->fecha = $fecha;
        $this->hora = $hora;
    }

    public function coincideCon($filtro)
    {
        $filtro = strtolower($filtro);
        return strpos(strtolower($this->descripcion), $filtro) !== false ||
            strpos(strtolower($this->tipo), $filtro) !== false ||
            strpos(strtolower($this->lugar), $filtro) !== false;
    }

    public function mostrar()
    {
        echo "<div class='evento'>";
        echo "<h3>" . htmlspecialchars($this->descripcion) . "</h3>";
        echo "<p><strong>Tipo:</strong> " . htmlspecialchars($this->tipo) . "</p>";
        echo "<p><strong>Lugar:</strong> " . htmlspecialchars($this->lugar) . "</p>";
        echo "<p><strong>Fecha:</strong> " . htmlspecialchars($this->fecha) . "</p>";
        echo "<p><strong>Hora:</strong> " . htmlspecialchars($this->hora) . "</p>";
        echo "<hr></div>";
    }
}
