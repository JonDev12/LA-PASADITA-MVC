<?php
require_once '../Model/Connection.php';
class ModelBitacora
{
    private $db;

    public function __construct($con) {
        $this->db = $con->getConnection();
    }

    public function GetAllBitacora() {
        try {
            $query = "SELECT IdBitacora, Responsable, Operacion, TablaObjetivo, Atributo, ValorAnterior, ValorNuevo, FechaMovimiento FROM bitacora";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $tableBody = '';
                while ($row = $result->fetch_assoc()) {
                    $tableBody .= '<tr>';
                    $tableBody .= '<td class="text-center">' . $row['IdBitacora'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Responsable'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Operacion'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['TablaObjetivo'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['Atributo'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['ValorAnterior'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['ValorNuevo'] . '</td>';
                    $tableBody .= '<td class="text-center">' . $row['FechaMovimiento'] . '</td>';
                    $tableBody .= '</tr>';
                }
                return $tableBody;
            } else {
                return '
                        <tr class="text-center">
                            <td colspan="5" class="text-center">
                                <h7 class="text-center">No hay datos aun</h7>
                            </td>
                        </tr>';
            }
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

