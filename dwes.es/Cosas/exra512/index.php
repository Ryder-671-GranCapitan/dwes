<?php
// Yahya Limouni | 12

namespace exra512;

require_once($_SERVER['DOCUMENT_ROOT'] . "/exra512/util/Autocarga.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/exra512/controlador/Controlador12.php");

use exra512\controlador\Controlador12;
use exra512\util\Autocarga;

Autocarga::registerAutoload();

$controlador = new Controlador12();
$controlador->gestonarPeticion();
?>