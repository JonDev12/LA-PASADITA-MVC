<?php
require_once '../Model/Mdl_Pedidos.php';
require_once '../Model/Connection.php';

class ControllerDelivery{
    private $model;

    public function __construct(){
        $con = new Connection();
        $this->model = new ModelDelivery($con);
    }

    public function getDeliveries(){
        return $this->model->getDeliveries();
    }
    
    public function getSaurces(){
        return $this->model->getSaurces();
    }
}