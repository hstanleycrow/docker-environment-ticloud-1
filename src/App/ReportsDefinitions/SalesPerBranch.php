<?php

namespace App\ReportsDefinitions;

use hstanleycrow\EasyPHPReports\CellFormat;

class SalesPerBranch
{
    public const FILENAME = "Ventas por Sucursal";

    public function query(string $startDate, string $endDate): string
    {
        return "
        SELECT 
            -- ROW_NUMBER() OVER () AS no,
	        -- CAST(a.date AS DATE) AS order_date,
	        b.name AS branch_name,
	        SUM(a.total_amount) AS total_amount
        FROM 
	        orders a INNER JOIN branches b ON a.branch_id = b.id
        WHERE 
	        cast(a.date AS DATE) BETWEEN '{$startDate}' AND '{$endDate}'
        GROUP BY a.branch_id
        ";
    }

    public function columnsHeaders(): array
    {
        return array(
            // ["header" => "No", "format" => CellFormat::NUMBER, "calculate" => false],
            //["header" => "Fecha", "format" => CellFormat::DATE, "calculate" => false],
            ["header" => "Sucursal", "format" => CellFormat::TEXT, "calculate" => false],
            ["header" => "Venta", "format" => CellFormat::MONEY, "calculate" => true],
        );
    }
}
