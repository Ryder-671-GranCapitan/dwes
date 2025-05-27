<?php

function generar_token(array $usuario, string $clave) {

$jwt = "";

// Codificamos los datos en formato JSON.
$cabecera = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
$payload = json_encode($usuario);

// Pasarlo, tanto cabecera como payload, a base64. 
$cabecera_base64 = base64_encode($cabecera);
$payload_base64 = base64_encode($payload);

// Reemplazar caracteres que pueden incluir dentro de los valores pasados.
$cabecera_base64_limpio = str_replace(["+","/","="], ["-", "_", ""], $cabecera_base64);
$payload_base64_limpio = str_replace(["+","/","="], ["-", "_", ""], $payload_base64);

// Creo la firma.
$firma = hash_hmac("sha256", $cabecera_base64_limpio.".".$payload_base64_limpio, $clave, true);

// Firma en base_64
$firma_base64 = base64_encode($firma);

// Reemplazo caracteres que puede incluir la firma.
$firma_base64_limpia = str_replace(["+","/","="], ["-", "_", ""], $firma_base64);

$jwt = $cabecera_base64_limpio . "." . $payload_base64_limpio . "." . $firma_base64_limpia;

return $jwt;

}

?>