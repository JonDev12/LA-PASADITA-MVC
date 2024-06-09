<?php 
require_once '../Model/Connection.php'; // Import the Connection class

$con = new Connection(); // Create a new Connection object

function UploadDrinks() {
    global $con; // Access the global variable $con

    // Sanitize the user input
    $D = $con->getConnection()->real_escape_string($_POST["desc"]);
    $C_ML = $con->getConnection()->real_escape_string($_POST["cant"]);
    $C = $con->getConnection()->real_escape_string($_POST["ingre"]);
    $P = $con->getConnection()->real_escape_string($_POST["price"]);

    // Construct the SQL query to call the stored procedure
    $sql = 'CALL InsertBebidas("'.$D.'", "'.$C_ML.'", "'.$C.'", "'.$P.'")';

    // Execute the SQL query
    if ($con->getConnection()->query($sql) === TRUE) {
        // Successful registration
        return true;
    } else {
        // Error registering order
        return false;
    }
}

// Check database connection
if($con->getConnection()->connect_errno) {
    echo "Failed to connect";
} else {
    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Try to register the order
        if (UploadDrinks()) {
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirect after adding a drink
            exit();
        } else {
            echo "Error registering order"; // Provide feedback in case of an error
        }
    }
}
?>
