<?php
require_once '../Controller/Ctl_Pedidos.php';
$delv = new ControllerDelivery();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Pedidos</title>
</head>
<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Pedidos</a>
            <form class="d-flex text-center" role="search">
                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalOrden">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Ventas
            </button>

            <button class="col btn btn-success b_calc" data-bs-toggle="modal" data-bs-target="#modalCalc">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Ventas
            </button>

            <div class="row" style="position: absolute; top: 125px; left: 340px;">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="date" placeholder="Search" aria-label="Search" style="width:800px">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div> 
    </div>

    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <th scope="col" class="text-center" style="width:100px; background-color:#c4f1fc">#</th>
                    <th scope="col" class="text-center encabezado">Estado</th>
                    <th scope="col" class="text-center encabezado">Fecha</th>
                    <th scope="col" class="text-center encabezado">Hora</th>
                    <th scope="col" class="text-center encabezado">Cantidad</th>
                    <th scope="col" class="text-center encabezado">Monto</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $delv->getDeliveries();
                    ?>
                </tbody>
            </table>
        </div>
        <div>
            
        </div>
    </div>
</body>
</html>