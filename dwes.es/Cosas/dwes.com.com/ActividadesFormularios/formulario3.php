<?php
// Incluye el archivo de funciones externas (funciones.php) que contiene funciones de utilidad
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

// Definir los precios base y los incrementos dependiendo del tipo de pizza
$precioMinimo = 5; // Precio inicial de cualquier pizza con tomate y queso
$extraVegetal = 3; // Incremento para pizzas vegetarianas
$extraNoVegetal = 2; // Incremento para pizzas no vegetarianas

// Lista de ingredientes y precios para pizzas no vegetarianas
$noVeg = [
    "Atún" => 2.00,
    "Carne picada" => 2.50,
    "Peperoni" => 1.75,
    "Morcilla" => 2.25,
    "Anchoas" => 1.50,
    "Salmón" => 3.00,
    "Gambas" => 4.00,
    "Langostinos" => 4.00,
    "Mejillones" => 2.00
];

// Lista de ingredientes y precios para pizzas vegetarianas
$veg = [
    "Pepino" => 1.00,
    "Calabacín" => 1.50,
    "Pimiento verde" => 1.25,
    "Pimiento rojo" => 1.75,
    "Tomate" => 1.50,
    "Aceitunas" => 3.00,
    "Cebolla" => 1.00
];

// Llama a la función para generar la cabecera de la página HTML con estilos predefinidos
inicio_html("Gestión de pizzas", ["/estilos/formulario.css", "/estilos/general.css", "/estilos/tabla.css"]);

// Función para obtener y sanear los datos del formulario usando filtros de PHP
function obtenerDatosSaneados() {
    // Define los filtros para cada campo del formulario, asegurando la limpieza y validación de datos
    $opciones_filtrado = [
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS, // Filtra caracteres especiales en el nombre
        'direccion' => FILTER_SANITIZE_SPECIAL_CHARS, // Filtra caracteres especiales en la dirección
        'tlf' => FILTER_SANITIZE_NUMBER_INT, // Filtra para solo números en el teléfono
        'tipoPizza' => FILTER_SANITIZE_SPECIAL_CHARS, // Filtra caracteres especiales en el tipo de pizza
        'veg' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS, // Filtra caracteres especiales en ingredientes vegetales
            'flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE // Asegura que sea un array o NULL si no hay selección
        ],
        'noVeg' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS, // Filtra caracteres especiales en ingredientes no vegetales
            'flags' => FILTER_REQUIRE_ARRAY | FILTER_NULL_ON_FAILURE // Asegura que sea un array o NULL si no hay selección
        ],
        'extrQueso' => FILTER_SANITIZE_NUMBER_INT, // Filtra para solo números en extra queso (1 si seleccionado, 0 si no)
        'bordQueso' => FILTER_SANITIZE_NUMBER_INT, // Filtra para solo números en borde de queso
        'nPizzas' => FILTER_SANITIZE_NUMBER_INT // Filtra para solo números en el número de pizzas
    ];

    // Filtra y retorna todos los datos del formulario usando el arreglo de filtros definido
    return filter_input_array(INPUT_POST, $opciones_filtrado);
}

// Función para calcular el precio total de la pizza basada en los parámetros seleccionados
function calcularPrecioPizza($tipoPizza, $ingredientesVegetales, $ingredientesNoVegetales, $extraQueso, $bordQueso, $numPizzas, $precioMinimo, $extraVegetal, $extraNoVegetal, $veg, $noVeg) {
    $precioBase = $precioMinimo; // Precio inicial de la pizza

    // Aumenta el precio base según si la pizza es vegetariana o no vegetariana
    $precioBase += ($tipoPizza == 'vegetariana') ? $extraVegetal : $extraNoVegetal;

    $precioIngredientes = 0; // Inicializa la suma del precio de ingredientes adicionales

    // Suma el precio de los ingredientes seleccionados si es vegetariana
    foreach ($ingredientesVegetales as $ing) {
        $precioIngredientes += $veg[$ing];
    }

    // Suma el precio de los ingredientes seleccionados si es no vegetariana
    foreach ($ingredientesNoVegetales as $ing) {
        $precioIngredientes += $noVeg[$ing];
    }

    // Suma el precio del extra de queso si está seleccionado
    $precioIngredientes += $extraQueso ? 1 : 0; // Extra queso cuesta 1 €

    // Suma el precio del borde relleno de queso si está seleccionado
    $precioIngredientes += $bordQueso ? 1.5 : 0; // Borde relleno cuesta 1.5 €

    // Retorna el precio total multiplicado por la cantidad de pizzas solicitadas
    return ($precioBase + $precioIngredientes) * $numPizzas;
}

// Función para mostrar el resumen detallado del pedido
function mostrarResumenPedido($nombre, $direccion, $telefono, $tipoPizza, $ingredientesVegetales, $ingredientesNoVegetales, $extraQueso, $bordQueso, $numPizzas, $precioTotal) {
    // Muestra todos los detalles del pedido del cliente
    echo "<h3>Resumen de tu pedido</h3>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Dirección:</strong> $direccion</p>";
    echo "<p><strong>Teléfono:</strong> $telefono</p>";
    echo "<p><strong>Tipo de pizza:</strong> " . ucfirst($tipoPizza) . "</p>";
    echo "<p><strong>Ingredientes Vegetales:</strong> " . implode(", ", $ingredientesVegetales) . "</p>";
    echo "<p><strong>Ingredientes No Vegetales:</strong> " . implode(", ", $ingredientesNoVegetales) . "</p>";
    echo "<p><strong>Extra queso:</strong> " . ($extraQueso ? "Sí" : "No") . "</p>";
    echo "<p><strong>Borde de queso:</strong> " . ($bordQueso ? "Sí" : "No") . "</p>";
    echo "<p><strong>Número de pizzas:</strong> $numPizzas</p>";
    echo "<p><strong>Precio total:</strong> $precioTotal €</p>";
}

// Verifica si el formulario fue enviado usando el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
    // Obtiene los datos del formulario aplicando los filtros definidos
    $datos_saneados = obtenerDatosSaneados();

    // Asignación de variables individuales desde el arreglo de datos saneados
    $nombre = $datos_saneados['nombre'] ?? '';
    $direccion = $datos_saneados['direccion'] ?? '';
    $telefono = $datos_saneados['tlf'] ?? '';
    $tipoPizza = $datos_saneados['tipoPizza'] ?? '';
    $ingredientesVegetales = $datos_saneados['veg'] ?? [];
    $ingredientesNoVegetales = $datos_saneados['noVeg'] ?? [];
    $extraQueso = isset($datos_saneados['extrQueso']) && $datos_saneados['extrQueso'] == '1' ? 1 : 0;
    $bordQueso = isset($datos_saneados['bordQueso']) && $datos_saneados['bordQueso'] == '1' ? 1 : 0;
    $numPizzas = $datos_saneados['nPizzas'] ?? 1;

    // Llama a la función para calcular el precio total de la pizza
    $precioTotal = calcularPrecioPizza($tipoPizza, $ingredientesVegetales, $ingredientesNoVegetales, $extraQueso, $bordQueso, $numPizzas, $precioMinimo, $extraVegetal, $extraNoVegetal, $veg, $noVeg);

    // Muestra el resumen del pedido con los detalles y el precio total
    mostrarResumenPedido($nombre, $direccion, $telefono, $tipoPizza, $ingredientesVegetales, $ingredientesNoVegetales, $extraQueso, $bordQueso, $numPizzas, $precioTotal);

    fin_html(); // Cierra el HTML generado por la función inicio_html

// Si no se ha enviado una solicitud POST, muestra el formulario de pedido con el metodo GET
} else {
    ?>
    <!-- Formulario HTML para recoger datos del pedido -->
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
            <!-- Campo para el nombre del cliente -->
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            <!-- Campo para la dirección del cliente -->
            <div>
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion">
            </div>
            <!-- Campo para el teléfono del cliente -->
            <div>
                <label for="tlf">Teléfono</label>
                <input type="tel" name="tlf" id="tlf">
            </div>
            <!-- Campo para seleccionar ingredientes vegetales -->
            <div>
                <label for="veg">Vegetales:</label>
                <select name="veg[]" id="veg" size="5" multiple>
                    <?php foreach ($veg as $nombre => $precio) : ?>
                        <option value="<?= $nombre ?>"><?= "$nombre - $precio €" ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Campo para seleccionar ingredientes no vegetales -->
            <div>
                <label for="noVeg">No Vegetales:</label>
                <select name="noVeg[]" id="noVeg" size="5" multiple>
                    <?php foreach ($noVeg as $nombre => $precio) : ?> <!-- Itera sobre la lista de ingredientes no vegetales -->
                        <option value="<?= $nombre ?>"><?= "$nombre - $precio €" ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Campo para seleccionar extras -->
            <div>
                <label for="extrQueso">Extra queso:</label>
                <input type="checkbox" name="extrQueso" id="extrQueso" value="1">
            </div>
            <div>
                <label for="bordQueso">Borde de queso:</label>
                <input type="checkbox" name="bordQueso" id="bordQueso" value="1">
            </div>
            <!-- Campo para indicar el número de pizzas -->
            <div>
                <label for="nPizzas">Número de pizzas:</label>
                <input type="number" name="nPizzas" id="nPizzas" value="1" min="1">
            </div>
            <!-- Botón para enviar el formulario -->
            <div>
                <input type="submit" name="enviar" value="Realizar pedido">
            </div>
        </fieldset>
    </form>
    <?php
    fin_html(); // Cierra la estructura HTML de la página
}
?>
