<?php

/**
 * Interface que define las operaciones basicas a realizar en la Base de datos para un CRUD
 * @author Harold "TheCrow" Rivas
 * @copyright 2022
 * @version  1.0
 * Consideraciones: Por si no lo sabias, si un parametro esta entre corchetes [] significa que es un parametro opcional.
 */

namespace App\Core;

interface IOperacionesDb
{
	public function getAffectedRows(): int;
	public function getRows(string $query): mixed;
	public function addRows(array $fieldsList): mixed;
	public function updateRow(array $fieldsList): bool;
	public function deleteRow(): bool;
	public function getLastError(): array;
	public function sendLog(string $level, string $message): void;
}
