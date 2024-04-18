<?php

// Incluye el archivo de conexión a la base de datos
require_once '../Model/Connection.php';

// Instancia de la clase Connection
$con = new Connection();

// Verifica si se ha enviado la solicitud POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar la entrada del usuario
    $usuario = filter_input(INPUT_POST, 'txt_usuario', FILTER_SANITIZE_STRING);
    $contrasena = filter_input(INPUT_POST, 'txt_password', FILTER_SANITIZE_STRING);

    // Verificar si los datos de usuario y contraseña están presentes
    if (!$usuario || !$contrasena) {
        echo "<p>Por favor, ingrese tanto el nombre de usuario como la contraseña.</p>";
        return false;
    }

    // Preparar la consulta
    $consulta = $con->getConnection()->prepare("SELECT * FROM Usuarios WHERE Username = ? AND Contrasena = ?");

    // Verificar si la preparación de la consulta fue exitosa
    if (!$consulta) {
        echo "Error en la preparación de la consulta: " . $con->getConnection()->error;
        return false;
    }

    // Ejecutar la consulta
    $consulta->bind_param('ss', $usuario, $contrasena);
    $consulta->execute();

    // Obtener el resultado
    $resultado = $consulta->get_result();

    // Verificar si se encontró un registro
    if ($resultado->num_rows == 1) {
        // Usuario y contraseña válidos
        header('Location: ../View/MenuPrincipal.php');
        exit; // Asegura que el script se detenga inmediatamente después de la redirección
    } else {
        // Usuario o contraseña incorrectos
        echo "<p>Usuario o contraseña incorrectos</p>";
        return false; // Devuelve false si la sesión no se inició correctamente
    }
    // Cerrar la consulta
    $consulta->close();
} else {
    // Si no se envió la solicitud POST
    echo '<script>alert("ATENCION: No se pueden validar campos vacios ");</script>';
    return false;
}
