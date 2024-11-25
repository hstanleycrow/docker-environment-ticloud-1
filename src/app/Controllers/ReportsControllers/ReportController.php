<?php

namespace App\Controllers\ReportsControllers;

use Carbon\Carbon;
use App\Core\Model;
use App\Core\Template;
use App\Controllers\Controller;
use App\Core\ReportGenerator\ReportService;
use App\Core\ReportGenerator\PHPReportGenerator;

abstract class ReportController extends Controller
{
    protected Model $model;
    protected ReportService $reportService;
    protected $reportDefinition;

    protected function setReportDefinition($reportDefinition): self
    {
        $this->reportDefinition = $reportDefinition;
        return $this;
    }

    protected function renderReport()
    {
        $startDate = $this->request->get('startDate');
        $endDate = $this->request->get('endDate');
        $output = $this->request->get('output');

        $reportStartDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $reportEndDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $this->model = new Model($this->connection);
        $this->reportService = new ReportService(new PHPReportGenerator());

        $reportHeaders = $this->reportDefinition->columnsHeaders();
        $filepath = "exportedReports" . DIRECTORY_SEPARATOR . $this->reportDefinition::FILENAME . date("YmdHis");

        $reportQuery = $this->reportDefinition->query($reportStartDate, $reportEndDate);

        $reportData = $this->model
            ->query($reportQuery)
            ->getRecords();

        $reportContent = "No se encotraron datos para el informe";
        $isDownloadable = false;

        if (!empty($reportData)) :
            $reportContent = $this->reportService->generateReport($output, $reportHeaders, $reportData, $filepath);
            $isDownloadable = $this->reportService->isDownloadable();
        endif;

        $data = $this->prepareData($startDate, $endDate, $output, $reportContent, $isDownloadable);

        echo Template::render('sections/Reports/RangeDatesForm.tpl', $data);
    }

    abstract protected function prepareData($startDate, $endDate, $output, $reportContent, $isDownloadable);
}
