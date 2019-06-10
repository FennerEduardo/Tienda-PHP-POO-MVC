<?php
//Incluir el modelo
require_once 'models/usuario.php';

// definir clase controladora
class usuarioController{
    
    public function index() {
        echo 'Controlador Usuarios, Acción index';
    }
    //Método de registro
    public function registro() {
        require_once 'views/usuario/registro.php';
    }
    //Método de guardado de usuarios
    public function save() {
        if(isset($_POST)){
           $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false; 
           $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false; 
           $email = isset($_POST['email']) ? $_POST['email'] : false; 
           $password = isset($_POST['password']) ? $_POST['password'] : false; 
            
            if($nombre && $apellidos && $email && $password){
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);
                $save2 = $usuario->save();

                if($save2){
                    $_SESSION['register'] = "complete";
                }else{
                    $_SESSION['register'] = "failed";
                } 
            }else{
                $_SESSION['register'] = "failed";
            }
        }else{
            $_SESSION['register'] = "failed";
        }
        header("Location:".base_url."usuario/registro");
    }
    
    //Método para Login de usuarios
    public function login() {
        // comprobar POST
        if (isset($_POST)) {
        // Identificar al usuario
            //Consulta a la base de datos mediante el modelo y su metodo login
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);
            
            $identity = $usuario->login();
           
            //Crear una sesión para mantener al usuario identificado
            if($identity && is_object($identity)){
                $_SESSION['identity'] = $identity;
                // ¿Es un usuario administrador?
                if($identity->rol == 'admin'){
                    $_SESSION['admin'] = true;
                }
            } else{
                $_SESSION['error_login'] = 'Identificación fallida !!';
            }
        }
        header("Location:".base_url);
        
    }
    //Método para logout de usuarios
    public function logout() {
        if(isset($_SESSION['identity'])){
            unset($_SESSION['identity']);
        }
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
        }
        header("Location:".base_url);
    }
} // Fin de la clase

