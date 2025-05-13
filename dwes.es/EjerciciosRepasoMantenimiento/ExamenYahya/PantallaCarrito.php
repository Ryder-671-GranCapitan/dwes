<?php
    session_start(); // Inicia la sesión

    require_once('./includes/funciones.php'); // Incluye el archivo de funciones
    require_once('./includes/jwt_include.php'); // Incluye el archivo para manejo de JWT
    require_once('./db.php'); // Incluye el archivo de conexión a la base de datos

    // Verifica si la cookie 'jwt' está establecida, si no, redirige a la pantalla inicial
    if (!isset($_COOKIE['jwt'])) {
        header('Location: PantallaInicial.php');
    }

    $jwt = $_COOKIE['jwt']; // Obtiene el JWT de la cookie
    $payload = verificar_token($jwt); // Verifica el token y obtiene el payload

    // Si el token no es válido, redirige a la pantalla inicial
    if( !$payload ){
        header('Location: PantallaInicial.php');
        exit(1);
    }
    
    // Si no se ha establecido la hora de inicio en la sesión, redirige a la pantalla inicial
    if( !isset($_SESSION['hora_inicio']) ){
        header('Location: PantallaInicial.php');
        exit(1);
    }

    // Inicia el HTML con el título 'Carrito' y los estilos especificados
    inicio_html('Carrito', ['./estilos/formulario.css', './estilos/general.css']);

    // Muestra la información del usuario obtenida del payload del JWT
    echo "<h2>Identificador     :" . $payload['id'] . "</h2> <br>";
    echo "<h2>Nombre            :" . $payload['nombre'] . "</h2> <br>";
    echo "<h2>Fecha de comienzo :" . $_SESSION['hora_inicio'] . "</h2> <br>";
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <fieldset>
                <legend>Entradas</legend>

                <label for="espectaculo">Espectaculo</label>
                <select name="espectaculo" id="espectaculo">
                    <?php foreach($espectaculos as $key => $valor):?>
                        <option value="<?=$key?>"><?=$valor['titulo']?></option>
                    <?php endforeach;?>
                </select>

                <label for="fila">Fila</label>
                <input type="number" name="fila" id="fila" min=1 max=20>
            </fieldset>
            <input type="submit" value="Añadir Entrada">
            <br>
            <br>
            <a href="./PantallaFinal.php">Ver Entradas</a>
        </form>
    <?php

    // Si el método de la solicitud es POST, procesa el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if( isset($_POST['espectaculo']) && isset($_POST['fila']) ){
            // Sanea y valida los datos del formulario
            $espectaculo = filter_input(INPUT_POST, 'espectaculo', FILTER_SANITIZE_SPECIAL_CHARS);
            $fila = filter_input(INPUT_POST, 'fila', FILTER_SANITIZE_NUMBER_INT);
            $fila = filter_var($fila, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 20]]);

            // Si los datos no son válidos, redirige a la misma página
            if( !$espectaculo || !$fila || !array_key_exists($espectaculo, $espectaculos)){
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit(1);
            }

            // Si no existe la variable de sesión 'entradas', la inicializa como un array
            if (!isset($_SESSION['entradas'])) {
                $_SESSION['entradas'] = [];
            }

            // Si ya existe una entrada para este espectáculo, la elimina para reemplazarla con el nuevo valor
            if( array_key_exists($espectaculo, $_SESSION['entradas']) ){
                unset($_SESSION['entradas'][$espectaculo]);
            }
            
            // Establece la clave del espectáculo y la fila en la variable de sesión 'entradas'
            $_SESSION['entradas'][$espectaculo] = $fila;
        }
    }

?>