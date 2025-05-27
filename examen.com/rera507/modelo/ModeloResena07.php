<?php
    // JAIME GRUESO MARTIN

    namespace rera507\modelo;

    use Exception;
    use rera507\entidad\Resena07;
    use PDO;

    class ModeloResena07 {
        private const TABLE = 'reseña';
        private const PK = 'id_reseña';

        protected PDO $pdo;

        public function __construct() {
            $dsn = 'mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=tiendaol;charset=utf8mb4';
            $usuario = 'usuario';
            $clave = 'usuario';
            $options = [
                PDO::ATTR_CASE                 => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES     => false,
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            ];

            $this->pdo = new PDO($dsn, $usuario, $clave, $options);
        }

        public function procesaPeticion() : ?Resena07 {
            $id_reseña = $_POST['id_resena'];
            $id_reseña = filter_var($id_reseña, FILTER_SANITIZE_NUMBER_INT);
            $nif = $_POST['nif'];
            $nif = filter_var($nif, FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha = $_POST['fecha'];
            $referencia = $_POST['referencia'] ?? '';
            $referencia = filter_var($referencia, FILTER_SANITIZE_SPECIAL_CHARS);
            $clasificacion = $_POST['clasificacion'] ?? 0;
            $clasificacion = filter_var($clasificacion, FILTER_SANITIZE_NUMBER_INT);
            $comentario = $_POST['comentario'] ?? '';
            $comentario = filter_var($comentario, FILTER_SANITIZE_SPECIAL_CHARS);
            

            if (!$id_reseña) {
                throw new Exception("Reseña Invalida");
            }

            $sql = 'INSERT INTO ' . self::TABLE . " VALUES(null, :nif, :referencia, :fecha, :clasificacion, :comentario)";

            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':nif' => $nif,
                ':referencia' => $referencia,
                ':fecha' => $fecha,
                ':clasificacion' => $clasificacion,
                ':comentario' => $comentario
            ];
            
            $stmt->execute($params);
            
            $data = $stmt->fetch();

            if (!$data) {
                throw new Exception("No se ha podido insertar la reseña");
            }

            $objeto_resena = new Resena07($data);
            return $objeto_resena;
        }
    }
?>