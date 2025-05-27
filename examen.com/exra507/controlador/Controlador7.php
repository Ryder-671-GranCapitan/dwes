<?php
    // Jaime Grueso Martin

    // Espacio de Nombres
    namespace exra507\controlador\Controlador;

    class Controlador {
        public string $peticion;

        public function __construct($peticion) {
            $peticion = [
                'buscarPedido' => [
                    'modelo' => 'ModeloPedido07',
                    'vista' => 'VistaPedido07'
                ]
            ];
            return $peticion;
        }

        public function gestionarPeticion() {
            
        }

        
    }
?>