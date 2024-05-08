<?php

require_once '../Model/Connection.php';

class ModelSaurces{
    private $db;

    public function __construct($con){
        $this->db = $con->getConnection();
    }

    public function getAllSaurces(){
        try{
            $query = "SELECT ImagenPlatillo, Descripcion FROM platillos"; 
            $stmt = $this->db->prepare($query);
            $stmt->execute();   
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $cardbody = '';
                while($row = $result->fetch_assoc()){
                    $cardbody .= '<div class="card" style="width: 18rem;">
                                        <img src="' . $row['ImagenPlatillo'] . '" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <h5 class="card-title">Card title</h5>
                                        <p class="card-text">' . $row['Descripcion'] . '</p>
                                        <a href="#" class="btn btn-primary">Go somewhere</a>
                                        </div>
                                    </div>';
                }
                echo $cardbody;
            }else{
                echo '<h1 style="font-size: 23px;" class="text-center">Sin datos que mostrar</h1>';
            }
        }catch(Exception $e){
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>