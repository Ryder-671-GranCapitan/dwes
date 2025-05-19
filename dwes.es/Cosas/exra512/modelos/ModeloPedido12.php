<?php
// Yahya Limouni | 12
namespace exra512\modelos;

use Exception;
use exra512\entidad\Pedido12;
use PDO;

class ModeloPedido12 {
    protected const TABLA = 'pedido';
    protected const PK = 'npedido';

    protected PDO $pdo;

    public function __construct() {
        $dsn = "mysql:host=cpd.iesgrancapitan.org;port=9992;dbname=tiendaol;charset=utf8mb4";
        $usuario = "usuario";
        $clave = "usuario";
        $opciones = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $this->pdo = new PDO($dsn, $usuario, $clave, $opciones);
    }

    public function procesarPeticion(): ?Pedido12 {
        $npedido = $_POST['npedido'];
        $npedido = filter_var($npedido, FILTER_SANITIZE_NUMBER_INT);

        if( !$npedido ){
            throw new Exception("Can't proceed with the operation, invalid npedido");
        }

        $sql = "SELECT npedido, nif, fecha, observaciones, total_pedido ";
        $sql .= "FROM " . self::TABLA . " ";
        $sql .= "WHERE " . self::PK . " = :pk";

        $stmt = $this->pdo->prepare($sql);

        $parms = [
            ':pk' => $npedido
        ];

        $stmt->execute($parms);
        $data = $stmt->fetch();
        
        if(!$data) {
            throw new Exception("No se encontró ningún pedido con el ID proporcionado");
        }
        
        $pedido_object = new Pedido12($data);
        return $pedido_object;
    }
}
?>