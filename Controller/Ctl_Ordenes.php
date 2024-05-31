<?php
require_once '../Model/Mdl_Ordenes.php';
require_once '../Modals/ModalOrder.php';
require_once '../Model/Connection.php';

class ControllerOrders{
    private $model;
    private $modal;

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

    public function editOrder($id, $estado, $fecha, $hora, $cantidad, $monto){
        $this->model->editOrder($id, $estado, $fecha, $hora, $cantidad, $monto);
    }
    
    public function deleteOrder($id){
        $this->model->deleteOrder($id);
    }
    
}
