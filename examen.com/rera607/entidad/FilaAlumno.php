<?php
    // Nombre: JAIME GRUESO MARTIN

    // Espacio de nombres
    namespace entidad;

    use DateTime;
    use ReflectionProperty;
    use Exception;

    class FilaAlumno {
        private int $dni;
        private string $curso;
        private string $grupo; 
        private DateTime $fecha_nacimiento;
        
        public const FECHA_MYSQL = 'Y-m-d H:i:s';

        public function __construct(array $datos){
            foreach($datos as $property => $value){
                $this->__set($property, $value);
            };
        }

        public function __set($property, $value){
            if( !property_exists($this, $property) ){
                throw new Exception("No existe la propiedad $property");
            }

            if( !($this->tipoPropiedad($this, $property) == DateTime::class)){
                settype($value, $this->tipoPropiedad($this, $property));
                $this->$property = $value;
            }
            else {
                $this->$property = new DateTime($value);
            }
        }
        
        public function __get($property) {
            if( !property_exists($this, $property) ){
                throw new Exception("No existe la propiedad $property");
            }
            return $this->$property;
        }

        public function __toString(){
            $data = '';

            foreach( $this as $property => $value ){
                if( $this->tipoPropiedad($this, $property) == DateTime::class ) {
                    $data .= $property . ': ' . $value->format(self::FECHA_MYSQL) . "<br>";
                    continue;
                }
                $data .= $property . ": " . $value . "<br>";
            }

            return $data;
        }

        public function tipoPropiedad($object, $property){
            $objeto_ref = new ReflectionProperty($object, $property);
            $tipo_obj = $objeto_ref->getType();
            $nombre_tipo = $tipo_obj->getName();

            return $nombre_tipo;
        }
    }
?>
