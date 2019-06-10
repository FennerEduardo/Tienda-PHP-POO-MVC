<?php

//Cargar el modelo de producto
require_once 'models/producto.php';

// definir clase controladora
class carritoController {

    //Método para mostrar el carro
    public function index() {
        if (isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1) {
            $carrito = $_SESSION['carrito'];
        } else {
            $carrito = array();
        }
        //Cargar vista del carrito
        require_once 'views/carrito/index.php';
    }

    //Método para agregar productos al carrito
    public function add() {
        // Hay un id en el get?
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
        } else {
            header('Location:' . base_url);
        }
        // está sesión creada?
        if (isset($_SESSION['carrito'])) {
            $counter = 0; // contador a cero
            //Ciclo para recoger todos los elementos del objeto mediante el id
            foreach ($_SESSION['carrito'] as $indice => $elemento) {
                // sí el id del get coincide con el id de la sesión aumente una unidad
                if ($elemento['id_producto'] == $producto_id) {
                    $_SESSION['carrito'][$indice]['unidades'] ++;
                    $counter++; //contador suma uno más sí el producto ya está en la cesta
                }
            }
        }
        // Sí el contador no existe o está en cero creará la sesión y el objeto del producto
        if (!isset($counter) || $counter == 0) {
            // Obtener el producto
            $producto = new Producto();
            // pasar el id del producto para obtenerlo
            $producto->setId($producto_id);
            // usar el método para traer un producto
            $producto = $producto->getOne();

            // sí el producto es un objeto se va a crear un arreglo con sus propiedades
            // y se almacenarán en la sesión  es decir Creará el carrito
            if (is_object($producto)) {
                $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                );
            }
        }
        // Envia al index del controlador carrito
        header("Location:" . base_url . "carrito/index");
    }

    //Método para remover productos del carrito
    public function delete() {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            unset($_SESSION['carrito'][$index]);
        }
        header("Location:" . base_url . "carrito/index");
    }
    
    //Método para remover productos del carrito
    public function up() {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']++;
        }
        header("Location:" . base_url . "carrito/index");
    }
    
    //Método para remover productos del carrito
    public function down() {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']--;
            if($_SESSION['carrito'][$index]['unidades'] == 0){
                unset($_SESSION['carrito'][$index]);
            }
        }
        header("Location:" . base_url . "carrito/index");
    }
    
    // Método para vaciar el carrito
    public function delete_all() {
        unset($_SESSION['carrito']);
        header("Location:" . base_url . "carrito/index");
    }

}
