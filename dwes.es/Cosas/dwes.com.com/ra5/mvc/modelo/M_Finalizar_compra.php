<?php
    namespace mvc\modelo;

    use mvc\modelo\Modelo;
    use util\seguridad\JWT;
    use FFI\Exception;
use orm\modelo\ORMDireccion_Envio;

    class M_Finalizar_compra implements Modelo {
        public function despacha(): mixed {
            // Comprobar si hay abierta sesion,
            // si no la hay, se tiene que autenticar



            // Si esta autenticado, obtener de la BBDD
            // sus direcciones de envio y las formas de envio

            if (isset($_COOKIE['jwt'])) {
                $payload = JWT::verificar_token($_COOKIE['jwt']);
                if (!$payload) {
                    throw new Exception("El token no ha pasado la verificación", 4004);
                }

                $direcciones_envio = $this->obtener_direcciones_envio();
                $formas_envio = $this->obtener_formas_envio();
                
            }

        }

        private function obtener_direcciones_envio(): array {
            // Obtener las direcciones de envio del cliente
            // Si no tiene direcciones de envio, lanzar una excepción
            $orm_dir_env = new ORMDireccion_Envio();
            $direcciones_envio = $orm_dir_env->getAll();
        }
    }
?>