<?php
// se incluye el modelo para tener acceso a sus métodos
require_once 'models/categoria.php';
// se incluye el modelo de productos para tener acceso a sus métodos
require_once 'models/producto.php';
// definir clase controladora
class categoriaController{
    public function index() {
        // comprobando que el usuario es admin 
        Utils::isAdmin();
        // Creando objeto de la clase modelo
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        // cargar una vista para este controlador
        require_once 'views/categoria/index.php';
    }
    
    //Método para ver los productos en las categorías
    public function ver() {
        // Comprobar si llegan parametros por get
        if(isset($_GET['id'])){
            //Creo variable de id obtenida del get
            $id = $_GET['id'];
            
            //Crear objeto de la clase modelo para obtener la categoria
            $categoria = new Categoria();
            // usar método para configurar ID
            $categoria->setId($id);
            // Obtener método para cargar una categoria
            $categoria = $categoria->getOne();
            
             //Crear objeto de la clase modelo para obtener los productos
            $producto = new Producto();
            // usar método para configurar ID de la categoria 
            $producto->setCategoria_id($id);
            //Obtener todos los productos por categoria
            $productos = $producto->getAllCategory();
            
        }
        
        // cargar una vista para este controlador
        require_once 'views/categoria/ver.php';
    }
    
    //Método para crear nuevas categorias en la Base de datos
    public function crear() {
        // comprobando que el usuario es admin
        Utils::isAdmin();
        // Incluyendo la vista para la creación de las categorías
        require_once 'views/categoria/crear.php';
    }
    
    //Método para guardar las nuevas categorías
    public function save() {
        // comprobando que el usuario es admin
        Utils::isAdmin();
        if(isset($_POST) && isset($_POST['nombre'])){
        // Guardar en la base de datos
            $categoria = new Categoria();
            $categoria->setNombre($_POST['nombre']);
            $categoria->save();
        }
        //Hacer redirección 
        header("Location:".base_url."categoria/index");
    }
}

