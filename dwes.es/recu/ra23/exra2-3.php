<?php

use function PHPSTORM_META\type;

require_once($_SERVER['DOCUMENT_ROOT'] . '/recu/includes/funciones.php');

inicio_html('examen original RA 2-3', ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);

$cursos  = [
    'ofi' => ['Ofimática', 100],
    'pro' => ['Programación', 200],
    'rep' => ['Reparación de ordenadores', 150]
];

$TIPOS_MIME_VALIDOS = ['application/pdf'];
$TAMANIO_MAXIMO_KB = 100;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SANEAMIENTO
    $filtro_sanear = [
        'email' => FILTER_SANITIZE_EMAIL,
        'cursos' => [
            'filter' => FILTER_DEFAULT,
            'flags' => FILTER_REQUIRE_ARRAY
        ],
        'clases' => FILTER_SANITIZE_NUMBER_INT,
        'situacion' => FILTER_DEFAULT
    ];

    $datos_saneados = filter_input_array(INPUT_POST, $filtro_sanear);

    //VALIDACION

    $filtro_validar = [
        'email'  => FILTER_VALIDATE_EMAIL,
        'cursos' => FILTER_DEFAULT,
        'clases' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'max_range' => 10,
                'min_range' => 5
            ]
        ],
        'situacion' => [
            'filter' => FILTER_VALIDATE_BOOLEAN,
            'flags' => FILTER_NULL_ON_FAILURE
        ]
    ];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

    //LÓGICA NEGOCIO
    // validar curso
    if (!is_array($datos_validados['cursos']) || array_diff($datos_validados['cursos'], array_keys($cursos))) exit(1);

    // comprobar Situación y si hay fichero subido, en tal caso empezar guardar el archivo
    if ($datos_validados['situacion'] && $_FILES['tarjeta']){
        // si esta desempleado proceso el fichero
        $mime_fichero = $_FILES['tarjeta']['type'];
        $kb_fichero = $_FILES['tarjeta']['size'];
        $tmp_name_fichero = $_FILES['tarjeta']['tmp_name'];
        $errores_fichero = $_FILES['tarjeta']['error'];

        if( // comprobación del tipo mime del fichero
            !in_array($mime_fichero, $TIPOS_MIME_VALIDOS) ||
            !in_array(mime_content_type($tmp_name_fichero), $TIPOS_MIME_VALIDOS) ||
            !in_array(finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmp_name_fichero), $TIPOS_MIME_VALIDOS)
            ) exit(2);

        
        if ($errores_fichero === UPLOAD_ERR_FORM_SIZE) exit(3); // error en el tamaño del archivo
        if ($kb_fichero > $cursosTAMANIO_MAXIMO_KB *1204) exit(3);

        $directorio_subida = $_SERVER['DOCUMENT_ROOT'] . "/recu/ra23/tarjetas";

        // en este punto el archivo es valido
        if ($errores_fichero == UPLOAD_ERR_OK) {

            // se crea la carpeta tarjetas, si no se crea da error
            if (!file_exists($directorio_subida) || !is_dir($directorio_subida)) {
                if (!mkdir($directorio_subida,0755,true)) {
                    exit(4); // error al crear la carpeta
                }
            }

            // guardar el archivo
            if (move_uploaded_file($tmp_name_fichero, $directorio_subida . "/{$datos_validados['email']}.pdf")) exit(5);
        
        
        }else exit(6); //error, el usuario ha mandado el fichero y no esta desempleado o no ha mandado fichero estando desempleado


        // PRESUPUESTO
        $precio_total = 0;
        $precio_cursos = 0;
        $precio_clases = 10 * $datos_validados['clases'];
        foreach ($datos_validados['cursos'] as $curso_cod) {            
            $precio_cursos += $cursos[$curso_cod][1];
        }

        // total
        $precio_total =  $precio_cursos + $precio_clases;

        $datos_validados['situacion'] ? $precio_total *= 0.9 : '';



        // RESULTADO

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
                    <td><?=$datos_validados['email'] ?></td>
                    <td>
                        <?php foreach ($datos_validados['cursos'] as $curso_cod): ?>
                            <?=$cursos[cod]?>
                        <?php endforeach;?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php



    }

    //


}



if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // FORMULARIO
?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= $TAMANIO_MAXIMO_KB *1024?>">
        <fieldset>
            <legend>Cursos</legend>

            <label for="email">email</label>
            <input type="email" name="email" id="email">

            <label for="cursos">cursos</label>
            <select name="cursos[]" id="cursos" multiple>
                <?php foreach ($cursos as $curso => $value) : ?>
                    <option value="<?= $curso ?>"> <?= $value[0] ?> => <?= $value[1] ?> </option>
                <?php endforeach; ?>
            </select>

            <label for="clases">numero de clases</label>
            <input type="text" name="clases" id="clases">

            <label for="situacion">Situación de desempleo</label>
            <input type="checkbox" name="situacion" id="situacion">

            <label for="tarjeta">tarjeta de demandante de empleo</label>
            <input type="file" name="tarjeta" id="tarjeta" accept="application/pdf">

        </fieldset>
        <button type="submit">enviar</button>
    </form>

<?php
}



fin_html();
