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
        "isAdmin" => $isAdmin,
        "useDataTablesResources" => false
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
$id = 0;
$name = "";
$username = "";
$password = "";
$password_confirmation = "";
if (isset($_SESSION['formData']['id'])) :
    $id = $_SESSION['formData']['id'] ?? 0;
    unset($_SESSION['formData']['id']);
endif;
if (isset($_SESSION['formData']['name'])) :
    $name = $_SESSION['formData']['name'] ?? "";
    unset($_SESSION['formData']['name']);
endif;
if (isset($_SESSION['formData']['username'])) :
    $username = $_SESSION['formData']['username'] ?? "";
    unset($_SESSION['formData']['username']);
endif;
if (isset($_SESSION['formData']['password'])) :
    $password = $_SESSION['formData']['password'] ?? "";
    unset($_SESSION['formData']['password']);
endif;
if (isset($_SESSION['formData']['password_confirmation'])) :
    $password_confirmation = $_SESSION['formData']['password_confirmation'] ?? "";
    unset($_SESSION['formData']['password_confirmation']);
endif;
if (isset($_SESSION['formData']['isAdmin'])) :
    $isAdmin = $_SESSION['formData']['isAdmin'] ?? "N";
    unset($_SESSION['formData']['isAdmin']);
endif;

if (isset($record) && count($record) > 0) :
    $id = $record['id'];
    $name = $record['name'];
    $username = $record['username'];
    $password = $record['password'];
endif;

?>
<div class="container mt-5">
    <form method="POST" action="<?= $formAction; ?>" class="needs-validation" novalidate>
        <? if ($action == 'edit') : ?>
            <div class="mb-3 has-validation">
                <label for="id" class="form-label">Id del usuario:</label>
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
                <label for="active" class="form-label">Usuario activo:</label>
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
            <label for="name" class="form-label">Nombres y apellidos:</label>
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
            <label for="username" class="form-label">Username:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control <?= (!empty($errors['username'])) ? 'is-invalid' : '.is-valid'; ?>" name="username" autocomplete="off" value="<?= $username; ?>" aria-describedby="username">
            </div>
            <? if (!empty($errors['username'])) : ?>
                <div id="username" class="text-danger text-muted">
                    <?= $errors['username']; ?>
                </div>
            <? endif; ?>
        </div>
        <? if ($action == 'edit') : ?>
            <p><strong>Cambiar contraseña (dejar en blanco para no cambiar)</strong></p>
        <? endif; ?>
        <div class="mb-3 has-validation">
            <label for="password" class="form-label">Password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control <?= (!empty($errors['password'])) ? 'is-invalid' : '.is-valid'; ?>" name="password" autocomplete="new-password" value="<?= $password; ?>" aria-describedby="password">
            </div>
            <? if (!empty($errors['password'])) : ?>
                <div id="password" class="text-danger text-muted">
                    <?= $errors['password']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="mb-3 has-validation">
            <label for="password_confirmation" class="form-label">Confirmar password:</label>
            <div class="col-sm-4">
                <input type="password" class="form-control <?= (!empty($errors['password_confirmation'])) ? 'is-invalid' : '.is-valid'; ?>" name="password_confirmation" autocomplete="new-password" value="<?= $password_confirmation; ?>" aria-describedby="password_confirmation">
            </div>
            <? if (!empty($errors['password_confirmation'])) : ?>
                <div id="password_confirmation" class="text-danger text-muted">
                    <?= $errors['password_confirmation']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="mb-3 has-validation">
            <label for="isAdmin" class="form-label">¿Es admin?:</label>
            <div class="col-sm-4">
                <?= $isAdmin; ?>
            </div>
            <? if (!empty($errors['isAdmin'])) : ?>
                <div id="isAdmin" class="text-danger text-muted">
                    <?= $errors['isAdmin']; ?>
                </div>
            <? endif; ?>
        </div>
        <div class="clearfix"></div>
        <div id="buttons">
            <?= (new SaveButton())->render(); ?>
            <?= (new CancelButton('/users'))->render(); ?>
        </div>
    </form>
</div>
<?php $this->start('scripts') ?>

<?php $this->stop() ?>