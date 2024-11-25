<?php

use App\Components\Buttons\CancelButton;

$this->layout(
    'Layouts/layout',
    [
        "action" => $action,
        "formAction" => $formAction,
        "h1" => $h1,
        "record" => $record,
        "title" => $title,
        "products" => $products,
        "availableExtras" => $availableExtras,
        "selectedExtras" => $selectedExtras,
        "useDataTablesResources" => false
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
$product_id = 0;
$extra_id = 0;
$id = 0;
if (isset($_SESSION['formData']['id'])) :
    $id = $_SESSION['formData']['id'] ?? 0;
    unset($_SESSION['formData']['id']);
endif;
if (isset($_SESSION['formData']['product_id'])) :
    $product_id = $_SESSION['formData']['product_id'] ?? 0;
    unset($_SESSION['formData']['product_id']);
endif;
if (isset($_SESSION['formData']['extra_id'])) :
    $extra_id = $_SESSION['formData']['extra_id'] ?? 0;
    unset($_SESSION['formData']['extra_id']);
endif;

if (isset($record) && count($record) > 0) :
    $id = $record['id'];
    $product_id = $record['product_id'];
    $extra_id = $record['extra_id'];
endif;

?>
<div class="container mt-5">
    <form method="POST" action="<?= $formAction; ?>" class="needs-validation" enctype="multipart/form-data" novalidate>
        <div class="mb-3 has-validation">
            <label for="product_id" class="form-label">Producto: </label>
            <div class="col-sm-4">
                <?= $products; ?>
            </div>
            <? if (!empty($errors['product_id'])) : ?>
                <div class="text-danger text-muted">
                    <?= $errors['product_id']; ?>
                </div>
            <? endif; ?>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div class="col-sm-4">
                <label for="available_extra_id" class="form-label">Extras disponibles: </label>
                <?= $availableExtras; ?>
                <? if (!empty($errors['available_extra_id'])) : ?>
                    <div class="text-danger text-muted">
                        <?= $errors['available_extra_id']; ?>
                    </div>
                <? endif; ?>
            </div>

            <div class="d-flex flex-column justify-content-center">
                <button type="button" class="btn btn-primary mb-2">Agregar</button>
                <button type="button" class="btn btn-secondary">Remover</button>
            </div>

            <div class="col-sm-4">
                <label for="selected_extra_id" class="form-label">Salsas seleccionadas: </label>
                <?= $selectedExtras; ?>
                <? if (!empty($errors['selected_extra_id'])) : ?>
                    <div class="text-danger text-muted">
                        <?= $errors['selected_extra_id']; ?>
                    </div>
                <? endif; ?>
            </div>
        </div>

        <div class="clearfix"></div>
        <div id="buttons">
            <?= (new CancelButton('/products'))->render(); ?>
        </div>
    </form>
</div>
<?php $this->insert('Sections/toast.tpl', ['id' => 'cart-toast', 'message' => 'Producto agregado al carrito.']); ?>
<?php $this->start('scripts') ?>
<script src="/assets/js/toast.js"></script>
<script src="/assets/js/products/product_extras.js"></script>
<?php $this->stop() ?>