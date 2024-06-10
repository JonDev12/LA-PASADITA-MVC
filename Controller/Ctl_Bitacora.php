<?php
require_once '../Model/Mdl_Bitacora.php';
require_once '../Model/Connection.php';

class ControllerBitacora
{
    private $bi;

    public function __construct()
    {
        $con = new Connection();
        $this->bi = new ModelBitacora($con);
    }

    public function ShowData()
    {
        return $this->bi->GetAllBitacora();
    }
}
