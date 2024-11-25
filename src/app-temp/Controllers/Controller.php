<?php

namespace App\Controllers;

use App\Core\Route;
use App\Core\FlashMessages;
use App\Core\DBConnection\IConnection;
use hstanleycrow\FormValidator\Validator;
use Symfony\Component\HttpFoundation\Request;
use hstanleycrow\FormValidator\ValidationException;

class Controller
{

    public function __construct(protected Request $request, protected IConnection $connection, public string $currentRoute)
    {
    }

    protected function validate($rules, $messages = [])
    {
        $data = $this->request->request->all(); // Obtiene los datos de la solicitud

        $_SESSION['formData'] = $data;
        try {
            Validator::validate($data, $rules, $messages);
        } catch (ValidationException $e) {
            foreach ($e->getErrors() as $field => $errorsList) {
                foreach ($errorsList as $error) {
                    $errors[$field] = $error;
                }
            }
            $_SESSION['errors'] = $errors;
            $this->route($this->currentRoute, $data);
        }
    }

    protected function route(string $routeName, ?array $params = []): void
    {
        $url = Route::getUrlFromName($routeName, $params ?? []);
        redirect($url);
    }
}
