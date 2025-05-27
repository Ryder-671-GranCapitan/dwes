<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
  COOKIES
  -------
  - Dato que el servidor almacena en el HD del cliente.
  - Cualquier informacion alfanumerica de hasta 4KB.
  - Usos:
    - Seguimiento de la sesion.
    - Mantener datos entre peticiones.
    - Detalles de inicio de sesion: usuario (ya no, salvo que este cifrado)
  - Solo se puede leer desde el dominio del servidor que las creo, asi otros
    servidores no tiene acceso.

  - Cookies de 3os. -> Coockies que establece un sitio (servidor) web diferente
    al que se hizo la peticion.

  - Funcionamiento:

    Cliente                                           Servidor
    -------------------------------------             ----------------------------------------
    GET /index.html HTTP/1.1                      ->    HTTP/1.1 200 Ok
                                                      Encabezados (Cahce-control, Content-type,...)
                                                      Set-Cookie: nombre=valor
                                                      Set-Cookie: nombre=valor

                                                      <html>
                                                        ...
                                                      </html>

    GET /news.html HTTP/1.1
    Host: dwes.com
    Cookie = name=valor (la misma que recibio)... ->
*/

  // Ejemplo de uso de cookies: Preferencias de usuario

  require_once($_SERVER['DOCUMENT_ROOT'] . "/adrian-dwes/dwes.com.com/includes/funciones.php");

  $colores_validos = ["white" => "Blanco",
                      "black" => "Negro",
                      "red"   => "Rojo",
                      "blue"  => "Rosa",
                      "yellow"=> "Amarillo",
                      "brown" => "Marron",
                      "pink"  => "Rosa", 
                      "green" => "verde"];
   
  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (isset($_COOKIE['color_fondo']) && isset($_COOKIE['color_texto'])){
      $color_fondo = filter_input(INPUT_COOKIE, 'color_fondo', FILTER_SANITIZE_SPECIAL_CHARS);
      $color_texto = filter_input(INPUT_COOKIE, 'color_texto', FILTER_SANITIZE_SPECIAL_CHARS);

      if (!array_key_exists($color_fondo) || !array_key_exists($color_texto)){
        $color_fondo = "white";
        $color_texto = "black";
      }
    
    } else {
      $color_fondo = "white";
      $color_texto = "black";
    }
    inicio_html("Cookies", ["/estilos/general.css"]);
    echo "<div style='background-color:$color_fondo;color:$color_texto'>";
    echo "<header>Gestion de cookies</header>";
    echo <<<FORMULARIO1
      <form method="POST" action="{$_SERVER['PHP_SELF']}">
        <fieldset>
          <legend>Selecciona los colores que quieras</legend>
          <label for='color_fondo'>Color de fondo</label>
          <select name='color_fondo' size='1'>
    FORMULARIO1;
    foreach ($colores_validos as $clave => $valor) {
      echo "<option value='$clave'" . ($clave == $color_fondo ? "selected" : "") . ">$valor</option>";
    }
    echo <<<FORMULARIO2
      </select>
      <label for='color_fondo'>Color de texto</label>
          <select name='color_texto' size='1'>
    FORMULARIO2;
    foreach( $colores_validos as $clave => $valor) {
      echo "<option value ='$clave'" . ($clave == $color_texto ? "selected" : "") . ">$valor</option>";
    }
    echo <<<FORMULARIO3
          </select>
        </fieldset>
        <input type="submit" name='enviar' value="cambiar colores">
      </form>
      
    FORMULARIO3;
    echo "</div>";
  }
  elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ( isset($_POST['color_fondo']) && isset($_POST['color_texto'])){
      $color_fondo = filter_input(INPUT_POST, 'color_fondo', FILTER_SANITIZE_SPECIAL_CHARS);
      $color_texto = filter_input(INPUT_POST, 'color_texto', FILTER_SANITIZE_SPECIAL_CHARS);
      if ( array_key_exists($color_fondo, $colores_validos) && array_key_exists($color_texto, $colores_validos)){
        setcookie("color_fondo", $color_fondo, (time() + 60 * 60), "/adrian-dwes/dwes.com.com/ra4/cookies");
      }
    }
  }
?>