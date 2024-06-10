<!DOCTYPE html>
<html lang="en">
<?php
require_once '../Controller/Ctl_Bitacora.php';
$bit = new ControllerBitacora();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/estilos_menu.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>

<body>
<nav class="barra navbar">
        <div class="container-fluid ">
            <a class="navbar-brand ">Bitacora</a>
            <form class="d-flex text-center " role="search">
                <button class="botones " type="button" onclick="ReturnToPrincipal()" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon "></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="contenedor" style="margin-top: 70px;">
        <div style="height: 500px; overflow-y: auto;">
            <table border="1"  id="table-bitacora">
                <thead>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center encabezado">Responsable</th>
                    <th scope="col" class="text-center encabezado">Operacion</th>
                    <th scope="col" class="text-center encabezado">TablaObjetivo</th>
                    <th scope="col" class="text-center encabezado">Atributo</th>
                    <th scope="col" class="text-center encabezado">ValorAnterior</th>
                    <th scope="col" class="text-center encabezado">ValorNuevo</th>
                    <th scope="col" class="text-center encabezado">FechaMovimiento</th>
                </thead>
                <tbody>
                    <?php
                    echo $bit->ShowData();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>