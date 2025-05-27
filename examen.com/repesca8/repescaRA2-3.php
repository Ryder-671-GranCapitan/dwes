<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("repescaRA2-3", ["/estilos/bh.css", "/estilos/formulario.css", "/estilos/general.css", "/estilos/tablas.css"]);

$Origenes = [
    'afg' => [
        'nombre' => 'Afganistan'
    ],
    'cn' => [
        'nombre' => 'Corea del Norte'
    ],
    'ch' => [
        'nombre' => 'China'
    ],
    'lb' => [
        'nombre' => 'Libia'
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $filtro_saneamiento = [
        'codigo' => FILTER_SANITIZE_NUMBER_INT,
        'nombre' => FILTER_SANITIZE_SPECIAL_CHARS,
        'origen' => [
            'filter' => FILTER_DEFAULT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'destruir' => FILTER_DEFAULT
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_saneamiento);

    $filtro_validacion = [
        'codigo' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 1,
                'max_range' => 999
            ]
        ],
        'nombre' => FILTER_DEFAULT,
        'origen' => [
            'filter' => FILTER_DEFAULT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'destruir' => FILTER_VALIDATE_BOOL
    ];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validacion);

    if (!$datos_validados['codigo']) {
        echo "Error. el codigo no ha pasado la validacion <br>";
    }
    if (!$datos_validados['nombre']) {
        echo "Error. El nombre no ha pasado la validacion <br>";
    }

    if (!$datos_validados['origen']) {
        echo "Error. el origen no pasa la validacion <br>";
    }

    $tipo_mime_subida = $_FILES['informacion']['type'];
    $tipo_mime_permitido = ['text/plain'];
    $tipo_mime_archivo = mime_content_type($_FILES['informacion']['tmp_name']);

    if (
        !in_array($tipo_mime_subida, $tipo_mime_permitido) or
        !in_array($tipo_mime_archivo, $tipo_mime_permitido)
    ) {
        echo 'Error. El tipo del archivo no es el permitido <br>';
    }

    if ($_FILES['informacion']['error'] == UPLOAD_ERR_FORM_SIZE) {
        echo 'Error. El supera el tamaño indicado en el formulario <br>';
    }

    if ($_FILES['informacion']['error'] != UPLOAD_ERR_OK) {
        echo 'Error. El archivo no se ha subido por cualquier causa <br>';
    }

    $archivo = fopen($_FILES['informacion']['tmp_name'], 'r');
    $path = $_SERVER['DOCUMENT_ROOT'] . "./top_secret";
    $fichero = [];
    if ($archivo) {
        while (($búfer = fgets($archivo)) !== false) {
            array_push($fichero, $búfer);
        }
        if (!feof($archivo)) {
            echo "Error: fallo inesperado de fgets()\n";
        }
        fclose($archivo);
    }
    $cantidadfichero = count($fichero);
    $cantidadfichero -= 1;
    if (
        $fichero[0] != $datos_validados['codigo'] &&
        $fichero[$cantidadfichero] != $datos_validados['nombre']
    ) {
        echo 'Archivo no verificado';
    } else {
        if ($datos_validados['destruir'] == true) {
            echo "Informacion confirmada";
        } else {
            if (!is_dir($path) && !file_exists($path)) {
                if (!move_uploaded_file($_FILES['informacion']['tmp_name'] . ".txt", $path)) {
                    echo "Informacion confirmada";
                }
            }
        }
    }

?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= 1024 * 10 ?>">
        <fieldset>
            <legend>Identificacion de CIA</legend>

            <label for="codigo">Codigo</label>
            <input type="number" name="codigo" id="codigo" min="1" max="999">

            <label for="nombre">Nombre en clave</label>
            <input type="text" name="nombre" id="nombre">

            <label for="origen">Origen de la informacion</label>
            <select name="origen[]" id="origen" size="3" multiple>
                <?php
                foreach ($Origenes as $origen => $dato) {
                ?>
                    <option value="<?= $origen ?>"> <?= $dato['nombre'] ?></option>
                <?php
                }
                ?>
            </select>

            <label for="destruir">Destruir despues de leer</label>
            <input type="checkbox" name="destuir" id="destruir">

            <label for="informacion">Informacion</label>
            <input type="file" name="informacion" id="informacion" accept="text/txt">
        </fieldset>
        <input type="submit" value="enviar" name="operacion" id="operacion">

    </form>


<?php


}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= 1024 * 10 ?>">
        <fieldset>
            <legend>Identificacion de CIA</legend>

            <label for="codigo">Codigo</label>
            <input type="number" name="codigo" id="codigo" min="1" max="999">

            <label for="nombre">Nombre en clave</label>
            <input type="text" name="nombre" id="nombre">

            <label for="origen">Origen de la informacion</label>
            <select name="origen[]" id="origen" size="3" multiple>
                <?php
                foreach ($Origenes as $origen => $dato) {
                ?>
                    <option value="<?= $origen ?>"> <?= $dato['nombre'] ?></option>
                <?php
                }
                ?>
            </select>

            <label for="destruir">Destruir despues de leer</label>
            <input type="checkbox" name="destruir" id="destruir">

            <label for="informacion">Informacion</label>
            <input type="file" name="informacion" id="informacion" accept="text/plain">
        </fieldset>
        <input type="submit" value="enviar" name="operacion" id="operacion">

    </form>


<?php

}
fin_html();
?>