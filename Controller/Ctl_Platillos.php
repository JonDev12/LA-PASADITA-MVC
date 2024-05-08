<?php
require_once '../Model/Connection.php';
require_once '../Model/Mdl_Platillos.php';

class ControllerSaurces{
    private $model;

    public function __construct(){
        $con = new Connection();
        $this->model = new ModelSaurces($con);
    }

    public function getAllSaurcesList(){
        return $this->model->getAllSaurces();
    }

    public function getDelivery($id){
        return $this->model->getOrder($id);
    }

    public function getDeliveriesByUser($id){
        return $this->model->getOrdersByUser($id);
    }
}
?>