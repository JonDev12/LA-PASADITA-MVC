<!DOCTYPE html>
<html lang="en">

<?php
require_once '../Controller/Ctl_Bebidas.php';
$beb = new ControllerBebidas();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Bebidas</title>
</head>

<body>
    <nav class="barra navbar">
        <div class="container-fluid ">
            <a class="navbar-brand ">Bebidas</a>
            <form class="d-flex text-center " role="search">
                <button class="botones " type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon "></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-primary b_add" data-bs-toggle="modal" data-bs-target="#modalBeb">
                <i class="bi bi-cup-straw"></i>
                <br>
                Agregar Bebidas
            </button>

            <button class="col btn btn-success b_calc" data-bs-toggle="modal" data-bs-target="#modalBebCalc">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Bebidas
            </button>
        </div>
    </div>

    <div class="modal fade" id="modalBebCalc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <i class="bi bi-calculator" style="color: white; margin-right:10px; font-size:25px"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Calcular Bebidas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <label for="date1">Desde:</label>
                        <input type="date" id="date1" class="form-control" name="date1">
                        <label for="date2">Hasta:</label>
                        <input type="date" id="date2" class="form-control" name="date2">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Calcular</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Agregar Bebida -->
    <div class="modal fade" id="modalBeb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary" style="color:white">
                    <i class="bi bi-cup-straw" style="font-size:25px; color:white; margin-right: 10px;"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Bebida</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="NewBeb" method="POST" action="../Modals/ModalBebidas.php">
                        <div class="mb-3">
                            <label for="desc" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="desc" name="desc">
                            <label for="cant" class="form-label">Cantidad en Mililitros</label>
                            <input type="text" class="form-control" id="cant" name="cant">
                            <label for="ingre" class="form-label">Cantidad de Ingreso</label>
                            <input type="number" class="form-control" id="ingre" name="ingre">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="precio" placeholder="00.00" name="price">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Agregar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar Bebida -->
    <div class="modal fade" id="modalEditBeb" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary">
                    <i class="bi bi-cup-straw" style="font-size:25px; color:white; margin-right: 10px;"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: white;">Editar Bebida</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBebidaForm" method="POST">
                        <input type="hidden" name="id" id="editBebidaId">
                        <div class="mb-3">
                            <label for="editDesc" class="form-label">Descripcion</label>
                            <input type="text" class="form-control" id="editDesc" name="descripcion">
                            <label for="editCantML" class="form-label">Cantidad en Mililitros</label>
                            <input type="text" class="form-control" id="editCantML" name="cantidad_ml">
                            <label for="editCant" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="editCant" name="cantidad">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input type="text" class="form-control" id="editPrecio" name="precio" placeholder="00.00">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" name="edit_bebida">Guardar Cambios</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar Bebida -->
    <div class="modal fade" id="modalDeBebDe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <i class="bi bi-trash-fill" style="font-size:25px; color:white; margin-right:10px"></i>
                    <h1 class="modal-title fs-5" id="exampleModalLabel" style="color:white">Eliminar Bebida</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar la Bebida?
                </div>
                <div class="modal-footer">
                    <form id="deleteBebidaForm" method="POST">
                        <input type="hidden" name="id" id="deleteBebidaId">
                        <button type="submit" class="btn btn-danger" name="delete_bebida">Eliminar Bebida</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editButtons = document.querySelectorAll('.edit-bebida-btn');
            editButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    var descripcion = button.getAttribute('data-descripcion');
                    var cantidad_ml = button.getAttribute('data-cantidad_ml');
                    var cantidad = button.getAttribute('data-cantidad');
                    var precio = button.getAttribute('data-precio');

                    document.getElementById('editBebidaId').value = id;
                    document.getElementById('editDesc').value = descripcion;
                    document.getElementById('editCantML').value = cantidad_ml;
                    document.getElementById('editCant').value = cantidad;
                    document.getElementById('editPrecio').value = precio;
                });
            });

            var deleteButtons = document.querySelectorAll('.delete-bebida-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var id = button.getAttribute('data-id');
                    document.getElementById('deleteBebidaId').value = id;
                });
            });
        });
    </script>


    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-bebidas">
                <thead>
                    <th scope="col" class="text-center encabezado">#</th>
                    <th scope="col" class="text-center encabezado">Descripcion</th>
                    <th scope="col" class="text-center encabezado">Cantidad_ML</th>
                    <th scope="col" class="text-center encabezado">Cantidad</th>
                    <th scope="col" class="text-center encabezado">Precio</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $beb->ShowData();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div align="center">
        <a href="../fpdf/ReporteBebidas.php" target="_blank">Obtener Reporte</a>
    </div>

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js_personalizado/ReferencePage.js"></script>
</body>

</html>