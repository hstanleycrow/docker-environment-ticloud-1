<?php

namespace App\ReportsDefinitions;

use hstanleycrow\EasyPHPReports\CellFormat;

class DailySalesPerBranchDetailed
{
    public const FILENAME = "Ventas detalladas diarias por Sucursal";

    public function query(string $startDate, int $branchId): string
    {
        return "
            SELECT 
                c.name AS product_name,
                b.price,
                b.quantity,
                (b.price * b.quantity) AS subtotal
            FROM 
                orders a 
                INNER JOIN order_details b ON a.id = b.order_id
                INNER JOIN products c ON b.product_id = c.id
            WHERE 
                cast(a.date AS DATE) = '{$startDate}' 
                AND a.branch_id = '{$branchId}'
            GROUP BY b.product_id
        ";
    }

    public function columnsHeaders(): array
    {
        return array(
            ["header" => "Articulo", "format" => CellFormat::TEXT, "calculate" => false],
            ["header" => "Precio", "format" => CellFormat::MONEY, "calculate" => false],
            ["header" => "Cantidad", "format" => CellFormat::NUMBER, "calculate" => false],
            ["header" => "Subtotal", "format" => CellFormat::MONEY, "calculate" => true],
        );
    }
}
