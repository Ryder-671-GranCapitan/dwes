<?php

// Hoy vamos a terminar el ejercicio, vamos a empezar haciendo el modelo y la vista de la reseña para esto, nos va a hacer falta:

    // 1.- Crear la Entidad de la Reseña.
    // 2.- Crear el ORMReseña
    // 3.- Ver si nos hace falta un Mvc_Orm_Reseña
    // 4.- Crear nuestro M_Reseña (Modelo)

// Vamos a comenzar por el primer paso

// Espacio de nombres
namespace mvc\modelo;

use mvc\modelo\Modelo;
use mvc\modelo\orm\Mvc_Orm_Reseña;

// Cremos la clase M_Reseña que implementa de la interfaz Modelo
class M_Reseña implements Modelo{

    // Y creamos el método de la interfaz padre Modelo "despacha()" para devolverle a la vista los datos de las reseñas de un artículo
    public function despacha(): mixed
    {
        // Aquí debemos de validar la reseña que nos llega por el formulario del botón Añadir Reseña
        $referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_SPECIAL_CHARS);    
        $_SESSION['referencia'] = $referencia;
        // Y ahora, instanciamos un objeto de la clase Mvc_Orm_Reseña para llamar al método que ejecuta la consulta SQL
        // y le pasamos la referencia obtenida del formulario
        $mvc_orm_reseña = new Mvc_Orm_Reseña();
        $datos = $mvc_orm_reseña->getReseñas($referencia);

        // Y devolvemos el array de datos
        if ($datos){
            return $datos;
        }else{
            return "No hay reseñas para este artículo. ¡Sé el primero en añadir una!";
        }
    }

    // Y ahora ya, podemos crear la vísta
}
?>