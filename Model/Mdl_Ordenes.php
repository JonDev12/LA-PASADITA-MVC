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
                    $tableBody .= '<td>' . $row['id'] . '</td>';
                    $tableBody .= '<td>' . $row['estado'] . '</td>';
                    $tableBody .= '<td>' . $row['fecha'] . '</td>';
                    $tableBody .= '<td>' . $row['hora'] . '</td>';
                    $tableBody .= '<td>' . $row['cantidad'] . '</td>';
                    $tableBody .= '<td>' . $row['monto'] . '</td>';
                    $tableBody .= '<td>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditOrder" onclick="editOrder(' . $row['id'] . ')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDeleteOrder" onclick="deleteOrder(' . $row['id'] . ')">
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
        }    }

    public function getOrder($id){
        $query = $this->db->prepare('SELECT * FROM ordenes WHERE id_orden = ?');
        $query->execute(array($id));
        $order = $query->fetch(PDO::FETCH_OBJ);
        return $order;
    }

    public function getOrdersByUser($id){
        $query = $this->db->prepare('SELECT * FROM ordenes WHERE id_usuario = ?');
        $query->execute(array($id));
        $orders = $query->fetchAll(PDO::FETCH_OBJ);
        return $orders;
    }

    public function addOrder($id_usuario, $fecha, $total){
        $query = $this->db->prepare('INSERT INTO ordenes(id_usuario, fecha, total) VALUES(?,?,?)');
        $query->execute(array($id_usuario, $fecha, $total));
        return $this->db->lastInsertId();
    }

    public function deleteOrder($id){
        $query = $this->db->prepare('DELETE FROM ordenes WHERE id_orden = ?');
        $query->execute(array($id));
    }

    public function updateOrder($id, $id_usuario, $fecha, $total){
        $query = $this->db->prepare('UPDATE ordenes SET id_usuario = ?, fecha = ?, total = ? WHERE id_orden = ?');
        $query->execute(array($id_usuario, $fecha, $total, $id));
    }
}