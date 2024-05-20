<?php
require_once '../Controller/Ctl_Ventas.php';
$sales = new ControllerSales();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="../styles/Ventas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Ventas</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Ventas</a>
            <form class="d-flex text-center" role="search">
                <button class="botones" type="button" onclick="ReturnToPrincipal()">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <!--Botones CRUD-->
    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_venta"  data-bs-toggle="modal" data-bs-target="#modalRegistro">
                <i class="bi bi-bag-plus-fill"></i>
                <br>
                Agregar Venta
            </button>

            <button class="col btn btn-success b_venta">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Ventas
            </button>
            <div class="row">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <!--/*TODO Fix the search bar and the buttons*/---->
        </div>
    </div>

    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <th scope="col" class="text-center" style="width:100px; background-color:#c4f1fc">#</th>
                    <th scope="col" class="text-center encabezado">Fecha</th>
                    <th scope="col" class="text-center encabezado">Hora</th>
                    <th scope="col" class="text-center encabezado">Cantidad</th>
                    <th scope="col" class="text-center encabezado">Total</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $sales->getAllSales();
                    ?>
                </tbody>
            </table>
        </div>
        <div>
            <!--Modal para registro-->
            
        </div>
    </div>
    <script src="../js_personalizado/ReferencePage.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>