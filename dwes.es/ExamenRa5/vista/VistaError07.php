<?php
    namespace ExamenRa5\vista;

    use Exception;
    use ExamenRa5\util\Html;

    class VistaError07 {
        public function muestraError(Exception $excepcion) : void {
            Html::inicio("Pedido", ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

            $file = $excepcion->getFile();
            $components = explode("/", $file);
            $script = end($components);
            $modelo = rtrim($script, ".php");

            echo "<h1>Error</h1>";
            echo "<p>Error message {$excepcion->getMessage()}</p>";
            echo "<p>Error Code {$excepcion->getCode()}</p>";
            echo "<p>Model {$modelo}</p>";
            echo "<p>Line {$excepcion->getLine()}</p>";

            echo "<p><a href='index.php'>Volver al inicio</a></p>";

            Html::fin();
        }
    }
?>