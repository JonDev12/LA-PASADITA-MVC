<?php
require_once '../Model/Connection.php';
$con = new Connection();

// Verificar la conexión a la base de datos
if($con->getConnection()->connect_errno){
    echo "Failed to connect";
} else {
    // Verificar si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si hay campos vacíos
        if (empty($_POST["txt_name"]) || empty($_POST["txt_lname1"]) || empty($_POST["txt_lname2"]) || empty($_POST["txt_phone"]) || empty($_POST["cbx_type_user"]) || empty($_POST["txt_username"]) || empty($_POST["txt_pwd"])) {
            echo '<script>alert("AVISO: No se pueden validar campos vacíos");</script>';
            header("Location: ../View/index.php");
            exit();
        } else {
            // Intentar registrar el usuario
            if (UserLog()) {
                // Redireccionar si el registro fue exitoso
                header("Location: ../View/index.php");
                exit();
            } else {
                // Mostrar mensaje si hubo un error en el registro
                echo "<p>Registro de usuario fallido</p>";
            }
        }
    }
}

function UserLog(){
    global $con;

    // Sanitizar la entrada del usuario
    $nombre = $con->getConnection()->real_escape_string($_POST["txt_name"]);
    $apellido1 = $con->getConnection()->real_escape_string($_POST["txt_lname1"]);
    $apellido2 = $con->getConnection()->real_escape_string($_POST["txt_lname2"]);
    $telefono = $con->getConnection()->real_escape_string($_POST["txt_phone"]);
    $tipo_usuario = $con->getConnection()->real_escape_string($_POST["cbx_type_user"]);
    $username = $con->getConnection()->real_escape_string($_POST["txt_username"]);
    $contrasena = $con->getConnection()->real_escape_string($_POST["txt_pwd"]);

    // Consulta SQL para insertar usuario
    $sql = "INSERT INTO Usuarios (Nombre, ApellidoP, ApellidoM, Contacto, Tipo_Usuario, Username, Contrasena, Fecha_alta) 
            VALUES ('$nombre', '$apellido1', '$apellido2', '$telefono', '$tipo_usuario', '$username', '$contrasena', NOW())";

    // Ejecutar la consulta SQL
    if ($con->getConnection()->query($sql) === TRUE) {
        // Registro exitoso
        echo "Usuario registrado exitosamente";
        return true; // Devuelve true si el usuario se registró correctamente
    } else {
        // Error al registrar usuario
        echo "<script>alert('Atención usuario: Rellene los campos para continuar');</script>";
        return false; // Devuelve false si hubo un error al registrar el usuario
    }
}
?>
