<?php

namespace rera526\vista;

use Exception;
use rera526\util\Html;

class VistaError26 {
    public function muestraError(Exception $excepcion) : void {
        Html::inicio("Error", [
            '/rera526/estilos/formulario.css',
            '/rera526/estilos/general.css',
            '/rera526/estilos/tablas.css'
        ]);

        $file = $excepcion->getFile();
        $components = explode("/", $file);
        $script = end($components);
        $modelo = rtrim($script, ".php");

        echo "<h1>Error</h1>";
        echo "<p>Error mensaje {$excepcion->getMessage()}</p>";
        echo "<p>Error codigo {$excepcion->getCode()}</p>";
        echo "<p>modelo {$modelo}</p>";
        echo "<p>linea {$excepcion->getLine()}</p>";

        echo "<p><a href='inicio26.php'>Volver al inicio</a></p>";

        Html::fin();
    }
}

?>