<?php
// Clase estática para conectar con la base de datos.
class Database{
    public static function connect(){
        $db = new mysqli('localhost', 'root', '', 'tienda_master');
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}