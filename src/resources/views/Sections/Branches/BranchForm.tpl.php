<?php

use App\Components\Buttons\SaveButton;
use App\Components\Buttons\CancelButton;

$this->layout(
    'Layouts/layout',
    [
        "action" => $action,
        "formAction" => $formAction,
        "h1" => $h1,
        "record" => $record,
        "title" => $title,
        "useDataTablesResources" => false
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
$name = "";
$id = 0;
if (isset($_SESSION['formData']['id'])) :
    $id = $_SESSION['formData']['id'] ?? 0;
    unset($_SESSION['formData']['id']);
endif;
if (isset($_SESSION['formData']['name'])) :
    $name = $_SESSION['formData']['name'] ?? "";
    unset($_SESSION['formData']['name']);
endif;
if (isset($record) && count($record) > 0) :
    $id = $record['id'];
    $name = $record['name'];
endif;

?>
<div class="container mt-5">
    <form method="POST" action="<?= $formAction; ?>" class="needs-validation" novalidate>
        <? if ($action == 'edit') : ?>
            <div class="mb-3 has-validation">
                <label for="id" class="form-label">Id de la Sucursal</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control <?= (!empty($errors['id'])) ? 'is-invalid' : '.is-valid'; ?>" name="id" autocomplete="off" value="<?= $id; ?>" aria-describedby="id" readonly="readonly">
                </div>
                <? if (!empty($errors['id'])) : ?>
                    <div id="id" class="text-danger text-muted">
                        <?= $errors['id']; ?>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>
        <div class="mb-3 has-validation">
            <label for="name" class="form-label">Nombre de Sucursal</label>
            <div class="col-sm-4">
                <input type="text" class="form-control <?= (!empty($errors['name'])) ? 'is-invalid' : '.is-valid'; ?>" name="name" autocomplete="off" value="<?= $name; ?>" aria-describedby="name">
            </div>
            <? if (!empty($errors['name'])) : ?>
                <div id="name" class="text-danger text-muted">
                    <?= $errors['name']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="clearfix"></div>
        <div id="buttons">
            <?= (new SaveButton())->render(); ?>
            <?= (new CancelButton('/branches'))->render(); ?>
        </div>
    </form>
</div>
<?php $this->start('scripts') ?>

<?php $this->stop() ?>