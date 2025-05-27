<?php

// Lo primero es tener una interfaz de la que implementen nuestros modelos
// ¿Porque?
// Porque van a usar todos siempre el mismo método, así que lo creamos en una interfaz y que cada clase lo sobreescriba como quiera

// Creamos el espacio de nombres
namespace mvc\modelo;

// Creamos la interfaz
interface Modelo{
    // Y el método que este tiene (que esta vez si que es el despacha)
    public function despacha(): mixed;
}
?>