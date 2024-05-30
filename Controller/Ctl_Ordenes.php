<?php
require_once '../Model/Mdl_Ordenes.php';
require_once '../Model/Connection.php';

class ControllerOrders{
    private $model;

    public function __construct(){
        $con = new Connection();
        $this->model = new ModelOrders($con);
    }

    public function getOrders(){
        return $this->model->getOrders();
    }

    public function getSaurces(){
        return $this->model->getSaurces();
    }

    public function UploadSaurces(){
        
    }

    public function getOrder($id){
        return $this->model->getOrder($id);
    }

    public function getOrdersByUser($id){
        return $this->model->getOrdersByUser($id);
    }
    
}
