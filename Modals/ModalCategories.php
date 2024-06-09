<?php
require_once '../Model/Connection.php';
$con = new Connection();

function UploadCat(){
    global $con;

    // Check if the key "cbx_state" exists in $_POST
        // Sanitize the user input
        $desc = $con->getConnection()->real_escape_string($_POST["txtDescripcion"]);
        // SQL query to insert order
        $sql = "INSERT INTO Categorias (Descripcion, Fecha_Creacion) 
                VALUES ('$desc', NOW())";

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
        if (UploadCat()) {
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirige después de editar o eliminar
            return true;
        } else {
            return false;
        }
    }
}
?>
