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
                Agregar Categoria
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
                    <form id="new_cat" method="POST" action="../Modals/ModalCategories.php">
                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion">
                        </div>
                        <button type="subnit" class="btn btn-primary">
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
    <!-- Modal Editar -->
    <div class="modal fade" id="ModalCatUp" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Editar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" method="POST">
                        <input type="hidden" name="id" id="editCategoryId">
                        <div class="mb-3">
                            <label for="txtDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="editDescripcion" name="descripcion">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="edit_category">Editar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div class="modal fade" id="ModalCatDe" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <i class="bi bi-trash" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Eliminar Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Deseas eliminar esta categoria?
                </div>
                <div class="modal-footer">
                    <form id="deleteCategoryForm" method="POST">
                        <input type="hidden" name="id" id="deleteCategoryId">
                        <button type="submit" class="btn btn-danger" name="delete_category">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    var descripcion = button.getAttribute('data-descripcion');

                    document.getElementById('editCategoryId').value = id;
                    document.getElementById('editDescripcion').value = descripcion;
                });
            });

            var deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    document.getElementById('deleteCategoryId').value = id;
                });
            });
        });
    </script>


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