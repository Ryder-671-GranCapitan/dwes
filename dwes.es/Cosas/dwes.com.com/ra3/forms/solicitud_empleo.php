<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/includes/funciones.php");

inicio_html("Proceso de formulario 1", ["/estilos/general.css"]);

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$contraseña = $_POST['clave'];

echo "Nombre: $nombre<br>";
echo "Mail: $email<br>";
echo "Contraseña: $contraseña<br>";
fin_html();
?>