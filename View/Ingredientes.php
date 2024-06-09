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
                
                <button class="botones" type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
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
                    <form id="NewOrder" method="POST" action="../Modals/ModalIngredients.php">
                        <div class="mb-3">
                            <label for="Desc" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="Desc" name="Desc">
                        </div>
                        <div class="mb-3">
                            <label for="ammount" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="ammount" name="ammount">
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Unidad de Medida</label>
                            <select name="quantity" class="form-control" id="quantity">
                                <?php echo $ing->ShowUnit(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
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

    <!-- Modal editar -->
    <div class="modal fade" id="modalIngEd" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-secondary">
                    <i class="bi bi-pencil-square" style="font-size: 25px; color:white"></i>
                    <h5 class="modal-title text-center" style="color:white; margin-left:10px" id="modalRegistroLabel">Editar Ingrediente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-modal-Ingrediente-edit" method="POST" >
                    <input type="hidden" name="id" id="editIngredienteId">
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="editDescripcion" name="descripcion">
                        </div>
                        <div class="mb-3">
                            <label for="editCantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="editCantidad" name="cantidad">
                        </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="edit_Ingrediente">Editar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Modal eliminar -->
    <div class="modal fade" id="modalIngDe" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
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
                <form id="deleteIngredienteForm" method="POST" >
                <input type="hidden" name="id" id="deleteIngredienteId">
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal" name = "delete_Ingrediente">Eliminar</button>
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
                document.getElementById('deleteIngredienteId').value = id;
            });
        });
    });
</script>

    <div class="contenedor" style="margin-top: 70px;">
        <div style="height: 400px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <tr>
                        <th scope="col" class="text-center encabezado">Id</th>
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

    <div align="center">
        <a href="../fpdf/ReporteIngredientes.php" target="_blank">Obtener Reporte</a>
    </div>



    <script src="../js/botstrap.min.js"></script>
    <script src="../js_personalizado/ReferencePage.js"></script>
</body>

</html>