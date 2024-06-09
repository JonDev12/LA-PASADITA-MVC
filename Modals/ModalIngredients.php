<?php 
require_once '../Model/Connection.php'; // Import the Connection class

$con = new Connection(); // Create a new Connection object

function UploadIngredient() {
    global $con; // Access the global variable $con

    // Sanitize the user input
    $D = $con->getConnection()->real_escape_string($_POST["Desc"]);
    $C_ML = $con->getConnection()->real_escape_string($_POST["ammount"]);
    $UM = $con->getConnection()->real_escape_string($_POST["quantity"]);

    // Construct the SQL query to call the stored procedure
    $sql = 'CALL InsertIngredients("'.$D.'", "'.$C_ML.'", "'.$UM.'")';

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
        if (UploadIngredient()) {
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirect after editing or deleting
            exit();
        } else {
            echo "Error registering order"; // Provide feedback in case of an error
        }
    }
}
?>
