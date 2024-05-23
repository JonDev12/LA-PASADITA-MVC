<?php
require_once '../Controller/Ctl_Ordenes.php';
$ord = new ControllerOrders();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="../styles/Ordenes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Ordenes</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Ordenes</a>
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
                <i class="bi bi-plus-circle-fill"></i>                
                <br>
                Agregar Orden
            </button>

            <button class="col btn btn-success b_calc" data-bs-toggle="modal" data-bs-target="#modalCalc">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Ordenes
            </button>

            <div class="row" style="position: absolute; top: 125px; left: 340px;">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="date" placeholder="Search" aria-label="Search" style="width:800px">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>

        <div class="modal fade" id="modalOrden" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header bg-primary">
                        <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white" ></i>
                        
                        <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Registrar Orden</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Modal body content goes here -->
                        <form id="form-modal-NewOrder">
                            <div class="mb-3 ">
                                <label for="exampleInputPassword1" class="form-label">Estado de Orden</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>En espera</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Platillo</label>
                                <select class="form-select" aria-label="Default select example">
                                    //TODO Make this dynamic with php on Model and controller from Saurces class
                                    <option selected>Seleccionar</option>
                                    <?php
                                    echo $ord->getSaurces();
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="date">
                                <label for="exampleInputPassword1" class="form-label">Monto del platillo</label>
                                <input type="text" class="form-control" id="date"  placeholder="$00.00">
                            </div>
                            <button type="submit" class="btn btn-primary" id="">
                                Agregar
                                <i class="bi bi-arrow-right-circle-fill"></i>
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal footer content goes here -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalCalc" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistroLabel">Calcular Venta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Modal body content goes here -->
                        <form>
                            <div class="mb-3">
                                <label for="productName" class="form-label">Desde:</label>
                                <input type="date" class="form-control" id="countProdDate" required>
                                <label for="productName" class="form-label">Hasta:</label>
                                <input type="date" class="form-control" id="countProdDate2" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Calcular
                                <i class="bi bi-check-circle-fill"></i>
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- Modal footer content goes here -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
                        echo $ord->getOrders();
                        ?>
                    </tbody>c
                </table>
            </div>
            <div>
            </div>
        </div>
    </div>

    <script src="../js_personalizado/Orders.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>