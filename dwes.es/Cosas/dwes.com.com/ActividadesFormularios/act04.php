<?php
/*
Relación de actividades: 04 Actividades - Proceso de formularios con PHP.pdf
Actividad: 4.- Configuración del presupuesto de un coche
*/

require_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");

$modelos = ["mo"        => Array( 'nombre' => "Monroy", 'precio' => 20000),
            "mu"        => Array( 'nombre' => "Muchopami", 'precio' => 21000),
            "za"        => Array( 'nombre' => "Zapatoveloz", 'precio' => 22000),
            "gu"        => Array( 'nombre' => "Guperino", 'precio' => 25500),
            "al"        => Array( 'nombre' => "Alomejor", 'precio' => 29750),
            "te"        => Array( 'nombre' => "Telapegas", 'precio' => 32550)
];

$motores = ["ga"        => Array('nombre' => 'Gasolina', 'precio' => 0),
            "di"        => Array('nombre' => 'Diesel', 'precio' => 2000),
            "hi"        => Array('nombre' => 'Híbrido', 'precio' => 5000),
            "el"        => Array('nombre' => 'Eléctrico', 'precio' => 10000)
];

$colores = ["gt"       => Array('nombre' => 'Gris triste', 'precio' => 0),
            "rs"       => Array('nombre' => 'Rojo sangre', 'precio' => 250),
            "rp"       => Array('nombre' => 'Rojo pasión', 'precio' => 150),
            "an"       => Array('nombre' => 'Azul noche', 'precio' => 175),
            "ca"       => Array('nombre' => 'Caramelo', 'precio' => 300),
            "ma"       => Array('nombre' => 'Mango', 'precio' => 275),
];

$extras = ["na"         => Array('nombre' => 'Navegador GPS', 'precio' => 500),
           "ca"         => Array('nombre' => 'Calefacción asientos', 'precio' => 250),
           "ti"         => Array('nombre' => 'Antena aleta tiburón', 'precio' => 50),
           "sl"         => Array('nombre' => 'Acceso y arranque sin llave', 'precio' => 150),
           "ap"         => Array('nombre' => 'Arranque en pendiente', 'precio' => 200),
           "ci"         => Array('nombre' => 'Cargador inalámbrico', 'precio' => 300),
           "cc"         => Array('nombre' => 'Control de crucero', 'precio' => 500),
           "am"         => Array('nombre' => 'Detector ángulo muerto', 'precio' => 350),
           "fl"         => Array('nombre' => 'Faros led automáticos', 'precio' => 400),
           "fe"         => Array('nombre' => 'Frenada de emergencia', 'precio' => 375)
];

$forma_pago = ["co"         => Array('nombre' => 'Contado', 'meses' => 0),
               "2a"         => Array('nombre' => 'Financiado 2 años', 'meses' => 24),
               "5a"         => Array('nombre' => 'Financiado 5 años', 'meses' => 60),
               "10a"         => Array('nombre' => 'Financiado 10 años', 'meses' => 120)
];


inicio_html("Configuración de un coche nuevo", ["/estilos/formulario.css", "/estilos/general.css", "/estilos/tabla.css"]);

// En la petición POST estamos recibiendo el formulario con los datos, supuestamente.
if( $_SERVER['REQUEST_METHOD'] == "POST") {

    // Para verificar que se han recibido los datos del formulario.
    // Añade un plus de seguridad para garantizar que se ha enviado un formulario
    if( !isset($_POST['operacion']) ) {
        echo "<h3>No se han enviado los datos correctos</h3>";
        fin_html();

        // Función exit(). Termina la ejecución del script y solo 
        // se envía la salida generada hasta ahora.
        exit();     

    }

    /* Si el flujo de control ha llegado a este punto
       Es que tenemos los datos del formulario y
       podemos procesarlo para calcular el presupuesto del coche.

      Saneamiento y validación de datos:
      ----------------------------------
        - Nombre: Se quitan caracteres especiales HTML y se acepta cualquier cadena.
        - Teléfono: Se quitan caracteres que no sean números y se valida que sea entero.
        - Email: Se quitan caracteres no admisibles una dirección y se valida que sea email.
        - Modelo: Se quitan caracteres especiales HTML y se comprueba que el valor es clave en el
          array de modelos.
        - Motor: Se quitan caracteres especiales HTML y se comprueba que el valor es clave en el
          array de motores.
        - Pintura: Se quitan caracteres especiales HTML y se comprueba que el valor es clave en el
          array de colores.
        - Extras: Se quitan caracteres especiales HTML en cada elemento del array, y se comprueba 
          que cada valor del array es clave en el array de extras.
        - Forma de pago: Se quitan caracteres especiales HTML y se comprueba que el valor es clave en el
          array de forma_pago.
        
                 
    */

    $filtros_saneamiento = ['nombre'     => FILTER_SANITIZE_SPECIAL_CHARS,
                            'tlf'        => FILTER_SANITIZE_NUMBER_INT,
                            'email'      => FILTER_SANITIZE_EMAIL,
                            'modelo'     => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                            'motor'      => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                            'pintura'    => FILTER_SANITIZE_SPECIAL_CHARS,
                            'extras'     => Array ('filter'  => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                                                   'flags' => FILTER_REQUIRE_ARRAY),
                            'fp'         => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                        ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtros_saneamiento);

    $datos_validados['nombre'] = filter_var($datos_saneados['nombre'], FILTER_DEFAULT);
    $datos_validados['tlf'] = filter_var($datos_saneados['tlf'], FILTER_VALIDATE_INT);
    $datos_validados['email'] = filter_var($datos_saneados['email'], FILTER_VALIDATE_EMAIL);
    $datos_validados['modelo'] = array_key_exists($datos_saneados['modelo'], $modelos) ? $datos_saneados['modelo'] : False;
    $datos_validados['motor'] = array_key_exists($datos_saneados['motor'], $motores) ? $datos_saneados['motor'] : False;
    $datos_validados['pintura'] = array_key_exists($datos_saneados['pintura'], $colores) ? $datos_saneados['pintura'] : False;

    // Todos los extras deben aparecer en el array de extras disponibles
    $extras_ok = True;
    foreach( $datos_saneados['extras'] as $extra ) {
        if( !array_key_exists($extra, $extras) ) {
            $extras_ok = False;
            break;
        }
    }
    $datos_validados['extras'] = $extras_ok ? $datos_saneados['extras'] : False;
    $datos_validados['fp'] = array_key_exists($datos_saneados['fp'], $forma_pago) ? $datos_saneados['fp'] : False;

    // Verificamos que todos los datos son OK antes de proceder a calcular el presupuesto
    $todo_ok = True;
    foreach( $datos_validados as $clave => $valor ) {
        if( ! $valor) {
            echo "<h4>El elemento $clave NO HA PASADO LA VALIDACIÓN</h4>";
            $todo_ok = False;
        }
    }
    if( ! $todo_ok ) {
        echo "<h3>Algún dato no ha pasado la validación vuelva a intentarlo</h3>";
        echo "<p><a href='{$_SERVER['PHP_SELF']}'>Volver al formulario de datos</a></p>";
        fin_html();
        exit();
    }

    // En este punto todos los datos son OK. Calculamos el precio total
    $total = 0;
    echo "<header>Resultado de la configuración del vehículo</header>";
    echo "<table><thead><tr><th>Elemento</th><th>Tipo</th><th>Precio</th></tr></thead>";
    echo "<tbody>";
    
    // Modelo
    echo "<tr><td>Modelo</td><td>" . $modelos[ $datos_validados['modelo']]['nombre'] . "</td>";
    echo "<td>{$modelos[ $datos_validados['modelo']]['precio']} €</td></tr>";
    $total += $modelos[ $datos_validados['modelo'] ]['precio'];

    // Motor
    echo "<tr><td>Motor</td><td>{$motores[ $datos_validados['motor']]['nombre']}</td>";
    echo "<td>{$motores[ $datos_validados['motor']]['precio']} €</td></tr>";
    $total += $motores[ $datos_validados['motor'] ]['precio'];

    // Pintura
    echo "<tr><td>Pintura</td><td>{$colores[ $datos_validados['pintura']]['nombre']}</td>";
    echo "<td>{$colores[ $datos_validados['pintura']]['precio']} €</td></tr>";
    $total += $colores[ $datos_validados['pintura'] ]['precio'];

    // Extras
    echo "<tr><td>Extras</td>";
    foreach( $datos_validados['extras'] as $extra ) {
        $extras_añadidos[] = $extras[ $extra]['nombre'];
        $precio_extras[] = $extras[$extra]['precio'] . " €";
        $total += $extras[ $extra ]['precio'];
    }
    echo "<td>" . implode("<br>", $extras_añadidos) . "</td>";
    echo "<td>" . implode("<br>", $precio_extras) . "</td>";

    echo "</tbody>";
    echo "</table>";
    
    echo "<h3>Precio total: " . number_format(floatval($total)) . " €</h3>";

    echo "<h4>Plan de pago</h4>";
    $meses = $forma_pago[ $datos_validados['fp'] ]['meses'];
    $descripcion = $forma_pago[ $datos_validados['fp'] ]['nombre'];
    if( $meses == 0 ) {
        // Pago al contado
        echo "<h3>El pago es contado</h3>";
    }
    else {
        $entrada = $cuota_final = $total * 0.25;
        $plazo = ($total - ($entrada + $cuota_final)) / $meses;
        echo "<h3>Entrada: " . number_format($entrada) . " €. Cuota final: " . number_format($cuota_final) .
             " €. $meses plazos a " . number_format($plazo) . " €</h3>";
    }

    echo "<p>¿Quiere <a href='{$_SERVER['PHP_SELF']}'>volver a configurar un coche?</a></p>";
}
else {
    // Hay una petición GET. Presentamos el formulario.
?>
    <!-- Página autogenerada. En el mismo script el formulario y la respuesta. -->
<header>Incluye los datos del coche de tus sueños</header>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
    <fieldset>
        <legend>Datos de configuración del coche</legend>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" size="40" required>

        <label for="tlf">Teléfono</label>
        <input type="tel" name="tlf" id="tlf" size="10" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" size="20" required>

        <label for="modelo">Modelo</label>
        <select name="modelo" id="modelo" size="1">
<?php
        foreach($modelos as $clave => $modelo) {
            echo "<option value='$clave'>{$modelo['nombre']} {$modelo['precio']} €</option>";
        }
?>
        </select>

        <label for="motor">Motor</label>
        <div>
<?php
        foreach($motores as $clave => $motor) {
            echo "<input type='radio' name='motor' value='$clave'>{$motor['nombre']} {$motor['precio']} €";
        }
?>
        </div>        

        <label for="pintura">Pintura</label>
        <select name="pintura" id="pintura" size="1">
<?php
        foreach($colores as $clave => $color) {
            echo "<option value='$clave'>{$color['nombre']} {$color['precio']} €</option>";
        }
?>
        </select>

        <label for="extras[]">Extras</label>
        <div>
<?php
        foreach($extras as $clave => $extra) {
            echo "<input type='checkbox' name='extras[]' value='$clave'>{$extra['nombre']} {$extra['precio']} €<br>";
        }
?>
        </div>        

        <label for="fp">Forma de pago</label>
        <div>
<?php
        foreach($forma_pago as $clave => $fp) {
            echo "<input type='radio' name='fp' value='$clave'>{$fp['nombre']}";
        }
?>
        </div>        

    </fieldset>
    <input type="submit" name="operacion" id="operacion" value="Calcular presupuesto">
</form>

<?php
}
fin_html();
?>