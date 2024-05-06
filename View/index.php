<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/estilos_login.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Inicio de Sesion</title>
</head>

<body style="background-image: url(../images/background-lp.jpg); background-size:cover; ">
    <div class="form">
        <form class="form-box" action="../Controller/Sesion.php" method="POST">
            <h1 class="text-sesion p-4">Iniciar Sesion</h1>
            <div class="text-center">
                <label for="username" class="form-label ">Nombre de Usuario</label>
                <input type="text" placeholder="usuario123" class="entradas" name="txt_usuario">
                <label for="username" class="form-label ">Contraseña</label>
                <input type="password" placeholder="*******" class="entradas" name="txt_password">
            </div>
            <div class="text-center p-3">
                <button class="btn btn-primary" type="submit" value="Send">Inicar Sesion</button>
                <!-- Agrega un evento onclick para redirigir a la página de registro -->
                <button class="btn btn-primary" type="button" onclick="redireccion_menu()">Registrarse</button>
            </div>
        </form>
    </div>
    <!-- Incluye tu archivo JavaScript personalizado -->
    <script src="../js_personalizado/redireccion.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
hola
</html>
