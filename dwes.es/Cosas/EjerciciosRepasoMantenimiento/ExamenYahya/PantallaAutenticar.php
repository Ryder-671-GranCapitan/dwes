<?php
    // Inicia una nueva sesión o reanuda la sesión existente
    session_start();

    // Incluye archivos necesarios para funciones adicionales y JWT
    require_once('./includes/funciones.php');
    require_once('./includes/jwt_include.php');
    require_once('./db.php');

    // Si la solicitud es de tipo GET, redirige a PantallaInicial.php
    if( $_SERVER['REQUEST_METHOD'] == 'GET' ){
        header("Location: PantallaInicial.php");
        exit(1);
    }

    // Función para autenticar al usuario
    function autenticar($id, $password, $nombre) {
        // Accede a la variable global $usuarios
        global $usuarios;

        // Verifica si el ID de usuario existe en el array $usuarios
        if (!array_key_exists($id, $usuarios)) {
            return false;
        }

        // Verifica si la contraseña proporcionada coincide con la almacenada
        return password_verify($password, $usuarios[$id]['clave']);
    }

    // Si la solicitud es de tipo POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Verifica que los campos 'id', 'password' y 'nombre' estén presentes en la solicitud
        if (!isset($_POST['id'], $_POST['password'], $_POST['nombre'])) {
            header("Location: PantallaInicial.php");
            exit(1);
        }

        // Sanitiza y obtiene los valores de los campos del formulario
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);

        // Si alguno de los campos es inválido o la autenticación falla, redirige a PantallaInicial.php
        if( !$id || !$password || !$nombre || !autenticar($id, $password, $nombre)){ 
            header('Location: PantallaInicial.php');
            exit(1);
        }

        // Crea un array con los datos del usuario autenticado
        $usuario = [
            'id' => $id,
            'nombre' => $nombre
        ];

        // Genera un token JWT para el usuario
        $jwt = generar_token($usuario);

        // Establece una cookie con el token JWT que expira en 2 horas
        setcookie('jwt', $jwt, time() + 2 * 60 * 60, '/');

        // Guarda la hora de inicio de sesión en la sesión
        $_SESSION['hora_inicio'] = gmdate('M d Y H:i:s', time());

        // Redirige al usuario a PantallaCarrito.php
        header('Location: PantallaCarrito.php');
    }

?>