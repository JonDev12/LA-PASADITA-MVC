<?php
require_once '../Model/Connection.php';

class ModelOrders{
    private $db;

    public function __construct($con){
        $this->db = $con->getConnection();
    }

    public function getOrders(){
        try {
            $query = "SELECT IdOrdenes, estado, fecha, hora, cantidad, monto FROM ordenes";
            $stmt = $this->db->prepare($query);
            $stmt->execute();   
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                // Generate table body
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdOrdenes'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['estado'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['fecha'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['hora'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['cantidad'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['monto'] . '</td>';
                    // Botones de editar y eliminar
                    $tableBody .= '<td>';
                    $tableBody .= '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditOrder" onclick="editOrder(' . $row['IdOrdenes'] . ')">';
                    $tableBody .= '<i class="bi bi-pencil-square"></i> ';
                    $tableBody .= '</button>';
                    $tableBody .= '<button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteOrder" onclick="deleteOrder(' . $row['IdOrdenes'] . ')">';
                    $tableBody .= '<i class="bi bi-trash"></i> ';
                    $tableBody .= '</button>';
                    $tableBody .= '</td>';
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '<tr class="text-center"><td colspan="7" class="text-center"><h7 class="text-center">Sin datos que mostrar</h7></td></tr>';
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

    public function getPrices(){
        try{
            $sql = 'SELECT Precio FROM platillos';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $precios[$row["id"]] = $row["precio"];
                }
            }
        }catch(Exception $e){

        }
    }

    public function editOrder($id, $estado, $fecha, $hora, $cantidad, $monto){
        $query = $this->db->prepare('UPDATE ordenes SET estado = ?, fecha = ?, hora = ?, cantidad = ?, monto = ? WHERE IdOrdenes = ?');
        $query->execute(array($estado, $fecha, $hora, $cantidad, $monto, $id));
    }
    
    public function deleteOrder($id){
        $query = $this->db->prepare('DELETE FROM ordenes WHERE IdOrdenes = ?');
        $query->execute(array($id));
    }
    
}