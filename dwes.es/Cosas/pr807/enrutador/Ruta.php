<?php
    namespace pr807\enrutador;

    class Ruta {
        protected string $verbo;
        protected string $path;
        protected string $clase;
        protected string $metodo;

        // Constructor
        public function __construct(string $verbo, string $path, string $clase, string $metodo) {
            $this->verbo = $verbo;
            $this->path = $path;
            $this->clase = $clase;
            $this->metodo = $metodo;
        }

        public function getClase() {
            return $this->clase;
        }

        public function getMetodo() {
            return $this->metodo;
        }

        public function getPath() {
            return $this->path;
        }

        public function esIgual(string $verbo, string $path_ruta) {
            return $this->verbo === $verbo && preg_match($this->path, $path_ruta);
        }
    }
?>