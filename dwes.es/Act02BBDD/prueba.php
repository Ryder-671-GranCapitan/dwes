<?php
    $dsn = 'mysql:host=mysql;dbname=tiendaol;charset=utf8mb4';
    $usuario = 'user';
    $clave = 'password';

    $opciones = [
        PDO::ATTR_CASE                 => PDO::CASE_LOWER,
        PDO::ATTR_EMULATE_PREPARES     => false,
        PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $usuario, $clave, $opciones);
?>