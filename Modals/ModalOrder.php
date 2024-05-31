<?php
require_once '../Model/Connection.php';
$con = new Connection();

function UploadOrder(){
    global $con;
    
    // Get the data from the form
    $state = $_POST['state'];
    $datetime = new DateTime();
    $date = $datetime->format('Y-m-d');
    $time = $datetime->format('H:i:s');
    $count = $_POST['txt_quantity'];
    $entry = $_POST['cbx_dish'];
    $ammount = $_POST['txt_ammount'];

    try {
        // Prepare the SQL statement
        $sql = "CALL InsertOP_OB(?, ?, ?, ?, ?, ?)";
        $stmt = $con->getConnection()->prepare($sql);

        // Bind parameters
        $stmt->bind_param("sssisd", $state, $date, $time, $count, $entry, $ammount);

        // Execute the statement
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

    } catch (Exception $e) {
        error_log("Error al ejecutar el procedimiento almacenado: " . $e->getMessage());
        return false;
    }
}

// Check database connection
if ($con->getConnection()->connect_errno) {
    echo "Failed to connect";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Try to register the order
        if (UploadOrder()) {
            echo "Order registered successfully.";
        } else {
            echo "Failed to register order.";
        }
    }
}
?>
