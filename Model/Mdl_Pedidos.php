<?php

require_once '../Model/Connection.php';

class ModelDelivery{
    private $db;

    public function __construct($con){
        $this->db = $con->getConnection();
    }

    public function getDeliveries(){
        try {
            $query = "SELECT IdPedidos, estado, fecha, hora, cantidad, monto FROM pedidos";
            $stmt = $this->db->prepare($query);
            $stmt->execute();   
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td>' . $row['IdPedidos'] . '</td>';
                    $tableBody .= '<td>' . $row['estado'] . '</td>';
                    $tableBody .= '<td>' . $row['fecha'] . '</td>';
                    $tableBody .= '<td>' . $row['hora'] . '</td>';
                    $tableBody .= '<td>' . $row['cantidad'] . '</td>';
                    $tableBody .= '<td>' . $row['monto'] . '</td>';
                    $tableBody .= '<td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPedidosEd">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalPedidosDe">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>';
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="7" class="text-center">
                                <h7 class="text-center">Sin datos que mostrar</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }    
    }

    public function getSaurces(){
        try{
            $sql = "SELECT Descripcion FROM platillos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();   
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $options = '';
                while($row = $result->fetch_assoc()){
                    $options .= '<option>'.$row['Descripcion'].'</option>';
                }
                return $options;
            }
        }catch(Exception $e){
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}