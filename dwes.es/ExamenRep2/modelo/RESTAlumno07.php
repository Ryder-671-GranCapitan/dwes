<?php
    namespace ExamenRep2\modelo;

    use Exception;
    use PDO;
    use PDOException;
    use ExamenRep2\entidad\Alumno07;

    class RESTAlumno07 {
        protected static $TABLA = 'registro_asistente';
        protected static $PK = 'id';

        private PDO $pdo;

        public function __construct() {
            $dsn = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=examen;chartset=utf8mb4";
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
            } catch (PDOException $pdoe) {
                throw $pdoe;
            }
        }

        public function getAlumnos() : mixed {
            $parametro = filter_input(INPUT_GET, "email", FILTER_SANITIZE_SPECIAL_CHARS);

            try {
                $sql = "SELECT * FROM " . self::$TABLA . " ";
                $sql.= "WHERE email LIKE :email";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(":email", "%$parametro%");

                if ($stmt->execute()) {
                    $registros = [];
                    while ($fila = $stmt->fetch()) {
                        $registros[] = new Alumno07($fila);
                    }
                    return $registros;
                } else {
                    return null;
                }
            } catch (PDOException $pdoe) {
                throw $pdoe;
            }
        }
    }
?>