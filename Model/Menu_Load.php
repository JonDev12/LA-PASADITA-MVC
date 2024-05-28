<?php
require_once('../Model/Connection.php');

class Menu{
    private $model_session;
    
    public function __construct() {
        $this->model_session = new Connection();
    }
    
    public function GetUsers(){
        $con = $this->model_session->getConnection();
        // Here you can use the connection $con to perform queries
        // Query all users
        $sql = "SELECT IdUsuarios, Nombre, ApellidoP, ApellidoM, Tipo_usuario, Fecha_Alta FROM usuarios";
        $result = $con->query($sql);
    
        // Check if the query was successful
        if ($result === false) {
            // Handle the error here, for example:
            echo "Error in the query: " . $con->error;
        } else {
            // Create a variable to store the HTML of the table
            $html = '';
            $formatted_date = '';
            // Iterate over the results
            while ($row = $result->fetch_assoc()) {
                // Convert the date to the desired format 'd/m/Y'
                $datetime = date_create($row['Fecha_Alta']);
                $formatted_date = date_format($datetime, 'd/m/Y');
                
                // Add a row to the table for each result
                $html .= "<tr>";
                $html .= "<th scope='row' class='text-center'>{$row['IdUsuarios']}</th>";
                $html .= "<td class='text-center'>{$row['Nombre']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoP']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoM']}</td>";
                $html .= "<td class='text-center'>{$row['Tipo_usuario']}</td>";
                $html .= "<td class='text-center'>{$formatted_date}</td>"; // Show the formatted date
                $html .= "<td class='text-center'>
                            <div class='text-center'>
                                <button href='#' style='width: 40px; height: 40px;border-radius: 10px; background-color: #d9e3eb;'>
                                    <i class='bi bi-pen-fill'></i>
                                </button>
                                <button href='#' style='width: 40px; height: 40px;border-radius: 10px; background-color: red;'>
                                    <i class='bi bi-trash3-fill'></i>
                                </button>
                            </div>
                        </td>";
                $html .= "</tr>";                
            }
    
            // Close the connection after using it
            $con->close();
    
            // Return the generated HTML
            return $html;
        }
    }      
}
?>
