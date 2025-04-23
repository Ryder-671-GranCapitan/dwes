<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/recu/includes/funciones.php');

inicio_html('exra2-3', ['/recu/styles/general.css', '/recu/styles/formulario.css', '/recu/styles/tablas.css']);

$cursos = [
    'ofi' => ['Ofimática', 100],
    'pro' => ['programacion', 200],
    'rep' => ['reparación de ordenadores', 150]
];

$TIPOS_MIME_VALIDOS = ['application/pdf'];
$TAMANIO_MAXIMO_KB = 100;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtro_sanear = [
        'email' => FILTER_SANITIZE_EMAIL,
        'cursos' => [
            'filter' => FILTER_DEFAULT,
            'flags' => FILTER_REQUIRE_ARRAY,
        ],
        'clases' => FILTER_SANITIZE_NUMBER_INT,
        'situacion' => FILTER_DEFAULT
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear);

    $filtro_validar = [
        'email' => FILTER_VALIDATE_EMAIL,
        'cursos' => [
            'filter' => FILTER_REQUIRE_ARRAY,
            'options' => [
                'filter' => FILTER_VALIDATE_INT,
                'optiosn' => [
                    'max_range' => 10,
                    'min_range' => 5
                ]
            ]
        ],
        'situacion' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE
        ]
    ];
    $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

    // LÓGICA NEGOCIO  
    if (!is_array($datos_validados['cursos'] || array_diff($datos_validados['cursos'], array_keys($cursos)))) exit(1);


    if ($datos_validados['situacion'] && $_FILES['fichero']) {

        $mime_fichero = $_FILES['fichero']['type'];
        $kb_fichero = $_FILES['fichero']['size'];
        $name_fichero = $_FILES['fichero']['name'];
        $tmp_name_fichero = $_FILES['fichero']['tmp_name'];
        $errores_fichero = $_FILES['fichero']['error'];


        if (
            !in_array($mime_fichero, $TIPOS_MIME_VALIDOS) ||
            !in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS) ||
            !in_array(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmp_name_fichero), $TIPOS_MIME_VALIDOS)
        ) {
            echo '<h3>Error el archivo no es del tipo correcto</h3>';
            exit(2);
        }


        if (!in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS)) exit(2);

        if ($errores_fichero === UPLOAD_ERR_FORM_SIZE) exit(3);
        if ($kb_fichero > $TAMANIO_MAXIMO_KB * 1024) exit(3);

        $directorio_subida = $_SERVER['DOCUMENT_ROOT'] . '/recu/ra23/v2/tarjetas';
        if ($errores_fichero == UPLOAD_ERR_OK) {
            if (!file_exists($directorio_subida) || !is_dir($directorio_subida)) {
                if (!mkdir($directorio_subida, 0755, true)) exit(4);
            }
        }
        if (move_uploaded_file($tmp_name_fichero, "/{$directorio_subida['email']}.pdf")) exit(5);
    } else exit(6);


    // Presupuesto
    $precio_total = 0;
    $precio_cursos = 0;
    $precio_clases = 10 * $datos_validados['clases'];

    foreach ($datos_validados['cursos'] as $curso_cod) {
        $precio_cursos += $cursos[$curso_cod][1];
    }

    $precio_total = $precio_cursos + $precio_clases;

    $datos_validados['situacion'] ? $precio_total *= 0.9 : '';

    // resultado tabla
?>
    <table>
        <thead>
            <th>email</th>
            <th>cursos</th>
            <th>clases</th>
            <th>situacion</th>
        </thead>
        <tbody>
            <tr>
                <td><?= $datos_validados['email'] ?></td>
                <td>
                    <?php foreach ($datos_validados['cursos'] as $curso_cod) : ?>
                        <?= $cursos[$curso_cod][0] ?> => <?= $cursos[$curso_cod][1] ?>
                    <?php endforeach; ?>
                </td>
                <td><?= $datos_validados['clases'] ?></td>
                <td><?= $datos_validados['situacion'] ? 'desempleado' : 'empleado' ?></td>
            </tr>
        </tbody>
    </table>

    <h3>precio final: <?= $precio_total ?></h3>

<?php
}

if ($_SERVER['REQUEST_METHOD' === 'GET']) {
?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB * 1024 ?>">
        <fieldset>
            <legend>cursos</legend>

            <label for="email">email</label>
            <input type="email" name="email" id="email">

            <label for="cursos">cursos</label>
            <select name="cursos[]" id="cursos" multiple>
                <?php foreach ($cursos as $curso => $value): ?>
                    <option value="<?= $curso ?>"><?= $value[0] ?> => <?= $value[1] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="clases">Nº Clases</label>
            <input type="text" name="clases" id="clases">

            <label for="situacion">situacion</label>
            <input type="checkbox" name="situacion" id="situacion">

            <label for="fichero">carnet:</label>
            <input type="file" name="fichero" id="fichero">
        </fieldset>
        <button type="submit">Enviar</button>
    </form>


<?php
}




fin_html();
?>