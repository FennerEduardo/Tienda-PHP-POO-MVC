<?php
//Definiendo la clase modelo para producto, lo que tiene que ver con acciones de 
// usuario en la base de datos se relaciona aquí en el modelo
class Producto{
    //Definiendo propiedades del usuario = Campos de la base de datos
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;
    private $db;
    
    // Constructor
    public function __construct() {
        $this->db = Database::connect();
    }
    
    //Métodos Getter and Setter
    function getId() {
        return $this->id;
    }

    function getCategoria_id() {
        return $this->categoria_id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getStock() {
        return $this->stock;
    }

    function getOferta() {
        return $this->oferta;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    function setNombre($nombre) {
        // se pasa función para comprobar texto en los inputs de inserción de productos
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $this->db->real_escape_string($descripcion);
    }

    function setPrecio($precio) {
        $this->precio = $this->db->real_escape_string($precio);
    }

    function setStock($stock) {
        $this->stock = $this->db->real_escape_string($stock);
    }

    function setOferta($oferta) {
        $this->oferta = $this->db->real_escape_string($oferta);
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
    }
    
    //Método para seleccionar los productos de la BD
    public function getAll() {
        //Consulta a la base de datos
        $productos = $this->db->query("SELECT * FROM productos ORDER BY id DESC;");
        return $productos;
    }
    
    //Método para seleccionar los productos de la BD por categoria
    public function getAllCategory() {
        $sql = "SELECT p.*, c.nombre AS 'catnombre' FROM productos p "
                . "INNER JOIN categorias c ON c.id = p.categoria_id "
                . "WHERE c.id = {$this->getCategoria_id()} "
                . " ORDER BY id DESC;";
        //Consulta a la base de datos
        $productos = $this->db->query($sql);
        return $productos;
    }
    
    //Método para cargar productos aleatorios
    public function getRandom($limit) {
        //Consulta a la base de datos
        $productos = $this->db->query("SELECT * FROM productos ORDER BY RAND() LIMIT $limit;");
        return $productos;
    }
    
    //Método para seleccionar los productos de la BD
    public function getOne() {
        //Consulta a la base de datos
        $producto = $this->db->query("SELECT * FROM productos WHERE id = {$this->getId()};");
        return $producto->fetch_object();
    }
    
    // método para insertar productos
    public function save(){
        $sql = "INSERT INTO productos"
                . " VALUES(NULL,{$this->getCategoria_id()}, '{$this->getNombre()}', '{$this->getDescripcion()}', "
                . "{$this->getPrecio()}, {$this->getStock()}, NULL"
                . ", CURDATE(), '{$this->getImagen()}');";
        $save = $this->db->query($sql);
        // código para comprobar sí la consulta está bien, solo para depuración
//                    echo $sql;
//                    echo $this->db->error;
//                    die();
        
        $result = false;
        if($save){
           $result = true; 
        }
        return $result;
    }
    
        // método para editar productos
    public function edit(){
        $sql = "UPDATE productos";
        $sql .= " SET nombre= '{$this->getNombre()}', descripcion ='{$this->getDescripcion()}', ";
        $sql .= "precio = {$this->getPrecio()}, stock = {$this->getStock()}, categoria_id = {$this->getCategoria_id()} ";
        
        // se cargo imagen nueva?
        if($this->getImagen() != null){
            $sql .= ", imagen = '{$this->getImagen()}'";
        }
        $sql .= " WHERE id={$this->id};";
        $save = $this->db->query($sql);
        // código para comprobar sí la consulta está bien, solo para depuración
//                    echo $sql;
//                    echo $this->db->error;
//                    die();
        
        $result = false;
        if($save){
           $result = true; 
        }
        return $result;
    }
    
    //Método para eliminar registro de la BD
    public function delete() {
        $sql = "DELETE FROM productos WHERE id={$this->id}";
        $delete = $this->db->query($sql);
        
        $result = false;
        if($delete){
           $result = true; 
        }
        return $result;
    }
}