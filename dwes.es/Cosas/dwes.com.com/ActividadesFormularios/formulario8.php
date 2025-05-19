Crear un script PHP con un formulario en el que los usuarios pueden subir fotografías
en diferentes formatos de imagen.
a) Los archivos se guardan en la carpeta fotos/<login> de la raíz de
documentos del servidor, siendo <login> el del usuario que sube las fotos. Si
no está creada se crea con los permisos necesarios para poder crear nuevos
archivos.

b) La página es autogenerada.

c) Se valida que el archivo subido es JPG, PNG o WEBP. Al guardarse el archivo se
emplea el mismo nombre del archivo original del usuario.

d) Se impone un límite de formulario para el tamaño de los archivos de imagen a 150
KB. Opcionalmente, se pueden establecer los siguientes límites:
• Archivos jpg → 250 KB.
• Archivos png → 225 KB.
• Archivos webp → 200 KB.

e) Los campos del formulario son:
Campo   Tipo de campo                                     Valores
Login   Texto Solo letras minúsculas y dígitosnuméricos
Foto    File
Título  Text

f) La subida de archivos es cíclica y después de hacer una tiene que visualizarse la
lista de archivos subida por el usuario hasta ese momento.

<?php
define("DirectorioFotos", $_SERVER['DOCUMENT_ROOT'] . "/fotosEjercicio8/" . $login);

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

// Configuración de tamaños máximos de archivos según el tipo
$tamanosMaximos = [
    'image/jpeg' => 250 * 1024,  // 250 KB para JPG
    'image/png' => 225 * 1024,   // 225 KB para PNG
    'image/webp' => 200 * 1024   // 200 KB para WEBP
];

inicio_html("Subir Fotos", ["/estilos/formulario.css", "/estilos/general.css", "/estilos/tabla.css"]);

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);
    $login = preg_match("/[a-z0-9]+/", $login) == 0 ? "" : $login;

    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!is_dir(DirectorioFotos)) {
        if(!mkdir(DirectorioFotos, 0755)) {
            echo "Error al crear el directorio de fotos";
        }
        else {
            echo "Directorio de fotos creado correctamente";
        }
    }

    if (isset($_FILES['foto'])) {
        echo "<h3>Datos del archivo</h3>";
        echo "<p>";
        echo "Nombre: {$_FILES['foto']['name']}<br>";
        echo "Tipo: {$_FILES['foto']['type']}<br>";
        echo "Tamaño: {$_FILES['foto']['size']}<br>";
        echo "Archivo temporal: {$_FILES['foto']['tmp_name']}<br>";
        echo "Código de error: {$_FILES['foto']['error']}";
        echo "</p>";
    }

    elseif ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $tipo = $_FILES['foto']['type'];
        echo "<h3>Error. No se ha subido el archivo</h3>";   
    }

    elseif ($_FILES['foto']['size'] > $tamanosMaximos[$tipo]) {
        echo "<h3>Error. El archivo supera el tamaño máximo permitido</h3>";
    }

    else {
        $tipos_permitidos = ['image/jpeg', 'image/png', 'image/webp'];

        $tipo_mime1 = mime_content_type($_FILES['foto']['tmp_name']);
        $tipo_mime2 = $_FILES['foto']['type'];
        $tipo_mime3 = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['foto']['tmp_name']);

        if ($tipo_mime1 == $tipo_mime2 && $tipo_mime2 == $tipo_mime3 && in_array($tipo_mime1, $tipos_permitidos)) {
            $ruta_archivo = DirectorioFotos . "/" . basename($_FILES['foto']['name']);
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta)) {
                echo "<h3>Archivo subido correctamente</h3>";
            }
            else {
                echo "<h3>Error al subir el archivo</h3>";
            }
        }
        else {
            echo "<h3>Error. El archivo no es una imagen válida</h3>";
            
        }
    }
}
else { // esto es lo mismo que poner GET
?>
    <header>Subir Fotos</header>
    <form method="POST" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
        <fieldset>

            <legend>Subir una foto</legend>

            <label for="login">Login</label>
            <input type="text" name="login" id="login" pattern="[a-z0-9]+" required>

            <label for="foto">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/jpeg, image/png, image/webp" required>

            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" required>

        </fieldset>
        <input type="submit" value="Subir foto" name="Subir">
    </form>
    <footer>
        <a href="<?=$_SERVER['PHP_SELF']?>">Ver fotos subidas</a>
    </footer>

<?php
}
fin_html();
?>