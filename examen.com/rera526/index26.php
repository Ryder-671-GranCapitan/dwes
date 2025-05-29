<?php
namespace rera526;

require_once($_SERVER['DOCUMENT_ROOT'] . '/rera526/util/Autocarga.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/rera526/controlador/Controlador26.php');

use rera526\util\Autocarga;
use rera526\controlador\Controlador26;

Autocarga::registerAutoload();

$controlador = new Controlador26();
$controlador->gestionarPeticion();


?>