<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/recu/includes/funciones.php");

inicio_html('06Rafa sticky', ['/recu/styles/general.css', '/recu/styles/formulario.css', '/recu/styles/tablas.css']);

$proyectos = [
    'ap' => 'Agua potable',
    'ep' => 'Escuela de primaria',
    'ps' => 'Placas solares',
    'cm' => 'Centro médico'
];


$datos_validados = [
    'email' => '',
    'registro' => false,
    'cantidad' => '',
    'proyecto' => '',
    'propuesta' => ''
];


$mensajes = [];

//antes del formulario, comprobar si hay petición para recoger los datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // SANEAR CON ARRAY
    $filtro_sanear = [
        'email' => FILTER_SANITIZE_EMAIL,
        'registro' => FILTER_DEFAULT,
        'cantidad' =>
        [
            'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'proyecto' => FILTER_SANITIZE_SPECIAL_CHARS,
        'propuesta' => FILTER_SANITIZE_SPECIAL_CHARS
    ];

    $datos_saneados = filter_input_array(INPUT_POST,  $filtro_sanear);

    $filtro_validar = [
        'email' => FILTER_VALIDATE_EMAIL,
        'registro' => FILTER_VALIDATE_BOOLEAN,
        'cantidad' =>
        [
            'filter' => FILTER_VALIDATE_FLOAT,
            'option' => [
                'default' => 20,
                'min_range' => 10,
            ]
        ],
        'proyecto' => FILTER_DEFAULT,
        'propuesta' => FILTER_DEFAULT
    ];

    $datos_validados = filter_var_array($datos_saneados, $filtro_validar);

    if (!$datos_validados['email']) $mensajes['email'] = "el email no es correcto";
    if (!$datos_validados['cantidad']) $mensajes['cantidad'] = "el cantidad no es correcta";

    // lógica de negocio
    if (empty($datos_validados['proyecto']) || !array_key_exists($datos_validados['proyecto'], $proyectos)) {
        // el proyecto no es valido
        $mensajes['proyecto'] = 'el proyecto no es correcto';
    }

    if ($datos_validados['proyecto'] == '' && $datos_validados['propuesta'] == '') {
        // el proyecto no es valido
        $mensajes['proyecto'] = "hay que elegir proyecto si no haces propuesta";
    }


    //solo visualizamos los datos si $mensajes esta vacío
    if (count($mensajes) == 0) {

        $registro = $datos_validados['registro'] ? 'autoriza' : 'no autoriza';
        $proyecto =  $proyectos[$datos_validados['proyecto']];
        //no hay errores de validación
        echo <<<DATOS
            <table>
            <thead>
                <th>email</th>
                <th>registro</th>
                <th>cantidad</th>
                <th>proyecto</th>
                <th>propuesta</th>
            </thead>
            <tbody>
                <td>{$datos_validados['email']}</td>
                <td>{$registro} </td>
                <td>{$datos_validados['cantidad']}</td>
                <td>{$proyecto}</td>
                <td>{$datos_validados['propuesta']}</td>
            </tbody>
        </table>
        DATOS;
    } else {
        // hay errores de validación
        foreach ($mensajes as $mensaje) {
            echo $mensaje;
        }
    }
}


?>


<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

    <fieldset>
        <legend>ONG</legend>

        <label for="email">emaik</label>
        <input type="email" name="email" id="email" <?= isset($datos_validados['email']) ? "value = '{$datos_validados['email']}'" : '' ?>>

        <label for="registro">registro registro</label>
        <input type="checkbox" name="registro" id="registro" <?= isset($datos_validados['registro']) ? 'checked' : '' ?>>

        <label for="cantidad">cantidad</label>
        <input type="text" name="cantidad" id="cantidad" <?= isset($datos_validados['cantidad']) ? "value = '{$datos_validados['cantidad']}'" : "" ?>>

        <label for="proyecto">proyecto</label>
        <select name="proyecto" id="proyecto">
            <?php foreach ($proyectos as $key => $value) : ?>
                <option value="<?= $key ?>" <?= (isset($datos_validados['proyecto']) === $key) ? 'selected' : '' ?>>
                    <?= $value ?>
                </option> <?= PHP_EOL /*ESTO ES PARA AÑADIR SALTOS DE LINEA EN EL CÓDIGO FUENTE AUTOGENERATE */ ?>
            <?php endforeach; ?>
        </select>

        <label for="propuesta">propuesta</label>
        <textarea name="propuesta" id="propuesta" cols="30" rows="3" placeholder="escribe tu propuesta"><?= isset($datos_validados['propuesta']) ?? '' ?></textarea>


    </fieldset>
    <button type="submit">enviar</button>
</form>


<?php

fin_html();
?>