<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/formulario.css">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/tablas.css">
    <title>Añadir Actividad</title>
</head>

<body>
    <h1>Añadir nueva Actividad</h1>
    <form>
        <fieldset>
            <legend>Introducir nueva Actividad</legend>

            <label for="nombre">nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">descripcion:</label>
            <input type="text" name="descripcion" id="descripcion" required>

            <label for="nivel">nivel:</label>
            <select name="nivel" id="nivel" required>
            </select>

            <label for="cuota_mes">Cuota mes:</label>
            <input type="text" name="cuota_mes" id="cuota_mes">


        </fieldset>
        <button id="operacion" value="enviar">Enviar</button>
    </form>

    <div id="divRespuesta"></div>
    <script src="../js/script.js"></script>
</body>

</html>