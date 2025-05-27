<?php
// filepath: c:\Users\Jaime\Desktop\2ºDAWB\DWES\docker-dwes\dwes.es\pr826\index.php
require_once($_SERVER['DOCUMENT_ROOT'] . "/pr826/util/Autocarga.php");

// Registrar el autocargador personalizado
pr826\util\Autocarga::registerAutoload();

// Ahora puedes usar tus clases
use pr826\enrutador\Enrutador;

$enrutador = new Enrutador();
$enrutador->despacha();
?>