<?php

/* Funciones en PHP

  Conjunto de sentencias con un nombre asociado
  que se ejecutan a discreción del desarrollador,
  cuando es necesario.

  Invocación o llamada de la función: Sentencia que solicita
  la ejecución de la función, momento en el cual el flujo del programa se desvía a la primera sentencia de la función 
  y comienza su ejecucion.

  Las funciones pueden necesitar datos. Estos datos se les pasa en forma de parámetros o argumentos de la funcióin
  en el momento de la invocación.

  Pueden devolver uno o varios valores al punto de invocación
  que puede posteriormente utilizarse en cualquier expresion.

  Tipos:
  - Internas integradas o predefinidas -> Las propias del lengguaje.
  - Métodos -> funciones de clases de objetos.
  - De usuario -< Las que el desarrollador define.

  3.1 Definición de la función

  - Se puede definir en cualquier parte del script.
  - Tiene una cabecera y un cuerpo
  - Sintaxis:
      function nombre_función( [arg1, arg2, ...]){
        sentencias
      }
        - Nombre: cualquier identificador válido sin $.
        - Lista de parámetros o argumento separados por coma.
        - El cuerpo de la función es el conjunto de sentencias entre {}
*/

function area_triangulo($base, $altura) {
  $area = $base * $altura / 2;
  return $area;
}

function area_triangulo2($base, $altura){
  echo "Dentro de la función: {$base} y {$altura}<br>";

  $area = $base * $altura;

  $base = 10;
  $altura = 20;

  echo "Dentro de la función: {$base} y {$altura}<br>";

  return $area;
}

function area_rectangulo(float $base, float $altura) {
  return $base * $altura;
}

function media_aritmetica(...$numeros){
  $suma = 0;
  foreach( $numeros as $numero ){
    $suma += $numero;
  }

  return $suma / count($numeros);
}

function circulo_y_circunferencia($radio): array {
  $PI = 3.1416;

  $resultado[] = $circulo =  $PI * $radio ** 2;
  $resultado[] = $circunferencia = 2 * $PI * $radio;

  return $resultado;
}

function area_rectagulo2($base, $altura): ?float {
  $area = 0;
  $base < 0 || $altura < 0 ?
    $area == null:    
    $area = $base * $altura;

  return $area;
}

function suma(){
  $resultado = $a + $b;
  return $resultado;
}

function contador_ejecuciones(){
  static $numero_ejecuciones = 0;
  ++$numero_ejecuciones;

  echo "Número de ejecuciones: $numero_ejecuciones<br>";
}

function factorial($numero){
  if ( $numero == 1) 
    $factorial = 1; 
  else if($numero == 2)
      $factorial = 2;
  else
    $factorial = $numero * factorial($numero -1);
  
  return $factorial;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Funciones</title>
</head>
<body>
  <?php

    $base = 8;
    $altura = 3;

    $area = area_triangulo($base, $altura);

    // Invocación de la función.
    echo "El triangulo de base {$base} y altura {$altura} tiene como area {$area}<br>";

    // Paso por valor
    $area = area_triangulo2($base, $altura);
    echo "El triángulo con base {$base} y altura {$altura} tiene como area {$area}<br>";

    // Tipos de datos en los parámetros.
    $area = area_rectangulo(3, 2);
    echo "El área el rectángulo es $area<br>";

    // Calculamos la media con ...args.
    $media = media_aritmetica(6,8,7,9,3,2,5,6,4,7,6);
    echo "La media aritmética del alumno es $media<br>";

    // Devolución de más de un valor
    $circulo_y_circunferencia = circulo_y_circunferencia(5);
    echo "El área del círculo con radio 5 es {$circulo_y_circunferencia[0]} y la 
    longitud de la circunferencia es {$circulo_y_circunferencia[1]}<br>";

    // Devolución de un valor nulo.
    $valor_nulo = area_rectagulo2(2, 9);
    echo ($valor_nulo ? "El area es $valor_nulo" : "El valor del area del rectangulo es un valor nulo");

    // Ámbito y visibilidad de las variables.
    $a = 3;
    $b = 8;
    $resultado = suma();
    echo "El valor de a es $a, el valor de b es $b y el resultado es $resultado -<br>";

    contador_ejecuciones();
    contador_ejecuciones();
    contador_ejecuciones();
    contador_ejecuciones();
    contador_ejecuciones();

    // Función recursiva.
    $factor = factorial(8);
    echo "El factorial de 8 es $factor<br>";
    

  ?>
</body>
</html>