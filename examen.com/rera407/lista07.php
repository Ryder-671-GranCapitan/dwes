<?php
    session_start(); // Inicia la sesión

    require_once('./includes/funciones.php'); 
    require_once('./includes/jwt_include.php'); 
    require_once('./dbase.php');

    // Verifica si la cookie 'jwt' está establecida, si no, redirige a la pantalla inicial
    if (!isset($_COOKIE['jwt'])) {
        header('Location: index07.php');
    }

    $jwt = $_COOKIE['jwt']; // Obtiene el JWT de la cookie
    $payload = verificar_token($jwt); // Verifica el token y obtiene el payload

    // Si el token no es válido, redirige a la pantalla inicial
    if( !$payload ){
        header('Location: index07.php');
        exit(1);
    }
    
    // Si no se ha establecido la hora de inicio en la sesión, redirige a la pantalla inicial
    if( !isset($_SESSION['hora_inicio']) ){
        header('Location: index07.php');
        exit(1);
    }

    // Inicia el HTML con los estilos especificados
    inicio_html('Pantalla Cursos', ['./estilos/formulario.css', './estilos/general.css']);
    ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <fieldset>
                <legend>Elige que curso quieres</legend>
                <label for="curso">Curso</label>
                <select name="curso" id="curso">
                    <?php foreach($cursos as $key => $valor):?>
                        <option value="<?=$key?>"><?=$valor['descripcion']?></option>
                    <?php endforeach;?>
                </select>

                <label for="horas">Horas</label>
                <input type="number" name="horas" id="horas">
            </fieldset>
            <input type="submit" name="operacion" id="operacion" value="Seleccionar">
            <br>
            <br>
            <a href="./final07.php">Ver Cursos</a>
        </form>
    <?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if( isset($_POST['curso']) && isset($_POST['horas']) ){
        // Sanea y valida los datos del formulario
        $curso = filter_input(INPUT_POST, 'curso', FILTER_SANITIZE_SPECIAL_CHARS);
        $horas = filter_input(INPUT_POST, 'horas', FILTER_SANITIZE_NUMBER_INT);

        // Si los datos no son válidos, redirige a la misma página
        if( !$curso || !$horas || !array_key_exists($curso, $cursos)){
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit(1);
        }

        if (!isset($_SESSION['curso'])) {
            $_SESSION['curso'] = [];
        }

        if( array_key_exists($curso, $_SESSION['curso']) ){
            unset($_SESSION['curso'][$curso]);
        }
        
        $_SESSION['curso'][$curso] = $horas;
    }
}

?>