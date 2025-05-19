<?php
    namespace ExamenRa7Rep\modelo;

    use Exception;
    use PDO;
    use PDOException;
    use ExamenRa7Rep\entidad\Alumno07;


    class RESTAlumno07 {
        // PROPIEDADES DE LA CLASE
        protected static $TABLA = "alumno";
        protected static $PK = "nif";

        // PROPIEDADES DEL OBJETO
        private PDO $pdo;

        // CONSTRUCTOR
        public function __construct() {
            $dsn = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=examen;charset=utf8mb4";
            $usuario = "examen";
            $password = "usuario";
            $options = [
                PDO::ATTR_CASE                 => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES     => false,
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            ];

            try {
                $this->pdo = new PDO($dsn, $usuario, $password, $options);
            } catch (Exception $pdoe) {
                throw $pdoe;
            }
        }

        public function getAlumnos() : mixed {
            // OBTENEMOS EL PARAMETRO DE CONSULTA PARA FILTRAR
            $parametroConsulta = filter_input(INPUT_GET, "apellidos", FILTER_SANITIZE_SPECIAL_CHARS);

            try {
                // CONSULTA Y CONSULTA
                $sql = "SELECT * FROM " . self::$TABLA . " ";
                $sql .= "WHERE apellidos LIKE :apellidos";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(":apellidos", "%$parametroConsulta%");

                // SI SE EJECUTA CORRECTAMENTE SE OBTIENE UN ARRAY DE OBJETOS ARTICULOS
                if ($stmt->execute()) {
                    $registrosDevueltos = [];
                    while ($fila = $stmt->fetch()) {
                        $registrosDevueltos[] = new Alumno07($fila);
                    }
                    
                    return $registrosDevueltos;
                } else {
                    return null;
                }
            } catch (PDOException $pdoe) {
                throw $pdoe;
            }
        }
    }
?>