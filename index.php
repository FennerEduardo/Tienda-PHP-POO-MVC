<?php
//Controlador frontal: es aquel que se encarga de cargar ficheros, acciones en 
// función de los parametros de la URL es el único fichero que se encarga de cargarlo 
// absolutamente todo, este index es un ejemplo 

//Iniciar la sesión
session_start();

// Llamo a los controladores a través del autoload
require_once 'autoload.php'; // Archivo autoload
require_once 'config/db.php'; //Conexión a la base de datos.
require_once 'config/parameters.php'; // archivo de parametros
require_once 'helpers/utils.php'; //Archivo de utilidades
require_once 'views/layout/header.php'; // layout header vista
require_once 'views/layout/sidebar.php'; // layout sidebar vista


//Funciones para cargar controlador de errores
function show_error(){
    $error = new errorController();
    $error->index();
}

if(isset($_GET['controller'])){
    //Sí existe el controlador haga:
   $nombre_controlador = $_GET['controller'].'Controller';
}elseif(!isset ($_GET['controller']) && !isset ($_GET['action'])){
    //Sí no existe el controlador y la acción, debe cargar el controlador default
    // configurado en el .htaccess 
    $nombre_controlador = controller_default;
}else{
    // Sino existe el error, llame la función de errores
    show_error();
    exit();
}
// comprobando que el controlador exista
if(isset($nombre_controlador) && class_exists($nombre_controlador)){

    //Creo un nuevo objeto de la clase controladora
    $controlador = new $nombre_controlador();
    // Invocando los métodos automáticamente
    if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
        $action = $_GET['action'];
        $controlador->$action();
    }elseif(!isset ($_GET['controller']) && !isset ($_GET['action'])){
    //Sí no existe el controlador y la acción, debe cargar el controlador default
    // configurado en el .htaccess 
        $action_default = action_default;
        $controlador->$action_default();
    }else{
        show_error();
    }
}else{
    show_error();
       
}
require_once 'views/layout/footer.php'; // layout footer