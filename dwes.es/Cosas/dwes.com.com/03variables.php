<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tipos de datos</title>
    </head>
    <body>

        <h1>Variables: 03variables</h1>
        <?php
        // Las variables se definen con $identificador
        $nombre_variable = "Valor de la variable";

        // Variables que no se han definido
        $resultado = $numero + 25;
        echo "El valor de numero es $numero y el resultado es $resultado<br>";

        $resultado = $sin_definir + 5.5;
        echo "El valor de sin definir es $sin_definir y el resultado es $resultdado<br>"

        // Si la variable está en un contexto lógico su valor
        // lógico asume por defecto False


        ?>

        <h2>Análisis de variables</h2>
        <h3>Análisis simple</h3>
        <?php
            // Consiste en introducir una variable en una cadena con " o heredoc
            // para incrustar su valor dentro de la cadena.
            echo "El resutado es $resultado<br>"

        ?>

        <h3>Análisis complejo</h3>
        <?php
            // En algunas situaciones noso encontramos ambigüedad en
            // una variable interpolada. Para ello usamos las llaves
            // y se elimina la ambigüedad.
            $calle = "Trafalgar Sq";
            $numero = 5;
            $poblacion = "London";
            $distrito = "5000";

            echo "Mi dirección en Londres es:<br> {$numero}th, $calle<br>$poblacion<br>$distrito<br>";
        ?>

        <h2>Funciones para variables</h2>
        <?php
            // Función gettype()
            echo "El tipo de datos de $resultado es " . gettype($resultado) . "<br>";
            echo "El tipo de datos de una expresión es " . gettype($numero) . "<br>";

            // Función empty()
            /*
             Comprueba si una variable tiene un valor 
             - Si es entero devuelve True si es 0, False en caso contrario.
             - Si es float devuelve True si es 0.0, False en caso contrario.
             - Si es cadena devuelve True si es "", False en caso contrario.
             - Devuelve True si es NULL o False.
            */
            if( empty($numero) ) echo "\$numero tiene el valor $numero<br>";
            else echo "\$numero tiene un valor no vacío<br>";

            $numero = NULL;
            if( empty($numero) ) $numero = 10;
            else echo "\$numero ya tiene un valor asignado y es $numero<br>";

            // Función isset()
            // Devuelve True si la variable está definida y no es NULL
            if( isset($nueva_variable)) echo "La variable está definida y su valor es $nueva_variable<br>";
            else echo "La variabe no está definida<br>";

            $variable_null = NULL;
            if( isset($variable_null)) echo "La variable está definida y su valor es $variable_null<br>";
            else echo "La variabe no está definida<br>";

            /*
            Funciones que comprueban los tipos de datos:

                - is_bool() -> True si la expresión es booleana
                - is_int() -> True si la expresión es integer
                - is_float() -> True si lal expresión es float
                - is_string() -> True si la expresión es una cadena
                - is_array() -> True si la expresión es un array

                En cualquier otro caso, develve false.
            */

            $edad = 25;
            $mayor_edad = $edad > 18;
            $numero_e = 2.71;
            $mensaje = "El número e es " . $numero_e . "<br>";

            if( is_int($edad) ) echo "\$numero es un entero<br>";
            if( is_bool($mayor_edad) ) echo "\$mayor_edad es un boolean<br>";
            if( is_float($numero_e) ) echo "\$numero_e es un float<br>";
            if( is_string($mensaje) ) echo "\$mensaje es un string<br>";
        

        ?>

        <h2>Constantes</h2>
        <p>Una constante es un valor con nombre que no puede cambiar de valor en el programa, se le asigna un valor en la declaracióny permanece invariable.
            Se definen de dos formas:<br>
            - Mediante la funcion define()<br>
            - Mediante la palabra clave const
        </p>
        <?php
            define("PI", 3.1416);
            define("PRECIO_BASE", 1500);
            define("DIRECTORIO_SUBIDAS", "/uploads/archivos");

            echo "El número pi es " . PI . "<br>";
            $area_circulo = PI * PI * 5;
            echo "El área del círculo de radio 5 es $area_circulo<br>";

            $path_archivo = DIRECTORIO_SUBIDAS . "/archivo.pdf";
            echo "El archivo subido es $path_archivo<br>";

            $precio_rebajado = PRECIO_BASE - PRECIO_BASE * 0.25;
            echo "El precio rebajado es $precio_rebajado<br>";

            const SESION_USUARIO = 600;
            echo "La sesión de usuario finaliza en " . SESION_USUARIO . " segundos<br>";

            // Constantes predefinidas por PHP
            echo "El script es " . __FILE__ . " y la línea es " . __LINE__ ."<br>";

        ?>

        <h2>Expresiones, operadores y operandos</h2>
        <p>Una expresión es una combinación de operandos y operadores que arroja un
          resultado. Tiene tipos de datos, que depende del tipo de datos de sus
          operandos y de la operación realizada.<br>
          Un operador es un símbolo formado por uno, dos o tres caracteres que date_interval_formatuna operación.<br>
          Los operadores pueden ser:<bt>
            - Unarios. Solo necesitan un operando.
            - Binarios. Utilizan dos operandos.
            - Ternarios. Utilizan tres operandos.
          Un operando es una expresión en sí misma, siendo la más simple un literal o una variable, pero tambiñen puede ser un valor devuelto por una función o
          la precedencia y asociatividad de los operadores. Esta puede alterar a
          conveniencia.
        </p>
        <h2>Operadores</h2>

        <h3>Asignación</h3>
        <?php
          // El operador de asignación es = 
          $numero = 45;
          $resultado = $numero + 5 - 29;
          $sin_valor = NULL;


        ?>

        <h3>Operadores aritméticos</h3>
        <?php
          /*
            + Suma
            - Resta
            * Multiplicación
            / División
            % Módulo
            ** Exponenciación

            Unarios
            + Conversión a entero
            - El opuesto
          */
          $numero1 = 15;
          $numero2 = 18;
          $suma = $numero1 + 10;
          $resta = 25 - $numero2;
          $opuesto = -$numero1;
          $multiplicacion = $numero1 * 3;
          $division = $numero2 /3;
          $modulo = $numero1 % 4;
          $potencia = $numero1 ** 2;
          echo "Suma: $suma<br>";
          echo "Resta: $resta<br>";
          echo "Opuesto: $opuesto<br>";
          echo "Multiplicación: $multiplicacion<br>";
          echo "Divisón: $division<br>";
          echo "Módulo: $modulo<br>";
          echo "Potencia: $potencia<br>";

          $numero3 = "35";
          $numero4 = +$numero3;
          echo "El \$numero4 y su tipo es " . gettype($numero4) . "<br>";

          // No lo hace con float
          $numero5 = PI;
          $numero6 = +$numero5;
          echo "El \$numero6 es $numero6 y su tipo es " . gettype($numero6) . "<br>";
          ?>

          <h2>Operadores de asignación aumentada</h2>
          <?php
          /* Operadores de asignación aumentada
          ++ Incremento
          -- Decremento
          +=
          -=
          *=
          /=
          %=
          */

          $numero = 4;
          $numero++;  // Equivalente a $numero = $numero + 1;
          echo "Antes número era 4 ahora es $numero<br>";
          ++$numero;
          echo "Antes número era 5 ahora es $numero<br>";

          $numero = 10;
          $resultado = $numero++ * 2; // Equivale a $resultado= $numero * 2; $numero = $numero +1;
          echo "El resultado es $resultado y el número es $numero<br>";

          $numero = 10;
          $resultado = ++$numero * 2; // Equivale a $numero = $numero +1; resultado = $numero * 2;
          echo "El resultado es $resultado y el número es $numero<br>";

          $numero+=5; // Equivale a $numero = $numero + 5;
          echo "El número es $numero<br>";
          $numero-=3; // Equivale a $numero = $numero - 3;
          echo "El número es $numero<br>";
          $numero*=3; // Equivale a $numero = $numero * 3;
          echo "El número es $numero<br>";
          $numero%=7; // Equivale a $numero = $numero % 7;
          echo "El número es $numero<br>";
          $numero/=5; // Equivale a $numero = $numero / 5;
          echo "El número es $numero<br>";

          ?>

          <h2>Operadores relacionales</h2>
          <?php
            /*
              == Igual a
              === Idéntico a
              != Distinto
              !== Distinto valor o distinto tipo
              > Mayor que
              < Menor que
              >= Mayor o igual que
              <= Menor o igual que
              <=> Nave espacial
            */
            $n1 = 5;
            $cadena = "5";
            $n2 = 8;

            $resultado = $n1 == $n2;
            echo "Es n1 igual que n2: " . (int)$resultado . "<br>";
            $resultado = $n1 == $cadena;
            echo "Es n1 igual que cadena: " . (int)$resultado . "<br>";
            $resultado = $n1 === $cadena;
            echo "Es n1 idéntico que cadena: " . (int)$resultado . "<br>";

            $resultado = $n1 != $n2;
            echo "Es n1 distinto de n2: " . (int)$resultado . "<br>";

            $resultado = $n1 != $cadena;
            echo "Es n1 distinto que cadena: " . (int)$resultado . "<br>";
            $resultado = $n1 !== $cadena;
            echo "Es n1 distinto que cadena: " . (int)$resultado . "<br>";

            $resultado = $n1 <=> $n2;
            echo "Es n1 menor, igual o mayor que n2: " . (int)$resultado . "<br>";

            $nombre1 = "Zacarias";
            $nombre2 = "adela";
            $resultado = $nombre1 > $nombre2;
            echo "Es nombre1 mayor que nombre2: " . (int)$resultado;

            
          ?>

          <h2>Operadores lógicos</h2>
          <?php
            // AND lógico o conjunción lógica
            // OR Or lógico o disyunción lógica
            // XOR Or exclusivo
            // ! Not
            // && And lógico
            // || Or lógico

            $n1 = 9;
            $n2 = 5;
            $n3 = 10;
            $resultado = $n1 == $n2 OR $n2 > $n3;
            $resultado = $n1 == $n2 AND $n2 < $n3;

            echo "El resultado es: " . (int)$resultado . "<br>";

            $resultado = $n1 == 9 OR $n2 < $n1 AND $n3 > 10;
            echo "El resultado es: " . (int)$resultado . "<br>";

            $resultado = $n1 == 9 || $n2 < $n1 AND $n3 > 10;
            echo "El resultado es: " . (int)$resultado . "<br>";

            $resultado = $n1 + 5 / $n3 < $n1 ** 3 AND $n3 /5 + $n2 * 2 >= $n1 * $n2 / $n3 OR $n1 - 3 % 2 == $n3 - 7;

            
          ?>

          <h2>Estructuras de control anidadas/compuestas</h2>
          <?php
            $n1 = 9;
            $n2 = 5;
            $n3 = 10;
            if ( ($n1 == 9 OR $n2 < $n1) AND $n3 >10) {
              echo "El resultado global es True<br>";
            } else {
              echo "El resultado global es False<br>";
            }

            $nota = 4;

            if ( $nota >= 0 || $nota > 5 ){
              echo "Suspenso";
            } elseif ( $nota < 6 ) {
              echo "Aprobado";
            } elseif ( $nota < 7 ) {
              echo "Bien";
            } elseif ( $nota < 9 ){
              echo "Notable";
            } elseif ( $nota <= 10 ){
              echo "Sobresaliente";
            } else{
              echo "La nota no es correcta";
            }
            echo "<br>";

            // Estructura condicional múltiples switch
            $nota = 7;
            switch( $nota ){
              case 1: 
              case 2: 
              case 3: 
              case 4: {
                echo "Suspenso";
                break;
              }
              case 5: 
              case 6: 
              case 7: 
              case 8: 
              case 9: 
              case 10:{
                echo "Aprobado";
                break;
              }
              default:{
                echo "Nota no válida";
              }
            }

            echo "<br>";

            // Expresión match
            $calificacion = match ($nota) {
              0,1,2,3,4 => "Suspenso",
              5         => "Aprobado",
              6         => "Bien",
              7,8       => "Notable",
              9, 10     => "Sobresaliente",
              default   => "Nota errónea"
            };

            echo "Con tu nota $nota, tienes una calificación $calificacion";
            echo "<br>";
            
          ?>

          <h2>Operador ternario</h2>
          <?php
            // Sintaxis:
            // <condición> ? <expresión_true> : <expresión_false>;

            $nota = 6;
            $resultado = $nota >= 5 ? "Estás aprobado" : "Estás suspenso";
            echo "$resultado <br>";
          ?>

          <h2>Bucles</h2>
          <ul>
            <li>For con contador (estilo Java y C++)</li>
            <li>For para colecciones de datos</li>
            <li>While</li>
            <li>Do...while</li>
            <li>Sentencias break y continue</li>
          <ul>
          <h3>Bucle for con contadores (estilo Java y C++)</h3>
          <?php
          $numero = 4;
            for ($contador = 0; $contador < 10; $contador++){
              echo "Número: $numero * $contador = " . $numero*$contador . "<br>";
            }
            $contador = 0;
          ?>
          <h3>Bucle for para colecciones de datos</h3>
          <?php
          ?>
          <h3>While</h3>
          <?php
            while($contador < 10){
              echo "Número: $numero * $contador = " . $numero*$contador . "<br>";;
              $contador++;
            }
            $contador = 0;
          ?>
          <h3>Do...while</h3>
          <?php
            do{
              echo "Número: $numero * $contador = " . $numero*$contador . "<br>";
              $contador++;
            }while($contador < 10);
            $contador = 0;
          ?>

          <?php
            // Generar 200 números aleatorios entre 1 y 1000.
            // Por cada número se comprueba cuántos números primos
            // hay desde 1 hasta ese número.
            // Si hay más de 10 números primos que termine.
            // Al final visuallizar cada número generado y los primos haste ese número.

            for ($i = 0; i < 200; $i++){
              $numero_random = rand(1, 1000);
              echo "El número generado es: $numero_random <br>";
              for ($j = 1; $j < $numero_random; $j++){
                // Averiguar si $j es primo.
                $es_primo = true;
                $raiz_cuadrada = sqrt($j);
                $k = 2;
                while($es_primo && $k < $raiz_cuadrada){
                  if ($j % $k == 0) $es_primo = false;
                  $k++;
                }
                if ($es_primo){
                  
                }
              }
            }
          ?>

          <h3>Sintaxis alternativa a la estructuras de control</h3>
          <?php
          $numero = rand(1,100);
          if( $numero % 2 == 0 ):
              echo "El número $numero es par<br>";
          else:
              echo "El número $numero es impar<br>";
          endif;

        
          ?>

    </body>
</html>