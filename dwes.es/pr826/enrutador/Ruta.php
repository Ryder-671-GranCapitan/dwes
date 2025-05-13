<?php

// Espacio de nombres
namespace pr826\enrutador;

// Creación de la clase Ruta
class Ruta {

    // Propiedades de la clase Ruta
    protected string $verbo;
    protected string $path;
    protected string $clase;
    protected string $metodo;

    // Constructor de Ruta
    public function __construct(string $verbo, string $path, string $clase, string $metodo){
        $this->verbo = $verbo;
        $this->path = $path;
        $this->clase = $clase;
        $this->metodo = $metodo;
    }

    // Métodos de la clase Ruta

    // Método que obtiene la clase
    public function getClase() {
        return $this->clase;
    }

    // Método que devuelve el método de la clase
    public function getMetodo(){
        return $this->metodo;
    }

    // Método que devuelve la ruta de la clase
    public function getPath(){
        return $this->path;
    }

    // Método compara si una ruta contiene el mismo verbo y cumple con la expresión regular que contiene la ruta que llama al método
    public function esIgual(string $verbo, string $path_ruta){
        return $this->verbo === $verbo && preg_match($this->path, $path_ruta);
    }
}


?>