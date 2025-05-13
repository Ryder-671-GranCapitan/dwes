<?php
    // Inicio sesion
    session_start();

    // Inicio ob
    ob_start();

    // Importo los archivos necesarios
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/Ejercicio6/articulos_carrito.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/jwt_include.php");

    inicio_html('Pantalla Principal', ["/EjerciciosRepasoMantenimiento/styles/styles.css", "/EjerciciosRepasoMantenimiento/styles/formulario.css", "/EjerciciosRepasoMantenimiento/styles/tablas.css"]);

    // a) Los artículos disponibles están en articulos_carrito.php que puedes incluir en cada script.

    // b) Pantalla carrito → Se presentan los artículos para que el usuario elija cuál quiere y
    // en qué cantidad. Conforme se van añadiendo artículos al carrito, se muestra en
    // formato de tabla. Además, se tendrán opciones para ir al pago del carrito o a la
    // autenticación de usuario.

    // Gestionamos las peticiones
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Mostramos el formulario con la tabla de los articulos
        global $articulos;
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <?php
                foreach ($articulos as $key => $value) {
                ?>
                    <tr>
                        <td><input type='checkbox' name='valores[]' value='<?= key($articulos) ?>'></td>
                        <td><?php echo $value['descripcion'] ?></td>
                        <td><?php echo $value['precio'] ?></td>
                        <td><input type="number" name="cantidad" id="cantidad"></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <input type="submit" id="operacion" name="operacion" value="Añadir al carrito">
        </form>
    <?php
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $valores = $_POST['valores'];

        foreach ($valores as $valor) {
            if (array_key_exists($valor, $articulos)){
            echo "$valor: {$articulos[$valor]['precio']}<br>";
            }
        }
    }
// Cerramos el control de cabeceras.
$ob_contenido = ob_get_contents();
ob_flush();

// Finalizamos html.
fin_html();


?>