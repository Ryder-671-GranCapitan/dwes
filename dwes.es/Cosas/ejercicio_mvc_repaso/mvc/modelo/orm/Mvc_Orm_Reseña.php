<?php

// Espacio de nombres
namespace mvc\modelo\orm;

use DateTime;
use orm\modelo\ORMReseña;
use Exception;
use util\seguridad\Jwt;

// Creación de la clase
class Mvc_Orm_Reseña extends ORMReseña{

    // Vamos a crear un método que nos va a devolver todas las reseñas que tiene el artículo que se le pase por parámetro
    public function getReseñas($referencia){
        // Preparamos la consulta SQL
        $sql = "SELECT id_reseña, nif, referencia, fecha, clasificacion, comentario";
        $sql.= " FROM reseña";
        $sql.= " WHERE referencia = :referencia";
        $stmt = $this->pdo->prepare($sql);

        // Vinculamos el valor a la propiedad de la referencia
        $stmt->bindValue(':referencia', $referencia);

        // Y ejecutamos la consulta
        if ($stmt->execute()){
            $reseñas = $stmt->fetchAll();
            if($reseñas){
                return $reseñas;
            } else {
                return "No hay reseñas para este artículo. ¡Sé el primero en añadir una!";
            }
            
        }
    }

    // Función en la que insertaremos la reseña mediante los parametros pasados
    public function insertaReseña($nif, $referencia, $clasificacion, $comentario){
        // Preparamos la consulta SQL
        $sql = "INSERT INTO reseña VALUES(null, :nif, :referencia, :fecha, :clasificacion, :comentario)";
        $stmt = $this->pdo->prepare($sql);

        // Vinculamos los valores (Se podría haber hecho con bindParams pero... :) )
        $stmt->bindValue(':nif', $nif);
        $stmt->bindValue(':referencia', $referencia);
        $date = new DateTime();
        $stmt->bindValue(':fecha', $date->format('d-m-y H:i:s'));
        $stmt->bindValue(':clasificacion', $clasificacion);
        $stmt->bindValue(':comentario', $comentario);

        // Ejecutamos la consulta
        if ($stmt->execute()){
            return true;
        }else {
            false;
        }
    }
}

// Con esto, tendríamos todas las reseñas mediante la consulta SQL
// Ahora, debemos de crear el Modelo de la Reseña para devolverle a la vista las reseñas y que las muestre por pantalla
?>