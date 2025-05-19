<?php

    // Espacio de nombres
    namespace mvc\vista;
    use mvc\vista\Vista;

    // Creamos la clase
    class V_Insertar_Reseña extends Vista {
        public function genera_salida($datos): void {
            $this->inicio_html("Valores de la reseña", ['./styles/general.css', './styles/tablas.css']);

            // Vamos a devolver una tabla con el valor que se ha introducido en la base de datos y un boton pa que vuelva a la ventana 
            // anterior.

            // Como el valor valor lo tenemos en $datos vamos a recorrerlo y ver los valores que tiene


            $this->fin_html();
        }
    }

?>