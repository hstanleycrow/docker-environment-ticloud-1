<?php

use App\Core\FlashMessages;

$this->layout(
    'Layouts/layout',
    [
        "title" => $title,
        "h1" => $h1,
        "datatable" => $datatable,
        "useDataTablesResources" => true
    ]
);

FlashMessages::display();
?>
<?= $datatable->setTableId('order_status')->render();
?>
<?php $this->start('scripts') ?>

<?php $this->stop() ?>

