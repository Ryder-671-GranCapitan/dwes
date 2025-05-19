<?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST");
  header("Access-Control-Allow-Headers: Content-Type");
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  require_once($_SERVER . '/../../includes/funciones.php');
  define("DIRECTORIO_PDF", $_SERVER['DOCUMENT_ROOT'] . "/archivos_cv");

  inicio_html("Saneamiento y Validación de datos",
             ['./styles/general.css', './styles/tablas.css', './styles/formulario.css']);


  echo "<header>Saneamiento y validación de datos</header>";
  if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    echo "<p><a href='".$_SERVER['PHP_SELF']."'>Introducir otros datos</a></p>";

    /* Vamos a sanear los datos.
    1ª Opcion: Uso de htmlspecialchars().

    */
    echo "<h2>Saneamos con htmlspecialchars()</h2>";
    $dni = htmlspecialchars($_POST['dni']);
    $nombre = htmlspecialchars( $_POST['nombre']);
    $email = htmlspecialchars( $_POST['email']);
    $clave = htmlspecialchars( $_POST['clave']);
    $suscripcion = htmlspecialchars( $_POST['suscripcion']);
    $sitio = htmlspecialchars( $_POST['sitio']);
    $peso = htmlspecialchars( $_POST['peso']);
    $edad = htmlspecialchars( $_POST['edad']);
    foreach($_POST['patologias_previas'] as $pat){
      $patologias[] = htmlspecialchars($pat);
    };
    $comentarios = htmlspecialchars($_POST['comentarios']);

    echo "El dni es $dni<br>";
    echo "El nombre es $nombre<br>";
    echo "El email es $email<br>";
    echo "La clave es $clave<br>";
    echo "La suscripcion es $suscripcion<br>";
    echo "El sitio es $sitio<br>";
    echo "El peso es $peso<br>";
    echo "La edad es $edad<br>";
    echo "Las patologias previas son ". implode(", " ,$patologias) . "<br>";
    echo "El comentario es $comentarios<br>";

    /* Vamos a sanear los datos.
    2ª Opcion: Uso de filter_input();.

    */
    echo "<h2>Saneamos con filter_input()</h2>";
    $dni2 = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre2 = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $email2 = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $clave2 = filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $suscripcion2 = isset($_POST['suscripcion']);
    $sitio2 = filter_input(INPUT_POST, 'sitio', FILTER_SANITIZE_URL);
    $peso2 = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $edad2 = filter_input(INPUT_POST, 'edad', FILTER_SANITIZE_NUMBER_INT);
    $patologias2 = filter_input(INPUT_POST, 'patologias_previas', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    $comentario2 = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    echo "El dni es $dni2<br>";
    echo "El nombre es $nombre2<br>";
    echo "El email es $email2<br>";
    echo "La clave es $clave2<br>";
    echo "La suscripcion es $suscripcion2<br>";
    echo "El sitio es $sitio2<br>";
    echo "El peso es $peso2<br>";
    echo "La edad es $edad2<br>";
    echo "Las patologias previas son ". implode(", " ,$patologias2) . "<br>";
    echo "El comentario es $comentario2<br>";

    /* Vamos a sanear los datos.
    3ª Opcion: Uso de filter_input_array();.

    */
    echo "<h2>Saneamos con filter_input_array()</h2>";

    $opciones_filtrado = [
      'dni'   => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'nombre'=> FILTER_SANITIZE_SPECIAL_CHARS,
      'email' => FILTER_SANITIZE_EMAIL,
      'clave'=> FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'suscripcion' => FILTER_DEFAULT,
      'sitio' => FILTER_SANITIZE_URL,
      'peso' => [
                 'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
                 'flags' => FILTER_FLAG_ALLOW_FRACTION,
                ],
      'edad' => FILTER_SANITIZE_NUMBER_INT,
      'patologias_previas' => [
                              'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                              'flags' => FILTER_REQUIRE_ARRAY,
                            ],
      'comentarios' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
      'operacion' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    ];
    $datos_saneados = filter_input_array(INPUT_POST, $opciones_filtrado);
    foreach( $datos_saneados as $clave => $valor){
      if( is_array($valor)){
        echo "$clave: " . implode(", ", $valor) . "<br>";
      }else{
        echo "$clave : $valor<br>";
      }
    }
    echo "</p>";

    /*
    Validacion de formato de datos
    ------------------------------
    */

    // Por lo general las cadenas de texto genéricas se sanean.
    $dni3 = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre3 = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $comentarios3 = filter_input(INPUT_POST, 'comentarios', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $operacion3 = filter_input(INPUT_POST, 'operacion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $nombre3 = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Validación de formato email.
    $email3 = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);

    // Validación de formato boolean.
    $suscripcion3 = filter_input(INPUT_POST, 'suscripcion', FILTER_VALIDATE_BOOLEAN);
    $clave3 = filter_input(INPUT_POST, 'clave', FILTER_DEFAULT);

    // Validación de formato URL.
    $sitio3 = filter_input(INPUT_POST, 'sitio', FILTER_VALIDATE_URL);

    // Validación de formato gloat con rango incluido.
    $peso3 = filter_input(INPUT_POST, 'peso', FILTER_VALIDATE_FLOAT, Array('options' => ['min_range' => 40, 'max_range' => 150],
                                                                            'flags' => FILTER_NULL_ON_FAILURE));
    $edad3 = filter_input(INPUT_POST, 'edad', FILTER_VALIDATE_INT, Array('options' => ['min_range' => 18, 'max_range' => 80],
                                                                            'flags' => FILTER_NULL_ON_FAILURE));
    
    
    $patologias3 = filter_input(INPUT_POST, 'patologias_previas', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    
    echo "El dni es $dni3<br>";
    echo "El nombre es $nombre3<br>";
    echo "El email es $email3<br>";
    echo "La clave es $clave3<br>";
    echo "La suscripcion es $suscripcion3<br>";
    echo "El sitio es $sitio3<br>";
    echo "El peso es $peso3<br>";
    echo "La edad es $edad3<br>";
    echo "Las patologias previas son ". implode(", " ,$patologias3) . "<br>";
    echo "El comentario es $comentarios3<br>";

    /*
      Validación de datos con lógica de datos
      ---------------------------------------
    */

    // Formato del DNI: 8 dígitos numéricos y una letra mayúscula.
    $dni4 = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $exp_reg = "/[0-9]{7,8}[A-Z]/";
    if (preg_match($exp_reg, $dni4)){
      echo "Dni con formato correcto: $dni4<br>";
    } else {
      echo "El dni introducido no es válido.";
    }

    // Nombres de usuario solo con caracteres alfabéticos y dígitos numéricos.
    // Con longitud mínima de 4 y máxima 8.
    $nombre4 = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (ctype_alnum($nombre4) && strlen($nombre4) >= 4 && strlen($nombre4) <=8){
      echo "Nombre con formato adecuado: $nombre4<br>";
    }else {
      echo "Nombre: NO tiene el formato adecuado<br>";
    }

    // Clave: Requisitos de complejidad.
    // Tipos de caracteres: Letras mayñusculas, letras minúsculas, dígitos y símbolos gráficos.
    // Longitud mínima: 6.

    $clave4 = htmlspecialchars($_POST['clave']);
    $letras_minusculas = preg_match("/[a-z]/", $clave);
    $letras_mayusculas = preg_match("/[A-Z]/", $clave);
    $letras_numericos = preg_match("/[0-9]/", $clave);
    $letras_graficos = preg_match("/[,.\-;:_\+\*!\$%&\(\)]/", $clave);

    if ($letras_minusculas && $letras_mayusculas && $letras_numericos && $letras_graficos){
      echo "Cumple con los requisitos de la contraseña.";
    } else {
      echo "No cumple con los requisitos de complejidad.";
    }



    
  } else {
    ?>
      <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
        <fieldset>
          <legend>Introducir sus datos</legend>
          <label for="dni">DNI</label>
          <input type="text" name="dni" id="dni" size="10">
          
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" size="40">
          
          <label for="email">Email</label>
          <input type="text" name="email" id="email" size="30">
          
          <label for="clave">Clave</label>
          <input type="password" name="clave" id="clave" size="10">
          
          <label for="suscripcion">Suscribirse al boletín</label>
          <input type="checkbox" name="suscripcion" id="suscripcion">

          <label for="sitio">Web personal</label>
          <input type="text" name="sitio" id="sitio" size="30">

          <label for="peso">Peso</label>
          <input type="text" name="peso" id="peso" size="3">

          <label for="edad">Edad (entre 18 y 65)</label>
          <input type="text" name="edad" id="edad" size="3">

          <label for="patologias_previas">Patologias previas</label>
          <select name="patologias_previas[]" id="patologias_previas" multiple size='5'>
            <option value="osteoporosis">Osteoporosis</option>
            <option value="diabetes">Diabetes</option>
            <option value="colesterol">Hipercolesterolemia</option>
            <option value="anemia">Anemia</option>
            <option value="arterioesclerosis">Arterioesclerosis</option>
          </select>

          <label for="comentarios">Comentarios</label>
          <textarea rows="4" cols="30" name="comentarios" id="comentarios" placeholder="Escribe sobre ti"></textarea>
        </fieldset>
        <input type="submit" name="operacion" id="operacion" value="Enviar">
      </form>
    <?php
  }


  
  fin_html();

?>