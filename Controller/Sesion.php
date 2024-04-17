<?php
require_once '../Model/Connection.php';
$con = new Connection();
//This is the connection to the database
if($con->getConnection()->connect_errno){
    echo "Failed to connect";
}else{
     // Send the form data to the database
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // use the method to go to the database and sign in 
        if (SesionOn()) {
            // open sesion
            header("Location: MenuPrincipal.php");
            exit(); 
        } else {
            
            echo "<p>Registro de usuario fallido</p>";
        }
    }else{
        echo'
        <script>
        alert("ATENCION: No se pueden validar campos vacios ");
        </script>';
    }
}

function SesionOn(){
    global $conn;

    // Sanitizar la entrada del usuario
    $user = $conn->real_escape_string($_POST["txt_usuario"]);
    $pass = $conn->real_escape_string($_POST["txt_password"]);
    

    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Username = ? AND Contrasena = ?");
    
    // Ejecutar la consulta
    $stmt->bind_param('ss', $user, $pass);
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si se encontró un registro
    if ($result->num_rows == 1) {
        // Usuario y contraseña válidos
        echo "Inicio de sesión exitoso";
        return true; // Devuelve true si la sesión se inició correctamente
    } else {
        // Usuario o contraseña incorrectos
        echo "<p>Usuario o contraseña incorrectos</p>";
        return false; // Devuelve false si la sesión no se inició correctamente
    }

    // Cerrar la consulta
    $stmt->close();
}