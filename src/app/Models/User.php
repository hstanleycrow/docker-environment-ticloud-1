<?php

namespace Models;

use App\Core\Model;
use App\Core\ReadRecords;
use App\Core\DBConnection\IConnection;

class User extends Model
{
    protected ?string $table = 'users';
    private String $username = '';
    private string $password = '';

    public function __construct(protected IConnection $connection)
    {
        parent::__construct($connection);
        #$this->setDBTable($this->dbTable);
    }

    public function setId(int $id): void
    {
        $this->primaryKey = $id;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function isAvailableUser(string $username): bool
    {
        $queryAvailableUser = "
                SELECT ifnull(id,0) as id, active FROM users WHERE username = '{$username}'
            ";
        $readRecords = new ReadRecords($this->connection, $queryAvailableUser);
        $readRecords->execute();
        return $readRecords->isAffectedRows();
    }

    /**
     * function Register_User for register new users on database
     * @param $fields: a list of fields on array format to insert into table
     * @return returns user_id or error number
     * */
    public function create($data): self
    {
        if (isset($data['password'])) {
            // Obtener el password sin cifrar
            $plainPassword = $data['password'] . AUTH_SALT;
            // Encriptar el password utilizando el método passwordHash
            $hashedPassword = $this->passwordHash($plainPassword);

            // Reemplazar el password sin cifrar con el password encriptado en el arreglo de datos
            $data['password'] = $hashedPassword;
        }
        parent::create($data);
        return $this;
    }

    public function isInserted(): bool
    {
        /*if ($this->getIdValue() > 0)
            return true;*/
        return false;
    }

    /**
     * funcion para actualizar los datos de un usuario
     * @param $fields: a list of fields on array format to insert into table
     * @return returns user_id or error number
     * */


    public function isUpdated(): bool
    {
        return true;
        #return $this->isAffectedRows();
    }
    public function getUsersForDropdown(): array
    {
        $records = array();
        $this->query = "
                SELECT 
                    id, 
                    name 
                FROM 
                    {$this->table}
                WHERE
                    active = 'S'
                ORDER BY id
            ";
        #echo $query . PHP_EOL;

        $records = parent::getRecords();
        return (count($records) > 0) ? $records : [];
    }
    public function getUsuarioById(): array
    {
        $data = array();
        /*$query = "
                SELECT 
                    tipo_de_persona_id, 
                    usuario_nombre, 
                    usuario_apellido, 
                    usuario_usuario, 
                    usuario_estado,
                    usuario_clave 
                FROM 
                    usuarios 
                WHERE 
                    usuario_id = '{$this->usuario_id}'
            ";
        #echo $query . PHP_EOL;
        
        $data = $this->GetData($query);*/
        return $data;
    }

    /*protected function getUsuarioByUsuario(): array
    {
        $query = "
                SELECT 
                    usuario_id,
                    tipo_de_persona_id, 
                    usuario_nombre, 
                    usuario_apellido, 
                    usuario_usuario, 
                    usuario_estado,
                    usuario_clave 
                FROM 
                    usuarios 
                WHERE 
                    usuario_usuario = '{$this->usuario_usuario}'
            ";
        echo $query;
        die();
        $data = array();
        $data = $this->GetData($query);
        return $data;
    }*/

    /*public function cambiarClave($usuario_clave_actual, $usuario_clave_nueva)
    {
        $row = $this->getUsuarioById();
        if ($row) {
            if (password_verify($usuario_clave_actual, $row[0]['usuario_clave'])) {
                $fields['usuario_clave'] = $usuario_clave_nueva;
                $return = $this->UpdateRow('usuarios', $fields, 'usuario_id', $this->usuario_id);
                return $return;
            }
        }
        return false;
    }*/
    /*public function _getInfoCorreosByTipos($tipo_de_persona_id)
    {
        $query = "
                SELECT 
                    usuario_email, 
                    usuario_nombre 
                FROM 
                    usuarios 
                WHERE 
                    tipo_de_persona_id = $tipo_de_persona_id
                    AND usuario_estado = 1
            ";
        $data = $this->getData($query);
        if ($this->num_filas > 0) {
            return $data;
        }
        return false;
    }*/

    public static function isValidPassword(string $inputPassword, string $dbPassword): bool
    {
        if (function_exists('password_verify')) {
            return password_verify($inputPassword . AUTH_SALT, $dbPassword);
        } elseif (md5($inputPassword) == $dbPassword) {
            return true;
        } else {
            return false;
        }
    }
    static function passwordHash($usuario_clave)
    {
        if (function_exists('password_hash'))
            return password_hash($usuario_clave, PASSWORD_DEFAULT);
        else
            return md5($usuario_clave);
    }
}
