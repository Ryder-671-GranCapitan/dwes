<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  require_once($_SERVER['DOCUMENT_ROOT'] . "/adrian-dwes/dwes.com.com/includes/funciones.php");

  if ($_SERVER['REQUEST_METHOD'] == "GET"){
    inicio_html("Redirecciones", ["/estilos/general.css", "/estilos/bh.css"]);
    ?>
    <header>Opciones de la aplicacion</header>
    <form method="POST" action="">
      <div>
        <button type="submit" name="operacion" value="1">Ver el catalogo</button>
        <button type="submit" name="operacion" value="2">Venta online</button>
        <button type="submit" name="operacion" value="3">Quienes somos</button>
        <button type="submit" name="operacion" value="4">Contacto</button>
      </div>
    </form>
    <?php
    fin_html();
  } elseif ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['operacion'])) {
      $operacion = filter_input(INPUT_POST, 'operacion', FILTER_SANITIZE_NUMBER_INT);
      $protocolo = $_SERVER['SERVER_PROTOCOL'];

      switch(intval($operacion)){
        case 1: {
          header("$protocolo 301 Moved Permanently");
          header("Location: /adrian-dwes/dwes.com.com/ra4/redireccion/catalogo.php");
          break;
        }
        case 2: {
          header("$protocolo 301 Moved Permanently");
          header("Location: /adrian-dwes/dwes.com.com/ra4/redireccion/venta_online.php");
          break;
        }
        default: {
          header("$protocolo 404 Not Found");
        }
      }
    }
  }

?>
