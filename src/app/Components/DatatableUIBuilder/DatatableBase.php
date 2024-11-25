<?php

namespace App\Components\DatatableUIBuilder;

class DatatableBase
{

    public function __construct(private DatatableClient $datatableClient)
    {
    }
    public function changeButtonsToRender(array $buttonsToRender = []): self
    {
        $this->datatableClient->changeButtonsToRender($buttonsToRender);
        return $this;
    }

    public function render(): string
    {
        return $this->datatableClient->render();
    }

    public function setAddButtonClass(string $class): self
    {
        $this->datatableClient->setAddButtonClass($class);
        return $this;
    }

    public function addCssClass(string $class): self
    {
        $this->datatableClient->addCssClass($class);
        return $this;
    }

    public function autoLoadDatatableJS(): string
    {
        return $this->datatableClient->autoLoadDatatableJS();
    }
    public function autoLoadCssResources(): string
    {
        return $this->datatableClient->autoLoadCssResources();
    }
    public function autoLoadJsResources(): string
    {
        return $this->datatableClient->autoLoadJsResources();
    }
    public function setTableId(string $tableId): self
    {
        $this->datatableClient->setTableId($tableId);
        return $this;
    }
    public function setDTLanguage(string $language): self
    {
        $this->datatableClient->setDTLanguage($language);
        return $this;
    }
    public function setDTRowsPerPage(int $rowsPerPage = 25): self
    {
        $this->datatableClient->setDTRowsPerPage($rowsPerPage);
        return $this;
    }
    public function setFramework(string $framework): void
    {
        $this->datatableClient->setFramework($framework);
    }
}
