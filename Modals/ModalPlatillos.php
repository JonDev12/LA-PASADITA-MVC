<?php
require_once '../Model/Connection.php';
$con = new Connection();

function UploadCat(){
    global $con;

    // Check if the key "cbx_state" exists in $_POST
    if(isset($_POST["descr"]) && isset($_POST["cat"])) {
        // Sanitize the user input
        $desc = $con->getConnection()->real_escape_string($_POST["descr"]);
        $cat = $con->getConnection()->real_escape_string($_POST["cat"]);
        // SQL query to insert order
        $sql = "CALL InsertPlatillos('$desc', '$cat')";

        // Execute the SQL query
        if ($con->getConnection()->query($sql) === TRUE) {
            // Successful registration
            return true; // Return true if the order was successfully registered
        } else {
            // Error registering order
            return false; // Return false if there was an error registering the order
        }
    } else {
        return false;
    }
}

// Check database connection
if($con->getConnection()->connect_errno){
    echo "Failed to connect";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Try to register the order
        if (UploadCat()) {
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
            exit(); // Termina la ejecución del script después de redirigir
        } else {
            echo "Error in uploading category"; // Añadido mensaje de error para manejar fallos
        }
    }
}
?>
