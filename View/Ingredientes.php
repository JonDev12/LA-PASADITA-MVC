<?php
require_once '../Controller/Ctl_Ingredientes.php';
$ing = new ControllerIngredients();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Ingredientes</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Ingredientes</a>
            <form class="d-flex text-center" role="search">

                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalIng">
                <i class="bi bi-plus-square-fill"></i>
                <br>
                Agregar Ingrediente
            </button>
        </div>
    </div>



    <div class="modal fade" id="modalIng" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Registrar Ingrediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="">
                        <div class="mb-3">
                            <label for="Desc" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="Desc">
                        </div>
                        <div class="mb-3">
                            <label for="ammount" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="ammount">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Unidad de Medida</label>
                            <select name="quantity" class="form-control" id="quantity">
                                <?php echo $ing->ShowUnit(); ?>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="ValidateOrder()">
                            Agregar
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

    <div class="modal fade" id="ModalIngEd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Editar Ingrediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_edit_ing" method="POST">
                        <div class="mb-3">
                            <label for="desc">Descripcion</label>
                            <input type="text" class="form-control" id="desc">
                            <label for="ammount" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="ammount">
                            <label for="Med">Unidad de Medida</label>
                            <select name="Med" class="form-control" id="Med">
                                <?php echo $ing->ShowUnit(); ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalIngDe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-danger">
                    <i class="bi bi-trash3-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Elimnar Ingrediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form_delete_ing" method="POST">
                        ¿Deseas eliminar el ingrediente?
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Eliminar ingrediente</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="contenedor" style="margin-top: 70px;">
        <div style="height: 400px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <tr>
                        <th scope="col" class="text-center encabezado">Descripcion</th>
                        <th scope="col" class="text-center encabezado">Cantidad</th>
                        <th scope="col" class="text-center encabezado">Unidad Medida</th>
                        <th scope="col" class="text-center encabezado">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $ing->ShowData(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="../js/bootstrap.min.js"></script>
</body>

</html>