<?php

namespace App\Controllers\ReportsControllers;

use Carbon\Carbon;
use App\Core\Model;
use App\Core\Template;
use App\Controllers\Controller;
use App\ReportsDefinitions\SalesPerBranch;
use App\Core\ReportGenerator\ReportService;
use App\Core\ReportGenerator\ReportGenerator;
use App\Components\Dropdowns\BranchesDropdown;
use App\Core\ReportGenerator\PHPReportGenerator;
use App\ReportsDefinitions\DailySalesPerBranchDetailed;


class DailySalesPerBranchController extends Controller
{
    const TEMPLATE = 'sections/Reports/DateAndBranchForm.tpl';

    private $title = "Ventas diarias por Sucursal detallado | " . BUSINESS_NAME;
    private $h1 = "Ventas diarias por Sucursal detallado";
    protected $reportDefinition = DailySalesPerBranchDetailed::class;
    protected Model $model;
    protected ReportService $reportService;
    public string $currentRoute;


    public function showForm(): void
    {
        $startDate = date('d/m/Y');

        $branches = (new BranchesDropdown($this->connection))->getBranchesDropdown();

        $data = $this->prepareData($startDate, $branches, ReportGenerator::SCREEN, "", false);

        echo Template::render(self::TEMPLATE, $data);
    }

    public function renderReport()
    {
        $startDate = $this->request->get('startDate');
        $branchId = $this->request->get('branch_id');
        $output = $this->request->get('output');

        $reportStartDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');

        $this->model = new Model($this->connection);
        $this->reportService = new ReportService(new PHPReportGenerator());
        $this->reportDefinition = new DailySalesPerBranchDetailed();

        $reportHeaders = $this->reportDefinition->columnsHeaders();
        $filepath = "exportedReports" . DIRECTORY_SEPARATOR . $this->reportDefinition::FILENAME . date("YmdHis");

        $reportQuery = $this->reportDefinition->query($reportStartDate, $branchId);

        $reportData = $this->model
            ->query($reportQuery)
            ->getRecords();

        $reportContent = "No se encotraron datos para el informe";
        $isDownloadable = false;

        if (!empty($reportData)) :
            $reportContent = $this->reportService->generateReport($output, $reportHeaders, $reportData, $filepath);
            $isDownloadable = $this->reportService->isDownloadable();
        endif;

        $branches = (new BranchesDropdown($this->connection))->getBranchesDropdown();

        $data = $this->prepareData($startDate, $branches, $output, $reportContent, $isDownloadable);

        echo Template::render(self::TEMPLATE, $data);
    }

    protected function prepareData(string $startDate, string $branches, string $output, string $reportContent, bool $isDownloadable)
    {
        return [
            "title" => $this->title,
            "h1" => $this->h1,
            "resultado" => true,
            "output" => $output,
            "originalOutput" => $output,
            "startDate" => $startDate,
            "branches" => $branches,
            "reportContent" => $reportContent,
            "isDownloadable" => $isDownloadable,
        ];
    }
}
