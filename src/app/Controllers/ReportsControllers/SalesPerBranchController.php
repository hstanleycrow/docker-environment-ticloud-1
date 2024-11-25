<?php

namespace App\Controllers\ReportsControllers;

use App\Core\Template;
use App\ReportsDefinitions\SalesPerBranch;
use App\Core\ReportGenerator\ReportGenerator;


class SalesPerBranchController extends ReportController
{

    private $title = "Reporte de ventas por Sucursal | " . BUSINESS_NAME;
    private $h1 = "Ventas por sucursal";
    public string $currentRoute;

    public function showForm(): void
    {
        $startDate = date('01/m/Y');
        $endDate = date('d/m/Y');

        $data = $this->prepareData($startDate, $endDate, ReportGenerator::SCREEN, "", false);

        echo Template::render('sections/Reports/RangeDatesForm.tpl', $data);
    }

    public function renderReport()
    {
        parent::setReportDefinition(new SalesPerBranch());
        #$salesPerBranch = new SalesPerBranch();
        #$startDate = $this->request->get('startDate');
        #$endDate = $this->request->get('endDate');
        #$output = $this->request->get('output');

        parent::renderReport();
    }

    protected function prepareData($startDate, $endDate, $output, $reportContent, $isDownloadable)
    {
        return [
            "title" => $this->title,
            "h1" => $this->h1,
            "resultado" => true,
            "output" => $output,
            "originalOutput" => $output,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "reportContent" => $reportContent,
            "isDownloadable" => $isDownloadable,
        ];
    }
}
