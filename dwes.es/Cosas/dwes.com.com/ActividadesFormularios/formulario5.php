<?php
/**/

require_once ($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

ini_set("upload_max_filesize", 500 * 1024); // Modificar directamente en el servidor

// Array de destinos
 $destinos = [
    "paris"     => Array('nombre' => 'Paris', 'precio' => 100),
    "londres"   => Array('nombre' => 'Londres', 'precio' => 120),
    "estocolmo" => Array('nombre' => 'Estocolmo', 'precio' => 200),
    "edinburgo" => Array('nombre' => 'Edinburgo', 'precio' => 175),
    "praga"     => Array('nombre' => 'Praga', 'precio' => 125),
    "viena"     => Array('nombre' => 'Viena', 'precio' => 150)
];
// Array de compañias
$compañias = [
    "myair"     => Array('nombre' => 'MyAir', 'precio' => 0),
    "airfly"   => Array('nombre' => 'AirFly', 'precio' => 50),
    "vuelaconmigo" => Array('nombre' => 'VuelaConmigo', 'precio' => 75),
    "apedalesair" => Array('nombre' => 'ApedaleAir', 'precio' => 150)
];

$hoteles = [ 3=> 0, 
            4=> 40, 
            5=> 100];

$extras = ["vg" => 200, "bt" => 30, "2m" => 20, "sv" => 30];

// Pagina autogenerada: El formulario se presenta con GET y el proceso se hace con POST

inicio_html("Actividad Formularios 5", ["/estilos/general.css", "/estilos/formulario.css"]);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Procesa el formulario
    // Si hay sticky form, se inicializan las variables con los datod del formulario
    // para inicializar los valores de los controles del formulario

    $responsable = filter_input(INPUT_POST, 'responsable', FILTER_SANITIZE_SPECIAL_CHARS);

    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_NUMBER_INT);
    $telefono = preg_match("/[0-9]{9}/", $telefono) == 0 ? "" : $telefono;

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    $destino = filter_input(INPUT_POST, 'destino', FILTER_SANITIZE_SPECIAL_CHARS);
    $destino = array_key_exists($destino, $destinos) ? $destino : false;

    $compañia = filter_input(INPUT_POST, 'compañia', FILTER_SANITIZE_SPECIAL_CHARS);
    $compañia = array_key_exists($compañia, $compañias) ? $compañia : false;

    $hotel = filter_input(INPUT_POST, 'hotel', FILTER_SANITIZE_NUMBER_INT);
    $hotel = filter_var($hotel, FILTER_VALIDATE_INT, Array('min_range' => 3, 'max_range' => 5,'default' => 3)); // lo mismo qu el alinea de abajo
    // $hotel = $hotel < 3 && $hotel > 5 ? $hotel : 3;

    $desayuno = isset($_POST['desayuno']) && $_POST['desayuno'] == 'on';

    $personas = filter_input(INPUT_POST, 'personas', FILTER_SANITIZE_NUMBER_INT);
    $hotel = filter_var($hotel, FILTER_VALIDATE_INT, Array('min_range' => 5, 'max_range' => 10,'default' => 5)); // lo mismo qu el alinea de abajo

    $dias = filter_input(INPUT_POST, 'dias', FILTER_SANITIZE_NUMBER_INT);
    $dias = $dias == 5 || $dias == 10 || $dias == 15 ? $dias : False;

    $extras_recibido = filter_input(INPUT_POST, 'extras[]', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    $extras_ok = True;

    foreach ($extras_recibido as $clave => $valor) {
        if (!array_key_exists($extra, $extras)) {
            $extras_ok = False;
            break;
        }
    }

    // Datos recibidos, validados y saneados

    // Se genera el presupuesto

    // Se inicia un buffer de salida
    ob_start();

    // Datos personales
    echo "<h3>Datos del presupuesto para las vacaciones</h3>";

    echo "<p>Persona Responsable: $responsable - " . ($email ? $email : "Email no valido") . "<br>";
    echo "Telefono de contacto: " . ($telefono ? $telefono : "Telefono no valido") . "<br>";
    $total = 0;
    if($destino && $personas && $dias) {
        echo "Destino: {$destinos[$destino]['nombre']}<br>";
        echo "Numero de personas: $personas<br>";
        echo "Numero de dias: $dias<br>";
        $precio_destino = $destinos[$destino]['precio'] * intval($personas) * intval($dias); 
        echo "Precio por ir a  {$destinos[$destino]['nombre']} para $perosnas personas durante $dias dias es de $precio_destino</p>";
        $total += $precio_destino;
    }
    else {
        ob_clean();
        echo "<h3>Error. El destino, las personas o el dia no son correctos</h3>";

        // Enviar el formulario

        muestra_formulario();
        fin_html();
        ob_flush();
        exit(1);
    }

    if ($compañia && $persona) {
        echo "<p>Linea aerea {$compañias[$compañias]['nombre']}<br>";
        if (strtoupper($compañia == 'MyAir')) {
            echo "Sin coste adicional<br>";
        }
    }
    else {
        $precio_compañia = $compañias[$compañia]['precio'];
        $total_compañia = $precio_compañia * intval($personas);
        echo "Suplemento por linea aerea: $total_compañia €</p>";
        $total += $total_compañia;
    }
}
else {
    ob_clean();
        echo "<h3>Error. La linea aerea o las personas son erroneas</h3>";

        // Enviar el formulario

        muestra_formulario();
        fin_html();
        ob_flush();
        exit(2);
}

    if ($hotel && $personas && $dias) {
        echo "<p>Hotel: $hotel *<br>";
        $precio_hotel = $hoteles[$hotel];
        $total_hotel = $precio_hotel * intval($personas) * intval($dias);
        if ($precio_hotel == 0) {
            echo "Sin sobrecoste por hotel de $hotel estrellas</p>";
        }
        else {
            echo "Suplemento por hotel de $hotel estrellas: $total_hotel €</p>";
        }
    }    
    else {
        ob_clean();
        echo "<h3>Error. La categoria de hotal o el numero de dias o personas es erroneo</h3>";

        // Enviar el formulario

        muestra_formulario();
        fin_html();
        ob_flush();
        exit(3);
    }


    // subida de archivos
    if ($_FILES['libro']['error'] == UPLOAD_ERR_OK) { // El arvhivo de ha subido y se puede gestionar
    }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Poner el formulario si no es sticky form

    // Si es sticky form, inicializar los valores de los campos de los controles
    // del formulario con valores por defecto
}

    // Si es sticky form, el formulario viene aqui

    function muestra_formulario() { 
        global $destinos, $compañias, $hoteles;
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?=500*1024?>">
    <fieldset>
        <legend>Datos del Viaje</legend>
        <label for="responsable">Responsable de Grupo</label>
        <input type="text" name="responsable" id="responsable" size="40" required>

        <label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" size="10" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="eamil" size="30" required>

        <label for="destino">Destino</label>
        <select name="destino" id="destino" size="1">
<?php
        foreach ($destinos as $clave => $valor) {
            echo "<option value='$clave'>{$valor['nombre']}</option>";
        }
?>
        </select>

        <label for="compañia">Compañias</label>
        <select name="compañia" id="compañia" size="1">
<?php
        foreach ($compañias as $clave => $valor) {
            echo "<option value='$clave'>{$valor['nombre']}€/p/d</option>";
        }
?>
        </select>

        <label for="hotel">Hoteles</label>
        <select name="hotel" id="hotel" size="1">
<?php
        foreach ($hoteles as $clave => $valor) {
            echo "<option value='$clave'>$clave * ($valor €/p/d)</option>";
        }
?>
        </select>

        <label for="desayuno">Desayuno</label>
        <input type="checkbox" name="desayuno" id="desayuno">

        <label for="personas">Nº Personas</label>
        <input type="number" min="5" max="10" value="5" name="personas" id="personas">

        <label for="dias">Nº Dias</label>
        <div>
            <input type="radio" name="dias" id="dias_5" value="5">
            <input type="radio" name="dias" id="dias_10" value="10">
            <input type="radio" name="dias" id="dias_15" value="15">
        </div>

        <label for="extras[]">Extras</label>
        <div>
            <input type="checkbox" name="extras['vg']" id="extras_1">Visita Guiada <br>
            <input type="checkbox" name="extras['bt']" id="extras_2">Bus Turistico <br>
            <input type="checkbox" name="extras['2m']" id="extras_3">2ª Maleta Facturada <br>
            <input type="checkbox" name="extras['sv']" id="extras_4">Seguro de Viaje <br>
        </div>

        <label for="">Copia del Libro de Familia</label>
        <input type="file" name="libro" id="libro">
        
    </fieldset>
    <input type="submit" name="operacion" id="operacion" value="Calcular presupuesto">

</form>

<?php
}
fin_html();
ob_flush();
?>