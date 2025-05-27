<?php
$usuarios_posibles = [
    '30A' => ['clave' => password_hash('usu123', PASSWORD_DEFAULT), 'nombre' => 'Juan'],
    '30B' => ['clave' => password_hash('usu456', PASSWORD_DEFAULT), 'nombre' => 'María']
];

$cursos = [
    'ofi' => ['descripcion' => 'Ofimática', 'precio' => 10],
    'prog' => ['descripcion' => 'Programación', 'precio' => 50],
    'ssoo' => ['descripcion' => 'Sistemas Operativos', 'precio' => 20],
    'rep' => ['descripcion' => 'Reparacion de PCs', 'precio' => 30]
];
?>