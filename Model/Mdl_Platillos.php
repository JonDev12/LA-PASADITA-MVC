<?php

require_once '../Model/Connection.php';

class ModelSaurces{
    private $db;

    public function __construct($con){
        $this->db = $con->getConnection();
    }

    public function getAllSaurces(){
        try{
            $sql = "SELECT 
                    'ImagenPlpatillo', 'Descripcion', 
                    'Categoria', 'FechaCreacionN'
                    FROM platillos
                    INNNER JOIN categoria ON 
                    platillos.idCategoria = categoria.idCategoria";
        }catch(Exception $e){
            echo '<script>alert("Error"'.$e->getMessage().')</script>';
        }
    }
}
?>