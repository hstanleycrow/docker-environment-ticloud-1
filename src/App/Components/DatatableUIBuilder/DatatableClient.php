<?php

namespace App\Components\DatatableUIBuilder;

use hstanleycrow\EasyPHPDatatableCRUD\DatatableUIBuilder;


class DatatableClient implements DatatableInterface
{
    protected DatatableUIBuilder $datatableUIBuilder;

    public function __construct(string $DTDefinition, ?array $dtDisabledIdButtons = [])
    {
        $this->datatableUIBuilder = new DatatableUIBuilder($DTDefinition, $dtDisabledIdButtons);
    }

    public function changeButtonsToRender(array $buttonsToRender = []): self
    {
        $this->datatableUIBuilder->changeButtonsToRender($buttonsToRender);
        return $this;
    }

    public function render(): string
    {
        return $this->datatableUIBuilder->render();
    }

    public function setAddButtonClass(string $class): self
    {
        $this->datatableUIBuilder->setAddButtonClass($class);
        return $this;
    }
    public function addCssClass(string $class): self
    {
        $this->datatableUIBuilder->addCssClass($class);
        return $this;
    }

    public function autoLoadDatatableJS(): string
    {
        return $this->datatableUIBuilder->autoLoadDatatableJS();
    }
    public function autoLoadCssResources(): string
    {
        return $this->datatableUIBuilder->autoLoadCssResources();
    }
    public function autoLoadJsResources(): string
    {
        return $this->datatableUIBuilder->autoLoadJsResources();
    }
    public function setTableId(string $tableId): self
    {
        $this->datatableUIBuilder->setTableId($tableId);
        return $this;
    }
    public function setDTLanguage(string $language): self
    {
        $this->datatableUIBuilder->setDTLanguage($language);
        return $this;
    }
    public function setDTRowsPerPage(int $rowsPerPage = 25): self
    {
        $this->datatableUIBuilder->setDTRowsPerPage($rowsPerPage);
        return $this;
    }
    public function setFramework(string $framework): void
    {
        $this->datatableUIBuilder->setFramework($framework);
    }
}
