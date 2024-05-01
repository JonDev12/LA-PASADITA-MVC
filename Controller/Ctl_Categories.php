<?php
require_once '../Model/Mdl_Categories.php';
require_once '../Model/Connection.php';

class ControllerCategories
{
    private $mc;

    public function __construct()
    {
        $con = new Connection();
        $this->mc = new ModelCategories($con);
    }

    public function ShowData()
    {
        return $this->mc->GetAllCategories();
    }
}
