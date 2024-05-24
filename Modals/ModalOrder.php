<?php
require_once '../Model/Connection.php';
$con = new Connection();

function UploadOrder(){
    global $con;

    // Check if the key "cbx_state" exists in $_POST
        // Sanitize the user input
        $cantidad = $con->getConnection()->real_escape_string($_POST["txt_quantity"]);
        $monto = $con->getConnection()->real_escape_string($_POST["txt_ammount"]);
        $datetime = new DateTime();
        $fecha = $datetime->format('Y-m-d');
        $hora = $datetime->format('H:i:s');

        // SQL query to insert order
        $sql = "INSERT INTO Ordenes (Estado, Fecha, Hora, Cantidad, Monto) 
                VALUES ('En espera', '$fecha', '$hora' ,'$cantidad', '$monto')";

        // Execute the SQL query
        if ($con->getConnection()->query($sql) === TRUE) {
            // Successful registration
            return true; // Return true if the order was successfully registered
        } else {
            // Error registering order
            return false; // Return false if there was an error registering the order
        }
}

// Check database connection
if($con->getConnection()->connect_errno){
    echo "Failed to connect";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Try to register the order
        if (UploadOrder()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
