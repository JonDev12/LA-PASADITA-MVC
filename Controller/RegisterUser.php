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
        if (UserLog()) {
            // open sesion
            header("Location: ../View/index.php");
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

function UserLog(){
    global $conn;

    // Sanitizar la entrada del usuario
    $nombre = $conn->real_escape_string($_POST["txt_name"]);
    $apellido1 = $conn->real_escape_string($_POST["txt_lname1"]);
    $apellido2 = $conn->real_escape_string($_POST["txt_lname2"]);
    $telefono = $conn->real_escape_string($_POST["txt_phone"]);
    $tipo_usuario = $conn->real_escape_string($_POST["cbx_type_user"]);
    $username = $conn->real_escape_string($_POST["txt_username"]);
    $contrasena = $conn->real_escape_string($_POST["txt_pwd"]);

    // Consulta SQL para insertar usuario
    $sql = "INSERT INTO Usuarios (Nombre, ApellidoP, ApellidoM, Contacto, Tipo_Usuario, Username, Contrasena) 
            VALUES ('$nombre', '$apellido1', '$apellido2', '$telefono', '$tipo_usuario', '$username', '$contrasena')";

    // Ejecutar la consulta SQL
    if ($conn->query($sql) === TRUE) {
        // Registro exitoso
        echo "Usuario registrado exitosamente";
        return true; // Devuelve true si el usuario se registró correctamente
    } else {
        // Error al registrar usuario
        echo "Error al registrar usuario: " . $conn->error;
        return false; // Devuelve false si hubo un error al registrar el usuario
    }
}

