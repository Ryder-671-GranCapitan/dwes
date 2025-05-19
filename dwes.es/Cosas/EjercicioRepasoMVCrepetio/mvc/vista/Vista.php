<?php
    // Espacio de nombre
    namespace mvc\Vista;

    // Instanciamos la clase Abstracta Vista
    abstract class Vista {

        // Funcion que genera la salida
        public function genera_salida(mixed $datos): void {}


        // Funcion que pone nuestro principio del html el titulo y los estilos
        public static function inicio_html($titulo, $estilos) { ?>
            <!DOCTYPE html>
            <html lang='es'>
                <head>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width;initial-scale=1'>
            <?php
                    foreach( $estilos as $estilo) {
                        echo "\t\t<link rel='stylesheet' type='text/css' href='$estilo'>\n";
                    }
            ?>
                    
                    <title><?=$titulo?></title>
                </head>
                <body>
            <?php
        }
        
        // Funcion que pone fin al html
        public static function fin_html() {?>
                </body>
            </html> 
        <?php
        }
    }
?>