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
                <button class="botones" type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalPedidosAdd">
                <i class="bi bi-cart-plus-fill"></i>
                <br>
                Añadir Pedido
            </button>

            <button class="col btn btn-success b_calc" data-bs-toggle="modal" data-bs-target="#modalCalc">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Pedidos
            </button>

            <div class="row" style="position: absolute; top: 125px; left: 340px;">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="date" placeholder="Search" aria-label="Search" style="width:800px">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPedidosAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <i class="bi bi-cart-plus-fill" style="font-size: 25px; margin-right:10px; color:white"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color:white">Agregar Pedidos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="state" class="form-label">Estado de Orden</label>
                            <select class="form-select" name="state" id="state" aria-label="Default select example">
                                <option selected>En espera</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cbx_dish" class="form-label">Platillo</label>
                            <select class="form-select" name="cbx_dish" id="cbx_dish" aria-label="Default select example">
                                <option selected>Seleccionar</option>
                                <?php echo $delv->getSaurces() ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txt_quantity" class="form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="txt_quantity" name="txt_quantity">
                            <label for="txt_ammount" class="form-label">Precio:</label>
                            <input type="text" class="form-control" id="txt_ammount" name="txt_ammount" placeholder="$00.00">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="ValidateOrder()">
                            Agregar
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPedidosEd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="font-size: 25px; margin-right:10px; color:white"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color:white">Editar Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="state" class="form-label">Estado de Orden</label>
                            <select class="form-select" name="state" id="state" aria-label="Default select example">
                                <option selected>En espera</option>
                                <option>En proceso</option>
                                <option>Entregado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cbx_dish" class="form-label">Platillo</label>
                            <select class="form-select" name="cbx_dish" id="cbx_dish" aria-label="Default select example">
                                <option selected>Seleccionar</option>
                                <?php echo $delv->getSaurces() ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="txt_quantity" class="form-label">Cantidad:</label>
                            <input type="number" class="form-control" id="txt_quantity" name="txt_quantity">
                            <label for="txt_ammount" class="form-label">Precio:</label>
                            <input type="text" class="form-control" id="txt_ammount" name="txt_ammount" placeholder="$00.00">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="ValidateOrder()">
                            Agregar
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPedidosDe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <i class="bi bi-trash-fill" style="font-size: 25px; margin-right:10px; color:white"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color:white">Elimanr Pedido</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el pedido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCalc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <i class="bi bi-calculator" style="color: white; font-size: 25px; margin-right:10px"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Calcular Pedidos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="datetime1" class="form-label">Desde:</label>
                            <input type="date" class="form-control" id="datetime1" name="datetime1">
                            <label for="datetime2" class="form-label">Hasta:</label>
                            <input type="date" class="form-control" id="datetime2" name="datetime2">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Calcular</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                    echo $delv->getDeliveries();
                    ?>
                </tbody>
            </table>
        </div>
        <div>

        </div>
    </div>

    <script src="../js_personalizado/ReferencePage.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>