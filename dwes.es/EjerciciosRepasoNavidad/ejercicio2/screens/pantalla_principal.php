<?php

// Almacenaremos todos los datos que se vayan seleccionando dentro del array de sesiones
// asi que inicializamos la sesion
session_start();

// Una vez inicializada la sesion, debemos de recoger los datos necesarios para la creacion
// de nuestra pagina
require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoNavidad/includes/funciones.php");

// Ahora, comprobamos las peticiones que hacemos como usuario
inicio_html("Pantalla principal", ["../styles/formulario.css", "../styles/general.css"]);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    session_unset();
    session_destroy();
    ?>
    <h1>Selecciona directorio</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <fieldset>
            <legend>
                Selecciona uno de los directorios.
            </legend>
            <select name="directorio" id="directorio">
                <?php
                /*
                    Haciendo uso de glob() obtenemos las rutas dentro del directorio padre
                    Pero, ¿cómo funciona glob()?
                    ----------------------------
                    El método glob() necesita dos parámetros
                    {
                        string $direccion_o_ruta,
                        int $bandera
                    }
                    Y devuelve un array con los directorios. Un array de string con las rutas.

                    Las banderas de las que puede hacer uso son varias, (se encuentran en la documentación,
                    aquí os las dejo: https://www.php.net/manual/es/function.glob.php) pero de la que hago 
                    uso es de GLOB_ONLYDIR

                    ¿Qué hace GLOB_ONLYDIR?
                    -----------------------
                    Devuelve sólo las entradas de directorio que conciden con la $direccion_o_ruta
                    Es decir, devuelve un entero. Es como si contase cuantos directorios hay dentro
                    de $direccion_o_ruta y los devuelve.
                */
                    foreach(glob($_SERVER['DOCUMENT_ROOT'] . '/EjerciciosRepasoNavidad/*', GLOB_ONLYDIR) as $ruta){
                        echo "<option value='{$ruta}'>" . basename($ruta) . '</option>';
                    }
                ?>
            </select>
        </fieldset>
        <input type="submit" name="operacion" id="operacion">
    </form>
    <?php
}
else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Validamos los datos que tenemos del post del formulario anterior, es decir, la ruta que ya tenemos
    // Solo es un string, asi que no necesita otra validacion ni saneamiento.
        $ruta = filter_input(INPUT_POST, 'directorio', FILTER_SANITIZE_SPECIAL_CHARS);

    // Lo almacenamos en sesion para que lo tengamos disponible en la otra ventana.
    $_SESSION['ruta'] = $ruta;

    // Comprobamos que se haya almacenado correctamente
    // Si es asi, navegamos a la siguiente ventana
    if ($ruta){
        echo "<h2>Directorio recogido correctamente</h2>";
        echo "<a href='pantalla_lista_de_archivos.php'>Navega a la siguiente ventana</a>";
    }else {
        // Si no es asi, devolvemos un mensaje de error y que vuelva a probar.
        echo "<h2>No se ha podido recoger ningun dato</h2>";
        echo "<a href='{$_SERVER['PHP_SELF']}'>Vuelve a intentarlo</a>";
    }
}


fin_html();

?>