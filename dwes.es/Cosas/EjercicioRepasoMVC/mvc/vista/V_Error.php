<?php
    // Espacio de nombres
    namespace mvc\vista;

    // Gneramos la clase
    class V_Error extends Vista {
        public function genera_salida($datos): void {
            echo "El error es " . $datos->getMessage();
        }
    }
?>