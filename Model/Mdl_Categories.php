<?php

require_once '../Model/Connection.php';
$con = new Connection();

class ModelCategories{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllCategories()
    {
        try{
            
        }catch(Exception $e){
            echo'<script>alert('.$e->getMessage().');</script>';
        }
    }
}
