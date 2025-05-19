<?php

// 5. controlador
namespace ExamenRa5Repetido1\controlador;

use Exception;
use ExamenRa5Repetido1\vista\VistaError26;



class Controlador26
{
    protected array $peticiones;
    public function __construct()
    {
        $this->peticiones = [
            'buscarPedido' => [
                'modelo' => 'ExamenRa5Repetido1\\modelo\\ModeloPedido26',
                'vista' => 'ExamenRa5Repetido1\\vista\\vistaPedido26'
            ]
        ];
    }

    public function gestionarPeticion(): void
    {
        try {
            $request = isset($_POST['idp']) ? $_POST['idp'] : '';

            $request = filter_var($request, FILTER_SANITIZE_SPECIAL_CHARS);

            // comprobar que el modelo existe
            if (!class_exists($this->peticiones[$request]['modelo'])) {
                throw new Exception("Modelo no encontrado", 5);
            }

            $modelo_class = $this->peticiones[$request]['modelo'];

            // comprobar que la vista existe
            if (!class_exists($this->peticiones[$request]['vista'])) {
                throw new Exception("Vista no encontrada", 6);
            }

            $vista_class = $this->peticiones[$request]['vista'];


            // ejecutar el MVC 
            $instancia_modelo = new $modelo_class();
            $data = $instancia_modelo->procesaPeticion();

            $instancia_vista = new $vista_class();
            $instancia_vista->enviarSalida($data);


        } catch (Exception $e) {
            
            $instancia_error = new VistaError26();
            $instancia_error->muestraError($e);
            
        }
    }
}
