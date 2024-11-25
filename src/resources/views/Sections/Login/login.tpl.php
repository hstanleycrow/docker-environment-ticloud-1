<?php

use App\Components\Buttons\LoginButton;

$this->layout(
    'Layouts/loginLayout',
    [
        "title" => $title,
        "h1" => $h1,
        'tokenCSRF' => $tokenCSRF,
        "useDataTablesResources" => false,
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
$username = "";
if (isset($_SESSION['formData'])) :
    $username = $_SESSION['formData']['username'];
    unset($_SESSION['formData']);
endif;
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" style="background-color: white;">
                    <div class=" text-center">
                        <img class="img-responsive " src="assets/images/logo-ticloud-azul-y-gris-2048x731.png" alt="<?= BUSINESS_NAME; ?>" width="270" />
                    </div>
                    <!-- <h3 class="text-center text-black">Inicio de sesión</h3> -->
                </div>
                <div class="card-body">
                    <form method="POST" action="/login" class="needs-validation">
                        <div class="mb-3 has-validation">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control <?= (!empty($errors['username'])) ? 'is-invalid' : ''; ?>" id="username" name="username" autocomplete="off" value="<?= $username; ?>">
                            <? if (!empty($errors['username'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['username']; ?>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="mb-3 has-validation">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control <?= (!empty($errors['password'])) ? 'is-invalid' : ''; ?>" id="password" name="password" value="">
                            <? if (!empty($errors['password'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['password']; ?>
                                </div>
                            <? endif; ?>
                        </div>
                        <div class="mb-3 has-validation">
                            <input type="hidden" class="form-control <?= (!empty($errors['credentials'])) ? 'is-invalid' : ''; ?>">
                            <? if (!empty($errors['credentials'])) : ?>
                                <div class="invalid-feedback">
                                    <?= $errors['credentials']; ?>
                                </div>
                            <? endif; ?>
                        </div>
                        <input type="hidden" name="csrf_token" value="<?= $tokenCSRF; ?>">
                        <div class="d-grid">
                            <?= (new LoginButton())->render(); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>