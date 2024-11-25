<?php

namespace App\Core;

use Exception;
use PDO;
use PDOException;

class Crud extends DbConnection implements IOperacionesDb
{
    private string $table;
    private string $fieldIdName;
    private int $fieldIdValue;
    private int $affectedRows;
    private mixed $statement;
    private int $lastInsertId;
    private mixed $recordSet;
    private string $scriptName;
    private DBError $dbError;
    protected $errorCode;
    protected $errorMessage;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->fieldIdName = "";
        $this->fieldIdValue = 0;
        $this->lastInsertId = 0;
        $this->recordSet = false;
        $this->affectedRows = 0;
        $this->scriptName = $_SERVER['SCRIPT_NAME'];
        parent::__construct();
    }

    public function setFieldIdName(string $fieldIdName): void
    {
        $this->fieldIdName = $fieldIdName;
    }

    public function setFieldIdValue(int $fieldIdValue): void
    {
        $this->fieldIdValue = $fieldIdValue;
    }

    public function getAffectedRows(): int
    {
        return $this->affectedRows;
    }

    private function runQuery(string $query): void
    {
        $this->recordSet = $this->getConnection()->query($query);
        if ($this->recordSetWorks()) :
            $this->recordSet->setFetchMode(PDO::FETCH_ASSOC);
            $this->setAffectedRowsSelect();
        endif;
    }

    private function recordSetWorks(): bool
    {
        return ($this->recordSet !== false) ? true : false;
    }

    private function setAffectedRowsSelect(): void
    {
        $this->affectedRows = $this->recordSet->rowCount();
    }

    private function returnRows(): array
    {
        $rows = array();
        if ($this->recordSetWorks())
            while ($row = $this->recordSet->fetch()) :
                $rows[] = $row;
            endwhile;
        return $rows;
    }

    public function sendLog(string $level, string $message): void
    {
        $log = new LoggerRec(__NAMESPACE__);
        $log->setLevel($level);
        $log->sendLog($message);
    }

    /**
     * Obtiene los datos de un query tipo SELECT y devuelve los valores en un array
     * @param string $query: query tipo SELECT a ejecutar
     * @return array devuelve el listado de datos del query en un array, true si se ejecuto pero no retorno filas y false si el query tuvo algun error para ejecutarse
     **/
    public function getRows(string $query): mixed
    {
        try {
            $this->runQuery($query);
        } catch (PDOException $e) {
            $this->sendLog("error", "Error con query. Metodo: " . __METHOD__ . ", query: {$query}. Mensaje original:" . $e->getMessage() . ". Scriptname: " . $this->scriptName);
            $this->setError();
        }
        return $this->returnRows();
    }

    private function buildFieldsListString(array $fieldsList): string
    {
        return implode(",", array_keys($fieldsList[0]));
    }

    private function buildPrepareStringForInsert(array $fieldsList): string
    {
        $row_length = count($fieldsList[0]);
        $nb_rows = count($fieldsList);
        $length = $nb_rows * $row_length;
        return implode(',', array_map(
            function ($el) {
                return '(' . implode(',', $el) . ')';
            },
            array_chunk(array_fill(0, $length, '?'), $row_length)
        ));
    }

    private function buildValueData(array $fieldsList): array
    {
        $values = array();
        foreach ($fieldsList as $data) :
            foreach ($data as $value) :
                array_push($values, $value);
            endforeach;
        endforeach;
        #echo "<pre>";print_r($values);die();
        return $values;
    }

    private function buildPrepareQueryForInsert(array $fieldsList): string
    {
        return "INSERT INTO {$this->table} (" . $this->buildFieldsListString($fieldsList) . ") VALUES " . $this->buildPrepareStringForInsert($fieldsList);
    }

    private function runInsert(array $fieldsList): void
    {
        #echo "<pre>" . $this->buildPrepareQueryForInsert($fieldsList) . PHP_EOL . "</pre>";die();
        #echo "<pre>" . print_r($this->buildValueData($fieldsList)) . "</pre>";die();
        #$statement  = $this->getConnection()->prepare($this->buildPrepareQueryForInsert($fieldsList));
        #var_dump($statement);die();
        if ($this->statement->execute($this->buildValueData($fieldsList)))
            $this->lastInsertId = $this->getConnection()->lastInsertId();
    }

    private function prepareInsertStatement(array $fieldsList): mixed
    {
        return $this->getConnection()->prepare($this->buildPrepareQueryForInsert($fieldsList));
    }

    public function addRows(array $fieldsList): mixed
    {
        try {
            if ($this->statement = $this->prepareInsertStatement($fieldsList))
                $this->runInsert($fieldsList);
            else
                throw new PDOException("Error preparando el statement");
        } catch (PDOException $e) {
            $this->sendLog("error", "Error con query. Metodo: " . __METHOD__ . ". Query: " . $this->statement->queryString . ". Valores a insertar: " . print_r($this->buildValueData($fieldsList), 1) . ". Mensaje original:" . $e->getMessage() . ". ScriptName: " . $this->scriptName);
            $this->setError();
        }
        return $this->lastInsertId;
    }

    private function buildPrepareStringForUpdate(array $fieldsList): string
    {
        $fieldsStatement = "";
        foreach ($fieldsList as $key => $field) :
            foreach ($field as $fieldName => $fieldValue) :
                $fieldsStatement .= "$fieldName = ?,";
            endforeach;
        endforeach;
        return substr($fieldsStatement, -0, -1);
    }

    private function buildPrepareQueryForUpdate(array $fieldsList): string
    {
        if ($this->dataIsSetted())
            return "UPDATE {$this->table} SET " . $this->buildPrepareStringForUpdate($fieldsList) . " WHERE {$this->fieldIdName} = ?";
        return false;
    }

    private function dataIsSetted(): bool
    {
        if (isset($this->fieldIdName) && !empty($this->fieldIdName) && isset($this->fieldIdValue) && $this->fieldIdValue > 0) return true;
        return false;
    }

    private function prepareUpdateStatement(array $fieldsList): mixed
    {
        return $this->getConnection()->prepare($this->buildPrepareQueryForUpdate($fieldsList));
    }

    private function setAffectedRowsUpdate(): void
    {
        $this->affectedRows = $this->statement->rowCount();
    }

    private function addIdFieldToFieldsList(array $fieldsList): array
    {
        $fieldsList[0][$this->fieldIdName] = $this->fieldIdValue;
        return $fieldsList;
    }

    private function runUpdate(array $fieldsList): void
    {
        #$fieldsList = $this->addIdFieldToFieldsList($fieldsList);
        #echo "<pre>";print_r($fieldsList);die();
        if ($this->statement->execute($this->buildValueData($this->addIdFieldToFieldsList($fieldsList)))) :
            $this->setAffectedRowsUpdate();
        endif;
    }

    public function updateRow(array $fieldsList): bool
    {
        try {
            if ($this->statement = $this->prepareUpdateStatement($fieldsList))
                $this->runUpdate($fieldsList);
            else
                throw new PDOException("Error preparando el statement");
        } catch (PDOException $e) {
            $this->sendLog("error", "Error con query. Metodo: " . __METHOD__ . ". Query: " . $this->statement->queryString . ". Valores a actualizar: " . print_r($this->buildValueData($this->addIdFieldToFieldsList($fieldsList)), 1) . ". Mensaje original:" . $e->getMessage() . ". ScriptName: " . $this->scriptName);
            $this->setError();
        }
        return $this->getAffectedRows();
    }

    private function buildPrepareQueryForDelete(): string
    {
        if ($this->dataIsSetted())
            return "DELETE FROM {$this->table} WHERE {$this->fieldIdName} = ?";
        return false;
    }

    private function prepareDeleteStatement(): mixed
    {
        return $this->getConnection()->prepare($this->buildPrepareQueryForDelete());
    }

    private function runDelete(): void
    {
        #$fieldsList = $this->addIdFieldToFieldsList(array());
        #echo "<pre>";print_r($fieldsList);die();
        if ($this->statement->execute($this->buildValueData($this->addIdFieldToFieldsList(array())))) :
            $this->setAffectedRowsUpdate();
        endif;
    }

    public function deleteRow(): bool
    {
        try {
            if ($this->statement = $this->prepareDeleteStatement())
                $this->runDelete();
            else
                throw new PDOException("Error preparando el statement");
        } catch (PDOException $e) {
            $this->sendLog("error", "Error con query. Metodo: " . __METHOD__ . ". Query: " . $this->statement->queryString . ". Registro a eliminar: " . print_r($this->buildValueData($this->addIdFieldToFieldsList(array())), 1) . ". Mensaje original:" . $e->getMessage() . ". ScriptName: " . $this->scriptName);
            $this->setError();
        }
        return $this->getAffectedRows();
    }

    private function setError(): void
    {
        $this->errorCode = $this->statement->errorInfo()[1];
        $this->errorMessage = $this->statement->errorInfo()[2];
    }

    public function getLastError(): array
    {
        return array("errorCode" => $this->errorCode, "errorMessage" => $this->errorMessage, "scriptName" => $this->scriptName);
    }
}
