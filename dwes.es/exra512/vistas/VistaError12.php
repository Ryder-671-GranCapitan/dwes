<?php
// Yahya Limouni | 12
namespace exra512\vistas;

use Exception;
use exra512\util\Html;

class VistaError12 {
    public function muestraError(Exception $exception): void {
        Html::inicio("Error", ['/exra512/estilos/general.css']);

        $file = $exception->getFile();
        $components = explode("/", $file);
        $script = end($components);
        $model = rtrim($script, ".php");

        echo "<h1>Error</h1>";
        echo "<p>Error message {$exception->getMessage()}</p>";
        echo "<p>Error Code {$exception->getCode()}</p>";
        echo "<p>Model {$model}</p>";
        echo "<p>Line {$exception->getLine()}</p>";

        echo "<p><a href='index.php'>Volver al inicio</a></p>";

        Html::fin();
    }
}

?>