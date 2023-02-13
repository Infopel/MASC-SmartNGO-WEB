<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ExportGeneral implements FromView, ShouldAutoSize
{
    protected $title;
    protected $dataType;
    protected $application;
    protected $reportData;

    public function __construct(string $title, $application, array $reportData, string $dataType)
    {
        $this->reportData = $reportData;
        $this->title = $title;
        $this->dataType = $dataType;
        $this->application = $application;
    }

    public function view(): View
    {
        return view('report_files.exports.export_general_issues', [
            "title" => $this->title,
            "application" => $this->application,
            "reportData" => $this->reportData,
            "dataType" => $this->dataType,
        ]);
    }
}
