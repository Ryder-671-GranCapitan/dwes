<?php
    // JAIME GRUESO MARTIN

    namespace rera507\entidad;

    use Exception;
    use ReflectionProperty;
    use DateTime;
    
    class Resena07 {
        public const FECHA_MYSQL = "Y-m-d H:i:s";
        public const FECHA_USUARIO = "d/m/Y H:i:s";

        private int $id_resena;
        private string $nif;
        private string $referencia;
        private DateTime $fecha;
        private ?int $clasificacion;
        private ?string $comentario;

        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                $this->__set($propiedad, $valor);
            }
        }

        public static function getProperty($objeto, $propiedad) : string {
            $instancia_reflection = new ReflectionProperty($objeto, $propiedad);
            return $instancia_reflection->getType()->getName();
        }

        public function __set($propiedad, $valor) {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad Invalida");
            }

            if (self::getProperty($this, $propiedad) == DateTime::class) {
                $this->$propiedad = new DateTime($valor);
            } else {
                $this->$propiedad = $valor;
            }
        }

        public function __get($propiedad) : mixed {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad Invalida");
            }
            return $this->$propiedad;
        }
    }
?>

