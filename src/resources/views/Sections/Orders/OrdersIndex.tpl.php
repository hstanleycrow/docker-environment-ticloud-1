<?php

use App\Core\Route;
use App\Core\FlashMessages;

$this->layout(
    'Layouts/transaction',
    [
        'closeRoute' => $closeRoute,
        "branchName" => $branchName,
        "h1" => $h1,
        "paymentMethods" => $paymentMethods,
        "title" => $title,
        "useDataTablesResources" => false,
        "userName" => $userName,
    ]
);
$category_id = 1;
FlashMessages::display();

?>
<div class="row">
    <div class="col-3">
        <div class="row">
            <div class="col-5 d-flex">
                <img class="img-responsive" src="/assets/images/logo-ticloud-azul-y-gris-2048x731.png" alt="<?= BUSINESS_NAME; ?>" width="150" />
            </div>
            <div class="col-7 d-flex align-items-center">
                <h3 class="fw-bold fs-5 text-danger">Sucursal <?= $branchName; ?></h3><br>
            </div>
        </div>
        <div class="clearfix"></div>
        <p>Hola, <span class="fw-600 fs-5 text-info"><?= $userName; ?></span> | <span><a class="fs-6" href="<?= $closeRoute; ?>">Cerrar Sesion</span></p>

        <div id="categories" class="row justify-content-between">
            <? foreach ($categories as $category) : ?>
                <div id="cat-<?= $category['id']; ?>" class="fila d-flex align-items-center <?= $category['id'] == 1 ? 'selected' : ''; ?>">
                    <a href="#" class="d-flex align-items-center">
                        <img class="img-responsive" src="/<?= $category['image']; ?>" alt="<?= $category['name']; ?>" width="50" />
                        <span class="fw-bold fs-5 ms-2 text-black text-truncate"> <?= $category['name']; ?></span>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
        <div class="d-grid gap-2 col-12 mx-auto mt-5">
            <a id="cancel-order-btn" href="#" class="btn btn-danger btn-lg text-uppercase fw-bold noroundborder">Cancelar pedido</a>
        </div>
    </div>
    <div id="centro" class="col-7">
        <h2 class="fw-bolder" id="category-name"></h2>
        <p class="fw-bold">Elija los productos a agregar a la orden</p>
        <div id="product-list">

        </div>
    </div>
    <div id="cart" class="col-2">
        <h2 class="text-black fs-2 fw-bolder">Pedido</h2>
        <p class="d-none"><b>Id:</b> <span id="customer_id" class="fw-bold fs-6 text-dark"><?= $customerWithContactsData['id']; ?></span></p>
        <p class="mb-0"><b>Cliente:</b> <span id="customer_name" class="fw-bold fs-6 text-dark"><?= $customerWithContactsData['name']; ?></span></p>
        <p class="mb-0"><b>Telefono: </b><span id="customer_phone" class="fw-bold fs-6 text-dark"><?= $customerWithContactsData['phone_number']; ?></span></p>
        <p class="mb-0"><b>Direccion: </b><span id="customer_address" class="fw-bold fs-6 text-dark"><?= $customerWithContactsData['address']; ?></span></p>
        <p><b>Punto de referencia: </b><span id="customer_reference_point" class="fw-bold fs-6 text-dark"><?= $customerWithContactsData['reference_point']; ?></span></p>
        <p>Productos agregados a la orden:</p>

        <div id="cart-items">
        </div>
        <div id="totalContainer">
            <p>Total: <span id="total" class="fw-bold fs-4 text-warning">$0</span></p>
            <div class="d-grid gap-2 col-12 mx-auto">
                <button id='confirm-order' class="btn btn-primary btn-lg text-uppercase fw-bold noroundborder" disabled>Confirmar Pedido</button>
            </div>
        </div>
    </div>
</div>
<? require 'TransactionModalWindow.php'; ?>
<? #require 'CustomizeOrderModalWindow.php'; 
?>
<? require 'ProcessOrderModalWindow.php'; ?>
<? #require 'ToastWindow.php'; 
?>
<?php $this->insert('Sections/toast.tpl', ['id' => 'cart-toast', 'message' => 'Producto agregado al carrito.']); ?>

<?php $this->start('scripts') ?>
<script>
    var productModal = new bootstrap.Modal(document.getElementById('productModal'));
    var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
    var filterProductsUrl = '<?= Route::getUrlFromName('FilterProducts'); ?>';
    var getSaucesAndExtrasUrl = '<?= Route::getUrlFromName('FilterSaucesAndExtras'); ?>';
    var processOrderUrl = '<?= Route::getUrlFromName('ProcessOrder'); ?>';
    var customerWithContactsData = <?= json_encode($customerWithContactsData) ?>;
</script>

<script src="/assets/js/orders/cart.js"></script>
<script src="/assets/js/orders/product.js"></script>
<script src="/assets/js/orders/eventHandlers.js"></script>
<?php $this->stop() ?>