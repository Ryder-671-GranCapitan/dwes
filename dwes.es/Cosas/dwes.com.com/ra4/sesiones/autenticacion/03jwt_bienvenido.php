<?php

session_start();

// require_once();

// 1º Obtener el token.
$jwt = $_COOKIE['jwt'];

// 2º Verificar el token.
$payload = verificar_token($jwt);

echo "<header>Autenticacion con JWT</header>";
if ( $payload ){
  // 3º Si el token es válido se presenta la página.
  echo "<p>Bienvenido a la zona restringida</p><br>";
  echo "id de usuario: {$payload['id']}";
  echo "Nombre de usuario: {$payload['username']}";
  echo "Rol de usuario: {$payload['role']}";
}
else {
  // 4º Si el token no es válido, se emite mensaje de error (o redirección al inicio).
  echo "<p>Error al iniciar sesión. El token no se ha autenticado correctamente.</p>";
}

function verificar_token($jwt){
  $partes = explode(".", $jwt);
  if (count($partes) == 3){
    // Token no válido.
    return false;
  }
  else{

    // Separo las partes del jwt.
    list($cabecera_base64_limpio, $payload_base64_limpio, $firma_base64_limpio) = $partes;

    // Obtengo la clave.
    $clave = leer_clave();

    // Creo la firma.
    $firma = hash_hmac("sha256", $cabecera_base64_limpio .".". $payload_base64_limpio.".".$firma_base64_limpio, $clave, true);

    // Reemplazamos los valores de la firma.
    $firma_base64 = base64_encode($firma);
    $firma_base64_nuevo = str_replace(["+", "/", "="],["-","_",""], $firma_base64);


    // Verificamos que el token no sea distinto al que hemos recibido.
    if ($firma_base64_limpio != $firma_base64_nuevo){
        return false;
    }

    // Aqui el token es valido.
    // Obtenemos el payload(datos de usuario) del JWT.
    $payload_base64 = str_replace(["-","_",""],["+", "/", "="], $payload_base64_limpio);
    $payload_json = base64_decode($payload_base64);
    $payload = json_decode($payload_json);

    return $payload;
  }
}

function leer_clave(){
  if ( file_exists('03clave.txt')){
    $fichero_clave = fopen("03clave.txt", "r");
    $clave = fgets($fichero_clave);
    fclose($fichero_clave);
    return $clave;
  }
  else{
    $clave = "abc123";
  }
}


?>