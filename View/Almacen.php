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
    <nav class="barra navbar" >
        <div class="container-fluid ">
            <a class="navbar-brand ">Almacen</a>
            <form class="d-flex text-center " role="search">
                <button class="botones " type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon "></i>
                </button>
            </form>
        </div>
    </nav>


    <div class="contenedor" style="margin-top: 150px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1" id="table-almacen">
                <thead>
                    <th scope="col" class="text-center encabezado">#</th>
                    <th scope="col" class="text-center encabezado">Descripcion</th>
                    <th scope="col" class="text-center encabezado">Total</th>
                    <th scope="col" class="text-center encabezado">Disponibles</th>
                    <th scope="col" class="text-center encabezado">Defectuosos</th>
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