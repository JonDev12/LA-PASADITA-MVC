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
        <form class="form-box" action="../Controller/RegisterUser.php" method="POST">
            <div>
                <h1 class="etiquetas">REGISTRARSE</h1>
                <h1 class="etiquetas">Foto(Opcional)</h1>
                <img src="../images/acceso.png" alt="" class="logo-user" onclick="">
            </div>
            <div class="div1 row">
                <div class="col-md-4 text-center">
                    <label for="inputEmail4" class="form-label controls">Nombre</label>
                    <input type="text" class="controls" id="inputname" style="background-color: #DEEBF7;" name="txt_name">
                </div>
                <div class="col-md-4 text-center">
                    <label for="inputEmail4" class="form-label controls">Apellido Materno</label>
                    <input type="text" class="controls" id="inputname" style="background-color: #DEEBF7;" name="txt_lname1">
                </div>
                <div class="col-md-4 text-center">
                    <label for="inputEmail4" class="form-label controls">Apellido Paterno</label>
                    <input type="text" class="controls" id="inputname" style="background-color: #DEEBF7;" name="txt_lname2">
                </div>
            </div>
            <div class="div1 row-md-7">
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label text-center" style="margin-left: 2.5rem;">Telefono de Contacto</label>
                    <input type="tel" class="controls2" id="inputPhone" style="margin-left: 1rem; width:500ox" name="txt_phone">
                </div>
            </div>
            <div class="div1 row-md-7">
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label text-center" style="margin-left: 2.5rem;">Tipo de Usuario</label>
                    <<select id="inputUser" class="controls2" style="margin-left: 1rem;" name="cbx_type_user">
                        <option selected>.......</option>
                        <option>Empleado</option>
                        <option>Administrador</option>
                    </select>
                </div>
            </div>
            <div class="div1 row-md-7">
                <div class="col-md-6">
                    <label for="inputPassword4" class="form-label text-center" style="margin-left: 2.5rem;">Nombre de Usuario</label>
                    <input type="text" class="controls2" id="inputUsername" style="margin-left: 1rem; width:500ox" name="txt_username">
                </div>
            </div>
            <div class="div1 row-md-7">
                <div class="col-md-6">
                    <label for="inputPassword" class="form-label text-center" style="margin-left: 2.5rem;">Password</label>
                    <input type="password" class="controls2" id="inputpassword" style="margin-left: 1rem; width:500ox" name="txt_pwd">
                </div>
            </div>
            <div class="text-center" style="margin: 1.5rem">
                <button class="btn btn-primary" type="submit" value="Send">Enviar Datos</button>
            </div>
        </form>
    </div>
</body>

</html>