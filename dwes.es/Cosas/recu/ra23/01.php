<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/recu/includes/funciones.php");

inicio_html("ej1, formularios", ['/recu/styles/formulario.css', '/recu/styles/general.css', '/recu/styles/tablas.css']);



// funciones

function decBinario(int $numero): int
{
    $numero = decbin($numero);
    return $numero * 1;
}

function decOctal($numero): int
{
    $numero = decoct($numero);
    return $numero * 1;
}

function decHexadecimal($numero) : string {
    $numero = dechex($numero);
    return $numero;
}
?>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
    <fieldset>
        <legend>Calculadora de valores numericos</legend>
        <label for="numero">numero decimal:</label>
        <input type="number" name="numero" id="numero">
    </fieldset>
    <button type="submit"> enviar </button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);

?>
    <table>
        <thead>
            <tr>
                <td>decimal</td>
                <td>binario</td>
                <td>octal</td>
                <td>hexadecimal</td>
            </tr>
        </thead>
        <tr>
            <th><?= $numero ?></th>
            <th><?= decBinario($numero) ?></th>
            <th><?= decOctal($numero) ?></th>
            <th><?= decHexadecimal($numero) ?></th>

        </tr>
    </table>

<?php
}





fin_html();
?>