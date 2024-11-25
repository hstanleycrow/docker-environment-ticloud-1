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
$image = "";
$id = 0;
$description = "";
if (isset($_SESSION['formData']['id'])) :
    $id = $_SESSION['formData']['id'] ?? 0;
    unset($_SESSION['formData']['id']);
endif;
if (isset($_SESSION['formData']['name'])) :
    $name = $_SESSION['formData']['name'] ?? "";
    unset($_SESSION['formData']['name']);
endif;
if (isset($_SESSION['formData']['description'])) :
    $description = $_SESSION['formData']['description'] ?? "";
    unset($_SESSION['formData']['description']);
endif;

if (isset($record) && count($record) > 0) :
    $id = $record['id'];
    $name = $record['name'];
    $description = $record['description'];
endif;

?>
<div class="container mt-5">
    <form method="POST" action="<?= $formAction; ?>" class="needs-validation" enctype="multipart/form-data" novalidate>
        <? if ($action == 'edit') : ?>
            <div class="mb-3 has-validation">
                <label for="id" class="form-label">Id:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control <?= (!empty($errors['id'])) ? 'is-invalid' : '.is-valid'; ?>" name="id" autocomplete="off" value="<?= $id; ?>" aria-describedby="id" readonly="readonly">
                </div>
                <? if (!empty($errors['id'])) : ?>
                    <div id="id" class="text-danger text-muted">
                        <?= $errors['id']; ?>
                    </div>
                <? endif; ?>
            </div>
            <div class="mb-3 has-validation">
                <label for="active" class="form-label">Disponibilidad:</label>
                <div class="col-sm-4">
                    <?= $active; ?>
                </div>
                <? if (!empty($errors['active'])) : ?>
                    <div id="active" class="text-danger text-muted">
                        <?= $errors['active']; ?>
                    </div>
                <? endif; ?>
            </div>
        <? endif; ?>
        <div class="mb-3 has-validation">
            <label for="name" class="form-label">Nombre:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control <?= (!empty($errors['name'])) ? 'is-invalid' : '.is-valid'; ?>" name="name" autocomplete="off" value="<?= $name; ?>" aria-describedby="name">
            </div>
            <? if (!empty($errors['name'])) : ?>
                <div id="name" class="text-danger text-muted">
                    <?= $errors['name']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="mb-3 has-validation">
            <label for="description" class="form-label">Descripcion:</label>
            <div class="col-sm-4">
                <textarea name="description" id="description" cols="30" rows="5" class="form-control <?= (!empty($errors['description'])) ? 'is-invalid' : '.is-valid'; ?>"" aria-describedby=" description"><?= $description; ?></textarea>
            </div>
            <? if (!empty($errors['description'])) : ?>
                <div id="description" class="text-danger text-muted">
                    <?= $errors['description']; ?>
                </div>
            <? endif; ?>
        </div>
        <? if ($action == 'edit') : ?>
            <div class="mb-3 has-validation">
                <label for="image" class="form-label">Imagen Actual: </label>
                <div class="col-sm-2">
                    <img src="<?= BASE_URL . $record['image']; ?>" alt="<?= $record['name']; ?>" class="img-thumbnail">
                    <input type="hidden" name="actual_image" value="<?= $record['image']; ?>">
                </div>
            </div>
        <? endif; ?>
        <div class="mb-3 has-validation">
            <label for="image" class="form-label"><?= $action == 'edit' ? 'Cambiar ' : 'Agregar '; ?>Imagen: </label>
            <div class="col-sm-4">
                <input type="file" class="form-control <?= (!empty($errors['image'])) ? 'is-invalid' : '.is-valid'; ?>" name="image" autocomplete="off" value="<?= $image; ?>" aria-describedby="image" accept=".gif,.jpg,.jpeg,.png">
            </div>
            <? if (!empty($errors['image'])) : ?>
                <div id="image" class="text-danger text-muted">
                    <?= $errors['image']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="clearfix"></div>
        <div id="buttons">
            <?= (new SaveButton())->render(); ?>
            <?= (new CancelButton('/sauces'))->render(); ?>
        </div>
    </form>
</div>
<?php $this->start('scripts') ?>

<?php $this->stop() ?>