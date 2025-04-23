<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/recu/includes/funciones.php');

inicio_html('repeticion 3', ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);

$TIPOS_MIME_VALIDOS = ['application/pdf'];
$TAMANIO_MAXIMO_KB = 200;

$cursos  = [
    'ofi' => ['Ofimática', 100],
    'pro' => ['Programación', 200],
    'rep' => ['Reparación de ordenadores', 150]
];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // sanear
    $filtro_sanear = [
        'email' => FILTER_SANITIZE_EMAIL,
        'cursos' => [
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'clases' => FILTER_SANITIZE_NUMBER_INT,
        'situacion' => FILTER_DEFAULT,
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear);

    // validar

    $filtro_validar = [
        'email' => FILTER_VALIDATE_EMAIL,
        'cursos' => FILTER_DEFAULT,
        'clases' => [
            'max_range' => 10,
            'min_range' => 5,
        ],
        'situacion' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE
        ]
    ];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

    // logica negocio

    if (!is_array($datos_validados['cursos']) || array_diff($datos_validados['cursos'], array_keys($cursos))) exit(1);

    if ($datos_validados['situacion'] && $_FILES['fichero']) {
        $mime_fichero = $_FILES['fichero']['type'];
        $kb_fichero = $_FILES['fichero']['size'];
        $tmp_name_fichero = $_FILES['fichero']['tmp_name'];
        $name_fichero = $_FILES['fichero']['name'];
        $errores_fichero = $_FILES['fichero']['error'];

        if (!in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS)) exit(1);

        if ($errores_fichero === UPLOAD_ERR_FORM_SIZE) exit(2);

        if ($kb_fichero > $TAMANIO_MAXIMO_KB *1024) exit(3);

        $directorio_subida = $_SERVER['DOCUMENT_ROOT'] . "/recu/ra23/tarjetas";

        if ($errores_fichero === UPLOAD_ERR_OK){
            if (!file_exists($directorio_subida) || !is_dir($directorio_subida)) {
                if (!mkdir($directorio_subida,0755, true)) exit(4);
            }

            if (!move_uploaded_file($tmp_name_fichero, $directorio_subida. "/{$datos_validados['email']}.pdf")) exit(5);
        }


    }else exit(2);


}

if ($_SERVER['REQUEST_METHOD'] == 'GET' || $datos_validados) {
?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB * 1024 ?>">
        <fieldset>
            <legend>cursos</legend>
            <label for="email">email</label>
            <input type="email" name="email" id="email" <?= isset($datos_validados['email']) ? "value='{$datos_validados['email']}'" : '' ?>>

            <label for="cursos">cursos</label>
            <select name="cursos[]" id="cursos" multiple>
                <?php foreach ($cursos as $curso_cod => $value) : ?>
                    <option value="<?= $curso_cod ?>" <?= (isset($datos_validados['curso']) === $curso_cod) ? 'selected' : ''  ?>> <?= $value[0] ?> => <?= $value[1] ?></option>
                <?php endforeach ?>
            </select>

            <label for="clases">clases</label>
            <input type="text" name="clases" id="clases">

            <label for="situacion">situacion</label>
            <input type="checkbox" name="situacion" id="situacion" <?= isset($datos_validados['situacion']) ? 'checked' : '' ?>>

            <label for="fichero">fichero</label>
            <input type="file" name="fichero" id="fichero" accept="<?= $TIPOS_MIME_VALIDOS[0] ?>">
        </fieldset>
        <button type="submit">enviar</button>


    </form>

<?php
}
fin_html()
?>