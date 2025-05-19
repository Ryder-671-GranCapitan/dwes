<?php
/*
    Script:     04subida_archivo.php
    Descripcion: Ejemplo de formulario para subida de archivos al servidor desde los clientes.

        SUBIDA DE ARCHIVOS
        ------------------

        * Un formulario permite subir archivos si el elemento form tiene el atributo
        enctype="multipart/form-data". Ademas tendra un elemento input con type="file".

        * Directivas php.ini que regulan la subida de archivos:
            - file_upploads <bool> -> Indica si la subida de archivos esta activada. Por defecto ON
            - upload_max_filesize <int> -> Limite del tamaño del archivo a subir en bytes. Por defecto 2MB
            - max_file_uploads <int> -> Numero maximo de archivos que se pueden subir en una peticion. Por defecto 20
            - post_maz_size <int> -> Tamaño maximo de la peticion POST. Por defecto 8 MB.
            - upload_tmp_dir <dir> -> Directorio TEMPORAL donde se almacenan los archivos subidos. Por defecto, segun el SO: /tmp (Linux)
                C:\TEMP (Windows)
        
        * Todos los parametros anteriores en php.ini son configurables con la funcion ini_set()

        * Ademas podemos poner limite del tamaño de archivo subido
            - Duro -> Directiva upload_max_filesize en php.ini
            - Blando -> Campo oculto de formulario MAX_FILE_SIZE.
            - De usuario -> El desarrollador puede establecer limites  en campos ocultos. Viene
                            bien cuando quiero poner un limite para diferentes tipos de archivo.
                            El propio desarrollador lo controla.

        * Cuando se sube un archivo, el script que procesa el formulario tiene que hacer 
            varias comprobaciones antes de guardarlo o procesarlo.
            1º Existe el archivo en el array $_FILES (que haya un control de formulario para la subida)
            2º El usuario ha incluido en el formulario el archivo a subir. En el script php
            3º El tamaño del archivo esat dentro de los limites de PHP. Automaticamente por PHP
            4º El tamaño del archivo esta dentro de los limites establecidos por el usuario. En el script php
            5º El tipo de archivo es el requerido.

        * Si vamos a guradar el archivo, comprobar si existe el directorio de subida. si no esta creado, hay que crearlo.

        * Si el archivo subido cumple todos los requisitos, se guarada en el directorio se subida o se procesa.

        Enfoque del script:
            - Pagina autogenerada.
            - Se suben archivos de forma cíclica
            - Si hay una peticion Get: se presenta el formulario
            - Si hay una peticion POST:
                - Procesamos la subida del archivo.
                - Si hay un error, se presengta la salida producida hasta el momento. Si hay un error,
                presentamos un mensaje de error y el formulario de subida
                - Si no tenemos creado el directorio de subida, lo creamos.
                - Si no hay error, se guarda el archivo en un directorio y se presenta el formulario de subida de nuevo
*/
define("Directorio_PDF", $_SERVER['DOCUMENT_ROOT'] . "/archivos_cv");

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/funciones.php");

inicio_html("Subida de archivos", ["/estilos/formulario.css", "/estilos/general.css"]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];

    $limite_pdf = $_POST['limite_pdf'];
    

    echo "<h3>Datos recibidos en la peticion</h3>";
    echo "<p>El dni es $dni y el nombre es $nombre</p>";
    echo "<p>El limite para archivos PDF es $limite_pdf bytes</p>";

    /*
        Creacion del directorio de subida
        ---------------------------------
        - El usuario que ejecuta el servicio web (Apache) en el servidor necesita tener
            permisos de escritura sobre el directorio padre del directorio de subida

        1º forma:  creamos el directorio desde el SO y le asignamos propietario o permisos
        Si el usuario no es propietario del directorio de subida, tiene que tener permisos
        777: rwx rwx rwx. No recomendable, cualquier persona puede acceder al dirrectorio y hacer cambios

        2º forma: Modificar la ACL del directorio de subida (si estacreado previamente) o 
        del directorio padre (si queremos crearlo en el script PHP)

        Empleamos la 2º forma y asiganmos rwx al usuario que ejecuta Apache (www-data) sobre el 
        directorio padre del directorio de subida, y este, se crea en el script PHP.

        setfacl -m u:www-data:rwx /var/www/dwes.com
    */

    mkdir(Directorio_PDF)

}
?>

    <form method="POST" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

        <!-- Limite Blando de PHP. Si el archivo tiene un tamaño superior a 1MB, PHP lo descarta -->
        <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?=1024*1024?>">

        <!-- Limite Blando del usuario. El script comprueba  -->
        <input type="hidden" name="limite_pdf" id="limite_pdf" value="<?=100*1024?>">

        <fieldset>
            <legend>Introduzca sus datos y su Curriculum Vitae</legend>

            <label for="dni">DNI</label>
            <input type="text" name="dni" id="dni" size="10">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" size="40">


            <!-- Atributo accept. Se emplea para poner un filtro al campo file -->

            <label for="archivo_cv">Archivo CV (solo PDF)</label>
            <input type="file" name="archivo_cv" id="archivo_cv" accept="application/pdf">
        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Enviar">
    </form>

<?php
fin_html();

?>