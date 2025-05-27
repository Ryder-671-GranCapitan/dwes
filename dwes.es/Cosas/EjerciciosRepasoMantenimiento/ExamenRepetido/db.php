<?php
    $usuarios = [
        '123456' => ['clave' => password_hash('Abc123', PASSWORD_DEFAULT), 'nombre' => 'Fernando Munoz'],
        '654321' => ['clave' => password_hash('321cba', PASSWORD_DEFAULT), 'nombre' => 'Fernanda Gonzalez']
    ];

    $espectaculos  = [
        'chi01' => ['titulo' => 'Chicago, el musical', 'fila1_10' => 25, 'fila11_20' => 20],
        'can02' => ['titulo' => 'Concierto ano nuevo', 'fila1_10' => 25, 'fila11_20' => 15],
        'ope03' => ['titulo' => 'Opera Don Giovanni', 'fila1_10' => 30, 'fila11_20' => 25],
        'ama04' => ['titulo' => 'Amadeus', 'fila1_10' => 40, 'fila11_20' => 35]
    ]
?>