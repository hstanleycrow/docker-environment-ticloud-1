<?php

namespace App\Core\ReportGenerator;

use hstanleycrow\EasyPHPReports\PHPReport;

class PHPReportGenerator implements ReportGenerator
{
    private PHPReport $report;

    public function generate($output, $reportHeaders, $reportData, $filepath)
    {
        PHPReport::initialize();
        $this->report = new PHPReport(
            $output,
            $reportHeaders,
            $reportData,
            $filepath
        );

        return $this->report->generate();
    }

    public function isDownloadable(): bool
    {
        return $this->report->isDownloadable();
    }
}
