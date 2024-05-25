<?php

require_once '../Model/Connection.php';

class ModelIngredients{
    private $db;
    public function __construct($con){
        $this->db = $con->getConnection();        
    }

    public function GetAllIngredients(){
        try {
            $query = "SELECT Descripcion, Cantidad, U_Medida FROM Ingredientes";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['Descripcion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Cantidad'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['U_Medida'] . '</td>';
                    $tableBody .=   "<td class='text-center'>
                                        <div class='text-center'>
                                            <button data-bs-target='#modalIngEd' style='width: 40px; height: 40px;border-radius: 10px; background-color: #d9e3eb;'>
                                                <i class='bi bi-pen-fill'></i>
                                            </button>
                                            <button data-bs-target='#modalIngDe' style='width: 40px; height: 40px;border-radius: 10px; background-color: red;'>
                                                <i class='bi bi-trash3-fill'></i>
                                            </button>
                                        </div>
                                    </td>";
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="4" class="text-center">
                                <h7 class="text-center">No hay datos aun</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }

    public function ShowUnit(){
        try{
            $sql = "SELECT DISTINCT U_Medida FROM Ingredientes";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $data = '';
                while($row = $result->fetch_assoc()){
                    $data .= '<option value="' . $row['U_Medida'] . '">' . $row['U_Medida'] . '</option>';
                }
                return $data;
            } else {
                return '<option>No units found</option>';
            }
        } catch(Exception $e){
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
    
}