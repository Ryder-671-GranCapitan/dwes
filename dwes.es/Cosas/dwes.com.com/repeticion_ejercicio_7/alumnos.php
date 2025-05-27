<?php
$archivo = "alumnos.csv";
$mensaje = "";

// Si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nif = $_POST["nif"] ?? '';
    $nombre = $_POST["nombre"] ?? '';
    $apellidos = $_POST["apellidos"] ?? '';
    $grupo = $_POST["grupo"] ?? '';

    // Validación simple
    if ($nif && $nombre && $apellidos && $grupo) {
        $nuevaFila = [$nif, $nombre, $apellidos, $grupo];
        $fp = fopen($archivo, 'a');
        fputcsv($fp, $nuevaFila);
        fclose($fp);
        $mensaje = "✅ Alumno añadido correctamente.";
    } else {
        $mensaje = "❌ Por favor, rellena todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Alumno</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin-top: 20px; }
        input { display: block; margin-bottom: 10px; padding: 8px; width: 100%; }
        button { padding: 10px 15px; }
        .mensaje { margin-top: 15px; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Añadir Nuevo Alumno</h2>

    <form method="POST">
        <label>NIF:
            <input type="text" name="nif" required>
        </label>
        <label>Nombre:
            <input type="text" name="nombre" required>
        </label>
        <label>Apellidos:
            <input type="text" name="apellidos" required>
        </label>
        <label>Grupo:
            <input type="text" name="grupo" required>
        </label>
        <button type="submit">Guardar</button>
    </form>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

</body>
</html>
