<?php
    namespace ExamenRa5Repetido\modelo;

    use Exception;
    use ExamenRa5Repetido\entidad\Pedido07;
    use PDO;

    class ModeloPedido07 {
        protected const TABLE = 'pedido';
        protected const PK = 'npedido';

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

        public function procesaPeticion() : ?Pedido07 {
            $npedido = $_POST['npedido'];
            $npedido = filter_var($npedido, FILTER_SANITIZE_NUMBER_INT);

            if (!$npedido) {
                throw new Exception("Pedido Invalido");
            }

            $sql = "SELECT npedido, nif, fecha, observaciones, total_pedido ";
            $sql .= "FROM " . self::TABLE . ' ';
            $sql .= "WHERE " . self::PK . ' = :pk';

            $stmt = $this->pdo->prepare($sql);

            $params = [
                ':pk' => $npedido
            ];

            $stmt->execute($params);
            $data = $stmt->fetch();

            if (!$data) {
                throw new Exception("No se encontro el pedido con el numero seleccionado");
            }

            $objeto_pedido = new Pedido07($data);
            return $objeto_pedido;
        }
    }
?>