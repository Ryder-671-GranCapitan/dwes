<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/estilos.css">
    <title>Document</title>
</head>
<body>

<h2>Insertar alumnos</h2>

<form>
    <fieldset>
        <legend>Introduce los datos del alumno</legend>
        <label for="dni">Dni del alumno</label>
        <input type="text" id="dni" class="dni">
        <label for="nombre">Nombre del alumno</label>
        <input type="text" id="nombre" class="nombre">
        <label for="apellidos">Apellidos del alumno</label>
        <input type="text" id="apellidos" class="apellidos">
        <label for="fecha_nacimiento">Fecha de nacimiento del alumno</label>
        <input type="date" id="fecha_nacimiento" class="fecha_nacimiento">
        <label for="curso">Curso del alumno</label>
        <select id="curso" class="curso" name="curso">
            <option value="1DAW">1DAW</option>
            <option value="2DAW">2DAW</option>
            <option value="1DAM">1DAM</option>
            <option value="2DAM">2DAM</option>
        </select>
        <label for="grupo">Grupo del alumno</label>
        <select name="grupo" id="grupo" class="grupo">
            <option value="A">A</option>
            <option value="B">B</option>
        </select>
    </fieldset>
    <button id="mandarPeticion" class="mandarPeticion">Mandar datos</button>
</form>

<div id="tabla-datos-introducidos">
    
</div>

</body>
<script src="./js/script.js"></script>
</html>