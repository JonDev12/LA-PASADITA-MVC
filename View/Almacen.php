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
            <!--<div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalIng">
                <i class="bi bi-file-earmark-fill"></i>
                <br>
                Generar Reporte
            </button>
        </div>-->
            <!--<button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalIng">
            <i class="bi bi-calculator"></i>
            <br>
            Generar Reporte
        </button>-->
        </div>

        <!-- Modal Editar -->
        <div class="modal fade" id="modalAlmEd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-secondary">
                        <i class="bi bi-pencil-square" style="color:white; margin-right:10px; font-size:25px"></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Editar Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editItemForm" method="POST" action="../Model/Mdl_Almacen.php">
                            <input type="hidden" name="id" id="editItemId">
                            <div class="mb-3">
                                <label for="editDesc">Descripcion</label>
                                <input type="text" class="form-control" id="editDesc" name="descripcion">
                                <label for="editTotal">Total</label>
                                <input type="number" class="form-control" id="editTotal" name="total">
                                <label for="editDisp">Disponibles</label>
                                <input type="number" class="form-control" id="editDisp" name="disponibles">
                                <label for="editDef">Defectuosos</label>
                                <input type="number" class="form-control" id="editDef" name="defectuosos">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="edit_item">Editar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal fade" id="modalAlmDe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <i class="bi bi-trash-fill" style="color:white; margin-right:10px; font-size:25px"></i>
                        <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Eliminar Item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ¿Deseas Eliminar este item?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteItemForm" method="POST" action="../Model/Mdl_Almacen.php">
                            <input type="hidden" name="id" id="deleteItemId">
                            <button type="submit" class="btn btn-danger" name="delete_item">Eliminar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var editButtons = document.querySelectorAll('.edit-item-btn');
                editButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var id = button.getAttribute('data-id');
                        var descripcion = button.getAttribute('data-descripcion');
                        var total = button.getAttribute('data-total');
                        var disponibles = button.getAttribute('data-disponibles');
                        var defectuosos = button.getAttribute('data-defectuosos');

                        document.getElementById('editItemId').value = id;
                        document.getElementById('editDesc').value = descripcion;
                        document.getElementById('editTotal').value = total;
                        document.getElementById('editDisp').value = disponibles;
                        document.getElementById('editDef').value = defectuosos;
                    });
                });

                var deleteButtons = document.querySelectorAll('.delete-item-btn');
                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function() {
                        var id = button.getAttribute('data-id');
                        document.getElementById('deleteItemId').value = id;
                    });
                });
            });
        </script>

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