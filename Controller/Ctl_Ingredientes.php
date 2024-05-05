<?php
require_once '../Model/Mdl_Ingredientes.php';
require_once '../Model/Connection.php';

class ControllerIngredients
{
    private $mc;

    public function __construct()
    {
        $con = new Connection();
        $this->mc = new ModelIngredients($con);
    }

    public function ShowData()
    {
        return $this->mc->GetAllIngredients();
    }
}
