<?php
    session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . '/Act02BBDD/util/Autocarga.php');

    use orm\ORMCliente;
    use util\Autocarga;
    use util\Html;

    Autocarga::autoload_reg();

    $error = [];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['origin'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            $clave = $_POST['clave'];

            $ORMcliente = new ORMCliente();

            if ($_SESSION['cliente'] = $ORMcliente->autenticar_cliente($email, $clave)) {
                header("Location: 02_dir_env.php");
                exit(2);
            }
            $error[] = "<h2>La Autenticacion no ha tenido exito</h2>";
        }

        if (isset($_POST['operacion']) && htmlspecialchars($_POST['operacion']) == 'cerrar_session') {
            $cookie = session_get_cookie_params();

            setcookie(session_name(), '', time() - 1000, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);

            session_unset();

            session_destroy();

            session_start();
        }
    }

    Html::inicio("Autenticacion", ['./estilos/general.css', './estilos/formulario.css']);
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <fieldset>
        <legend>Login</legend>
        <input type="hidden" name="origin" value="auth">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="clave">Clave</label>
        <input type="password" name="clave" id="clave">
    </fieldset>
    <input type="submit" value="Login">
</form>

<?php
if ($error)  {
    echo implode("<br>", $error);
}
Html::fin();
?>