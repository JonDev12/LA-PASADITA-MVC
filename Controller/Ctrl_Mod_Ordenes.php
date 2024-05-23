<?php
require_once '../Model/Connection.php';

class ModalOrder{
    private $db;

    public function __construct(){
        $this->db = new Connection();
        $this->db = $this->db->getConnection();
    }

    

    public function SetOrder(){
        $state = $_POST['cbx_state'];
        $dish = $_POST['cbx_dish'];
        $ammount = $_POST['txt_ammount'];

        $datetime = new DateTime();
        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('H:i:s');
        
        $price = $_POST['txt_price'];

        $sql = "INSERT INTO ordenes(Estado, Fecha, Hora, Cantidad, Monto) 
                VALUES ('$state', '$date', '$time', '$ammount','$price')";
                
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>