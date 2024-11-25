<?php

namespace App\Core\ReportGenerator;

class ReportService
{
    private $reportGenerator;

    public function __construct(ReportGenerator $reportGenerator)
    {
        $this->reportGenerator = $reportGenerator;
    }

    public function generateReport($output, $reportHeaders, $reportData, $filepath)
    {
        return $this->reportGenerator->generate($output, $reportHeaders, $reportData, $filepath);
    }

    public function isDownloadable(): bool
    {
        return $this->reportGenerator->isDownloadable();
    }
}
