<?php
  /* 
  GESTION DE LA CACHE DEL NAVEGADOR CON CABECERAS

  El servidor puede comunicar al navegador si puede o no cachear el recurso
  solicitado y durante cuanto tiempo.

  Cabeceras que intervienen:
    - Expires: <fecha - hora> -> Indica fecha y hora en que se considera el recurso reciente.</fecha - hora >

    - Cache-control: <valores> -> Conjunto de valores que controlan la cache de una respuesta. 
                    Tiene precedencia sobre Expires.</valores>

                    no-cache -> Cachea la pagina, pero antes de mostrarla al usuario tiene que pedir validacion al servidor.
                    
                    no-store -> No se puede guardar la pagina en cache

                    max-age: <segundos> -> Tiempo durante el cual el recurso se considera reciente.</segundos>

                    must-revalidate -> El navegador valida la pagina en el servidor si se ha superado el max-age

                    private | public -> Si es privada, solamente la puede cachear el navegador.
                                        Si es pulica la puede cachear navegador y dispositivos
                                        intermedios (proxy)


  */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  $ahora = time();
  $dentro_de_una_hora = $ahora + 60 * 60;
  $formato_fecha = "%a:%d:%b:%Y:%H:%M:%S GMT";
  $caducidad = gmstrftime($formato_fecha, time() + 60 * 60);

  header("Expires: $caducidad");
  header("Cache-control: no-cache,must-revalidate,max-age: 3600");

  // Evitar que el navegador cachee las respuestas.
  $caducidad = gmdate("D, d M Y H:i:s") . "GMT"; // Devuelve fecha y hora actual en formato GMT.
  header("Expire: $caducidad");
  header("Last Modified: $caducidad");
  header("Cache-Control: no-store, no-cache, must-revalidate, private, max-age=0");

  require_once($_SERVER['DOCUMENT_ROOT'] . "/dwes.com.com/includes/funciones.php");

  inicio_html("Cache del navegador", ["/estilos/general.css"]);

  echo "<header>Probando la cache del navegador</header>";
  echo "<h1>Este cambio lo hace mientras que la pagina esta disponible</h1>";

  fin_html();

?>