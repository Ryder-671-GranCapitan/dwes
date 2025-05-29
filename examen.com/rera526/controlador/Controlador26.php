<?php

namespace rera526\controlador;

use Exception;
use rera526\vista\VistaError26;

class Controlador26
{
    protected array $peticiones;

    public function __construct()
    {
        $this->peticiones = [
            'listarEnvios' => [
                'modelo' => 'rera526\\modelo\\ModeloEnvio26',
                'vista' => 'rera526\\vista\\VistaEnvio26'
            ]
        ];
    }

    public function gestionarPeticion()
    {
        try {
            $idp = $_POST['idp'] ?? '';
            $idp = filter_var($idp, FILTER_SANITIZE_SPECIAL_CHARS);

            if (!class_exists($this->peticiones[$idp]['modelo'])) {
                throw new Exception("modelo desconocido", 4);
            }

            if (!class_exists($this->peticiones[$idp]['vista'])) {
                throw new Exception("vista desconocida", 4);
            }

            $claseModelo = $this->peticiones[$idp]['modelo'];
            $claseVista = $this->peticiones[$idp]['vista'];

            $instanciaModelo = new $claseModelo();
            $data = $instanciaModelo->procesaPeticion();

            $instanciaVista = new $claseVista;
            $instanciaVista->enviarSalida($data);
        } catch (Exception $e) {
            $error = new VistaError26();
            $error->muestraError($e);
        }
    }
    
}
