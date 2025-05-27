<?php
namespace recupera526;

require_once($_SERVER['DOCUMENT_ROOT'] . '/recupera526/util/autocarga.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/recupera526/controlador/Controlador26.php');

use recupera526\util\Autocarga;
use recupera526\controlador\Controlador26

Autocarga::registerAutoload();

$controlador = new Controlador26;
$controlador->gresionarPeticion();


?>