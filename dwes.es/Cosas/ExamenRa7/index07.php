<?php
    require_once(__DIR__ . "/util/Autocarga.php");

    use ExamenRa7\enrutador\Enrutador07;
    use ExamenRa7\util\Autocarga;

    Autocarga::autocarga();

    $enrutador = new Enrutador07();
    $enrutador->manejarPeticion();
?>