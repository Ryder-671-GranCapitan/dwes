<?php

namespace recupera526\vista;

use Exception;
use recupera526\util\Html;

class Error26
{
    public function muestraError(Exception $exception)
    {
        Html::inicio('Error', ['./estilos/formulario.css', './estilos/general.css', './estilos/tablas.css']);

        $file = $exception->getFile();
        $components = explode('/', $file);
        $script = end($components);
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