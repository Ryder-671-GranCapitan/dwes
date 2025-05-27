<?php
    // Nombre: JAIME GRUESO MARTIN

    namespace orm;

    use entidad\FilaAlumno;
    use PDO;
    use PDOException;

    class ORMAlumno {
        private const TABLA = 'alumno';
        private const CLAVE = 'dni';

        protected const DSN = 'mysql:host=192.168.12.71;dbname=examen;charset=utf8mb4';

        protected static array $OPTIONS = [
            PDO::ATTR_CASE                 => PDO::CASE_LOWER,
            PDO::ATTR_EMULATE_PREPARES     => false,
            PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
        ];

        protected PDO $pdo;

        public function __construct(){
            $this->pdo = new PDO(self::DSN, 'examen', 'usuario', self::$OPTIONS);
        }

        public function actualizar($alumno) {
            try {
                $sql = "UPDATE " . self::TABLA . " SET (curso = :curso, grupo = :grupo, fecha_nacimiento = :fecha_nacimiento) WHERE " . self::CLAVE . " = :dni";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':curso', $alumno->curso);
                $stmt->bindValue(':grupo', $alumno->grupo);
                $stmt->bindValue(':fecha_nacimiento', $alumno->fecha_nacimiento->format('Y-m-d'));
                $stmt->bindValue(':dni', $alumno->dni);
                return $stmt->execute();
            } catch(PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }

        public function buscar($dni) {
            $sql = "SELECT * FROM " . self::TABLA . " WHERE " . self::CLAVE . " = :dni";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':dni', $dni);
            $stmt->execute();
            $result = $stmt->fetch();
            if ($result) {
                return new FilaAlumno($result);
            }
            return null;
        }
    }


























    
?>