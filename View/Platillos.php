<!DOCTYPE html>
<html lang="en">

<?php
require_once '../Controller/Ctl_Platillos.php';
$platillos = new ControllerSaurces();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Platillos</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid">
            <a class="navbar-brand">Platillos</a>
            <form class="d-flex text-center" role="search">
                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions" onclick="ReturnToPrincipal()">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>
    <br>
    <h1 class="text-center" style="font-size: 30px">Nuestros Platillos</h1>


    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#ModalPl">
                <i class="bi bi-bag-plus-fill"></i>
                <br>
                Agregar Platillo
            </button>
        </div>
    </div>

    <div class="modal fade" id="ModalPl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Agregar Platillo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../Modals/ModalPlatillos.php" method="POST">
                        <label for="descr">Descripcion</label>
                        <input type="text" name="descr" id="descr" class="form-control">
                        <label for="cat">Categoria del platillo</label>
                        <select name="cat" id="cat" class="form-control">
                            <?php
                            echo $platillos->getAllCategories();
                            ?>
                        </select>
                        <!-- Mover el botón dentro del formulario -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalPlaEd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Editar Platillo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../Modals/ModalPlatillos.php" method="POST">
                        <label for="descr">Descripcion</label>
                        <input type="text" name="descr" id="descr" class="form-control">
                        <label for="cat">Categoria del platillo</label>
                        <select name="cat" id="cat" class="form-control">
                            <?php
                            echo $platillos->getAllCategories();
                            ?>
                        </select>
                        <!-- Mover el botón dentro del formulario -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar -->
    <div class="modal fade" id="ModalPlaDe" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <i class="bi bi-trash-fill" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Eliminar Ingrediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea elimnar este Ingrediente?
                </div>
                <div class="modal-footer">
                    <form id="deletePlatilloForm" method="POST">
                        <input type="hidden" name="id" id="deletePlatilloId">
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name="delete_Platillo">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--Lista de Platillos-->

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
                    echo $platillos->getAllSaurcesList();
                    ?>
                </tbody>
            </table>
        </div>
        <div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    var descripcion = button.getAttribute('data-descripcion');
                    var cantidad = button.getAttribute('data-cantidad');

                    document.getElementById('editIngredienteId').value = id;
                    document.getElementById('editDescripcion').value = descripcion;
                    document.getElementById('editCantidad').value = cantidad;
                });
            });

            var deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    document.getElementById('deletePlatilloId').value = id;
                });
            });
        });
    </script>

    <script src="../js_personalizado/ReferencePage.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>