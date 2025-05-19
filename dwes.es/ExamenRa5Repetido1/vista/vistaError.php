<?php

namespace ExamenRa5Repetido1\vista;

use Exception;
use ExamenRa5Repetido1\util\Html;


// 4.3 clase para generar la vista del error, tambien generico

class VistaError26
{
    public function muestraError(Exception $exception): void
    {

        Html::inicio('Error', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

        $file = $exception->getFile();
        $componets = explode('/', $file);
        $script = end($componets);
        $modelo = rtrim($script, '.php');

?>
        <h1>error</h1>
        <p>Error Message <?= $exception->getMessage() ?></p>
        <p>Error Message <?= $exception->getCode() ?></p>
        <p>Error Message <?= $exception->getLine() ?></p>
        <p>Error Message <?= $modelo ?></p>
        <p><a href="index.php">volver al inicio</a></p>
<?php
        Html::fin();
    }
}
?>