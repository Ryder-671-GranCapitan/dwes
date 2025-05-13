<?php
    require_once(__DIR__ . "/util/Autocarga.php");

    use ExamenRa7Rep\enrutador\Enrutador07;
    use ExamenRa7Rep\util\Autocarga;

    Autocarga::autocarga();

    $enrutador = new Enrutador07();
    $enrutador->manejarPeticion();
?>