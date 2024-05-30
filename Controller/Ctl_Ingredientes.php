<?php
require_once '../Model/Connection.php';
require_once '../Model/MdI_Ingredientes.php';

class ControllerIngredients
{
    private $mc;

    public function __construct()
    {
        $con = new Connection();
        $this->mc = new ModelIngredients($con);
    }

    public function ShowData(){
        return $this->mc->GetAllIngredients();
    }

    public function ShowUnit(){
        return $this->mc->ShowUnit();
    }
}

