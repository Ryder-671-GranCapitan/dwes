<?php

// Espacio de nombres
namespace mvc\modelo\orm;

use Exception;
use orm\modelo\ORMCliente;

// Creación de la clase
class Mvc_Orm_Autenticar extends ORMCliente{

    // Tenemos que crear un método que nos permita recoger un cliente por su email
    public function recogeUsuarioEmail($email): mixed{
        // Creamos y preparamos la consulta sql
        $sql = "SELECT nif, nombre, apellidos, clave, iban, telefono, email, ventas";
        $sql.= " FROM cliente";
        $sql.= " WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);

        // Vinculamos los parámetros
        $stmt->bindValue(":email", $email);

        // Ejecutamos la consulta
        if ($stmt->execute()){
            $valor = $stmt->fetch();
            return $valor;
        }else {
            throw new Exception("No existe el usuario indicado");
        }
    }

    // Funcion que obtiene los articulos
    public function recogerDatosArticulo() : array {
        // Creamos la consulta y la preparamos
        $sql = "SELECT referencia, descripcion, pvp, dto_venta, categoria, tipo_iva";
        $sql .= " FROM articulo";

        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute()) {
            $productos = $stmt->fetchAll();
            return $productos;
        }
    }
}

?>