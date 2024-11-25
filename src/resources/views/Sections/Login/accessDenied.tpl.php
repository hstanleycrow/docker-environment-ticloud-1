<?php

$this->layout(
    'Layouts/transaction',
    [
        "title" => $title,
        "h1" => $h1,
        "message" => $message,
        "redirectURL" => $redirectURL,
        "useDataTablesResources" => false,
    ]
);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Acceso Denegado</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger" role="alert">
                        <?= $message; ?>
                    </div>
                    <div class="text-center">
                        <a href="<?= $redirectURL ?>" class="btn btn-primary">Volver a la página de ventas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>