<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/repesca26/includes/funciones.php');

inicio_html("repesca", ['/repesca26/estilos/formulario.css', '/repesca26/estilos/general.css', '/repesca26/estilos/tablas.css', '/repesca26/estilos/bh.css']);

$TIPOS_MIME_VALIDOS = ['text/plain'];
$TAMANIO_MAXIMO_KB = 10;
$lista_origenes = [
    'af' => 'Afganistán',
    'co' => 'Corea del norte',
    'ch' => 'china',
    'li' => 'libia'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // saneamiento
    $filtro_sanear = [
        'codigo' => FILTER_SANITIZE_NUMBER_INT,
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
        'origen' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'destruir' => [
            'filter' => FILTER_DEFAULT,
            'flags' =>  FILTER_NULL_ON_FAILURE
        ]
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear);
    // validacion
    $filtro_validar = [
        'codigo' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'max_range' => 999,
                'min_range' => 1
            ]
        ],
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
        'origen' => [
            'filter' => FILTER_DEFAULT,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'destruir' => [
            'filter' => FILTER_DEFAULT,
            'flags' =>  FILTER_NULL_ON_FAILURE
        ]
    ];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

    if(!in_array($datos_validados['origen'][0], array_keys($lista_origenes))) exit(1);

    if (!$datos_validados['codigo'] || !$datos_validados['nombre'] || !$datos_validados['origen']) exit(1);

    if ($_FILES['fichero']) {

        $name_fichero = $_FILES['fichero']['name'];
        $tmp_name_fichero = $_FILES['fichero']['tmp_name'];
        $kb_fichero = $_FILES['fichero']['size'];
        $type_fichero = $_FILES['fichero']['type'];
        $error_fichero = $_FILES['fichero']['error'];

        if (
            !in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS) ||
            !in_array($type_fichero, $TIPOS_MIME_VALIDOS)
        ) {
            echo "<h3>no se ha validado el tipo mime</h3>";
            exit(3);
        }

        if ($kb_fichero > ($TAMANIO_MAXIMO_KB * 1024)) exit(4);

        if ($error_fichero === UPLOAD_ERR_OK) {

            $fichero = fopen($tmp_name_fichero, 'r');
            $confirma_codigo = false;
            $confirma_nombre = false;

            while ($linea = fgets($fichero)) {

                echo $linea . '<br>';
                if ($linea == $datos_validados['codigo']) {
                    $confirma_codigo = true;
                }

                // compara "bond con "bond"
                // le obligo a que bon1 se concadene con " para que haga bien la comparación
                // desconozco porque no aparece el ultimo "
                if ($linea . '\" ' == $datos_validados['nombre']) {
                    $confirma_nombre = true;
                }
            }

            fclose($fichero);

            if (!$confirma_codigo && !$confirma_nombre) {
                echo "<h3>No se ha verificado el archivo</h3>";
                exit(6);
            }

            //carpeta
            if (!$datos_validados['destruir']) {
                $ruta_top_secret = $_SERVER['DOCUMENT_ROOT'] . '/repesca26/top_secret';

                if (!is_dir($ruta_top_secret) || is_file($ruta_top_secret)) {
                    if (!mkdir($ruta_top_secret, 0755, true)) {
                        echo '<h3>error creando la carpeta top secret </h3>';
                        exit(7);
                    }
                }

                if (!move_uploaded_file($tmp_name_fichero, $ruta_top_secret . '/' . $name_fichero)) {
                    exit(8);
                }

                echo "<h3>bien hecho soldado, volvemos a casa</h3>";
            }
        } else exit(5);
    } else exit(2);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $datos_validados) {
    // FORMULARIO
?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB * 1024 ?>">

        <fieldset>
            <legend>formulario</legend>

            <label for="codigo">codigo</label>
            <input type="text" name="codigo" id="codigo" required>

            <label for="nombre">nombre en clave</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="origen">origen de la </label>
            <select name="origen[]" id="origen" required multiple>
                <?php foreach ($lista_origenes as $key => $value ) : ?>
                    <option value="<?= $key ?>"> <?= $value ?></option>
                <?php endforeach; ?>
            </select>


            <label for="destruir">destruir despues de leer</label>
            <input type="checkbox" name="destruir" id="destruir">

            <label for="fichero">información:</label>
            <input type="file" name="fichero" id="fichero" accept="<?= $TIPOS_MIME_VALIDOS[0] ?>">
        </fieldset>
        <button type="submit">enviar</button>
    </form>

<?php
}

fin_html();
?>