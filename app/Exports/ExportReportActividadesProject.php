<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportReportActividadesProject implements FromView, ShouldAutoSize
{
    protected $title;
    protected $project;
    protected $start_date;
    protected $end_date;
    protected $application;
    protected $reportData;

    public function __construct(string $title, $application, $project, $start_date, $end_date, $reportData)
    {
        $this->title = $title;
        $this->application = $application;
        $this->project = $project;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->reportData = $reportData;
    }

    public function view(): View
    {
        return view('report_files.exports.export_actividades_project.blade', [
            "title" => $this->title,
            "application" => $this->application,
            "data" => $this->reportData,
            "project" => $this->project,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
        ]);
    }
}
