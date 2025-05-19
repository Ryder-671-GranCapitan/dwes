<?php
    // Inicio sesion
    session_start();

    // Inicio ob
    ob_start();

    // Importo los archivos
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepasoMantenimiento/includes/functions.php");

    // Inicio el html
    inicio_html("Pagina 2", ['../styles/styles.css']);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SESSION['archivos_directorio']) {
        echo "<h1>Tenemos los siguientes documentos</h1>";
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <?php
                    foreach ($_SESSION['archivos_directorio'] as $clave) {
                        if (!is_dir($clave) && mime_content_type($_SESSION['ruta_mandada'] . "/$clave") == "image/jpeg") {
                            $tipo_mime = mime_content_type($_SESSION['ruta_mandada'] . "/$clave");
                            $ruta = "{$_SESSION['ruta_mandada']}/$clave";
                            ?>
                                <input type="checkbox" name="seleccion[]" value="<?=$clave?>">
                            <?php
                            echo "Nombre imagen: $clave, Tipo de dato: $tipo_mime<br>";
                            echo "<img src='$ruta'><br>";
                        }
                    }
                ?>
                <input type="submit" name="operacion2" id="operacion2" value="Mandar seleccion">
            </form>
        <?php
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['imagenes_seleccionadas'] = $_POST['seleccion'];
        header("Location: /EjerciciosMantenimientoEstado/Ejercicio2/02pantalla_imagenes_seleccionadas.php");
    }

    $datos_ob = ob_get_contents();
    ob_flush();

    fin_html();

?>