<?php
    // Espacio de nombres
    namespace mvc\Controlador;

use Exception;

    // Instanciamos la clase Controlador
    class Controlador {
        // Tiene 3 propiedades
        protected string $peticion;
        protected array $peticiones_validas;

        protected string $vista_error = 'mvc\\Vista\\V_Error';

        // Cosntructor de la clase para rellenar el array de peticiones validas
        public function __construct() {
            $this->peticiones_validas = [
                'main' => [
                            'modelo' => 'mvc\\Modelo\\M_Main',
                            'vista' => 'mvc\\Vista\\V_Main'
                ],
                'autenticar' => [
                            'modelo' => 'mvc\\Modelo\\M_Autenticar',
                            'vista' => 'mvc\\Vista\\V_Autenticar'
                ],
                'reseña' => [
                            'modelo' => 'mvc\\Modelo\\M_Reseña',
                            'vista' => 'mvc\\Vista\\V_Reseña'
                ],
                'insertar_reseña' => [
                            'modelo' => 'mvc\\Modelo\\M_Insertar_Reseña',
                            'vista' => 'mvc\\Vista\\V_Insertar_Reseña'
                ]
            ];
        }

        // Metodo gestiona_peticion() enactagado ede controlar las peticiones
        public function gestiona_peticion() {
            try {
                // Controla la peticion recibida
                $peticion = $_GET['idp'] ?? $_POST['idp'] ?? 'main';

                // Validamos la peticion
                $peticion = filter_var($peticion, FILTER_SANITIZE_SPECIAL_CHARS);

                // Comprobar que la peticion este dentro del array
                if (array_key_exists($peticion, $this->peticiones_validas)) {
                    $clase_modelo = $this->peticiones_validas[$peticion]['modelo'];
                    $clase_vista = $this->peticiones_validas[$peticion]['vista'];
                }

                //Comprobamos que las clases existan
                if (!class_exists($clase_modelo)) {
                    throw new Exception("La clase modelo $clase_modelo no ha sido encontrada");
                }

                if (!class_exists($clase_vista)) {
                    throw new Exception("La clase vista $clase_vista no ha sido encontrada");
                }

                $modelo = new $clase_modelo;
                $datos = $modelo->despacha();

                $vista = new $clase_vista;
                $vista->genera_salida($datos);

            } catch(Exception $e) {
                $vista = new $this->vista_error();
                $vista->genera_salida($e);
            }
        }
    }
?>