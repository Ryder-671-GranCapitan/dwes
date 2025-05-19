<?php

namespace EjerciciosRepasoNavidad\ejercicio2\classes\Archivo;

class Archivo{
    protected string $nombre;
    protected string $path;
    protected string $tipo_mime;
    protected string $puntero;

    public function __construct(string $nombre, string $path, string $tipo_mime, int $puntero = 0)
    {
        $this->nombre = $nombre;
        $this->path = $path;
        $this->tipo_mime = $tipo_mime;
        $this->puntero = $puntero;
    }

    public function getNombre():string {
        return $this->nombre;
    }

    public function getPath():string {
        return $this->path;
    }

    public function getMime():string {
        return $this->tipo_mime;
    }

    public function getPuntero():int {
        return $this->puntero;
    }

    public function escribirArchivo(string $ruta, string $mensaje){
        $archivo = fopen($ruta, "a");
        fwrite($archivo, $mensaje);
    }

    public function leerLineasArchivo(string $ruta):string {
        $valorLineas = '';
        $archivo = fopen($ruta, "r");
        while (($linea = fgets($archivo)) !== false) {
            $valorLineas .= $linea . "\n";
        }
        fclose($archivo);
        return $valorLineas;
    }
}
?>