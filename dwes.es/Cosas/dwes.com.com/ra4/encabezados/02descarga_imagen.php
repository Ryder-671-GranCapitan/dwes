<?php
  $imagen = filter_input(INPUT_GET, 'imagen', FILTER_SANITIZE_NUMBER_INT);

  $imagen_validada = filter_var($imagen, FILTER_VALIDATE_INT);

  switch( $imagen ){
    case 1: {
      $archivo = "/Applications/XAMPP/xamppfiles/htdocs/adrian-dwes/dwes.com.com/ra4/imagenes/architecture.png";
      if( file_exists($archivo)){
        $tipo_mime = mime_content_type($archivo);
        header("Content-type: $tipo_mime");
        readfile($archivo);
      }
      break;
    }
    case 2: {
      $archivo = "/Applications/XAMPP/xamppfiles/htdocs/adrian-dwes/dwes.com.com/ra4/imagenes/chord.png";
      if( file_exists($archivo)){
        $tipo_mime = mime_content_type($archivo);
        header("Content-type: $tipo_mime");
        readfile($archivo);
      }
      break;
    }
  }
?>