<?php
    // Inicio sesion
    session_start();

    // Importo los archivos necesarios
    require_once('./includes/funciones.php');
    require_once('./includes/jwt_include.php');
    require_once('./db.php');

    // Si es get la mando a la pagina anterior
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        header('Location: Inicio.php');
        exit(1);
    }

    // Autenticamos al usuario
    function autenticar($id, $password, $nombre) {
        // Accedemos al array de usuario haciendolo global
        global $usuarios;

        if (!array_key_exists($id, $usuarios)) { // Verifica si el id esta en usuarios
            return false;
        }

        // Comprueba si la contraseña introducida es igual a la que hay en el archivo
        return password_verify($password, $usuarios[$id]['clave']);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Se verifica que los campos id, nombre y password han llegado bien en la peticion
        if (!isset($_POST['id'], $_POST['password'], $_POST['nombre'])) {
            header('Location: Inicio.php');
            exit(1);
        }

        // Una vez que hemos comprobado que la peticion ha llegado con los datos, se sanitizan los datos
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

        // Si el id, contraseña o nombre, o directamente la autenticacion falla, se devuelve a la pagina de inicio
        if (!$id || !$password || !$nombre || !autenticar($id, $password, $nombre)) {
            error_log("Autenticación fallida para el usuario: $id"); // Añade esta línea para depuración
            header('Location: Inicio.php');
            exit(1);
        }

        // SI todo ha ido bien creo un array con los datos del usuario
        $usuario = [
            'id' => $id,
            'nombre' => $nombre
        ];

        // Ahora ya se genera token JWT para el usuario
        $jwt = generar_token($usuario);

        // Establezco al cookie
        setcookie('jwt', $jwt, time() + 2 * 60 * 60, '/');

        // Guardo la hora de inicio en la sesion
        $_SESSION['hora_comienzo'] = gmdate('M d Y H:i:s', time());

        // Redirige a la siguiente pantalla que es la del CARRITO
        header('Location: Carrito.php');
        exit(1); // Asegúrate de que el script se detiene después de la redirección
    }
?>