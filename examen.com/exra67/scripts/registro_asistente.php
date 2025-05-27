<?php
    // Iniciamos sesion
    session_start();
    
    // Iniciamos ob
    ob_start();

    // Importamos los archivos necesarios
    use util\Html;

    // Iniciamos el html
    Html::inicio("Indicar Email", ["../../estilos/general.css", "../../estilos/formulario.css"]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <h1>Indica que Actividad desea registrar</h1>
            <legend>Inserta Actividad</legend>
            <fieldset>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    <label for="fecha_incipcion">Fecha Inscripcion</label>
                    <input type="text" name="fecha_inscripcion" id="fecha_inscripcion" required>

                    <label for="actividad">Actividad</label>
                    <select name="actividad" id="actividad">
                        <option value="1">Simulador Red GNS3</option>
                        <option value="2">Configuracion Cortafuegos FTP</option>
                        <option value="3">Despliegue Rapido Docker</option>
                    </select>
                </form>
                <input type="submit" id="operacion" name="operacion" value="Enviar">
            </fieldset>

            <!-- // Se ñade un boton o enlace para cerrar sesion y volver al primer script -->
            <form action="indicar_email.php" method="post">
                <input type="submit" name="cerrar_sesion" value="Cerrar Sesion">
            </form>
        <?php
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recogemos el dato del formulario y lo saneamos
        $fecha_inscripcion = filter_input(INPUT_POST, 'fecha_inscripcion', FILTER_SANITIZE_SPECIAL_CHARS);
        $actividad = filter_input(INPUT_POST, 'actividad', FILTER_SANITIZE_SPECIAL_CHARS);

        // Lo mandamos a la sesion
        $_SESSION['fecha_inscripcion'] = $fecha_inscripcion;
        $_SESSION['actividad'] = $actividad;
    }

?>