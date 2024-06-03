<?php
require_once '../Model/Menu_Load.php';
$s = new Menu();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Menu Principal</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Menu Principal</a>
            <form class="d-flex text-center" role="search">
                <div class="dropdown">
                    <button class="dropdown-toggle botones" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear-wide"></i>
                    </button>
                    <ul class="dropdown-menu " style="background-color: #c4f1fc;">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configuracion</a></li>
                        <li><a class="dropdown-item" href="#">Respaldo de BD</a></li>
                        <li><a class="dropdown-item" href="#" onclick="redireccion_IniciarSesion()">Salir</a></li>
                    </ul>
                </div>
                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-menu-button-wide t_icon"></i>
                </button>
            </form>
        </div>
    </nav>
    <div>
        <h1 class="text-center" style="font-size: 25px; margin-top: 21px;">Hola, Bienvenido</h1>
        <img src="../images/acceso.png" style="width: 100px;position: fixed;left: 47%;">
    </div>

    <div class="modal fade" id="ModalUsUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="color: white; margin-right:10px; font-size:25px"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Editar Informacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <form action="">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <label for="lastname">Apellido</label>
                            <input type="text" name="lastname" id="lastname" class="form-control">
                            <label for="lastname2">Apellido</label>
                            <input type="text" name="lastname2" id="lastname2" class="form-control">
                            <label for="cargo">Cargo</label>
                            <select name="cargo" id="cargo" class="form-control">
                                <option>Administrador</option>
                                <option selected>Empleado</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Editar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUsDe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <i class="bi bi-trash" style="color: white; margin-right:10px; font-size:25px"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Elimnar Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estas seguro de eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="contenedor" style="margin-top: 190px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1">
                <thead>
                    <th scope="col" class="text-center" style="width:100px; background-color:#c4f1fc">#</th>
                    <th scope="col" class="text-center encabezado">Nombre</th>
                    <th scope="col" class="text-center encabezado">Apellido</th>
                    <th scope="col" class="text-center encabezado">Apellido</th>
                    <th scope="col" class="text-center encabezado">Cargo</th>
                    <th scope="col" class="text-center encabezado">Registro</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $s->GetUsers();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header" style="background-color: #c4f1fc;">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu de Opciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group" style="margin-top: 100px; height: auto; left:auto" id="controles">
                <button class="botones-offcanvas" id="Ordenes">
                    <img src="../images/orden.png" class="iconos3">
                    <span class="titulos">Ordenes</span>
                </button>
                <button class="botones-offcanvas" id="Pedidos">
                    <img src="../images/pedidos.png" class="iconos" alt="">
                    <span class="titulos">Pedidos</span>
                </button>
                <button class="botones-offcanvas" id="Ventas">
                    <img src="../images/metodo-de-pago.png" class="iconos" alt="">
                    <span class="titulos">Ventas</span>
                </button>
                <button class="botones-offcanvas" id="Ingredientes">
                    <img src="../images/ingredientes.png" class="iconos2" alt="">
                    <span class="titulos">Ingredientes</span>
                </button>
                <button class="botones-offcanvas" id="Platillos">
                    <img src="../images/pierna-de-pollo.png" class="iconos" alt="">
                    <span class="titulos">Platillos</span>
                </button>
                <button class="botones-offcanvas" id="Bebidas">
                    <img src="../images/bebidas.png" class="iconos" alt="">
                    <span class="titulos">Bebidas</span>
                </button>
                <button class="botones-offcanvas" id="Categorias">
                    <img src="../images/categoria.png" class="iconos3" alt="">
                    <span class="titulos">Categorias</span>
                </button>
                <button class="botones-offcanvas" id="Almacen">
                    <img src="../images/almacen.png" class="iconos" alt="">
                    <span class="titulos">Almacen</span>
                </button>
                <button class="botones-offcanvas dropdown-menu" id="Mas">
                    <img src="../images/almacen.png" class="iconos" alt="">
                    <span class="titulos">Mas</span>
                </button>
            </ul>
        </div>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js_personalizado/Pagesredirect.js"></script>
    <script src="../js_personalizado/ReferencePage.js"></script>
</body>

</html>