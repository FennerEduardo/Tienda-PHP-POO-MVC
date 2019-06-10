<?php

//Incluir el modelo de pedidos
require_once 'models/pedido.php';

// definir clase controladora
class pedidoController {

    public function hacer() {

        // incluir la vista de pedidos
        require_once 'views/pedido/hacer.php';
    }

    //Método para agregar un pedido a la base de datos
    public function add() {
        // Está identificado?
        if (isset($_SESSION['identity'])) {
            // Cargo variables con datos del post
            $usuario_id = $_SESSION['identity']->id; // obtener id del usuario por la session
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : FALSE;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : FALSE;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : FALSE;

            // obtener el total del pedido con el método de utils statsCarrito
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];

            if ($provincia && $localidad && $direccion) {
                //Guardar pedido en la base de datos
                $pedido = new Pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);
                #Ejecutar el insert mediante el método save
                $save = $pedido->save();
                
                // Guardar Línea pedido
                $save_linea = $pedido->save_linea();
                
                if($save && $save_linea){
                    $_SESSION['pedido'] = 'complete';
                } else {
                    $_SESSION['pedido'] = 'failed';
                }
            }else {
                $_SESSION['pedido'] = 'failed';
            }
            //Redireccionar
            header('Location:' .base_url.'pedido/confirmado');
            
        }else {
            //Redireccionar
            header('Location:' . base_url);
        }
    }// fin de método
    
    //método para cargar los pedidos confirmados en una vista
    public function confirmado() {
        //confirmas si la sesión existe con los datos de usuario
        if(isset($_SESSION['identity'])){
            $identity = $_SESSION['identity'];
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);
            $pedido = $pedido->getOneByUser();
            
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($pedido->id);
        }
        //Cargar vista 
        require_once 'views/pedido/confirmado.php';
        
    }
    
    //Método para la gestión de mis pedidos
    public function mis_pedidos() {
        //Esta registrado y logueado el usuario?
        Utils::isIdentity();
        //Obtener id de la sesión actual
        $usuario_id = $_SESSION['identity']->id;
        //Crear objeto de la clase modelo
        $pedido = new Pedido();
        
        
        //Usar método para obtener los pedidos
        $pedido->setUsuario_id($usuario_id);
        $pedidos = $pedido->getAllByUser();
        
        //Cargar vista para ver mis pedidos
        require_once 'views/pedido/mis_pedidos.php';
    }
    
    //Método para el detalle de cada pedido
    public function detalle() {
        //Esta registrado y logueado el usuario?
        Utils::isIdentity();
        
        // hay parametros en el get y la url?
        if(isset($_GET['id'])){
            $id = $_GET['id']; // recojo id en variable
            
            // Obtener el pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido = $pedido->getOne();
            
            //listar los productos
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);
            
            
            //Cargar vista para ver mis pedidos
           require_once 'views/pedido/detalle.php';
           
        } else{
            header('Location:'.base_url.'pedido/mis_pedidos');
        }
    }
    
    //Método para la gestión de pedidos por el admin
    public function gestion() {
        //Es administrador?
        Utils::isAdmin();
        
        //Crear variable para la Gestión de los pedidos
        $gestion = true;
        
        //Creo objeto de los pedidos
        $pedido = new Pedido();
        $pedidos = $pedido->getAll();
        
         //Cargar vista para ver mis pedidos
        require_once 'views/pedido/mis_pedidos.php';
    }
    
    //Método para cambiar el estado de un pedido
    public function estado() {
        //Es administrador?
        Utils::isAdmin();
        
        //Existe el post?
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            //Recoger variables
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];
            
            //Update del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            
            $pedido->edit();
            
            header('Location:'.base_url.'pedido/detalle&id='.$id);
            
        } else {
            header('Location:'.base_url);
        }
    }
}
