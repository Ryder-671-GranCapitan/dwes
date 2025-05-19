<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

    use pr807\enrutador\Enrutador07;

    $instancia_enrutador = new Enrutador07();
    $instancia_enrutador->despacha();
?>