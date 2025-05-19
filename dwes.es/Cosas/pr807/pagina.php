<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/estilos.css">
    <title>Document</title>
</head>
<body>
    <form>
        <fieldset>
            <legend>Introduzca su nueva forma de envio</legend>
            <label for="id_fe">Id Forma Envio</label>
            <input type="text" name="id_fe" id="id_fe" required>

            <label for="descripcion">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" required>

            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" required>

            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="coste">Coste</label>
            <input type="number" name="coste" id="coste" required>
        </fieldset>
        <button id="operacion" value="Enviar">Enviar</button>
    </form>
    <div id="respuesta"></div>
</body>
<script src="./js/script.js"></script>
</html>


