<?php
namespace recupera526\controlador;

use Exception;
use recupera526\vista\Error26;

class Controlador26
{
    protected array $peticiones;

    public function __construct() {
        $this->peticiones = [
            'insertarResena' => [
                'modelo' => 'recupera526\\modelo\\modeloResena26',
                'vista' => 'recupera526\\vista\\insertar26'
            ]
            ];
    }
}


?>