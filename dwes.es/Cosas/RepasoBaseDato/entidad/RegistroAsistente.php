<?php
// Espacio de nombres (namespace) para organizar el código y evitar colisiones de nombres con otras clases
namespace entidad;

// Importación de clases necesarias
use DateTime;          // Se usa para manejar fechas y horas
use Exception;         // Se usa para manejar excepciones en caso de errores
use ReflectionProperty; // Se usa para inspeccionar propiedades de una clase en tiempo de ejecución

// Definición de la clase RegistroAsistente
class RegistroAsistente {
    // Definición de constantes para formatear fechas
    public const FORMATO_FECHA_MYSQL = 'Y-m-d H:i:s'; // Formato estándar de MySQL
    public const FORMATO_FECHA_USUARIO = 'm/d/Y H:i:s'; // Formato más amigable para usuarios

    // Propiedades privadas de la clase
    private int $id;                 // Identificador único del asistente
    private string $email;           // Correo electrónico del asistente
    private DateTime $fecha_inscripcion; // Fecha y hora de inscripción
    private string $actividad;       // Actividad en la que se inscribió

    /*
        * Constructor que inicializa las propiedades de la clase usando un array asociativo.
        * @param array $datos - Datos para inicializar el objeto.
     */
    public function __construct(array $datos) {
        // Itera sobre cada clave y valor del array recibido
        foreach ($datos as $propiedad => $valor) {
            // Usa el método mágico __set para asignar valores a las propiedades
            $this->__set($propiedad, $valor);
        }
    }

    /*
        * Método mágico __set para asignar valores a las propiedades de la clase.
        * @param string $propiedad - Nombre de la propiedad.
        * @param mixed $valor - Valor a asignar a la propiedad.
        * @throws Exception - Lanza una excepción si la propiedad no existe.
     */
    public function __set($propiedad, $valor) {
        // Verifica si la propiedad existe en la clase
        if (!property_exists($this, $propiedad)) {
            throw new Exception("No existe la propiedad $propiedad");
        }
        // Verifica si la propiedad es de tipo DateTime
        if (!($this->tipoPropiedad($this, $propiedad) == DateTime::class)) {
            // Si no es DateTime, asigna el valor directamente
            $this->$propiedad = $valor;
        } else {
            // Si es de tipo DateTime, convierte el valor en un objeto DateTime
            $this->$propiedad = new DateTime($valor);
        }
    }

    /*
        * Método mágico __get para obtener el valor de una propiedad.
        * @param string $propiedad - Nombre de la propiedad a obtener.
        * @return mixed - Valor de la propiedad.
        * @throws Exception - Lanza una excepción si la propiedad no existe.
     */
    public function __get($propiedad) {
        // Verifica si la propiedad existe en la clase
        if (!property_exists($this, $propiedad)) {
            throw new Exception("No existe la propiedad $propiedad");
        }
        // Retorna el valor de la propiedad
        return $this->$propiedad;
    }

    /*
        * Método mágico __toString para representar el objeto como una cadena.
        * @return string - Cadena con los valores de las propiedades del objeto.
     */
    public function __toString() {
        $datos = ''; // Variable para almacenar la representación en cadena del objeto

        // Itera sobre las propiedades del objeto
        foreach ($this as $propiedad => $valor) {
            // Si la propiedad es de tipo DateTime, formatearla antes de mostrarla
            if ($this->tipoPropiedad($this, $propiedad) == DateTime::class) {
                $datos .= $propiedad . ': ' . $valor->format(self::FORMATO_FECHA_MYSQL) . "<br>";
                continue;
            }
            // Agrega la propiedad y su valor a la cadena de salida
            $datos .= $propiedad . ': ' . $valor . '<br>';
        }
        // Retorna la representación del objeto como una cadena de texto
        return $datos;
    }

    /*
        * Método que devuelve el tipo de una propiedad usando ReflectionProperty.
        * @param object $objeto - Instancia de la clase.
        * @param string $propiedad - Nombre de la propiedad a inspeccionar.
        * @return string - Tipo de la propiedad (por ejemplo, "int", "string", "DateTime").
    */
    public function tipoPropiedad($objeto, $propiedad) {
        // Crea un objeto ReflectionProperty para inspeccionar la propiedad
        $objecto_ref = new ReflectionProperty($objeto, $propiedad);
        // Obtiene el tipo de la propiedad
        $tipo_obj = $objecto_ref->getType();
        // Obtiene el nombre del tipo (como string)
        $nombre_tipo = $tipo_obj->getName();
        
        return $nombre_tipo; // Retorna el nombre del tipo de la propiedad
    }

    /**
     * Método que convierte el objeto en un array asociativo.
     * @return array - Array con las propiedades del objeto y sus valores.
     */
    public function toArray() : array {
        // Retorna un array con las variables del objeto
        return get_object_vars($this);
    }
}
?>
