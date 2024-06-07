<?php
require_once('../Model/Connection.php');

class Menu
{
    private $model_session;

    public function __construct()
    {
        $this->model_session = new Connection();
    }

    public function GetUsers()
    {
        $con = $this->model_session->getConnection();
        $sql = "SELECT IdUsuarios, Nombre, ApellidoP, ApellidoM, Tipo_usuario, Fecha_Alta FROM usuarios";
        $result = $con->query($sql);

        if ($result === false) {
            echo "Error in the query: " . $con->error;
        } else {
            $html = '';
            while ($row = $result->fetch_assoc()) {
                $datetime = date_create($row['Fecha_Alta']);
                $formatted_date = date_format($datetime, 'd/m/Y');

                $html .= "<tr>";
                $html .= "<th scope='row' class='text-center'>{$row['IdUsuarios']}</th>";
                $html .= "<td class='text-center'>{$row['Nombre']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoP']}</td>";
                $html .= "<td class='text-center'>{$row['ApellidoM']}</td>";
                $html .= "<td class='text-center'>{$row['Tipo_usuario']}</td>";
                $html .= "<td class='text-center'>{$formatted_date}</td>";
                $html .= "<td class='text-center'>
                            <div class='text-center'>
                                <button type='button' class='btn btn-primary edit-btn' data-bs-toggle='modal' data-bs-target='#ModalUsUp'
                                        data-id='{$row['IdUsuarios']}' data-nombre='{$row['Nombre']}'
                                        data-apellidop='{$row['ApellidoP']}' data-apellidom='{$row['ApellidoM']}'
                                        data-tipousuario='{$row['Tipo_usuario']}'>
                                    <i class='bi bi-pencil-square'></i>
                                </button>
                                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#ModalUsDe'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </div>
                        </td>";
                $html .= "</tr>";
            }

            $con->close();
            return $html;
        }
    }

    public function EditUser()
    {
        $con = $this->model_session->getConnection();
        $sql = "UPDATE usuarios SET Nombre = ?, ApellidoP = ?, ApellidoM = ?, Tipo_usuario = ? WHERE IdUsuarios = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssssi', $nombre, $apellidoP, $apellidoM, $tipo_usuario, $id);
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $tipo_usuario = $_POST['tipo_usuario'];
        $id = $_POST['id'];
        $stmt->execute();
        $stmt->close();
        $con->close();
    }

    public function DeleteUser()
    {
        $con = $this->model_session->getConnection();
        $sql = "DELETE FROM usuarios WHERE IdUsuarios = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);
        $id = $_POST['id'];
        $stmt->execute();
        $stmt->close();
        $con->close();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = new Menu();
    if (isset($_POST['edit_user'])) {
        $menu->EditUser();
    } elseif (isset($_POST['delete_user'])) {
        $menu->DeleteUser();
    }
    header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
    exit;
}
?>
