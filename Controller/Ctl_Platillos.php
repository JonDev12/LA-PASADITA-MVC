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
        $platillos = getAllPlatillos();
            foreach ($platillos as $platillo) {
                echo '<div class="card" style="width: 18rem;">
                        <img src="'.$platillo['imagen'].'" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">'.$platillo['descripcion'].'</h5>
                                <p class="card-text">Categoría: '.$platillo['categoria'].'</p>
                                <p class="card-text">Fecha de Creación: '.$platillo['fecha_creacion'].'</p>
                            </div>
                        </div>';
        } 

    }

    public function getDelivery($id){
        return $this->model->getOrder($id);
    }

    public function getDeliveriesByUser($id){
        return $this->model->getOrdersByUser($id);
    }
}
?>