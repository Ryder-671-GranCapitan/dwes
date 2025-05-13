<?php
    //Espacio de nombres
    namespace mvc\Modelo\Mvc_Orm_Autenticar;

    use orm\modelo\ORMCliente;
    use Exception;

    // Instanciamos la clase
    class Mvc_Orm_Autenticar extends ORMCliente {
        // Funcion que devuelva al cliente
        public function clientePorEmail(string $email) {
            $sql = 'SELECT nombre, apellidos, nif, email FROM cliente WHERE email = :email';

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':email', $email);

            if ($stmt -> execute()) {
                $datos = $stmt->fetch();
                return $datos;
            } else {
                throw new Exception("No se ha encontrado al usuario");
            }
        }
    }
?>