<?php
    // Espacio de nombres
    namespace mvc\Modelo;
    use mvc\Modelo\Modelo;

    // Instanciamos la clase M_Main que implementa de Modelo (es interfaz)
    class M_Main implements Modelo {
        public function despacha(): mixed {
            if (isset($_COOKIE['jwt'])) {
                $this->usuarioLogueado();
                session_start();
            } else {
                session_start();
            }

            return true;
        }

        public function usuarioLogueado() {
            setcookie('jwt', '', time()-60, "/");
            session_unset();
            session_destroy();
        }
    }

?>