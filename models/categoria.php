<?php
//Definiendo la clase modelo para categorias, lo que tiene que ver con acciones de 
// usuario en la base de datos se relaciona aquí en el modelo
class Categoria{
    //Definiendo propiedades de la categoría = Campos de la base de datos
    private $id;
    private $nombre;
    private $db;
    
    // Constructor
    public function __construct() {
        $this->db = Database::connect();
    }
    //Métodos Setter an Getter
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        //Se usa un método para validar que cada propiedad se obtenga en un string
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    // Método para obtener las categorías consultando la base de datos
    public function getAll() {
        $categorias = $this->db->query("SELECT * FROM categorias ORDER BY id DESC;");
        return $categorias;
    }
    // Método para obtener una categoría y sus productos consultando la base de datos
    public function getOne() {
        $categoria = $this->db->query("SELECT * FROM categorias WHERE id={$this->getId()};");
        return $categoria->fetch_object();
    }
    
    //Método para guardar categorías
    public function save() {
         $sql = "INSERT INTO categorias VALUES(NULL, '{$this->getNombre()}');";
        $save = $this->db->query($sql);
        
        $result = false;
        if($save){
           $result = true; 
        }
        return $result;
    }

}