<?php

require_once '../Model/Connection.php';
class Categories{
    private $db = new Connection();

    public function __construct($db) {
        $this->db = $db;
    }

    public function SaveData($desc){
        $desc = $this->db->getConnection()->real_escape_string($_POST["form_desc"]);
        $sql = "";
    }
}