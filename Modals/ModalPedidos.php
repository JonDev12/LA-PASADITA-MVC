<?php
require_once '../Model/Connection.php'; // Importa la clase Conexion

// Crea una instancia de Conexion y obtén la conexión
$conn = new Connection();

function UploadDelivery(){
    global $conn; // Accede a la variable global $conn

    $state = $conn->getConnection()->real_escape_string($_POST['state']);
    $dish = $conn->getConnection()->real_escape_string($_POST['cbx_dish']);
    $quantity = $conn->getConnection()->real_escape_string($_POST['txt_quantity']);
    $price = $conn->getConnection()->real_escape_string($_POST['txt_ammount']); // Asegúrate de que el precio es correcto

    // Calcula el monto total si el precio es por unidad
    $total = $quantity * $price;

    $sql = "INSERT INTO Pedidos (Estado, Fecha, Hora, Cantidad, Monto)
            VALUES ('$state', NOW(), NOW(), '$quantity', '$total')";

    if ($conn->getConnection()->query($sql) === TRUE) {
        // Successful registration
        return true;
    } else {
        // Error registering order
        return false;
    }
}

if ($conn->getConnection()->connect_errno) {
    echo "Failed to connect";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (UploadDelivery()) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error registering order";
        }
    }
}
?>
