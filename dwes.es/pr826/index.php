<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

use pr826\enrutador\Enrutador;

$enrutador = new Enrutador();
$enrutador->despacha();

?>