<?php

use App\Components\Buttons\SaveButton;
use App\Components\Buttons\CancelButton;

$this->layout(
    'Layouts/layout',
    [
        "action" => $action,
        "formAction" => $formAction,
        "h1" => $h1,
        "customerRecord" => $customerRecord,
        "phoneNumberRecord" => $phoneNumberRecord,
        "addressRecord" => $addressRecord,
        "phoneType" => $phoneType,
        "addressType" => $addressType,
        "title" => $title,
        "useDataTablesResources" => false
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
$id = 0;
$name = "";
$phone_number = "";
$address = "";
$reference_point = "";
$notes = "";

if (isset($_SESSION['formData']['id'])) :
    $id = $_SESSION['formData']['id'] ?? 0;
    unset($_SESSION['formData']['id']);
endif;
if (isset($_SESSION['formData']['name'])) :
    $name = $_SESSION['formData']['name'] ?? "";
    unset($_SESSION['formData']['name']);
endif;
if (isset($_SESSION['formData']['phone_number'])) :
    $phone_number = $_SESSION['formData']['phone_number'] ?? "";
    unset($_SESSION['formData']['phone_number']);
endif;
if (isset($_SESSION['formData']['address'])) :
    $address = $_SESSION['formData']['address'] ?? "";
    unset($_SESSION['formData']['address']);
endif;
if (isset($_SESSION['formData']['reference_point'])) :
    $reference_point = $_SESSION['formData']['reference_point'] ?? "";
    unset($_SESSION['formData']['reference_point']);
endif;
if (isset($_SESSION['formData']['notes'])) :
    $notes = $_SESSION['formData']['notes'] ?? "";
    unset($_SESSION['formData']['notes']);
endif;
if (isset($customerRecord) && count($customerRecord) > 0) :
    $id = $customerRecord['id'];
    $name = $customerRecord['name'];
    $notes = $customerRecord['notes'];
endif;
if (isset($phoneNumberRecord) && count($phoneNumberRecord) > 0) :
    $phone_number = $phoneNumberRecord['phone_number'];
endif;
if (isset($addressRecord) && count($addressRecord) > 0) :
    $address = $addressRecord['address'];
    $reference_point = $addressRecord['reference_point'];
endif;

?>
<div class="container mt-5">
    <form method="POST" action="<?= $formAction; ?>" class="needs-validation" novalidate>
        <div class="row">
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
            <? endif; ?>
            <div class="mb-3 has-validation">
                <label for="name" class="form-label">Nombre:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control <?= (!empty($errors['name'])) ? 'is-invalid' : '.is-valid'; ?>" name="name" autocomplete="off" value="<?= $name; ?>" aria-describedby="name">
                </div>
                <? if (!empty($errors['name'])) : ?>
                    <div id="name" class="text-danger text-muted">
                        <?= $errors['name']; ?>
                    </div>
                <? endif; ?>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="mb-3 has-validation">
                    <label for="phone_number" class="form-label">Teléfono:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control <?= (!empty($errors['phone_number'])) ? 'is-invalid' : '.is-valid'; ?>" name="phone_number" autocomplete="off" value="<?= $phone_number; ?>" aria-describedby="phone_number">
                    </div>
                    <? if (!empty($errors['phone_number'])) : ?>
                        <div id="phone_number" class="text-danger text-muted">
                            <?= $errors['phone_number']; ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="mb-3 has-validation">
                    <label for="phoneType" class="form-label">Tipo:</label>
                    <div class="col-sm-6">
                        <?= $phoneType; ?>
                    </div>
                    <? if (!empty($errors['phoneType'])) : ?>
                        <div id="phoneType" class="text-danger text-muted">
                            <?= $errors['phoneType']; ?>
                        </div>
                    <? endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3 has-validation">
                    <label for="address" class="form-label">Dirección de entrega:</label>
                    <div class="col-sm-12">
                        <textarea class="form-control <?= (!empty($errors['address'])) ? 'is-invalid' : '.is-valid'; ?>" name="address" autocomplete="off" aria-describedby="address"><?= $address; ?></textarea>
                    </div>
                    <? if (!empty($errors['address'])) : ?>
                        <div id="address" class="text-danger text-muted">
                            <?= $errors['address']; ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="mb-3 has-validation">
                    <label for="reference_point" class="form-label">Punto de referencia:</label>
                    <div class="col-sm-12">
                        <textarea class="form-control <?= (!empty($errors['reference_point'])) ? 'is-invalid' : '.is-valid'; ?>" name="reference_point" autocomplete="off" aria-describedby="reference_point"><?= $reference_point; ?></textarea>
                    </div>
                    <? if (!empty($errors['reference_point'])) : ?>
                        <div id="reference_point" class="text-danger text-muted">
                            <?= $errors['reference_point']; ?>
                        </div>
                    <? endif; ?>
                </div>
                <div class="mb-3 has-validation">
                    <label for="addressType" class="form-label">Tipo:</label>
                    <div class="col-sm-4">
                        <?= $addressType; ?>
                    </div>
                    <? if (!empty($errors['addressType'])) : ?>
                        <div id="addressType" class="text-danger text-muted">
                            <?= $errors['addressType']; ?>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="mb-3 has-validation">
                <label for="notes" class="form-label">Notas:</label>
                <div class="col-sm-12">
                    <textarea class="form-control <?= (!empty($errors['notes'])) ? 'is-invalid' : '.is-valid'; ?>" name="notes" autocomplete="off" aria-describedby="notes" rows=5><?= $notes; ?></textarea>
                </div>
                <? if (!empty($errors['notes'])) : ?>
                    <div id="notes" class="text-danger text-muted">
                        <?= $errors['notes']; ?>
                    </div>
                <? endif; ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div id="buttons">
            <?= (new SaveButton())->render(); ?>
            <?= (new CancelButton('/customers'))->render(); ?>
        </div>
    </form>
</div>
<?php $this->start('scripts') ?>

<?php $this->stop() ?>