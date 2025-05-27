<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    <?php
    /*
    1.- Escribir un script PHP que genera un vector de 10 elementos numéricos entre 1 y 100,
    y posteriormente los visualice por consola.
    */

    echo "<h1>Ejercicio 1</h1><br>";
    $vector = Array();
    $interruptor = true;
    while ($interruptor){
      for($i=0; $i < 10; $i++){
        $numRand = rand(1, 100);
        $vector[] = $numRand;
        echo "Elemento $i creado en el array con el número $numRand<br>";
      };
      echo "fin for<br>";
      $interruptor = false;
    }
    echo 'fin while<br>';
    ?>
  </body>
</html>


