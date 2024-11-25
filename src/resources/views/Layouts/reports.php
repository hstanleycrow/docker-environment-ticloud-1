<?php

?>
<!DOCTYPE html>
<html lang="es" data-theme="dark" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->e($title) ?></title>

    <!-- BOOSTRAP DESCARGADO -->
    <link rel="stylesheet" href="<?= RESORUCES_URL; ?>bootstrap/css/bootstrap.min.css">

    <!-- SWEET ALERT DESCARGADO -->
    <link rel="stylesheet" href="<?= RESORUCES_URL; ?>sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>

<body>
    <main class="container">
        <section class="row mb-5">
            <?= $this->insert("Sections/Nav/mainMenuNav");
            ?>
        </section>
        <div class="clearfix"></div>
        <header class="row">
            <h1 class="mt-5"><?= $h1; ?></h1>
        </header>
        <?= $this->section("content"); ?>
    </main>
    <footer>
        <?= $this->section('footerLinks'); ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="<?= RESORUCES_URL; ?>bootstrap/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- SWEET ALERT DESCARGADO -->
    <script src="<?= RESORUCES_URL; ?>sweetalert2/sweetalert2.all.min.js"></script>

    <?php echo $this->section('scripts') ?>
</body>

</html>