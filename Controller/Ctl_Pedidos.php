<?php
require_once '../Model/Mdl_Ordenes.php';
require_once '../Model/Connection.php';

class ControllerDelivery{
    private $model;

    public function __construct(){
        $con = new Connection();
        $this->model = new ModelOrders($con);
    }

    public function getDeliveries(){
        return $this->model->getOrders();
    }
    
}