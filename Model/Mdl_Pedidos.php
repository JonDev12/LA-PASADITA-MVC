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
                    $tableBody .= "<td class='text-center'>
                    <div class='text-center'>
                        <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#modalEditarPedido' data-id='" . $row['IdPedidos'] . "' data-estado='" . $row['estado'] . "' data-cantidad='" . $row['cantidad'] . "' data-monto='" . $row['monto'] . "'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>
                                <button type='button' class='btn btn-danger delete-btn' data-bs-toggle='modal' data-bs-target='#modalEliminarPedido' data-id='" . $row['IdPedidos'] . "'>
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
    public function getPedido($id){
        $query = $this->db->prepare('SELECT * FROM pedidos WHERE IdPedidos = ?');
        $query->execute(array($id));
        $pedido = $query->fetch(PDO::FETCH_OBJ);
        return $pedido;
    }

    public function deletePedido($id){
        try {
            $query = "DELETE FROM pedidos WHERE IdPedidos = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al eliminar el pedido " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }

    public function updatePedido($id, $estado, $cantidad, $monto){
        try {
            $query = "UPDATE pedidos SET Estado = ?, Cantidad = ?, Monto = ? WHERE IdPedidos = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ssdi", $estado, $cantidad, $monto, $id);
            $stmt->execute();
            return true; // Éxito
        } catch (Exception $e) {
            echo "<script>alert('Error al editar el pedido: " . $e->getMessage() . "');</script>";
            return false; // Error
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = new ModelDelivery(new Connection());
    if (isset($_POST['edit_Pedido'])) {
        $id = $_POST['id'];
        $estado = $_POST['estado'];
        $cantidad = $_POST['cantidad'];
        $monto = $_POST['monto'];
        $menu->updatePedido($id, $estado, $cantidad, $monto);
    } elseif (isset($_POST['delete_Pedido'])) {
        $id = $_POST['id'];
        $menu->deletePedido($id);
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}