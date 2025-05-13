<?php
    namespace rera707;
    use rera707\enrutador\Enrutador07;
    use rera707\util\Autocarga;

    require_once $_SERVER['DOCUMENT_ROOT'] . '/rera707/util/Autocarga.php';
    
    Autocarga::autoload_reg();

    $enrutador = new Enrutador07();
    $enrutador->manejarPeticion();

?>