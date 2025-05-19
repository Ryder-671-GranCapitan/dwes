<?php

// Para poder realizar la clase Reseña, esta tiene que:

// - Extender de Entidad
// - Tener todos los datos que le hagan falta para crearse en la BD

// Vamos a comenzar echando un vistazo en la BBDD para saber que datos necesitamos para crearlo
// Con los datos ya encontrados, vamos a crear nuestra clase

namespace orm\entidad;
use orm\entidad\Entidad;
use DateTime;

class Reseña extends Entidad{

    // Ponemos todas las propiedades que hagan falta para la creación de nuestro objeto en la BBDD
    protected int $id_reseña;
    protected ?string $nif;
    protected ?string $referencia;
    protected DateTime $fecha;
    protected int $clasificacion;
    protected ?string $comentario;

    // Con esto, ya está generada nuestra clase Reseña
    // Ahora, vamos por el ORMReseña
}

?>