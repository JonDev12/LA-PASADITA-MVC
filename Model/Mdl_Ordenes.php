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
                    $tableBody .=  "<td class='text-center'>
                    <div class='text-center'>
                        <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#modalEditarOrden' data-id='" . $row['IdOrdenes'] . "' data-estado='" . $row['estado'] . "' data-cantidad='" . $row['cantidad'] . "' data-monto='" . $row['monto'] . "'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>
                                <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#modalEliminarOrden' data-id='" . $row['IdOrdenes'] . "'>
                                    <i class='bi bi-trash'></i>
                                </button>
                    </div>
                </td>";
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

    public function getOrder($id){
        $query = $this->db->prepare('SELECT * FROM ordenes WHERE IdOrdenes = ?');
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
        try {
            $query = "DELETE FROM ordenes WHERE IdOrdenes = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar la orden " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function updateOrder($id, $estado, $cantidad, $monto){
        try {
            $query = "UPDATE ordenes SET Estado = ?, Cantidad = ?, Monto = ? WHERE IdOrdenes = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssdi", $estado, $cantidad, $monto, $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al editar la orden: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }
    
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = new ModelOrders(new Connection());
    if (isset($_POST['edit_Orden'])) {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $cantidad = $_POST['cantidad'];
        $monto = $_POST['monto'];
        $menu->updateOrder($id, $estado, $cantidad, $monto);
    } elseif (isset($_POST['delete_Orden'])) {
        $id = $_POST['id'];
        $menu->deleteOrder($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}