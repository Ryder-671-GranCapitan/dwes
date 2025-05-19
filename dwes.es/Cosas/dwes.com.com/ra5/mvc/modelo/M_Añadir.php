<?php
    namespace mvc\modelo;

    use mvc\modelo\Modelo;
    use orm\modelo\ORMArticulo;
    use Exception;

    class M_Añadir implements Modelo {
        public function despacha(): mixed {

            // Sanear y validar los datos del formulario
            // - Referencia

            // Obtener los datos del articulo que se quiere comprar
            // Si no existe el articulo, lanzar una excepción

            // Añadir el articulo al carrito

            $referencia = filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_SPECIAL_CHARS);

            $articulo = $this->obtener_articulo($referencia);

            $_SESSION['carrito'][] = $articulo;

            return $articulo;
        }

        private function obtener_articulo(string $referencia) : object {
            // Obtener los datos del articulo que se quiere comprar
            // Si no existe el articulo, lanzar una excepción
            $orm_articulo = new ORMArticulo();
            $articulo = $orm_articulo->get($referencia);
            if( !$articulo ) {
                throw new Exception("El artículo $referencia no existe", 4005);
            }
            return $articulo;
        }
    }
?>