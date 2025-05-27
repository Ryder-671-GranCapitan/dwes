<?php
    require_once(__DIR__ . "/util/Autocarga.php");

    use rera707\enrutador\Enrutador07;
    use rera707\util\Autocarga;

    Autocarga::autocarga();

    $enrutador = new Enrutador07();
    $enrutador->manejarPeticion();
?>