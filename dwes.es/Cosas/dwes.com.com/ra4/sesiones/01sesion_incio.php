<?php
  /*
    - PHP tiene sooporte para gestionar las sesiones y proporcionar variables.
    persistentes

    - Las vriables (de sesion) son accesibles desde diferentes paginas (scripts) durante la sesion de usuario.

    - Adecuadas para formularios multipagina, guardar datos entre peticiones.

    - Cada sesion tiene un identificador de sesion que es unico el cual se pasa copmo cookie al cliente, las cuales 
    se devuelven en peticiones posteriores.

    - Cada sesion tiene un almacen de datos para las variables de sesion.

    - Funcionamiento basico:

      - Al iniciar la aplicacion en el primer script se invoca session_start().
      
      - Si hay una sesion previa recupera el PHPSESSID (cookie) y carga el array superglobal $_SESSION.

      - Si no hay una sesion previa, se crea una y se le asigna un ID de sesion.

      - En el array $_SESSION usamos la clave como nombre de la variable.

      - Cierre de una sesion:

        - Al cerrar el navegador.
        - Si se cierra la sesion explicitamente por el ususario:
          - Borrar el PHPSESSID (se borra la cookie).
          - Se invoca session_destroy()
        
        - El recolector de basura. Si alguna variable de $_SESSION no ha sido
        referenciada durante algun tiempo, la variable se borra.

        - Para configurar el recolector de basura hay unas directivas de configuracion en el php.ini.

        - Haremos un inici.php con un formulario nombre, email. 
        - Cuando se envie se llevara compra.php y relenaremos los datos de ese script.
        - Cuando hagamos eso, lo mandaremos a datos.php y podremos volver al apartado anterior. 
        - Tras esto, procedemos al pago. Y otro boton para empezar desde el principio.
  */

  // Lo primero que se hace en un script php que contemple sesiones.

  session_start(); // Array asociativo con directivas de configuracion de sesiones.

  date_default_timezone_set("Europe/Madrid");

  // Anadimos dos variables de sesion.
  if( !isset($_SESSION['instante'])){
    $_SESSION['instante'] = time();
    $_SESSION['cesta'] = [];
  }

  require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/includes/funciones.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/dwes.com.com/ra4/sesiones/01sesion_verdatos.php');

  inicio_html("Sesiones en PHP", ["./styles/general.css", "./styles/formulario.css"]);

  if ($_SERVER['REQUEST_METHOD'] == 'GET'){
      $operacion = filter_input(INPUT_GET, 'operacion', FILTER_SANITIZE_SPECIAL_CHARS);
      if ($operacion == 'cerrar') {
        cerrar_sesion();
        ver_datos_session();
      } 
  }
  ?>
  <form action='/dwes.com.com/ra4/sesiones/01sesion_datos.php' method='POST'>
    <fieldset>
      <legend>Datos personales</legend>

      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre">

      <label for="email">Email</label>
      <input type="email" name="email" id="email">
    </fieldset>
    <input type="submit" name="operacion" value="Anadir cosas a la cesta">
  </form>
  <?php
  fin_html();
?>