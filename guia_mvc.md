# GUIA MVC

## Apuntes
- las Excepciones que se lanzan. saltan al controlador
  - mostrando la vista de error
- toda la aplicación se ejecuta desde el index.php
  - el usuario solo ve index.php
  - tambien los datos pasados por $post a index.php son accesibles desde cualquier archivo  

rera526/
├── inicio26.php
├── index26.php
├── controlador/
│   └── Controlador26.php
├── entidad/
│   └── Resena26.php
├── modelo/
│   └── ModeloResena26.php
├── vista/
│   ├── VistaResen26C.php
│   └── VistaError26.php
├── util/
│   └── Autocarga.php


## paso 0
comprobar la redireccion del servidor o .htaccess (redireccion a archivo manual)

## paso 1: Autocarga
Hacer la Autocarga

````php
    namespace rera526\util;

    use Exception;

    class Autocarga {
        public static function registerAutoload(): void {
            if( !spl_autoload_register(self::class . "::autoload") ) {
                throw new Exception("Ha ocurrido un error");
            }
        }
        
        protected static function autoload(string $class) {
            $clean_class = str_replace('\\', '/', $class);
            $full_path = $_SERVER['DOCUMENT_ROOT'] . "/{$clean_class}.php";

            if( !file_exists($full_path) ){
                throw new Exception("No se ha encontrado '$full_path'");
            }
            require_once($full_path);
        }
    }

    phpcon
````

## paso 2: Controlador

la "logica" de la aplicacion se encuentra aqui, se gestionan las peticiones y se llama al modelo y a la vista correspondiente
Teoricamente, el controlador no deberia necesitar cambios segun el tipo de examen. el controlador deberia ser similar para todas las peticiones

````php
    namespace rera526\controlador;

    use Exception;
    use rera526\vista\VistaError07;

    class Controlador26 {
        // Creo el array de peticiones
        protected array $peticiones;

        // Meto dentro del array de peticiones la/las peticiones
        public function __construct() {

            // Defino las peticiones que se pueden hacer
            // cada peticion tiene un modelo y una vista
            // se puede añadir mas peticiones sin modificar el controlador
            $this->peticiones = [
                'insertarResena' => [
                    'modelo' => 'rera526\\modelo\\ModeloResena07',
                    'vista' => 'rera526\\vista\\VistaResena07'
                ]
            ];
        }

        public function gestionarPeticion() {
            try {
        try {
            $idp = $_POST['idp'] ? $_POST['idp'] : '';
            $idp = filter_var($idp, FILTER_SANITIZE_SPECIAL_CHARS);

            if (!class_exists($this->peticiones[$idp]['modelo'])) {
                throw new Exception("modelo desconocido", 4);
            }
            if(!class_exists($this->peticiones[$idp]['vista'])){
                throw new Exception("vista desconocida",4);                
            }

            $claseModelo = $this->peticiones[$idp]['modelo'];
            $claseVista = $this->peticiones[$idp]['vista'];

            $instanciaModelo = new $claseModelo();
            $data = $instanciaModelo->procesaPeticion();

            $instanciaVista = new $claseVista;
            $instanciaVista->enviarSalida($data);

            
        } catch (Exception $e) {
            $error = new VistaError26();
            $error->muestraError($e);
        }
        }
    }
    }
````


## Paso 3: Entidad 
hacer la entidad correspondiente a la tabla

lo unico que hay que cambiar es los atributos privados, con su tipo y nombre correspondiente

````php

    namespace rera526\entidad;

    use Exception;
    use ReflectionProperty;
    use DateTime;
    
    class Entidad_____26 {
        public const FECHA_MYSQL = "Y-m-d H:i:s";
        public const FECHA_USUARIO = "d/m/Y H:i:s";

        // Atributos privados que corresponden a la tabla
        // cambiando los atributos de la tabla y su tipo podemos utilizar esta clase para cualquier tabla
        // id_resena es la PK
        private int $id_resena;
        private DateTime $fecha;
        private ?int $clasificacion;


        // Constructor 
        // se le pasan los datos de la tabla como un array asociativo
        // y se asignan a los atributos privados
        // se utiliza el metodo __set para asignar los valores
        public function __construct(array $datos) {
            foreach ($datos as $propiedad => $valor) {
                $this->__set($propiedad, $valor);
            }
        }

        // Metodo para obtener el nombre de la propiedad
        // se utiliza ReflectionProperty para obtener el tipo de la propiedad
        public static function getProperty($objeto, $propiedad) : string {
            $instancia_reflection = new ReflectionProperty($objeto, $propiedad);
            return $instancia_reflection->getType()->getName();
        }


        // Metodo para establecer el valor de la propiedad
        // lo establece segun el tipo de la propiedad
        // si es un DateTime lo convierte a DateTime
        // si no es un DateTime lo establece directamente
        public function __set($propiedad, $valor) {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad Invalida");
            }

            if (self::getProperty($this, $propiedad) == DateTime::class) {
                $this->$propiedad = new DateTime($valor);
            } else {
                $this->$propiedad = $valor;
            }
        }

        // devuelve el valor de la propiedad
        public function __get($propiedad) : mixed {
            if (!property_exists($this, $propiedad)) {
                throw new Exception("Propiedad Invalida");
            }
            return $this->$propiedad;
        }
    }
````
## paso 4: Modelo

hacer el modelo correspondiente a la tabla
este modelo se encargara de la conexion a la base de datos y de las consultas
valida los datos del formulario y los inserta en la base de datos

los $_POST vienen del formulario, $_POST es accesible desde cualquier archivo gracias a la autocarga

````php
    namespace rera526\modelo;

    use Exception;
    use rera526\entidad\Resena26;
    use PDO;

    class ModeloResena26 {
        private const TABLE = 'reseña';
        private const PK = 'id_reseña';

        protected PDO $pdo;

        // Constructor
        // se conecta a la base de datos
        public function __construct() {
            $dsn = 'mysql:host=192.168.12.71;port=9992;dbname=examen;charset=utf8mb4';
            $usuario = 'usuario';
            $clave = 'usuario';
            $options = [
                PDO::ATTR_CASE                 => PDO::CASE_LOWER,
                PDO::ATTR_EMULATE_PREPARES     => false,
                PDO::ATTR_ERRMODE              => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE   => PDO::FETCH_ASSOC
            ];

            $this->pdo = new PDO($dsn, $usuario, $clave, $options);
        }

        // Recibe los datos del formulario, los valida 
        public function procesaPeticion() : ?Resena26 {
            $nif = $_POST['nif'] ?? '';
            $nif = filter_var($nif, FILTER_SANITIZE_SPECIAL_CHARS);
            $referencia = $_POST['referencia'] ?? '';
            $referencia = filter_var($referencia, FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha = $_POST['fecha'];
            $clasificacion = $_POST['clasificacion'] ?? 0;
            $clasificacion = filter_var($clasificacion, FILTER_SANITIZE_NUMBER_INT);
            $comentario = $_POST['comentario'] ?? '';
            $comentario = filter_var($comentario, FILTER_SANITIZE_SPECIAL_CHARS);
            

            // si faltan datos obligatorios, lanza una excepcion
            if (!$fecha) {
                throw new Exception("la reseña debe tener una fecha");
            }           

        // presenta la consulta, los :nombre sera sustituidos por los valores 
        // debe ponerse en el mismo orden que en la tabla
        // si es auto_increment se le pasa null
        $sql = "INSERT INTO ". self::TABLA. " VALUES(null, :nif, :referencia, :fecha, :clasificacion, :comentario)";

        $stmt = $this->pdo->prepare($sql);

        $param = [
            ':nif' => $nif,
            ':referencia' => $referencia,
            ':fecha' => $fecha,
            ':clasificacion' => $clasificacion,
            ':comentario' => $comentario
        ];

        // ejecuta la consulta sustituyendo los :nombre por los valores del array $param
        $stmt->execute($param);

        // si se ha insertado correctamente, devuelve un objeto Resena26
        $data = $stmt->fetch();

        if (!$data) {
            throw new Exception("error en la consulta", 3);            
        }

        $resena = new Resena26($data);
        return $resena;
        
        }




        public function getResenaById() : ?Resena26 {
            // consulta para obtener la reseña por id
            $sql = "SELECT * FROM ". self::TABLE . " WHERE ". self::PK . " = :id_reseña";
            $stmt = $this->pdo->prepare($sql);
            // se obtiene el id_reseña del $_POST
            $id_reseña = $_POST['id_reseña'] ?? null;
            if (!$id_reseña) {
                throw new Exception("ID Invalido");
            }
            $id_reseña = filter_var($id_reseña, FILTER_SANITIZE_NUMBER_INT);
            $stmt->bindValue(':id_reseña', $id_reseña, PDO::PARAM_INT);
            $stmt->execute();

            // si no se encuentra la reseña, devuelve null
            if ($stmt->rowCount() == 0) {
                return null;
            }

            // si se encuentra, devuelve un objeto Resena26
            $data = $stmt->fetch();
            return new Entidad_____26($data);
        }

        




        public function updateResena() : ?Resena26 {
            $id_reseña = $_POST['id_reseña'] ?? null;
            $id_reseña = filter_var($id_reseña, FILTER_SANITIZE_NUMBER_INT);
            $nif = $_POST['nif'];
            $nif = filter_var($nif, FILTER_SANITIZE_SPECIAL_CHARS);
            $referencia = $_POST['referencia'] ?? '';
            $referencia = filter_var($referencia, FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha = $_POST['fecha'];
            $clasificacion = $_POST['clasificacion'] ?? 0;
            $clasificacion = filter_var($clasificacion, FILTER_SANITIZE_NUMBER_INT);
            $comentario = $_POST['comentario'] ?? '';
            $comentario = filter_var($comentario, FILTER_SANITIZE_SPECIAL_CHARS);
            

            // si faltan datos obligatorios, lanza una excepcion
            if (!$id_reseña) {
                throw new Exception("Reseña Invalida");
            }

        // presenta la consulta, los :nombre sera sustituidos por los valores 
        // debe ponerse en el mismo orden que en la tabla
        // si es auto_increment se le pasa null
            $sql = "INSERT INTO ". self::TABLA. " VALUES(:id_reseña, :nif, :referencia, :fecha, :clasificacion, :comentario)";

            $stmt = $this->pdo->prepare($sql);

            $param = [
                ':id_reseña' => $id_reseña,
                ':nif' => $nif,
                ':referencia' => $referencia,
                ':fecha' => $fecha,
                ':clasificacion' => $clasificacion,
                ':comentario' => $comentario
            ];

            // ejecuta la consulta sustituyendo los :nombre por los valores del array $param
            $stmt->execute($param);

            // si se ha insertado correctamente, devuelve un objeto Resena26
            $data = $stmt->fetch();

            if (!$data) {
                throw new Exception("error en la consulta", 3);            
            }

            $resena = new Resena26($data);
            return $resena;

        }





        public function delResenaById() : bool {
            // consulta para eliminar la reseña por id
            $sql = "DELETE FROM ". self::TABLE . " WHERE ". self::PK . " = :id_reseña";
            $stmt = $this->pdo->prepare($sql);
            // se obtiene el id_reseña del $_POST
            $id_reseña = $_POST['id_reseña'] ?? null;

            $id_reseña = filter_var($id_reseña, FILTER_SANITIZE_NUMBER_INT);
            $stmt->bindValue(':id_reseña', $id_reseña, PDO::PARAM_INT);
            return $stmt->execute();
        }

    }
````


## paso 5: Formulario y vistas

### 4.1: Formulario
Crear el formulario que se mostrara al usuario, este formulario se encargara de enviar los datos al controlador

el formulario se envia a index26.php, que es el controlador de la aplicacion

````php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera526/util/Html.php');

    use rera526\util\Html;

    Html::inicio("Reseña", ['/rera526/estilos/formulario.css', '/rera526/estilos/general.css', '/rera526/estilos/tablas.css']);
    ?>
        <form action="index26.php" method="POST">
            <fieldset>
                <legend>Introduce la reseña</legend>
                <label for="nif">Nif</label>
                <input type="text" name="nif" id="nif">

                <label for="referencia">Referencia</label>
                <input type="text" name="referencia" id="referencia">

                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha">

                <label for="clasificacion">Clasificacion</label>
                <input type="number" name="clasificacion" id="clasiicacion">

                <label for="comentario">Comentario</label>
                <input type="text" name="comentario" id="comentario">
            </fieldset>
            <button name="idp" id="idp" value="operacion">Insertar</button>
        </form>
    <?php
    Html::fin();
````	

### 4.2: Vista del modelo
Crear la vista que se encargara de mostrar los datos del modelo, en este caso, la reseña
````php

    use rera526\util\Html;
    use rera526\entidad\Resena26;

    class VistaResena26 {
        public function enviarSalida(mixed $reseña) :void {
            Html::inicio("Reseña", ['/rera526/estilos/formulario.css', '/rera526/estilos/general.css', '/rera526/estilos/tablas.css']);
            ?>
            <h1>Detalles de la reseña <?=$reseña->id_reseña?></h1>
                <table>
                    <thead>
                        <tr>
                            <th>Id_Reseña</th>
                            <th>NIF</th>
                            <th>Fecha</th>
                            <th>Clasificacion</th>
                            <th>Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            echo "<tr>";
                                echo "<td>{$reseña->id_reseña}</td>";
                                echo "<td>{$reseña->nif}</td>";
                                echo "<td>{$reseña->fecha->format(Resena26::FECHA_USUARIO)}</td>";
                                echo "<td>{$reseña->clasificacion}</td>";
                                echo "<td>{$reseña->comentario}</td>";
                            echo"</tr>";
                        ?>
                    </tbody>
                </table>
            <?php
            Html::fin();
        }   
    }
````

### 4.3: Vista de error
Crear la vista que se encargara de mostrar los errores, en este caso, los errores que se produzcan en el modelo o en el controlador
````php
    namespace rera526\vista;

    use Exception;
    use rera526\util\Html;

    class VistaError26 {
        public function muestraError(Exception $excepcion) : void {
            Html::inicio("Reseña", ['/rera526/estilos/formulario.css', '/rera526/estilos/general.css', '/rera526/estilos/tablas.css']);

            $file = $excepcion->getFile();
            $components = explode("/", $file);
            $script = end($components);
            $modelo = rtrim($script, ".php");

            echo "<h1>Error</h1>";
            echo "<p>Error message {$excepcion->getMessage()}</p>";
            echo "<p>Error Code {$excepcion->getCode()}</p>";
            echo "<p>Model {$modelo}</p>";
            echo "<p>Line {$excepcion->getLine()}</p>";

            echo "<p><a href='insertar26.php'>Volver al inicio</a></p>";

            Html::fin();
        }
    }

````



## paso 6: index.php
por ultimo index, que interconecta todo, es el punto de entrada de la aplicacion

````php
    namespace rera526;

    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera526/util/Autocarga.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/rera526/controlador/Controlador26.php');

    use rera526\util\Autocarga;
    use rera526\controlador\Controlador26;


    // Autocarga de clases
    Autocarga::registerAutoload();

    // Inicio del controlador
    $controlador = new Controlador26();
    $controlador->gestionarPeticion();

    
````