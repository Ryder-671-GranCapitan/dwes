<?php
    require_once(__DIR__ . "/util/Autocarga.php");

    use ExamenRep2\enrutador\Enrutador07;
    use ExamenRep2\util\Autocarga;

    Autocarga::autocarga();

    $enrutador = new Enrutador07();
    $enrutador->manejarPeticion();
?>