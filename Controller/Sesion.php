<?php
require_once '../Model/Connection.php';
function SesionOn(){
    global $con; // Cambia $conn por $con para que coincida con la variable de conexión que has creado
    
    // Verifica si se ha enviado la solicitud POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitizar la entrada del usuario
        $user = $con->getConnection()->real_escape_string($_POST["txt_usuario"]);
        $pass = $con->getConnection()->real_escape_string($_POST["txt_password"]);
        
        // Preparar la consulta
        $stmt = $con->getConnection()->prepare("SELECT * FROM Usuarios WHERE Username = ? AND Contrasena = ?");
        
        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo "Error en la preparación de la consulta: " . $con->getConnection()->error;
            return false;
        }
        
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
    } else {
        // Si no se envió la solicitud POST
        echo '<script>alert("ATENCION: No se pueden validar campos vacios ");</script>';
        return false;
    }
}
