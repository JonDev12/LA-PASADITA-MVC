<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/estilos_registro.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Registro de Usuarios</title>
</head>

<body>
    <div class="form">
        <form class="form-box" action="../Controller/Ctl_RegisterUser.php" method="POST" id="Registro">
            <div>
                <h1 class="etiquetas">REGISTRARSE</h1>
                <h1 class="etiquetas">Foto (Opcional)</h1>
                <img src="../images/acceso.png" alt="User logo" class="logo-user">
            </div>
            <div class="div1 row">
                <div class="col-md-4 text-center">
                    <label for="inputName" class="form-label controls">Nombre</label>
                    <input type="text" class="controls" id="inputName" style="background-color: #DEEBF7;" name="txt_name" autocomplete="given-name">
                </div>
                <div class="col-md-4 text-center">
                    <label for="inputLname1" class="form-label controls">Apellido Materno</label>
                    <input type="text" class="controls" id="inputLname1" style="background-color: #DEEBF7;" name="txt_lname1" autocomplete="additional-name">
                </div>
                <div class="col-md-4 text-center">
                    <label for="inputLname2" class="form-label controls">Apellido Paterno</label>
                    <input type="text" class="controls" id="inputLname2" style="background-color: #DEEBF7;" name="txt_lname2" autocomplete="family-name">
                </div>
            </div>
            <div class="div1 row">
                <div class="col-md-6">
                    <label for="inputPhone" class="form-label text-center" style="margin-left: 2.5rem;">Teléfono de Contacto</label>
                    <input type="tel" class="controls2" id="inputPhone" style="margin-left: 1rem; width: calc(100% - 2rem);" name="txt_phone" autocomplete="tel">
                </div>
            </div>
            <div class="div1 row">
                <div class="col-md-6">
                    <label for="inputUserType" class="form-label text-center" style="margin-left: 2.5rem;">Tipo de Usuario</label>
                    <select id="inputUserType" class="controls2" style="margin-left: 1rem; width: calc(100% - 2rem);" name="cbx_type_user">
                        <option selected>.......</option>
                        <option>Empleado</option>
                        <option>Administrador</option>
                    </select>
                </div>
            </div>
            <div class="div1 row">
                <div class="col-md-6">
                    <label for="inputUsername" class="form-label text-center" style="margin-left: 2.5rem;">Nombre de Usuario</label>
                    <input type="text" class="controls2" id="inputUsername" style="margin-left: 1rem; width: calc(100% - 2rem);" name="txt_username" autocomplete="username">
                </div>
            </div>
            <div class="div1 row">
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label text-center" style="margin-left: 2.5rem;">Contraseña</label>
                    <input type="password" class="controls2" id="inputPassword" style="margin-left: 1rem; width: calc(100% - 2rem);" name="txt_pwd" autocomplete="new-password">
                </div>
            </div>
            <div class="text-center" style="margin: 1.5rem">
                <button class="btn btn-primary" type="submit" onclick="ValidateUserEntry()">Enviar Datos</button>
            </div>
        </form>
    </div>
    <script src="../js_personalizado/UserValidation.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
