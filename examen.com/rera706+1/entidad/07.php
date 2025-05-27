<?php
    namespace rera707\entidad;

    use JsonSerializable;
    use DateTime;
    use Exception;
    use ReflectionProperty;

    class Alumno07 implements JsonSerializable { 
        public static string $FORMATO_FECHA_JSON = "d/m/Y - H:i:s";

        // PROPIEDADES DEL OBJETO
        

        // CONSTRUCTOR
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
                if ($propiedad == "tipo_date" && $valor instanceof DateTime) {
                    $objetoJson[$propiedad] = $valor->format(self::$FORMATO_FECHA_JSON);
                } else {
                    $objetoJson[$propiedad] = $valor;
                }
            }
            return $objetoJson;
        }
    }
?>