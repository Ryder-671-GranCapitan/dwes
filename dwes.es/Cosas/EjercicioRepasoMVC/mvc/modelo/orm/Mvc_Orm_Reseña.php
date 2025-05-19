<?php

    // Espacio de nombres 
    namespace mvc\modelo\orm;
    use util\seguridad\Jwt;
    use orm\modelo\ORMReseña;
    use Exception;

    // Creacion de la clase
    class Mvc_Orm_Reseña extends ORMReseña {
        // Vamos a crear un metodo para que nos devuelva todas las reseñas que tiene el articulo que se le pase por parametro
        public function getReseñas($referencia) {
            // Preparamos la consulta
            $sql = "SELECT id_reseña, nif, referencia, fecha, clasificacion, comentario";
            $sql .= " FROM reseña";
            $sql .= " WHERE referencia = :referencia";

            $stmt = $this->pdo->prepare($sql);

            // Viculamos el valor a la propiedad de la refencia
            $stmt->bindValue(':referencia', $referencia);

            // Ejectamos la consulta
            if ($stmt->execute()) {
                $reseñas = $stmt->fetchAll();
                if ($reseñas) {
                    return $reseñas;
                } else {
                    throw new Exception("No se ha encontrado la referencia");
                    
                }
            }
        }

        // Funcion en la que insertaremos la reseña mediante los parametros pasados
        public function insertaReseña($nif, $referencia, $clasificacion, $comentario) {
            // Preparamos la consulta SQL
            $sql = "INSERT INTO reseña VALUES(null, :nif, :referencia, :fecha, :clasificacion, :comentario)";

            $stmt = $this->pdo->prepare($sql);

            // Esto lo podriamos haber hecho con bindParams pero xd
            $stmt->bindValue(':nif', $nif);
            $stmt->bindValue(':referencia', $referencia);
            $stmt->bindValue(':fecha', time());
            $stmt->bindValue(':clasificacion', $clasificacion);
            $stmt->bindValue(':comentario', $comentario);

            // Ejecutamos la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                false;
            }
        }
    }
// Con esto, tendriamos todas las reseñas mediante la consulta SQL
// Ahora, hay que crear el modelo de la reseña, para devolverke a la vista las reseñas y que las muestre por pantalla.
?>