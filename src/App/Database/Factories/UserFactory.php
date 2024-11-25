<?php

namespace App\Database\Factories;

use Models\User;
use Faker\Factory;
use App\Core\Initialize;
use App\Core\DBConnection\MySQLEnvConfig;
use App\Core\DBConnection\MySQLPDOConnection;
use App\Core\DBConnection\MySQLEnvCharsetConfig;

require dirname(__FILE__) . '/../../../vendor/autoload.php'; // Asegúrate de cargar el autoloader de Composer

// Verificamos si se pasan suficientes argumentos
if ($argc < 2) {
    echo "Uso: \nIngresar a App\nEjecutar\nphp UserFactory.php <cantidad> [<esActivo> <esAdmin>]\n";
    exit(1);
}

$count = (int)$argv[1];
$active = $argc >= 3 ? strtoupper($argv[2]) : 'S'; // Segundo argumento opcional, 'S' por defecto (ACTIVE)
$isAdmin = $argc >= 4 ? strtoupper($argv[3]) : 'N'; // Tercer argumento opcional, 'N' por defecto (ISADMIN)

// Inicializamos la aplicación
$app = Initialize::start(false);

// Creamos una instancia de Faker para generar datos falsos
$faker = Factory::create();
$password = '123456'; // Contraseña por defecto para los usuarios creados
$connection = (new MySQLPDOConnection(
    new MySQLEnvConfig($_ENV),
    new MySQLEnvCharsetConfig($_ENV),
    $_SERVER['SCRIPT_NAME']
));

// Creamos los usuarios en la base de datos
for ($i = 0; $i < $count; $i++) :
    $name = $faker->name;
    $username = $faker->userName;
    $data = [
        "name" => $name,
        "username" => $username,
        "password" => $password,
        "active" => $active,
        "isAdmin" => $isAdmin,
    ];
    try {
        $id = (new User($connection))->create($data)->lastInsertId();
        echo "Usuario creado: $id, $name, $username, $password, Activo: $active, Admin: $isAdmin\n";
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
endfor;
