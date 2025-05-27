<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once(__DIR__ . '/../../includes/funciones.php');
define("DIRECTORIO_PDF", $_SERVER['DOCUMENT_ROOT'] . "/archivos_cv");

inicio_html("Subida de archivos", ['./styles/general.css', './styles/tablas.css', './styles/formulario.css']);

echo "<header>Importación de datos</header>";

if( $_SERVER['REQUEST_METHOD'] == 'POST' ){
  // Comprobamos si hay un archivo.
    if (isset($_FILES['archivo_csv']) && $_FILES['archivo_csv']['error'] == UPLOAD_ERR_OK){
      
      $fila_cabecera = isset( $_POST['fila_cabecera']);

      echo "<table>";
      echo "<caption>Importación de " .$_FILES['archivo_csv']['name'] . "</caption>";
      echo "<thead>";

      

      $archivo = fopen($_FILES['archivo_csv']['tmp_name'], 'r');
      if ($archivo){
        // Fila de cabecera.
        if ($fila_cabecera){
          // Archivo está abierto.
          // Leemos la fila de cabecera.
          $cabecera = fgetcsv($archivo);

          
          echo "<tr>";
          foreach ($cabecera as $columna){
            echo"<th>$columna</th>";
          }
          echo "</tr>";
        }
      }
      // Presentamos los datos
      echo "<tbody>";
      while( $fila = fgetcsv($archivo)){
        echo "<tr>";
        foreach($fila as $dato){
          echo "<td>$dato</td>";
        }
        echo "</tr>";
      }
      echo "</tbody>";

      echo "</table>";
      echo "<a href=\'{$_SERVER['PHP_SELF']} Importar otro archivo</a>";
    }
    else {
      echo "<h3>Error. El archivo no se ha subido</h3>";
    }
  } else {
  ?>
  <form method="POST" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
  <fieldset>
    <legend>Introduzca el arvhico con los datos a importar</legend>
    <label for="fila_cabecera">Fila de cabecera"</label>
    <input type="checkbox" name="fila_cabecera" id="fila_cabecera" checked>

    <label for="archivo_csv">Archivo con los datos</label>
    <input type="file" name="archivo_csv" id="archivo_csv" accept="text/csv">
  </fieldset>
  <input type="hidden" name="op1" value="importar">
  <button type="submit" id="operacion">Importar</button>
</form>

<?php
}



fin_html();

?>
