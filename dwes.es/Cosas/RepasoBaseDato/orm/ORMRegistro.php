<?php
// Espacio de nombres (namespace) para organizar el código y evitar colisiones de nombres con otras clases
namespace orm;

// Importación de clases necesarias
use entidad\RegistroAsistente; // Se usa para manejar los registros de asistentes
use PDO;                       // Se usa para conectarse a la base de datos

/**
 * Clase ORMRegistro que maneja la comunicación con la base de datos
 * para la tabla "registro_asistente".
 */
class ORMRegistro {
    // Definición de constantes para la base de datos
    private const TABLA = "registro_asistente"; // Nombre de la tabla en la BD
    private const PK = "id";                    // Clave primaria de la tabla

    // Configuración de conexión a la base de datos
    private const DSN = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=examen;charset=utf8mb4";

    // Opciones de configuración para PDO
    protected static array $OPTIONS = [
        PDO::ATTR_CASE                 => PDO::CASE_LOWER,          // Convierte los nombres de columnas a minúsculas
        PDO::ATTR_EMULATE_PREPARES     => false,                    // Usa sentencias preparadas reales
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,   // Lanza excepciones en caso de error
        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC          // Devuelve resultados como arrays asociativos
    ];

    // Propiedad protegida para la conexión a la base de datos
    protected PDO $pdo;

    /**
     * Constructor de la clase ORMRegistro.
     * Se encarga de establecer la conexión con la base de datos.
     */
    public function __construct() {
        // Se crea una nueva conexión PDO usando las credenciales establecidas
        $this->pdo = new PDO(self::DSN, 'examen', 'usuario', self::$OPTIONS);
    }

    /*
     * Método para insertar un nuevo registro en la base de datos.
     * 
     * @param RegistroAsistente $registro - Objeto que representa el registro a insertar.
     * @return bool - Retorna true si la inserción fue exitosa, false en caso contrario.
     */
    public function insertar(RegistroAsistente $registro) {
        // Construcción de la consulta SQL de inserción
        $sql = "INSERT INTO " . self::TABLA . ' (email, fecha_inscripcion, actividad)';
        $sql .= " VALUES(:email, :fecha_inscripcion, :actividad)";

        // Preparar la consulta para evitar inyección SQL
        $stmt = $this->pdo->prepare($sql);

        // Parámetros a insertar en la consulta
        $params = [
            ':email' => $registro->email, 
            ':fecha_inscripcion' => $registro->fecha_inscripcion->format(RegistroAsistente::FORMATO_FECHA_MYSQL), 
            ':actividad' => $registro->actividad
        ];

        // Inicia una transacción para garantizar la atomicidad
        $this->pdo->beginTransaction();
        
        // Ejecuta la consulta con los parámetros y verifica si se insertó correctamente
        if ($stmt->execute($params) && $stmt->rowCount() == 1) {
            $this->pdo->commit(); // Confirma la transacción
            return true; // Retorna true si la inserción fue exitosa
        }

        return false; // Retorna false si la inserción falló
    }

    /*
     * Método para listar registros de la base de datos según el email.
     * 
     * @param string $email - Correo electrónico para filtrar los registros.
     * @return array - Devuelve un array de objetos RegistroAsistente.
     */
    public function listar(string $email) {
        // Construcción de la consulta SQL para seleccionar registros por email
        $sql = "SELECT * FROM " . self::TABLA . ' ';
        $sql .= "WHERE email = :email;";

        // Preparar la consulta SQL
        $stmt = $this->pdo->prepare($sql);

        // Parámetro de la consulta
        $params = [':email' => $email];

        // Ejecutar la consulta y verificar si hay resultados
        if ($stmt->execute($params)) {
            $array_registros = []; // Array donde se almacenarán los objetos RegistroAsistente
            
            // Itera sobre los resultados de la consulta
            while ($fila = $stmt->fetch()) {
                // Crea un nuevo objeto RegistroAsistente con los datos obtenidos
                $registro = new RegistroAsistente($fila);
                // Agrega el objeto al array de registros
                $array_registros[] = $registro;
            }

            // Retorna el array de registros encontrados
            return $array_registros;
        }
        
        // Si no hay registros, retorna un array vacío
        return [];
    }
}
?>
