<?php
    // Inicializamos la sesión
    session_start();

    // Requerimos el archivo de funciones
    require_once($_SERVER['DOCUMENT_ROOT'] . '/EjerciciosRepasoNavidad/includes/funciones.php');

    // Iniciamos el HTML
    inicio_html("Listado de directorio", ["../styles/formulario.css", "../styles/general.css"]);

    // Si el método de petición es GET y ruta esta en el array de sesiones
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_SESSION['ruta'])) {
        ?>
            <h1>Bienvenido a la pantalla de Lista de Archivos</h1>

            <!-- Ahora, debemos de generar el formulario que recoge los datos de nuestro directorio
            teniendo en cuenta que debemos filtrar por tipo, solamente podemos tener tipo txt y
            csv -->

            <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                <fieldset>
                    <legend>
                        Selecciona archivo que deseas visualizar
                    </legend>
                    
                    <select name="archivo" id="archivo">
                        <?php
                            foreach(array_diff(scandir($_SESSION['ruta']), array('..', '.')) as $datos){
                                $extension = pathinfo($datos, PATHINFO_EXTENSION);
                                if ($extension == 'txt' || $extension == 'csv'){
                                    echo "<option value='{$datos}'>" . $datos . '</option>';
                                }
                            }
                        ?>
                    </select>
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
        <?php
    }

    else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Validamos el archivo recibido
        $archivo = filter_input(INPUT_POST, 'archivo', FILTER_SANITIZE_SPECIAL_CHARS);

        // Almacenamos el archivo en la sesión
        $_SESSION['archivo'] = $archivo;

        // Si el archivo ha sido recibido y almacenado con éxito, navegamos a la pantalla de operaciones
        if ($archivo) {
            echo "<h2>Archivo recibido con éxito</h2>";
            echo "<a href='PantallaOperacion.php'>Navega a la pantalla de operaciones</a>";
        } else {
            echo "<h2>No se ha recibido ningún archivo</h2>";
            echo "<a href='{$_SERVER['PHP_SELF']}'>Vuelve a intentarlo</a>";
        }
    }

    // Finalizamos el HTML
    fin_html();
?>