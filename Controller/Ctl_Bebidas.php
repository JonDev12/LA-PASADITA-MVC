<?php
require_once '../Model/Mdl_Bebidas.php';
require_once '../Model/Connection.php';

class ControllerBebidas
{
    private $mb;

    public function __construct()
    {
        $con = new Connection();
        $this->mb = new ModelBebidas($con);
    }

    public function ShowData()
    {
        return $this->mb->GetAllBebidas();
    }
}
