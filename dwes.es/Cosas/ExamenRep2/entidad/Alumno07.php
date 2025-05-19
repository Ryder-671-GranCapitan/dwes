<?php
    namespace ExamenRep2\entidad;

    use JsonSerializable;
    use DateTime;
    use Exception;
    use ReflectionProperty;


    class Alumno07 implements JsonSerializable {
        public static string $formato = "d/m/Y - H:i:s";

        // Propiedades del Objeto
        private ?int $id;
        private ?string $email;
        private ?DateTime $fecha_inscripcion;
        private ?string $actividad;

        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                if (!property_exists($this, $propiedad)) {
                    throw new Exception("La propiedad $propiedad no existe");
                } else {
                    $propiedadReflection = new ReflectionProperty($this, $propiedad);
                    if ($propiedadReflection->getType()->getName() == DateTime::class) {
                        $this->$propiedad = $valor ? new DateTime($valor) : null;
                    } else {
                        $this->$propiedad = $valor;
                    }
                }
            }
        }

        public function jsonSerialize(): mixed {
            $objetoJson = [];
            foreach ($this as $propiedad => $valor) {
                if ($propiedad == "fecha_inscripcion" && $valor instanceof DateTime) {
                    $objetoJson[$propiedad] = $valor->format(self::$formato);
                } else {
                    $objetoJson[$propiedad] = $valor;
                }
            }
            return $objetoJson;
        }
    }
?>