<?php
namespace ejerciciosrepasonavidad\ejercicio_1\clases\ActividadFormacion;
use Exception;

class ActividadFormacion {
    // Atributos de la clase
    private int $codigo;
    private string $titulo;
    private int $horas_presenciales;
    private int $horas_online;
    private int $horas_no_presenciales;
    private string $nivel;
    const NIVEL = ['A', 'B', 'C'];

    // Metodos de la clase

    // Constructor
    function __construct(int $codigo, string $titulo, int $horas_presenciales, int $horas_online, int $horas_no_presenciales, string $nivel) {
        $this->codigo = $codigo;
        $this->titulo = $titulo;
        $this->horas_presenciales = $horas_presenciales;
        $this->horas_online = $horas_online;
        $this->horas_no_presenciales = $horas_no_presenciales;
        $this->nivel = $nivel;
    }
    
    // Gettersç
    public function getCodigo() {
        return $this->codigo;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getHorasPresenciales() {
        return $this->horas_presenciales;
    }

    public function getHorasOnline() {
        return $this->horas_online;
    }

    public function getHorasNoPresenciales() {
        return $this->horas_no_presenciales;
    }

    public function getNivel() {
        return $this->nivel;
    }

    // Setters
    public function setCodigo(int $codigo) {
        $this->codigo = $codigo;
    } 

    public function setTitulo(string $titulo) {
        $this->titulo = $titulo;
    }

    public function setHorasPresenciales(int $horas_presenciales) {
        $this->horas_presenciales = $horas_presenciales;
    }

    public function setHorasOnline(int $horas_online) {
        $this->horas_online = $horas_online;
    }

    public function setHorasNoPresenciales(int $horas_no_presenciales) {
        $this->horas_no_presenciales = $horas_no_presenciales;
    }

    public function setNivelhoras(string $nivel) {
        try {
            if (!array_key_exists(strtolower($nivel), ActividadFormacion::NIVEL)) {
                throw new Exception("{$nivel} no es un nivel válido");
            }
            $this->nivel = $nivel;
        } catch (Exception $e) {
            return "Error. {$e->getCode()}\nMessage {$e->getMessage()}";
        }
    }

    public function __clone() {
        try {
            if (!$this instanceof ActividadFormacion) {
                throw new Exception("El Objeto no pertenece a la clase ActividadFormacion");
            }
            $nuevoObjetoClonao = clone $this;
            return $nuevoObjetoClonao; 
        } catch (Exception $e) {
            return "Error. {$e->getCode()}\nMessage {$e->getMessage()}";
        }
    }

    public function __toString() {
        return "Codigo: {$this->getCodigo()}\nTitulo: {$this->getTitulo()}\nHoras Presenciales: {$this->getHorasPresenciales()}\nHoras Online: {$this->getHorasOnline()}
        \nHoras No Presenciales: {$this->getHorasNoPresenciales()}\nNivel: {$this->getNivel()}";
    }
}
?>