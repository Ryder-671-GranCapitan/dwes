<?php

// Espacio de nombres
namespace orm\modelo;

use orm\entidad\Reseña;
use orm\modelo\ORMBase;

// Creación de la clase ORMReseña
class ORMReseña extends ORMBase{
    protected string $tabla = "reseña";
    protected string $clave_primaria = "id_reseña";
    public function getClaseEntidad()
    {
        return Reseña::class;
    }
}

// Ahora si, ya hemos terminado con esta clase
// No me acordaba que era llamando a la Entidad anterior y creando dos propiedades para acceder directamente a la tabla con la PK
// Bueno, una vez tengamos esto, debemos mirar si tenemos que crear nuestra clase Mvc_Orm_Reseña o no
// ¿Y cómo lo miramos? Pues vamos a leer el ejercicio y a ver que nos dice
// Pues tenemos que crearla para obtener todas las reseñas que tiene ese articulo
// Vamos al lio
?>