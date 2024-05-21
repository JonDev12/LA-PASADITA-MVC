<?php
require_once '../Model/Connection.php';
$conn = new Connection();

class Ctl_Sesion{
    private $name;
    private $pwd;

    public function __construct($name, $pwd){
        $this->name = $name;
        $this->pwd = $pwd;
    }

    public function Login(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->name = $_POST['txt_usuario'];
            $this->pwd = $_POST['txt_password'];

            $conn = new Connection();
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$this->name' AND contrasena = '$this->pwd'";
            
        }
    }
}
?>