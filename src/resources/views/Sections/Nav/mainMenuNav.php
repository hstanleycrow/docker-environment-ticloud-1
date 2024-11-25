<?php

use App\Core\Route;

$usersURL = Route::getUrlFromName('usersList');
/* $branchesURL = Route::getUrlFromName('branchesList');
$categoriesURL = Route::getUrlFromName('categoriesList');
$productsURL = Route::getUrlFromName('productsList');
$saucesURL = Route::getUrlFromName('saucesList');
$extrasURL = Route::getUrlFromName('extrasList');
$salesPerBranchURL = Route::getUrlFromName('salesPerBranchForm');
$dailySalesPerBranchDetailedURL = Route::getUrlFromName('dailySalesPerBranchDetailedForm');
$ordersURL = Route::getUrlFromName('OrdersList');
$orderStatusURL = Route::getUrlFromName('orderStatusList');
$customersURL = Route::getUrlFromName('customersList'); */

?>
<nav class="navbar fixed-top navbar-expand-md mb-5 bg-white text-dark">
    <div class=" container-fluid">
        <a class="navbar-brand" href="/"><img class="img-responsive " src="/assets/images/logo-ticloud-azul-y-gris-2048x731.png" alt="<?= BUSINESS_NAME; ?>" width="130" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <? if (isLogged()) : ?>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sistema
                        </a>
                        <ul class="dropdown-menu bg-white">
                            <li><a class="nav-link text-dark active" aria-current="page" href="<?= $usersURL; ?>">Usuarios</a></li>
                            <li><a class="nav-link text-dark active" aria-current="page" href="<? #= $branchesURL; 
                                                                                                ?>">Sucursales</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $categoriesURL; 
                                                                    ?>">Categorias de productos</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $productsURL; 
                                                                    ?>">Productos</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $saucesURL; 
                                                                    ?>">Salsas</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $extrasURL; 
                                                                    ?>">Extras</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $orderStatusURL; 
                                                                    ?>">Estados Ordenes</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $customersURL; 
                                                                    ?>">Clientes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link text-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Reportes
                        </a>
                        <ul class="dropdown-menu bg-white">
                            <li><a class="nav-link text-dark active" aria-current="page" href="<? #= $salesPerBranchURL; 
                                                                                                ?>">Ventas por sucursal</a></li>
                            <li><a class="nav-link text-dark" href="<? #= $dailySalesPerBranchDetailedURL; 
                                                                    ?>">Ventas por Sucursal detallado</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                    <li><a class="nav-link text-dark" href="<? #= $ordersURL; 
                                                            ?>">Registrar Ventas</a></li>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="nav-link text-dark" href="/close">Cerrar sesión</a></li>
            </ul>
        <? endif; ?>
    </div>
</nav>
<div class="clearfix"></div>