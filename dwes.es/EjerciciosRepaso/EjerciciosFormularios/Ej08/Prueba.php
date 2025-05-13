<?php

// Función para validar el login
function validarLogin($login) {
    return preg_match('/^[a-z0-9]+$/', $login);
}

// Función para validar el tipo de archivo
function validarTipoArchivo($tipo) {
    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    return in_array($tipo, $tiposPermitidos);
}

// Función para validar el tamaño del archivo
function validarTamanioArchivo($tamanio, $tipo) {
    $limites = [
        'image/jpeg' => 250 * 1024, // 250 KB
        'image/png'  => 225 * 1024, // 225 KB
        'image/webp' => 200 * 1024, // 200 KB
    ];
    return $tamanio <= ($limites[$tipo] ?? 150 * 1024); // Límite por defecto: 150 KB
}

// Función para mostrar la lista de archivos subidos
function mostrarArchivosSubidos($login) {
    $rutaCarpeta = "fotos/$login";
    if (is_dir($rutaCarpeta)) {
        $archivos = scandir($rutaCarpeta);
        echo "<h3>Archivos subidos por $login:</h3>";
        echo "<ul>";
        foreach ($archivos as $archivo) {
            if ($archivo !== '.' && $archivo !== '..') {
                echo "<li><a href='$rutaCarpeta/$archivo' target='_blank'>$archivo</a></li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No hay archivos subidos aún.</p>";
    }
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $archivo = $_FILES['foto'] ?? null;

    // Validar login
    if (!validarLogin($login)) {
        echo "<p>Error: El login solo puede contener letras minúsculas y dígitos.</p>";
    } elseif ($archivo && $archivo['error'] === UPLOAD_ERR_OK) {
        // Validar tipo de archivo
        if (!validarTipoArchivo($archivo['type'])) {
            echo "<p>Error: Solo se permiten archivos JPG, PNG o WEBP.</p>";
        } elseif (!validarTamanioArchivo($archivo['size'], $archivo['type'])) {
            echo "<p>Error: El archivo excede el tamaño permitido.</p>";
        } else {
            // Crear la carpeta si no existe
            $rutaCarpeta = "fotos/$login";
            if (!is_dir($rutaCarpeta)) {
                mkdir($rutaCarpeta, 0755, true);
            }

            // Guardar el archivo
            $rutaArchivo = "$rutaCarpeta/" . basename($archivo['name']);
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                echo "<p>Archivo subido correctamente.</p>";
            } else {
                echo "<p>Error al subir el archivo.</p>";
            }
        }
    } else {
        echo "<p>Error: No se ha seleccionado un archivo válido.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Fotografías</title>
</head>
<body>
    <h1>Subir Fotografías</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" pattern="[a-z0-9]+" required><br><br>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>

        <label for="foto">Foto:</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png, image/webp" required><br><br>

        <button type="submit">Subir</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($login)) {
        mostrarArchivosSubidos($login);
    }
    ?>
</body>
</html>