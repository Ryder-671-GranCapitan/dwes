<?php

    namespace entidad\RegistroAsistente;

    class RegistroAsistente {
        private $id;
        private $email;
        private $fecha_inscripcion;
        private $actividad;

        public function __construct(int $id, string $email, string $fecha_inscripcion, string $actividad) {
            $this->id = $id;
            $this->email = $email;
            $this->fecha_inscripcion = $fecha_inscripcion;
            $this->actividad = $actividad;
        }

        // __get

        public function getId(): int {
            return $this->id;
        }

        public function getEmail(): string {
            return $this->email;
        }

        public function getFechaInscripcion(): string {
            return $this->fecha_inscripcion;
        }

        public function getActividad(): string {
            return $this->actividad;
        }

        // __set

        public function setId(int $id): void {
            $this->id = $id;
        }

        public function setEmail(string $email): void {
            $this->email = $email;
        }

        public function setFechaInscripcion(string $fecha_inscripcion): void {
            $this->fecha_inscripcion = $fecha_inscripcion;
        }

        public function setActividad(string $actividad): void {
            $this->actividad = $actividad;
        }


        //__toString
        public function __toString(): string {
            return "Id: $this->id, Email: $this->email, Fecha de inscripción: $this->fecha_inscripcion, Actividad: $this->actividad";
        }
    }
?>