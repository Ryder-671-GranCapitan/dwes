<?php
    namespace orm\entidad;

    use orm\entidad\Entidad;

    class DireccionEnvio extends Entidad {
        protected string $nif;
        protected int $id_dir_env;
        protected string $direccion;
        protected string $cp;
        protected string $poblacion;
        protected string $provincia;
        protected string $pais;

        public function __construct(array $fila) {
            $this->id_dir_env = $fila['id_dir_env'];
            $this->nombre = $fila['nombre'];
            $this->direccion = $fila['direccion'];
            $this->ciudad = $fila['ciudad'];
            $this->provincia = $fila['provincia'];
            $this->cp = $fila['cp'];
            $this->pais = $fila['pais'];
            $this->telefono = $fila['telefono'];
        }

        public function __get(string $atributo) {
            return $this->$atributo;
        }

        public function __set(string $atributo, mixed $valor) {
            $this->$atributo = $valor;
        }
    }
?>