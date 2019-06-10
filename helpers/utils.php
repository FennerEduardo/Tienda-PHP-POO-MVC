<?php
// Archivo de utilidades, creado para hacer clases y metodos de ayuda

// Creación de clase estática de utilidades
class Utils{
    
    //Método para eliminar una sesión especifica, pasada por el parametro $name
    public static function deleteSession($name){
        if(isset($_SESSION[$name])){
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }
    
    //Método para comprobar sí un usuario es Admin
    public static function isAdmin() {
        if (!isset($_SESSION['admin'])) {
            header("Location:".base_url);
        }else{
            return true;
        }
    }
    
     //Método para comprobar sí un usuario esta logueado
    public static function isIdentity() {
        if (!isset($_SESSION['identity'])) {
            header("Location:".base_url);
        }else{
            return true;
        }
    }
    
    //Método para mostrar las categorias
    public static function showCategorias(){
        // incluyendo el modelo
        require_once 'models/categoria.php';
        // Creando objeto de la clase modelo
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        
        return $categorias;
    }
    
    //Método para la gestión de cantidades en el carrito
    public static function statsCarrito(){
        //Arreglo de valores para las cantidades del carro
        $stats = array(
            'count' => 0,
            'total' =>0
        );
        if(isset($_SESSION['carrito'])){
            //Contar la cantidad de productos y los guardo en en el array
            $stats['count'] = count($_SESSION['carrito']);
            
            //Bucle para contar la cantidad de cada producto y el precio total
            foreach($_SESSION['carrito'] as $producto){
                $stats['total'] += $producto['precio']*$producto['unidades'];
            }
        }
        return $stats;
    }
    
    //Método para mostrar un estado
    public static function showStatus($status) {
        $value = 'Pendiente';
        if($status == 'confirm'){
            $value = 'Pendiente';
        }
        elseif ($status == 'preparate') {
            $value = 'En preparación';
        }
        elseif ($status == 'ready') {
            $value = 'Preparado';
        }
        elseif ($status == 'sended') {
            $value = 'Enviado';
        }
        return $value; 
        }
    
}// fin de clase  