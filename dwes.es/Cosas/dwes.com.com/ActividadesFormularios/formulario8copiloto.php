<?php

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
    $login = strtolower(trim($_POST['login']));
    $titulo = trim($_POST['titulo']);

    // Validación de login: solo letras minúsculas y números
    if (!preg_match('/^[a-z0-9]+$/', $login)) {
        echo "<p style='color:red;'>El campo Login solo puede contener letras minúsculas y dígitos numéricos.</p>";
    }

    // Validación de título: obligatorio y no vacío
    elseif (empty($titulo)) {
        echo "<p style='color:red;'>El campo Título es obligatorio.</p>";
    }

    // Validación del archivo subido
    elseif ($_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
        echo "<p style='color:red;'>Debe subir un archivo de imagen.</p>";
    } elseif ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tipoArchivo = mime_content_type($_FILES['foto']['tmp_name']);
        $tamanoArchivo = $_FILES['foto']['size'];

        // Validación de tipo de archivo
        if (!array_key_exists($tipoArchivo, $tamanosMaximos)) {
            echo "<p style='color:red;'>El archivo debe estar en formato JPG, PNG o WEBP.</p>";
        } else {
            // Validación del tamaño de archivo
            $tamanoMaximo = $tamanosMaximos[$tipoArchivo];
            if ($tamanoArchivo > $tamanoMaximo) {
                echo "<p style='color:red;'>El tamaño del archivo excede el límite de " . ($tamanoMaximo / 1024) . " KB para este tipo.</p>";
            } else {
                $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . '/fotos/' . $login;

                // Crear el directorio 'fotos/<login>' si no existe
                if (!is_dir($directorioDestino)) {
                    mkdir($directorioDestino, 0755, true);
                }

                // Definir la ruta completa para guardar el archivo con su nombre original
                $rutaArchivo = $directorioDestino . '/' . basename($_FILES['foto']['name']);

                // Mover el archivo a la carpeta de destino
                if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaArchivo)) {
                    echo "<p>Foto subida correctamente con el título: $titulo</p>";
                } else {
                    echo "<p style='color:red;'>No se pudo guardar el archivo. Verifique los permisos del directorio.</p>";
                }
            }
        }
    } else {
        echo "<p style='color:red;'>Error al subir el archivo.</p>";
    }

    // Mostrar las fotos subidas por el usuario
    $directorioUsuario = $_SERVER['DOCUMENT_ROOT'] . '/fotos/' . $login;
    if (is_dir($directorioUsuario)) {
        $archivos = array_diff(scandir($directorioUsuario), ['.', '..']);
        echo "<h2>Fotos subidas por $login:</h2><ul>";
        foreach ($archivos as $archivo) {
            $ruta_relativa = "/fotos/$login/$archivo";
            echo "<li><img src='$ruta_relativa' alt='$archivo' style='width:150px;'> $archivo</li>";
        }
        echo "</ul>";
    }
} else { // esto es lo mismo que poner GET
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
        <a href="/index.php">Volver al inicio</a>
    </footer>
<?php
}
fin_html();
?>