<?php

use App\Components\Buttons\ConfirmButton;
use App\Core\Route;
use App\Core\FlashMessages;

$this->layout(
    'Layouts/layout',
    [
        "h1" => $h1,
        "title" => $title,
        "resultado" => $resultado,
        "output" => $output,
        "originalOutput" => $originalOutput,
        "startDate" => $startDate,
        "endDate" => $endDate,
        "reportContent" => $reportContent,
        "isDownloadable" => $isDownloadable,
        "useDataTablesResources" => false,
    ]
);
if (isset($_SESSION['errors']) && count($_SESSION['errors']) > 0) :
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
endif;
FlashMessages::display();


if (!$resultado) :
    $output = $originalOutput;
endif;
?>
<?php $this->start('styles') ?>
<link rel="stylesheet" href="assets/js/jqueryui/1.13.2/jquery-ui.min.css">
<?php $this->stop() ?>

<div class="row">
    <form id="formulario" class="form-inline" method="POST" target="_self">
        <div class="row g-4">
            <div class="col has-validation">
                <label for="startDate" class="form-label">Fecha Inicio:</label>
                <div class="col-6ss">
                    <input type="text" class="form-control <?= (!empty($errors['startDate'])) ? 'is-invalid' : '.is-valid'; ?>" id="startDate" name="startDate" autocomplete="off" value="<?= $startDate; ?>" aria-describedby="startDateError">
                </div>
                <? if (!empty($errors['startDate'])) : ?>
                    <div id="startDateError" class="text-danger text-muted">
                        <?= $errors['startDate']; ?>
                    </div>
                <? endif; ?>
            </div>
            <div class="col has-validation">
                <label for="endDate" class="form-label">Fecha Fin:</label>
                <div class="col-sm-6ss">
                    <input type="text" class="form-control <?= (!empty($errors['endDate'])) ? 'is-invalid' : '.is-valid'; ?>" id="endDate" name="endDate" autocomplete="off" value="<?= $endDate; ?>" aria-describedby="endDateError">
                </div>
                <? if (!empty($errors['endDate'])) : ?>
                    <div id="endDateError" class="text-danger text-muted">
                        <?= $errors['endDate']; ?>
                    </div>
                <? endif; ?>
            </div>
            <div class="col ">
                <label for="output" class="form-label">Salida:</label>
                <div class="form-group d-flex align-items-center">
                    <label class="radio-inline">
                        <input type="radio" name="output" id="screen" value="SCREEN" <?= ($output == 'SCREEN') ? 'checked="checked"' : ''; ?> />&nbsp;&nbsp;Pantalla&nbsp;&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="output" id="excel" value="EXCEL" <?= ($output == 'EXCEL') ? 'checked="checked"' : ''; ?> />&nbsp;&nbsp;Excel&nbsp;&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="output" id="pdf" value="PDF" <?= ($output == 'PDF') ? 'checked="checked"' : ''; ?> />&nbsp;&nbsp;PDF&nbsp;&nbsp;
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="output" id="csv" value="CSV" <?= ($output == 'CSV') ? 'checked="checked"' : ''; ?> />&nbsp;&nbsp;CSV
                    </label>
                </div>
            </div>
            <div class="col d-flex">
                <?= (new ConfirmButton('Generar', 'fa-solid fa-file-export'))->addClass('btn btn-success align-items-center')->render(); ?>
            </div>
        </div>

        <input type="hidden" name="quehacer" value="reporte" />
        <?= (!empty($mensaje_res)) ? '<span id="error_res" class="errormsg">' . $mensaje_res . '</span>' : ''; ?>
    </form>
</div>
<?
if ($reportContent) :
    if ($_POST) :
        echo "<br><br>";
        if ($isDownloadable) {
            echo '<a href="' . $reportContent . '" download>Descarga el informe aqui</a>';
        } else {
            echo $reportContent;
        }
    endif;
else :
?>
    <div class="clearfix"></div><br><br>
    <!-- <div class="col-xs-6">
        <p class="bg-danger" style="padding:15px;margin:0 0 10px;">No se encontraron datos en el rango de fecha establecido</p>
    </div> -->
<?
    $resultado = true;
    $output = $originalOutput;
endif;
?>
<?php $this->start('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="assets/js/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="assets/js/reports/DatesManager.js"></script>
<?php $this->stop() ?>