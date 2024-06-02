<!DOCTYPE html>
<html lang="en">

<?php
require_once '../Controller/Ctl_Almacen.php';
$alm = new ControllerAlmacen();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Almacen</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid ">
            <a class="navbar-brand ">Almacen</a>
            <form class="d-flex text-center " role="search">
                <button class="botones " type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon "></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#ModalBebIn">
                <i class="bi bi-plus-circle-fill"></i>
                <br>
                Agregar 
            </button>
        </div>
    </div>

    <div class="modal fade" id="ModalBebIn" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Nuevo item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="">
                        <div class="mb-3">
                            <label for="Desc">Descripcion</label>
                            <input type="text" class="form-control" id="Desc" name="Desc">
                            <label for="Total">Total</label>
                            <input type="number" class="form-control" id="Total" name="Total">
                            <label for="Disp">Disponibles</label>
                            <input type="number" class="form-control" id="Disp" name="Disp">
                            <label for="Def">Defectuosos</label>
                            <input type="number" class="form-control" id="Def" name="Def">
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
    <!--Editar-->
    <div class="modal fade" id="ModalBebEd" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST">
                        <div class="mb-3">
                            <label for="desc">Descripcion</label>
                            <input type="text" class="form-control" id="desc" name="desc">
                            <label for="total">Total</label>
                            <input type="number" class="form-control" id="total" name="total">
                            <label for="disp">Disponibles</label>
                            <input type="number" class="form-control" id="disp" name="disp">
                            <label for="def">Defectuosos</label>
                            <input type="number" class="form-control" id="def" name="def">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Editar
                            <i class="bi bi-arrow-right-circle-fill"></i>
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Eiminar-->
    <div class="modal fade" id="ModalBebDe" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <i class="bi bi-trash3-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Elimnar </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="../Modals/ModalOrder.php" onsubmit="return ValidateOrder()">
                        ¿Deseas eliminar este item?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar item</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="contenedor" style="margin-top: 30px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-almacen">
                <thead>
                    <th scope="col" class="text-center encabezado">#</th>
                    <th scope="col" class="text-center encabezado">Descripcion</th>
                    <th scope="col" class="text-center encabezado">Total</th>
                    <th scope="col" class="text-center encabezado">Disponibles</th>
                    <th scope="col" class="text-center encabezado">Defectuosos</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $alm->ShowData();
                    ?>
                </tbody>
            </table>
        </div>
        <div>

        </div>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js_personalizado/ReferencePage.js"></script>
</body>

</html>