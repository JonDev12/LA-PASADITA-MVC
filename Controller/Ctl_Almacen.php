<?php
require_once '../Model/Mdl_Almacen.php';
require_once '../Model/Connection.php';

class ControllerAlmacen
{
    private $ma;

    public function __construct()
    {
        $con = new Connection();
        $this->ma = new ModelAlmacen($con);
    }

    public function ShowData()
    {
        return $this->ma->GetAllItems();
    }
}
