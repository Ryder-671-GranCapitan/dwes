<?php
    // JAIME GRUESO MARTIIN 
    namespace rera507\vista;

    use Exception;
    use rera507\util\Html;

    class VistaError07 {
        public function muestraError(Exception $excepcion) : void {
            Html::inicio("Reseña", ['/rera507/estilos/formulario.css', '/rera507/estilos/general.css', '/rera507/estilos/tablas.css']);

            $file = $excepcion->getFile();
            $components = explode("/", $file);
            $script = end($components);
            $modelo = rtrim($script, ".php");

            echo "<h1>Error</h1>";
            echo "<p>Error message {$excepcion->getMessage()}</p>";
            echo "<p>Error Code {$excepcion->getCode()}</p>";
            echo "<p>Model {$modelo}</p>";
            echo "<p>Line {$excepcion->getLine()}</p>";

            echo "<p><a href='insertar07.php'>Volver al inicio</a></p>";

            Html::fin();
        }
    }
?>