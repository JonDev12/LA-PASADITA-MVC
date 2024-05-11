<?php

require_once '../Model/Connection.php';

class ModelSaurces {
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function getAllSaurces() {
        try {
            $platillos = array();
            $sql = "SELECT 
                        platillos.ImagenPlatillo, platillos.Descripcion,
                        categorias.Descripcion AS Categoria, platillos.FechaCreacion
                    FROM platillos
                    INNER JOIN 
                        categorias_has_platillos
                    ON 
                        platillos.IdPLatillos = categorias_has_platillos.IdPLatillos
                    INNER JOIN 
                        categorias
                    ON 
                        categorias.IdCategorias = categorias_has_platillos.IdCategorias;";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();   
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $platillo = array(
                        'imagen' => $row['ImagenPlatillo'],
                        'descripcion' => $row['Descripcion'],
                        'categoria' => $row['Categoria'],
                        'fecha_creacion' => $row['FechaCreacion']
                    );
                    $platillos[] = $platillo;
                }
            }
            return $platillos;
        } catch(Exception $e) {
            // Manejar errores aquí si es necesario
            return array(); // Devolver un array vacío en caso de error
        }
    }
    
}
?>
