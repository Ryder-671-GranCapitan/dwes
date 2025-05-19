<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/EjerciciosFormularios/Ej08/includes/funciones.php");

    // Controlamos las peticiones
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        inicio_html("Logueo del usuario" , ['./styles/general.css', './styles/formulario.css']);
        echo "<h1>Bienvenido. Logueate y pasa el porro manin</h1>";
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Introduce los datos</legend>
                    
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" name="nombre" id="nombre" pattern="[a-z0-9]+">

                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png, image/webp">

                    <label for="titulo">Titulo</label>
                    <input type="text" name="titulo" id="titulo">
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
        <?php
        fin_html();
    } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

        inicio_html("Logueo del usuario" , ['./styles/general.css', './styles/formulario.css']);
        echo "<h1>Bienvenido. Logueate y pasa el porro manin</h1>";
        ?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Introduce los datos</legend>
                    
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" name="nombre" id="nombre" pattern="[a-z0-9]+">

                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen" accept="image/jpeg, image/png, image/webp">

                    <label for="titulo">Titulo</label>
                    <input type="text" name="titulo" id="titulo">
                </fieldset>
                <input type="submit" name="operacion" id="operacion">
            </form>
        <?php
        fin_html();

        // Array para la validacion
        $datos_validos = [
            'image/jpg' => 250,
            'image/png' => 225,
            'image/webp' => 200,
        ];

        // Validacion de datos
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
        $imagen = $_FILES['imagen'];
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);

        // Fichero de subida
        $subida = $_SERVER['DOCUMENT_ROOT'] . "/EjerciciosRepaso/EjerciciosFormularios/Ej08/$nombre";

        // Comprobacion del archivo de subida
        echo "$titulo <br>"; 
        echo "Nombre Archivo: " . $imagen['name'] . "<br>";
        echo "Tipo de Archivo: " . mime_content_type($imagen['tmp_name']) . "<br>";

        if (array_key_exists(mime_content_type($imagen['tmp_name']), $datos_validos)) {
            if (!file_exists($subida) || !is_dir($subida)) {
                if (!mkdir($subida, 0755, true)) {
                    echo "La carpeta no exite manin";
                }
            }
            if (move_uploaded_file($imagen['tmp_name'], $subida . "/{$imagen['name']}")) {
                echo "Ta bueno manin";
            }
        }

        $archivos = scandir("$nombre");
        echo "<h3>Archivos subidos por $nombre:</h3>";
        echo "<ul>";
        foreach ($archivos as $archivo) {
            if ($archivo !== '.' && $archivo !== '..') {
                echo "<li><a href='$nombre/$archivo' target='_blank'>$archivo</a></li>";
            }
        }
        echo "</ul>";
    }
?>