<?php

namespace App\Core\ReportGenerator;

interface ReportGenerator
{
    public const SCREEN = "SCREEN";
    public const EXCEL = "EXCEL";
    public const PDF = "PDF";
    public const CSV = "CSV";

    public function generate($output, $reportHeaders, $reportData, $filepath);

    public function isDownloadable(): bool;
}
