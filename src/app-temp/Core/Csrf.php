<?php

namespace App\Core;

class Csrf
{
    private $length = 32; // longitud de nuestro token
    private $token; // token
    private $expiration; // tiempo de expiración
    private $expirationTime = 300; // 60 * 5 = 5 minutos de expiración

    // Crear nuestro token si no existe y es el primer ingreso al sitio
    /* public function __construct()
    {
        if (!isset($_SESSION['csrf_token'])) :
            $this->generate();
            $_SESSION['csrf_token'] =
                [
                    'token'      => $this->token,
                    'expiration' => $this->expiration
                ];
            return $this;
        else :
            $this->token = $_SESSION['csrf_token']['token'];
            $this->expiration = $_SESSION['csrf_token']['expiration'];
        endif;
        return $this;
    } */

    public function __construct()
    {
        if (isset($_SESSION['csrf_token'])) :
            $this->token = $_SESSION['csrf_token']['token'];
            $this->expiration = $_SESSION['csrf_token']['expiration'];
        endif;
    }

    public function initToken(): self
    {
        if (!isset($_SESSION['csrf_token'])) :
            $this->generate();
            $_SESSION['csrf_token'] =
                [
                    'token'      => $this->token,
                    'expiration' => $this->expiration
                ];
        endif;
        return $this;
    }

    /**
     * Método para generar un nuevo token
     *
     * @return void
     */
    private function generate()
    {
        if (function_exists('bin2hex')) :
            $this->token = bin2hex(random_bytes($this->length)); // ASDFUHASIO32Jasdasdjf349mfjads9mfas4asdf
        else :
            $this->token = bin2hex(openssl_random_pseudo_bytes($this->length)); // asdfuhasi487a9s49mafmsau84
        endif;

        $this->expiration = time() + $this->expirationTime;
        return $this;
    }

    /**
     * Validar el token de la petición con el del sistema
     *
     * @param string $csrf_token
     * @param boolean $validate_expiration
     * @return void
     */
    public static function validate($csrf_token, $validate_expiration = false)
    {
        $self = new self();

        #pd($csrf_token . " | " . $self->getExpiration() . " | " . time());
        // Validando el tiempo de expiración del token
        if ($validate_expiration && $self->getExpiration() < time()) {
            return false;
        }

        if ($csrf_token !== $self->getToken()) {
            return false;
        }

        return true;
    }

    /**
     * Método para obtener el token
     *
     * @return void
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Método para obtener la expiración del token
     *
     * @return void
     */
    public function getExpiration()
    {
        return $this->expiration;
    }
    public static function clearCsrfToken(): self
    {
        unset($_SESSION['csrf_token']);
        return new self();
    }
}
