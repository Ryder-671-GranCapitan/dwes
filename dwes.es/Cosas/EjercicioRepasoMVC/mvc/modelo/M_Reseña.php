<?php
    // Creamos el modelo y la vista de la reseña, para ello nos hará falta.

    // 1.- Crear la Entidad de la Reseña
    // 2.- Crear el ORMReseña
    // 3.- Ver si nos hace falta un Mvc_Orm_Reseña
    // 4.- Crear nuestro M_Reseña (Modelo)

    // Espacio de nombres
    namespace mvc\modelo;

    use mvc\modelo\Modelo;
    use mvc\modelo\orm\Mvc_Orm_Reseña;

    class M_Reseña implements Modelo {
        public function despacha(): mixed {
            // Y creamos elñ metodo de la interfaz padre Modelo "despacha()" para devolverle a la vista los datos de las reseñas de un articulo

            // Aqui debemos validar la reseña que nos llega por el formulario del boton Añadir Reseña
            $referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_SPECIAL_CHARS);
            $_SESSION['referencia'] = $referencia;

            // Y ahora instanciamos un objeto de la clase Mvc_Orm_Reseña para llamar al metodo que ejecuta la consulta SQL
            // y le pasamos la referencia obtenida en el formulario
            $mvc_orm_reseña = new Mvc_Orm_Reseña();
            $datos = $mvc_orm_reseña->getReseñas($referencia);

            // Y devolvemos el array de datos
            if ($datos) {
                return $datos;
            } else {
                return "No hay reseñas pa este articulo. ¡Se el primero en dejar una reseña!";
            }
        }
    }

    // Y ahora creamos la vista
?>