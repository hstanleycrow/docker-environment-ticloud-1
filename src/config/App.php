<?php
$debug = false;
$useDataTablesResources = false;

define("RESORUCES_URL", $_ENV['RESORUCES_URL']);
define('AUTH_SALT', $_ENV['AUTH_SALT']);
define('BUSINESS_NAME', $_ENV['BUSINESS_NAME']);


if (stripos($_ENV['ENVIRONMENT'], "testing") !== false) :
    $debug = true;
    #define("DIR_BASE", "D:" . DIRECTORY_SEPARATOR . "sitios" . DIRECTORY_SEPARATOR . "CobroMaster" . DIRECTORY_SEPARATOR . "credicomer" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR);
    define('DIR_BASE', getcwd() . DIRECTORY_SEPARATOR);
else :
    define("DIR_BASE", $_ENV['DIR_BASE']); #Colocar ruta completa, ej: /var/www/tuproyecto/

endif;
define("DIR_BASE_LOGS", DIR_BASE . "logs");

if ($_ENV['PREPROS_ACTIVE']) :
    define("BASE_URL", 'http://127.0.0.1:' . $_ENV['PREPROS_PORT'] . '/');
else :
    define("BASE_URL", $_ENV['BASE_URL']);
endif;
define("DEFAULT_CONTROLLER", "FrontController");
define('DEFAULT_ERROR_CONTROLLER', 'error');
define('DEFAULT_METHOD', 'index');

/* DATOS */
const REPORT_ERROR_EMAIL = 'hstanleycrow@gmail.com';

/* Delimitadores decimal y millar por default */
define("SEPARADOR_DECIMAL", ".");
define("SEPARADOR_MILES", ",");
define("MONEDA", "$");

/* Configuraciones default */
date_default_timezone_set("America/El_Salvador");
#setlocale(LC_ALL, "es_SV.UTF-8");
ini_set('register_globals', 'Off');

define("SEARCH_ICON", '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
</svg>');
