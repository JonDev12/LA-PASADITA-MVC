<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Categorias</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Categorias</a>
            <form class="d-flex text-center" role="search">
                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-menu-button-wide t_icon"></i>
                </button>
            </form>
        </div>
    </nav>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header" style="background-color: #c4f1fc;">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Menu de Opciones</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group" style="margin-top: 100px; height: auto; left:auto">
                <button class="botones-offcanvas">
                    <img src="../images/orden.png" class="iconos3">
                    <span class="titulos">Ordenes</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/pedidos.png" class="iconos" alt="">
                    <span class="titulos">Peidios</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/metodo-de-pago.png" class="iconos" alt="">
                    <span class="titulos">Ventas</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/ingredientes.png" class="iconos2" alt="">
                    <span class="titulos">Ingredientes</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/pierna-de-pollo.png" class="iconos" alt="">
                    <span class="titulos">Platillos</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/bebidas.png" class="iconos" alt="">
                    <span class="titulos">Bebidas</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/categoria.png" class="iconos3" alt="">
                    <span class="titulos">Categorias</span>
                </button>
                <button class="botones-offcanvas">
                    <img src="../images/almacen.png" class="iconos" alt="">
                    <span class="titulos">Almacen</span>
                </button>
            </ul>
        </div>
    </div>
    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1">
                <thead>
                    <th scope="col" class="text-center" style="width:100px; background-color:#c4f1fc">#</th>
                    <th scope="col" class="text-center encabezado">Descripcion</th>
                    <th scope="col" class="text-center encabezado">Creado</th>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        <div>
            
        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>