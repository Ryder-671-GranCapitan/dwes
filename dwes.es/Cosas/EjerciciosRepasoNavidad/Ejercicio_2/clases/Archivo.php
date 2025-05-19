<?php
    namespace ejerciciosrepasonavidad\ejercicio_2\clases\Archivo;

    class Archivo {
        protected $nombre;
        protected $path;
        protected $tipo_mime;
        protected $puntero;

        public function __construct(string $nombre, string $path, string $tipo_mime, int $puntero = 0) {
            $this->nombre = $nombre;
            $this->path = $path;
            $this->tipo_mime = $tipo_mime;
            $this->puntero = $puntero;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setNombre(string $nombre) {
            $this->nombre = $nombre;
        }

        public function getPath() {
            return $this->path;
        }

        public function setPath(string $path) {
            $this->path = $path;
        }

        public function getTipoMime() {
            return $this->tipo_mime;
        }

        public function setTipoMime(string $tipo_mime) {
            $this->tipo_mime = $tipo_mime;
        }

        public function getPuntero() {
            return $this->puntero;
        }

        public function setPuntero(int $puntero) {
            $this->puntero = $puntero;
        }

        public function escribirArchivo(string $ruta, string $mensaje) {
            $archivo = fopen($ruta, 'a');
            fwrite($archivo, $mensaje);
            fclose($archivo);
        }

        public function leerArchivo(string $ruta) : string {
            $numLinea = "";
            $archivo = fopen($ruta, 'r');
            while (($linea = fgets($archivo)) !== false) {
                $numLinea .= $linea . "<br>";
            }
            fclose($archivo);
            return $numLinea;
        }
    }
?>