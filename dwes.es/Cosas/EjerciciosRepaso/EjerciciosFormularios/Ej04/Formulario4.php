<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/EjerciciosFormularios/Ej04/includes/funciones.php");

$modelos = [
    'mo' => ['nombre' => "Monroy", 'precio' => 20000],
    'mu' => ['nombre' => "Muchopami", 'precio' => 21000],
    'za' => ['nombre' => "Zapatoveloz", 'precio' => 22000],
    'gu' => ['nombre' => "Guperino", 'precio' => 25500],
    'al' => ['nombre' => "Alomejor", 'precio' => 29750],
    'te' => ['nombre' => "Telapegas", 'precio' => 32550]
];

$motores = [
    'ga' => ['nombre' => 'Gasolina', 'precio' => 0],
    'di' => ['nombre' => 'Diesel', 'precio' => 2000],
    'hi' => ['nombre' => 'Híbrido', 'precio' => 5000],
    'el' => ['nombre' => 'Eléctrico', 'precio' => 10000]
];

$colores = [
    'gt' => ['nombre' => 'Gris triste', 'precio' => 0],
    'rs' => ['nombre' => 'Rojo sangre', 'precio' => 250],
    'rp' => ['nombre' => 'Rojo pasión', 'precio' => 150],
    'an' => ['nombre' => 'Azul noche', 'precio' => 175],
    'ca' => ['nombre' => 'Caramelo', 'precio' => 300],
    'ma' => ['nombre' => 'Mango', 'precio' => 275]
];

$extras = [
    'na' => ['nombre' => 'Navegador GPS', 'precio' => 500],
    'ca' => ['nombre' => 'Calefacción asientos', 'precio' => 250],
    'ti' => ['nombre' => 'Antena aleta tiburón', 'precio' => 50],
    'sl' => ['nombre' => 'Acceso y arranque sin llave', 'precio' => 150],
    'ap' => ['nombre' => 'Arranque en pendiente', 'precio' => 200],
    'ci' => ['nombre' => 'Cargador inalámbrico', 'precio' => 300],
    'cc' => ['nombre' => 'Control de crucero', 'precio' => 500],
    'am' => ['nombre' => 'Detector ángulo muerto', 'precio' => 350],
    'fl' => ['nombre' => 'Faros led automáticos', 'precio' => 400],
    'fe' => ['nombre' => 'Frenada de emergencia', 'precio' => 375]
];

$forma_pago = [
    'co' => ['nombre' => 'Contado', 'meses' => 0],
    '2a' => ['nombre' => 'Financiado 2 años', 'meses' => 24],
    '5a' => ['nombre' => 'Financiado 5 años', 'meses' => 60],
    '10a' => ['nombre' => 'Financiado 10 años', 'meses' => 120]
];

// Gstionamos las pticiones
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    inicio_html("Cochesito Lere", ['./styles/formulario.css', './styles/general.css', './styles/tablas.css']);
    ?>
        <h1>Fokin Goku y Fokin Vegueta</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <fieldset>
                <legend>A vel manito que lo que tu quiere en tu carro</legend>

                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre">

                <label for="tel">Telefono</label>
                <input type="tel" name="tel" id="tel"> 

                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                <label for="modelo">Modelo</label>
                <select name="modelo" id="modelo" size="1">
                    <?php
                        foreach ($modelos as $modelo => $valor) { 
                            echo "<option value='$modelo'>{$valor['nombre']} - {$valor['precio']} €</option>";
                        }
                    ?>
                </select>

                <label for="motor">Motor:</label>
                <div>
                    <?php
                        foreach ($motores as $motor => $valor) {
                            echo "<input type='radio' name='motor' value='$motor'>{$valor['nombre']} - {$valor['precio']} €";
                        }
                    ?>
                </div>

                <label for="pintura">Pintura</label>
                <select name="pintura" id="pintura" size="1">
                    <?php
                        foreach ($colores as $color => $valor) {
                            echo "<option value='$color'>{$valor['nombre']} - {$valor['precio']} €</option>";
                        }
                    ?>
                </select>

                <label for="extras[]">Extras</label>
                <div>
                    <?php
                        foreach ($extras as $extra => $valor) {
                            echo "<input type='checkbox' name='extras[]' value='$extra'>{$valor['nombre']} - {$valor['precio']} € <br>";
                        }
                    ?>
                </div>

                <label for="fp">Forma Pago</label>
                <div>
                    <?php
                        foreach ($forma_pago as $forma => $valor) {
                            echo "<input type='radio' name='fp' value='$forma'>{$valor['nombre']}";
                        }
                    ?>
                </div>
            </fieldset>
            <input type="submit" name="operacion" id="operacion" value="Calcular">
        </form>
    <?php
fin_html();
}


elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Filtrado de datos
    inicio_html("Cochesito Lere", ['./styles/formulario.css', './styles/general.css', './styles/tablas.css']);
    $datos_filtrados = [
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
        'tel' => FILTER_SANITIZE_NUMBER_INT,
        'email' => FILTER_SANITIZE_EMAIL,
        'modelo' => FILTER_SANITIZE_SPECIAL_CHARS,
        'motor' => FILTER_SANITIZE_SPECIAL_CHARS,
        'pintura' => FILTER_SANITIZE_SPECIAL_CHARS,
        'extras' => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                    'flags' => FILTER_REQUIRE_ARRAY],
        'fp' => FILTER_SANITIZE_SPECIAL_CHARS
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $datos_filtrados);

    $datos_validados['nombre'] = filter_var($datos_saneados['nombre'], FILTER_DEFAULT);
    $datos_validados['tel'] = filter_var($datos_saneados['tel'], FILTER_VALIDATE_INT);
    $datos_validados['email'] = filter_var($datos_saneados['email'], FILTER_VALIDATE_EMAIL);
    $datos_validados['modelo'] = array_key_exists($datos_saneados['modelo'], $modelos) ? $datos_saneados['modelo'] : false;
    $datos_validados['motor'] = array_key_exists($datos_saneados['motor'], $motores) ? $datos_saneados['motor'] : false;
    $datos_validados['pintura'] = array_key_exists($datos_saneados['pintura'], $colores) ? $datos_saneados['pintura'] : false;

    $extras_OK = True;

    foreach ($datos_saneados['extras'] as $extra) {
        if (!array_key_exists($extra, $extras)) {
            $extras_OK = false;
            break;
        }
    }

    $datos_validados['extras'] = $extras_OK ? $datos_saneados['extras'] : False;
    $datos_validados['fp'] = array_key_exists($datos_saneados['fp'], $forma_pago) ? $datos_saneados['fp'] : false;

    // Calculamos el presupuesto
    $total = 0;

    ?>
        <h1>Avel mani segun lo que ha selesionao te va a salir el chiste por esto:</h1>
        <table>
            <thead>
                <tr>
                    <th>Elememento</th>
                    <th>Tipo</th>
                    <th>Presio</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Modelo</td>
                    <td><?=$modelos[$datos_validados['modelo']]['nombre']?></td>
                    <td><?=$modelos[$datos_validados['modelo']]['precio']?>€</td>
                </tr>
                <?php $total += $modelos[$datos_validados['modelo']]['precio']; ?>

                <tr>
                    <td>Motor</td>
                    <td><?=$motores[$datos_validados['motor']]['nombre']?></td>
                    <td><?=$motores[$datos_validados['motor']]['precio']?>€</td>
                </tr>
                <?php $total += $motores[$datos_validados['motor']]['precio']; ?>

                <tr>
                    <td>Pintura</td>
                    <td><?=$colores[$datos_validados['pintura']]['nombre']?></td>
                    <td><?=$colores[$datos_validados['pintura']]['precio']?>€</td>
                </tr>
                <?php $total += $colores[$datos_validados['pintura']]['precio']; ?>

                <tr>
                    <td>Extras</td>
                    <?php
                        foreach ($datos_validados['extras'] as $extra) {
                            $añadidos[] = $extras[$extra]['nombre'];
                            $precios[] = $extras[$extra]['precio'] . "€";
                            $total += $extras[$extra]['precio'];
                        }
                    ?>

                    <td><?=implode("<br>", $añadidos)?></td>
                    <td><?=implode("<br>", $precios)?></td>
                </tr>
            </tbody>
        </table>
    <?php
    echo "El precio total es: $total";

    echo "<h3>Eto ute como me lo va pagal</h3>";

    $meses = $forma_pago[$datos_validados['fp']]['meses'];
    $descripcion = $forma_pago[$datos_validados['fp']]['nombre'];

    if ($meses == 0) {
        echo "Dame la plata ya manito";
    }
    else {
        $entrada = $total * 0.25;
        $cuota_final = ($total - $entrada) * 0.25;
        $plazo = ($total - ($entrada + $cuota_final)) / $meses;

        echo "<h3>Entrada: ". number_format($entrada) . "€ <br>" . "Cuota final: " . number_format($cuota_final) . "€<br>" . $meses . " plazos a " . number_format($plazo) . "€<br></h3>";
    }

    echo "<p>¿Quiere coinfigural otro lambo de fokin vegueta y fokin goku? <a href='{$_SERVER['PHP_SELF']}'>Pulse acá</a></p>";

} 
?>