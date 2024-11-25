<?php

namespace Models;

use App\Core\Model;
use App\Core\DBConnection\IConnection;

class Auth extends Model
{
    const AUTH_SUCCESS = 'success';
    const AUTH_INACTIVE = 'inactive';
    const AUTH_FAILURE = 'failure';
    protected string $scriptName;

    private $isLogged = false;

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
        $this->setSessionUserStatus();
    }

    private function setSessionUserStatus(): void
    {
        $this->isLogged = isset($_SESSION['isLogged']) && $_SESSION['isLogged'];
        #(isset($_SESSION['islog'])) ? $this->isLogged = $_SESSION['islog'] : $this->isLogged = false;
    }

    /* public function isCredentialValid(string $usernameProvided, string $passwordProvided): string
    {
        $result = $this->getDBPassword($usernameProvided);
        if (!$result) :
            return self::AUTH_FAILURE;
        endif;
        $dbPassword = $result[0]['password'];
        $active = $result[0]['active'];
        if ($active === 'N') {
            return self::AUTH_INACTIVE;
        }
        if (User::isValidPassword($passwordProvided, $dbPassword)) {
            $this->saveUserDataOnSession($usernameProvided);
            return self::AUTH_SUCCESS;
        }
        return self::AUTH_FAILURE;
    } */
    public function isCredentialValid(string $usernameProvided, string $passwordProvided): array
    {
        $userData = $this->getDBPassword($usernameProvided);
        if (!$userData) :
            return ['status' => self::AUTH_FAILURE];
        endif;
        $dbPassword = $userData[0]['password'];
        $active = $userData[0]['active'];
        if ($active === 'N') {
            return ['status' => self::AUTH_INACTIVE];
        }
        if (User::isValidPassword($passwordProvided, $dbPassword)) {
            return ['status' => self::AUTH_SUCCESS, 'user' => $userData[0]];
        }
        return ['status' => self::AUTH_FAILURE];
    }

    private function getDBPassword(string $usernameProvided): array|bool
    {
        $this->query = "
            SELECT 
                id,
                name, 
                username, 
                password, 
                isAdmin,
                active
            FROM 
                users 
            WHERE 
                username = '$usernameProvided'
        ";
        $data = array();
        $data = $this->getRecords();
        return (count($data) > 0) ? $data : false;
    }

    private function saveUserDataOnSession(string $usernameProvided): void
    {
        $_SESSION['isLogged'] = true;
        $this->isLogged = true;
        $this->query = "
            SELECT 
                id,
                name, 
                username, 
                password, 
                isAdmin,
                active 
            FROM 
                users 
            WHERE 
                username = '{$usernameProvided}'
        ";
        $data = array();
        $data = $this->getRecords();
        $_SESSION['userdat'] = $data[0];
    }

    public function isLogged(): bool
    {
        return $this->isLogged;
    }
}
