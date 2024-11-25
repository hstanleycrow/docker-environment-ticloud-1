<?php

namespace App\Components\DatatableUIBuilder;

interface DatatableInterface
{
    public function changeButtonsToRender(array $buttonsToRender = []): self;
    public function render(): string;
    public function setAddButtonClass(string $class): self;
    public function addCssClass(string $class): self;
    public function autoLoadDatatableJS(): string;
    public function autoLoadCssResources(): string;
    public function autoLoadJsResources(): string;
    public function setTableId(string $tableId): self;
    public function setDTLanguage(string $language): self;
    public function setDTRowsPerPage(int $rowsPerPage = 25): self;
    public function setFramework(string $framework): void;
}
