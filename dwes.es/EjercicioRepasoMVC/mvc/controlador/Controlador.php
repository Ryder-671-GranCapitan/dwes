<?php

// Vale, comenzamos instanciando el espacio de nombres del controlador
namespace mvc\controlador;

use Exception;

// Y generamos nuestra clase Controlador
class Controlador{

    // Vale, el controlador tiene el método despacha
    // Este método se encarga de comprobar que la petición que realiza el cliente exista y esté definida

    // Vamos a empezar a definir a las propiedades del controlador (srry es que me están hablando por tlf)
    // Tenemos la peticion que va a hacer el cliente
    protected string $peticion;
    // Tambien tenemos la vista de error que tiene que estar establecida desde el principio
    protected string $vista_error = "mvc\\vista\\V_Error";
    // Tambien el array con las peticiones
    protected array $peticiones_validas;

    // Ahora, debemos de rellenar el array de las peticiones válidas de nuestra aplicación
    // Esto lo haremos desde el constructor de la clase de la siguiente manera
    public function __construct()
    {
        // LLamaremos al array de peticiones_validas de la clase y lo rellenaremos con las peticiones que nos 
        // dice el ejercicio que podemos hacer
        $this->peticiones_validas = [
            'main' => [
                'modelo' => 'mvc\\modelo\\M_Main',
                'vista' => 'mvc\\vista\\V_Main'
            ],
            'autenticar' => [
                'modelo' => 'mvc\\modelo\\M_Autenticar',
                'vista' => 'mvc\\vista\\V_Autenticar'
            ],
            'reseña' => [
                'modelo' => 'mvc\\modelo\\M_Reseña',
                'vista' => 'mvc\\vista\\V_Reseña'
            ],
            'insertar_reseña' => [
                'modelo' => 'mvc\\modelo\\M_Insertar_Reseña',
                'vista' => 'mvc\\vista\\V_Insertar_Reseña'
            ]
        ];
    }

    // Y una vez tengamos ya nuestro array con todas las peticiones posibles, creamos nuestra función gestiona_peticion()
    public function gestiona_peticion(){
        // Todo va a ir encerrado en un bloque try catch
        try{
            // Lo primero que debemos de hacer es validar la petición del cliente
            // Las peticiones pueden ser GET, POST o ninguna y lo que haríamos sería mostrar el 'main'
            $peticion = $_GET['idp'] ?? $_POST['idp'] ?? 'main';
            $peticion = filter_var($peticion, FILTER_SANITIZE_SPECIAL_CHARS);

            // Ahí ya tenemos la petición ahora, lo que debemos de hacer es, buscar la petición en nuestro array
            // de peiticines válidas
            if (array_key_exists($peticion, $this->peticiones_validas)){
                // Si existe, vamos a crear la "$clase_modelo" que contendrá el espacio de nombres del modelo
                // y crearemos también la "$clase_vista" que almacenará el espacio de nombres de la vista
                $clase_modelo = $this->peticiones_validas[$peticion]['modelo'];
                $clase_vista = $this->peticiones_validas[$peticion]['vista'];
            }

            // Ahora, comprobaremos que esas "clases" existan
            if (!class_exists($clase_modelo)){
                throw new Exception("La clase del modelo $clase_modelo no existe");
            }

            if (!class_exists($clase_vista)){
                throw new Exception("La clase de la vista $clase_vista no existe");
            }

            // Y si existen debemos hacer la comunicación entre estos, es decir:

            // 1º Instanciamos el modelo y recogemos los datos que nos devuelva
            $modelo = new $clase_modelo();
            $datos = $modelo->despacha();

            // 2º Instanciamos la vista y pasamos los datos recogidos del modelo
            // para mostrarlos al cliente
            $vista = new $clase_vista();
            $vista->genera_salida($datos);

        }catch(Exception $e){
            // Y si no existen o se genera algún error, tenemos que mandarlo a la vista de error
            // definidia anteriormente
            $vista_error = new $this->vista_error();
            $vista_error->genera_salida($e);
        }
    }
}
// Y ya estaróa nuestro Controlador hecho. :)
?>