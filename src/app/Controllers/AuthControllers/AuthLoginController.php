<?php

namespace App\Controllers\AuthControllers;

use Models\Auth;
use App\Core\Csrf;
use App\Core\Template;
use App\Controllers\Controller;

class AuthLoginController extends Controller
{
    private static $title = "Ingreso | " . BUSINESS_NAME;
    private static $h1 = "Inicio de Sesión";
    private static $tokenCSRF = '';

    public function login()
    {
        $validator = new AuthFormValidator();
        $this->validate($validator->getRules(), $validator->getMessages());

        $username = $this->request->get('username');
        $password = $this->request->get('password');
        $formCSRFToken = $this->request->get('csrf_token');

        if (Csrf::validate($formCSRFToken, true)) :
            $response = (new Auth($this->connection))->isCredentialValid($username, $password);
            if ($response['status'] === Auth::AUTH_SUCCESS) :
                $this->saveUserDataOnSession($username, $response['user']);
                if (isset($_SESSION['retorno'])) :
                    $retorno = $_SESSION['retorno'];
                    unset($_SESSION['retorno']);
                    if ($retorno <> '')
                        redirect($retorno);
                endif;
                Csrf::clearCsrfToken();
                if ($this->isAdmin())
                    $this->route('home');
                else
                    $this->route('home');
            else :
                if ($response['status'] === Auth::AUTH_FAILURE) :
                    $errors['credentials'] = "Usuario/password equivocados.";
                else :
                    $errors['credentials'] = "Esta cuenta se encuentra inactiva.";
                endif;
            endif;
        else :
            Csrf::clearCsrfToken();
            self::$tokenCSRF = (new Csrf())->getToken();
            $errors['credentials'] = "Existe un problema de seguridad con su petición, y no será posible iniciar sesión";
        endif;


        $data = [
            "title" => self::$title,
            "h1" => self::$h1,
            "errors" => $errors,
            'tokenCSRF' => self::$tokenCSRF,
        ];

        echo Template::render('sections/Login/login.tpl', $data);
    }

    private function saveUserDataOnSession(string $username, array $userData): void
    {
        $_SESSION['isLogged'] = true;
        $_SESSION['userdat'] = $userData;
    }


    private function isAdmin(): bool
    {
        return $_SESSION['userdat']['isAdmin'] === 'S';
    }
}
