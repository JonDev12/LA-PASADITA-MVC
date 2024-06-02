<?php
require_once '../Controller/Ctl_Ventas.php';
require_once '../Model/Mdl_Ventas.php'; // Incluir el archivo que contiene la clase ModelSales
$sales = new ControllerSales();
// Instanciar la clase ModelSales
$modelSales = new ModelSales(new Connection());

// Llamar al método generatePDFReport() cuando se hace clic en el botón "Obtener Reporte"
if(isset($_POST['obtener_reporte'])) {
    $modelSales->generatePDFReport();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="../styles/Ventas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Ventas</title>
</head>

<body>
    <nav class="barra navbar" style="width: 1366px;">
        <div class="container-fluid">
            <a class="navbar-brand">Ventas</a>
            <form class="d-flex text-center" role="search">
                <button class="botones" type="button" onclick="ReturnToPrincipal()">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>

    <!--Botones CRUD-->
    <div class="col" style="margin-left: 50px; margin-top:50px">
        <div>
            <button class="col btn btn-success b_venta" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                <i class="bi bi-calculator"></i>
                <br>
                Calcular Ventas
            </button>
            <button class="col btn btn-success b_venta" data-bs-target="#modalRegistro" name="obtener_reporte">
                <br>
                Obtener Reporte
            </button>

            <div class="row" style="position: absolute; top: 125px; left: 340px;">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="date" placeholder="Search" aria-label="Search" style="width:800px">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRegistroLabel">Registrar Venta</h5>
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
                        <button type="submit" class="btn btn-primary">CalcularV</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Modal footer content goes here -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
            d
        </div>
        <div>
        </div>
    </div>

    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-categories">
                <thead>
                    <th scope="col" class="text-center" style="width:100px; background-color:#c4f1fc">#</th>
                    <th scope="col" class="text-center encabezado">Fecha</th>
                    <th scope="col" class="text-center encabezado">Hora</th>
                    <th scope="col" class="text-center encabezado">Cantidad</th>
                    <th scope="col" class="text-center encabezado">Total</th>
                    <th scope="col" class="text-center encabezado">Acciones</th>
                </thead>
                <tbody>
                    <?php
                    echo $sales->getAllSales();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div  align="center" ><a  href= "../fpdf/ReporteVentas.php" target = "_blank">Obtener Reporte</div>

    <script src="../js_personalizado/ReferencePage.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="reportes.js"></script>
</body>

</html>