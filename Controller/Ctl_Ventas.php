<?php
require_once '../Model/Mdl_Ventas.php';
require_once '../Model/Connection.php';

class ControllerSales{
    private $model;

    public function __construct(){
        $con = new Connection();
        $this->model = new ModelSales($con);
    }

    public function getAllSales(){
        return $this->model->getAllSales();
    }

    public function getSale($id){
        //return $this->model->getSales($id);
    }

    public function getSalesByUser($id){
        //return $this->model->getOrdersByUser($id);
    }
}
