<?php
    // Iniciamos sesion
    session_start();
    
    // Iniciamos ob
    ob_start();

    // Importamos los archivos necesarios
    use util\Html;

    // Cierre y Apertura de sesion
    if(isset($_POST['cerrar_sesion'])) {
        session_destroy();
        session_start();
    }

    // iniciamos el html
    Html::inicio("Indicar Email", ["../../estilos/general.css", "../../estilos/formulario.css"]);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        ?>
            <!-- el destino del formulario es registro_asistente.php -->
            <h1>Indique su Email, porfavor</h1>
            <legend>Email</legend>
            <fieldset>
                <form action="registro_asistente.php" method="post">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </form>
                <input type="submit" id="operacion" name="operacion" value="Enviar">
            </fieldset>
        <?php
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recogemos el dato del formulario y lo saneamos
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        // Lo mandamos a la sesion
        $_SESSION['email'] = $email;

        // Redirigimos a registro_asistente.php
        header("Location: registro_asistente.php");
    }

    // Cerramos el html
    Html::fin();

    // Limpiamos el buffer
    ob_flush();

?>