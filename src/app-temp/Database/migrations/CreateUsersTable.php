<?php

namespace App\Database\Migrations;

use App\Core\Initialize;
use App\Core\DBConnection\MySQLEnvConfig;
use App\Core\DBConnection\MySQLPDOConnection;
use App\Core\DBConnection\MySQLEnvCharsetConfig;
use PDOException;

require dirname(__FILE__) . '/../../../vendor/autoload.php'; // Asegúrate de cargar el autoloader de Composer

// Inicializar la aplicación
$app = Initialize::start(false);

// Establecer la conexión a la base de datos
$connection = (new MySQLPDOConnection(
    new MySQLEnvConfig($_ENV),
    new MySQLEnvCharsetConfig($_ENV),
    $_SERVER['SCRIPT_NAME']
));

// Definir la consulta para crear la tabla 'users'
$sql = "
    CREATE TABLE IF NOT EXISTS `users` (
        `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
        `username` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
        `password` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
        `active` ENUM('S','N') NOT NULL DEFAULT 'S' COLLATE 'utf8_general_ci',
        `isAdmin` ENUM('S','N') NOT NULL DEFAULT 'S' COLLATE 'utf8_general_ci',
        `remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
        `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
        `updated_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`) USING BTREE,
        UNIQUE INDEX `users_username_unique` (`username`) USING BTREE
    )
    COLLATE='utf8_general_ci'
    ENGINE=InnoDB;
";

// Ejecutar la consulta para crear la tabla
try {
    $connection->getConnection()->exec($sql);
    echo "Tabla 'users' creada exitosamente.\n";
} catch (PDOException $e) {
    echo "Error al crear la tabla: " . $e->getMessage() . "\n";
}
