<?php

//Cargar el modelo 
require_once 'models/producto.php';

// definir clase controladora
class productoController {

    public function index() {
        
        //Creo objeto del producto 
        $producto = new Producto();
        //Llamo el método para mostrar productos aleatorios
        $productos = $producto->getRandom(6);
        
        //  var_dump($productos->fetch_object());
        
        // se renderizar la vista que se va ejecutar en este controlador
        require_once 'views/producto/destacados.php';
    }
    
    //Método para ver el detalle del producto
    public function ver() {
         //¿Existe el parametro Get?
        if(isset($_GET['id'])){
            //Crear variable de id 
            $id = $_GET['id'];
            
            // Crear objeto de producto
            $producto = new Producto();
            //Indico el objeto que quiero de la bd mediante el id
            $producto->setId($id);
            // llamo al método para sacar un solo producto del modelo
            $product = $producto->getOne();
            
        } 
            //Incluir vista de detalle del producto
            require_once 'views/producto/ver.php';
    }

    //Método para la gestión de productos
    public function gestion() {
        // Es un administrador?
        Utils::isAdmin();

        //Creo un objeto de la clase del modelo 
        $producto = new Producto();
        // obtengo los productos desde le método getAll
        $productos = $producto->getAll();

        // incluyendo vista para la gestión de los productos
        require_once 'views/producto/gestion.php';
    }

    // Método para crear productos
    public function crear() {
        // Es un administrador?
        Utils::isAdmin();
        // incluyendo vista para la creación de los productos
        require_once 'views/producto/crear.php';
    }

    public function save() {
        // Es un administrador?
        Utils::isAdmin();

        //¿Llegan datos por POST?
        if (isset($_POST)) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;
            //$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : false;

            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                //Creamos objeto de la clase modelo
                $producto = new Producto();

                // Le damos valor a cada propiedad, mediante los datos del formulario
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                // Guardar la imagen 
                
                
                if(isset($_FILES['imagen'])){
                    $file = $_FILES['imagen'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];
                    //Comprobar que el mimetype corresponda a una imagen
                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {
                        // Comprobar si existe directorio de subida
                        if (!is_dir('uploads/images')) {
                            // Cree el directorio de imagenes
                            mkdir('uploads/images', 0777, true);
                        }
                        //Guardar el archivo en la carpeta o directorio
                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                        // configurando el nombre de la imagen al objeto producto
                        $producto->setImagen($filename);
                    }
                }
                //Se comprueba si llega Id para edición o sí es un nuevo producto
                if(isset($_GET['id'])){
                    $id = $_GET['id'];// se crea variable id
                    $producto->setId($id); // se configura id del objeto
                    //Se ejecuta método para actualizar los datos en la BD
                    $save = $producto->edit();
                }else{
                    //Se ejecuta método para guardar los datos en la BD
                    $save = $producto->save();
                }
                //Comprobando que se haya ejecutado correctamente el guardado
                if ($save) {
                    $_SESSION['producto'] = 'complete';
                } else {
                    $_SESSION['producto'] = 'failed';
                }
            } else {
                $_SESSION['producto'] = 'failed';
            }
        } else {
            $_SESSION['producto'] = 'failed';
        }
        // Redirección al listado de productos en gestión
        header('Location:' . base_url . 'producto/gestion');
    }

// fin de método
    // Método para editar productos
    public function editar() {
        // Es un administrador?
        Utils::isAdmin();
        //¿Existe el parametro Get?
        if(isset($_GET['id'])){
            //Crear variable de id 
            $id = $_GET['id'];
            //Crear variable para condicionar la edición
            $edit = true;
            
            // Crear objeto de producto
            $producto = new Producto();
            //Indico el objeto que quiero de la bd mediante el id
            $producto->setId($id);
            // llamo al método para sacar un solo producto del modelo
            $pro = $producto->getOne();
            
            //Incluir vista de producto para edición
            require_once 'views/producto/crear.php';
        } else {
           header('Location:'.base_url.'producto/gestion'); 
        }
    }

    // Método para eliminar productos
    public function eliminar() {
        // Es un administrador?
        Utils::isAdmin();

        // Existe el id en GET
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // llamo al método del modelo que elimina registros de producto
            //Creo objeto de producto para usar sus métodos
            $producto = new Producto();
            // paso el id para ejecutar el delete
            $producto->setId($id);
            // uso metodo delete
            $delete = $producto->delete();
            // Compruebo sí se elimino el registro y cargo sesion para generar mensaje
            if ($delete) {
                $_SESSION['delete'] = 'complete';
            } else {
                $_SESSION['delete'] = 'failed';
            }
        } else {
            $_SESSION['delete'] = 'failed';
        }
        header('Location:'.base_url.'producto/gestion');
    }

}

// fin de clase 
