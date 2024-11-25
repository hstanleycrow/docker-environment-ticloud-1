<?php

namespace App\Components\Dropdowns;

use App\Core\DBConnection\IConnection;

class DBDropdown extends Dropdown
{
    protected array $options;

    public function __construct(
        protected IConnection $connection,
        protected string $modelName,
        protected string $methodName,
        protected ?string $selected = '0',
        protected ?bool $multiple = false,
        protected array $methodArgs = []  // Nuevo parámetro para los argumentos del método
    ) {
        $this->selected = $selected ?? null;
        $this->getOptions();
        $dropdownClient = new DropdownClient($this->options, $this->selected);
        parent::__construct($dropdownClient);
    }

    private function getOptions(): self
    {
        if (class_exists($this->modelName)) :
            $model = new $this->modelName($this->connection);
            if (method_exists($model, $this->methodName)) :
                // Pasamos los argumentos al método usando call_user_func_array
                $this->cleanOptions(call_user_func_array([$model, $this->methodName], $this->methodArgs));
            else :
                throw new \Exception("Method " . $this->methodName . " not found on model " . $this->modelName);
            endif;
        else :
            throw new \Exception("Class " . $this->modelName . " not found");
        endif;
        return $this;
    }

    private function cleanOptions(array $options): self
    {
        $cleanOptions = [];
        if (!$this->multiple)
            $cleanOptions = [0 => 'Seleccione una opción'];
        foreach ($options as $option) :
            $cleanOptions[$option['id']] = $option['name'];
        endforeach;
        $this->options = $cleanOptions;
        return $this;
    }
}
