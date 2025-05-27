<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejercicio 2</title>
</head>
<body>
  <?php
    /*
      Escribir un script PHP que genera un vector con las notas de 10 alumnos y al final
      tiene que mostrar por pantalla cuantos han suspendido, cuantos han aprobado y la
      nota media.
    */
    echo "<h2>Ejercicio 2</h2><br>";
    
    $notas = Array();
    $interruptor = true;
    while ($interruptor){
      for($i=0; $i < 10; $i++){
        $numRand = rand(1, 10);
        $notas[] = $numRand;
        echo "Elemento $i creado en el array con el número $numRand y tiene <br>";
      };
      echo "fin for<br>";
      $interruptor = false;
    }
    
    echo 'fin while<br>';

    foreach( $notas as $notasAlumnos ){
      echo "El alumno tiene un $notasAlumnos y está " . ($notasAlumnos < 5 ? 'suspenso' : 'aprobado') . ".<br>";
    }

  ?>
</body>
</html>