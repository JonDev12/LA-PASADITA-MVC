<!DOCTYPE html>
<html lang="en">

<?php
require_once '../Controller/Ctl_Categories.php';
$cat = new ControllerCategories();
?>

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
                <button class="botones" type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#ModalCat">
                <i class="bi bi-plus-circle-fill"></i>
                <br>
                Agregar Orden
            </button>
        </div>
    </div>

    <div class="modal fade" id="ModalCat" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Nueva Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="">
                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion">
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
    <div class="modal fade" id="ModalCatEd" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Nueva Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="">
                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion">
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
<!--Eiminar-->
    <div class="modal fade" id="ModalCatDe" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary">
                    <i class="bi bi-plus-circle-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Nueva Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-NewOrder" method="POST" action="">
                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion">
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

    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <th scope="col" class="text-center encabezado">#</th>
                    <th scope="col" class="text-center encabezado">Descripcion</th>
                    <th scope="col" class="text-center encabezado">Creado</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $cat->ShowData();
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