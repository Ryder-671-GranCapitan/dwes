<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/*
  Script: 04subida_archivo.php
  Descripción: ejemplo de formulario para subida de archivos al servidor desde los clientes.

      SUBIDA DE ARCHIVOS
      ------------------

      * Un formulario permite subir archivos si el elemento for tiene el atributo
        enctype="multipart/form-data". Además trendrá al menos un elemento input con 
        type = "file".
      
      * Directivas php.ini que regulan la subida de archivos:
        - file_uploads <bool> -> Indica si la subida de archivos está activada.
        - upload_max_filesize <int> -> Límite del tamaño del archivo a subir en bytes.
                                       el límite por defecto son 2mb.
        - max_file_uploads <int> -> Número máximo de archivos que se pueden subir en una petición.
                                    por defecto son 20.
        - post_max_size <int> -> Tamaño máximo de la petición post. Por defecto 8Mb.
        - upload_tmp_dir <dir> -> Directorio TEMPORAL donde se almacenan los archivos subidos.
                                  Por defecto, según el SO: /tmp (Linux). C:\TEMP (Windows).
        
      * Todos los parámetros anteriores en php.ini son configurables con la función ini_set().

      * Además, podemos poner límite del tamaño de archivo subido:
        - Duro -> Directiva upload_max_filesize en php.ini.
        - Blando -> Campo oculto de formulario MAX_FILE_SIZE.
        - De usuario -> El desarrollador puede establecer límites en campos ocultos. Viene
                        bien para cuando quiero poner un límite para diferentes tipos de archivos.
  */


require_once(__DIR__ . '/../../includes/funciones.php');
define("DIRECTORIO_PDF", $_SERVER['DOCUMENT_ROOT'] . "/archivos_cv");

inicio_html("Subida de archivos", ['./styles/general.css', ]);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $dni = $_POST['dni'];
  $nombre = $_POST['nombre'];

  $limite_pdf = $_POST['limite_pdf'];

  echo "<h3>Datos recibidos en la petición</h3>";
  echo "<p>El dni es $dni y el nombre es $nombre</p>";
  echo "<p>El limite para archivos PDF es $limite_pdf;</p>";

  /*
    Creación del directorio de subiuda
    ------------------------------------
  - El usuario que ejecuta el servicio web (Apache) en el servidor necesita tener permisos de escritura sobre el directorio padre del directorio de subida
  
  - 1ª forma: creamos el directorio desde el SO y le asignamos propietario o permisos
  Si el usuario no es propietario del directorio de subida, tiene que tener permisos 777: rwx rwx rwx. No recomendable, cualquier usuario puede accede al directorio y hacer lo que quiera

  - 2ª forma: modificar la acl del directorio de subida (si esta creado previamente) o del directorio padre (si queremos crearlo en el script php).

  Empleamos la 2ª forma y asignamos rwx al usuario que ejecuta Apache () sobre el directorio padre del directorio de subida y este se crea en el script php

  */

  if (!is_dir(DIRECTORIO_PDF)) {
    if (mkdir(DIRECTORIO_PDF, 0750)) {
      echo "<h3>Error. No se ha podido crear el directorio de subida</h3>";
    } else {
      echo "<p>El directorio de subida se ha creado con exito</p>";
    }
  }
}

/*
  Acceso a los archivos subidos
  -----------------------------

  Array global $_FILES contiene la información de los archivos que se han subido. Es un array asociativo cuya clase es el nombre del campo file del formulario.
  CAda elemento es, a su vez, otro array asociativo con los siguientes elementos:

  - name -> El nombre del archivo subido. ¡¡¡CUidado!!! con la convención de nombres del SO del cliente.
  - type -> TIpo MIME del archivo
  - size -> Tamaño en bytes del archivo
  - tap_name -> Nombre (ruta absoluta) del archivo subido temporalmente.
  - error -> codigo de error si hubo alguno
*/

/*
  1ª Comprobación. Existe el control del formulario para subir un archivo y la petición ha llegado al servidor
*/

if (isset($_FILES['archivo_cv'])) {
  echo "<h3>Datos del archivo:</h3>";
  echo "<p>";
  echo "Nombre: {$_FILES['archivo_cv']['name']}<br>";
  echo "Tipo: {$_FILES['archivo_cv']['type']}<br>";
  echo "Tamaño: {$_FILES['archivo_cv']['size']}<br>";
  echo "Archivo temporal: {$_FILES['archivo_cv']['tmp_name']}<br>";
  echo "Codigo de error: {$_FILES['archivo_cv']['error']}<br>";
  echo "</p>";


  /*
2ª Cmprobacion. El usuario ha enviado el formulario pero sin archivo. El usuario no rellena el campo para el archivo
  */
  if ($_FILES['archivo_cv']['error'] == UPLOAD_ERR_NO_FILE) {
    // No se ha subido el archivo
    echo "<h3>ERROR. No se ha subido el archivo</h3>";
  } else {
    /*
      3ª Comprobacion, Se comprueba que el archivo está dentro de los limites de tamaño establecidos
    */

    if ($_FILES['archivo_cv']['error'] == UPLOAD_ERR_INI_SIZE) {
      // el archivo excede lo indicado por la directiva upload_max_filesize
      echo "<h3>ERROR. El tamaño del archivo supera a upload_max_filesize</h3>";
    } else if ($_FILES['archivo_cv']['error'] == UPLOAD_ERR_FORM_SIZE) {
      // El archivo excede lo indicado por MAX_FILE_SIZE
      echo "<h3>ERROR. El tamaño del archivo supera a MAX_FILE_SIZE</h3>";
    } else if ($_FILES['archivo_cv']['size'] > $limite_pdf){
      // El archivo ezcede lo indicado por el límite de usuario.
      echo "<h3>Error. El tamaño del archivo supera a $limite_pdf </h3>";
    } else {
      /* 
      5ª Comprobación. El tipo de archivo es el requerido.

        - Si compro vamos directamente $_FILES['archivo_cv']['type'] == 'application/pdf' podemos añadir
        alguna vulnerabilidad.

        - Comprobar el tipo MIME del contenido del archivo.

        - Como es posible que se admitan varios tipos de archivos, recomendable un array con los tipos admintivos.
      */
      $tipos_permitidos = ["application/pdf"];

      $tipo_mime1 = mime_content_type($_FILES['archivo_cv']['tmp_name']);
      $finfo = finfo_open(FILEINFO_MIME_TYPE); // Abre el fileinfo en modo tipo MIME.
      $tipo_mime2 = finfo_file($finfo, $_FILES['archivo_cv']['tmp_name']);
      $tipo_mime3 = $_FILES['archivo_cv']['type'];

      if( $tipo_mime1 == $tipo_mime2 && $tipo_mime2 == $tipo_mime3 && 
      in_array($tipo_mime1, $tipos_permitidos)){
        // El tipo es el permitido.

        // Se han pasado todas las comprobaciones.
        // Se guarda el archivo.

        $nombre_archivo = DIRECTORIO_PDF . "/" . $_FILES['archivo_cv']['name'];
        if (move_uploaded_file($_FILES['archivo_cv']['tmp_name'], $nombre_archivo)){
            echo "<h3>Archivo subido con éxito. Si qiuere puede subir más archivos</h3>";
        }else{
            echo "<h3>Error al guardar el archivo</h3>";
        }
      }


    }

    
  }
  // if (empty($_FILES['archivo_cv']['name'])) {}
} else {
  echo "<h3>Error. El formulario no contiene el campo archivo</h3>";
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
?>
  <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" id="MAX_VALUE_SIZE" value="<?= 1024 * 1024 ?>">
    <input type="hidden" name="limite_pdf" id="limite_pdf" value="<?= 100 * 1024 ?>">
    <fieldset>
      <legend>
        Introduzca sus datos y su CV
      </legend>

      <label for="dni">DNI</label>
      <input type="text" name="dni" id="dni" size="10">

      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre">

      <label for="archivo_cv">Archivo cv (solo PDF)</label>
      <input type="file" name="archivo_cv" id="archivo_cv" accept="application/pdf">
    </fieldset>
    <input type="submit" value="enviar" id="enviar">
  </form>

<?php
}

fin_html();

?>