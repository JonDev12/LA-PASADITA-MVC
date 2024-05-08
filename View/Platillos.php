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
                <button class="botones" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="bi bi-arrow-return-left t_icon"></i>
                </button>
            </form>
        </div>
    </nav>
    <br>
    <h1 class="text-center" style="font-size: 30px">Nuestros Platillos</h1>
    <!--Carrusel de bebidas-->
    <div>
        <?php
        $platillos->getAllSaurcesList();
        ?>
    </div>
</body>
</html>