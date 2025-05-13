<?php
    // Para poder realizar la clase Reseña, esta tiene que:

    // - Extender de Entidad
    // - Tener todos los datos que le hagan falta para crearse en la BD

    // Creamos la clase
    namespace orm\entidad;

    use DateTime;
    use orm\entidad\Entidad;

    class Reseña extends Entidad {
        // Ponemos todas las propiedades que hagan falta para la creacion de
        protected int $id_reseña;
        protected ?string $nif;
        protected ?string $referencia;
        protected ?DateTime $fecha;
        protected int $clasificacion;
        protected ?string $comentario;

        // Con esto ya estaría la clase Reseña, Ahora vamos al ORMReseña
    }

?>